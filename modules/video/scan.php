<?php
/**
 * Video scanner
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 *
 * @package     MythWeb
 * @subpackage  Video
 *
/**/

// List of valid video extentions
    $Known_Exts = $db->query_list('SELECT extension
                                     FROM videotypes
                                    WHERE f_ignore = 0');

// First delete any videos that do not exist anymore
    $sh = $db->query('SELECT videometadata.intid,
                             videometadata.filename,
                             videometadata.coverfile
                        FROM videometadata');
    while (list($id, $filename, $cover) = $sh->fetch_row()) {
        if ( !file_exists($filename) && is_executable(dirname($filename)) ) {
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
            if ( in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $Known_Exts) === FALSE )
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
        $title = str_replace(array('_', '%20', '.'), ' ', $title);
        $title = preg_replace(array('/\[[^\]]*\]/',
                                    '/\([^\)]*\)/',
                                    '/\{[^\}]*\}/'
                                    ), '', $title);

        return trim($title);
    }
