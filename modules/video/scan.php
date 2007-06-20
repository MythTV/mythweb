<?php
/**
 * Video scanner
 *
 * @url         $URL: http://svn.mythtv.org/svn/trunk/mythplugins/mythweb/modules/video/edit.php $
 * @date        $Date: 2006-06-24 12:03:10 -0700 (Sat, 24 Jun 2006) $
 * @version     $Revision: 10290 $
 * @author      $Author: xris $
 *
 * @package     MythWeb
 * @subpackage  Video
 *
/**/

// List of valid video extentions
$Known_Exts = $db->query_list('SELECT extension FROM videotypes WHERE f_ignore = 0');

// First delete any videos that do not exist anymore
    $sh = $db->query('SELECT videometadata.intid,
                             videometadata.filename,
                             videometadata.coverfile
                        FROM videometadata');
    while (list($id, $filename, $cover) = $sh->fetch_row()) {
        if (!file_exists($filename)) {
            $db->query('DELETE FROM videometadata
                              WHERE videometadata.intid = ?',
                       $id
                       );
            $db->query('DELETE FROM videometadatagenre
                              WHERE videometadatagenre.idvideo = ?',
                       $id
                       );
            $db->query('DELETE FROM videometadatacountry
                              WHERE videometadatacountry.idvideo = ?',
                       $id
                       );
        // Delete the cover file if it's unused
            if ($db->query_col('SELECT COUNT(videometadata.intid)
                                  FROM videometadata
                                 WHERE videometadata.coverfile = ?',
                               $cover
                               ) == 0)
                unlink($cover);
        }
    }

// Now scan for any new ones
    $paths = explode(':', setting('VideoStartupDir', hostname));
    foreach ($paths as $path) {
        exec("find -L $path -type f", $files, $retval);
        foreach ($files as $file) {
            if ( in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $Known_Exts) === FALSE
                 && strpos(`file -ib "$file"`, 'video')                                 === FALSE )
                continue;
        // Check readable status
            if (!is_readable($file))
                continue;
            if ($db->query_col('SELECT COUNT(1)
                                  FROM videometadata
                                 WHERE videometadata.filename = ?', $file) == 0) {
                $filename   = basename($file);
                $title      = filenametotitle($filename);
                $db->query('INSERT INTO videometadata ( title, filename, showlevel, browse )
                                               VALUES (     ?,        ?,         1,      ? )',
                           strlen($title) > 0 ? $title : $filename,
                           $file,
                           setting('VideoNewBrowsable', hostname)
                           );
            }
        }
    }

    // Converts the filename to the title and cleans it up a little
    // This is a direct port of the C++ code from mythvideo
    function filenametotitle($filename) {

        $title = substr($filename, 0, strripos($filename, '.'));

        $title = str_replace('_', ' ', $title);
        $title = str_replace('%20', ' ', $title);
        $title = str_replace('.', ' ', $title);

        $title = eatbraces($title, '[', ']');
        $title = eatbraces($title, '(', ')');
        $title = eatbraces($title, '{', '}');

        return trim($title);
    }

    // Strips out braces and the text inside the braces.
    // This is a direct port of the C++ code from mythvideo
    function eatbraces($str, $left_brace, $right_brace) {
        $keep_checking = TRUE;

        while ($keep_checking) {
            $left_position = stripos($str, $left_brace);
            $right_position = stripos($str, $right_brace);

            // No matching pairs left
            if ($left_position === FALSE || $right_position === FALSE)
                $keep_checking = FALSE;

            // Matching set: ()
            elseif ($left_position < $right_position)
                $str = substr($str, 0, $left_postion) + substr($str, $right_position);

            // Matching set: )(
            elseif ($left_position > $right_position)
                $str = substr($str, 0, $right_postion) + substr($str, $left_position);
        }
        return $str;
    }

