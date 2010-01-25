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

// Video storage directories
    $video_dirs = $db->query_list('
        SELECT  dirname
        FROM    storagegroup
        WHERE   groupname = "Videos"
            AND hostname  = ?
        ', hostname);

// First delete any videos that do not exist anymore
    $sh = $db->query('SELECT videometadata.intid,
                             videometadata.filename,
                             videometadata.coverfile
                      FROM   videometadata
                      WHERE  host = ?', hostname);
    while (list($id, $filename, $cover) = $sh->fetch_row()) {
        $exists = false;
        foreach ($video_dirs as $dir) {
            $path = preg_replace('#/+#', '/', "$dir/$filename");
            if (file_exists($path) && is_executable(dirname($path))) {
                $exists = true;
                break;
            }
        }
        if ( !$exists ) {
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
                               ) == 0) {
                if ($cover != 'No Cover') {
                    @unlink($cover);
                }
            }
        }
    }

// Now scan for any new ones
    foreach ($video_dirs as $path) {
        $files = array();
        exec("find -L $path -name '.*' -prune -o -type f -print", $files, $retval);
        foreach ($files as $file) {
            if ( in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $Known_Exts) === FALSE )
                continue;
        // Check readable status
            if (!is_readable($file))
                continue;
        // Strip the directory off of the filename
            $file = preg_replace('#^'.preg_quote($path).'/*#', '', $file);
        // Already exists?
            $exists = $db->query_col('
                SELECT  COUNT(1)
                FROM    videometadata
                WHERE   filename = ?',
                $file);
            if ($exists != 0) {
                continue;
            }
        // Add to the database
            $filename   = basename($file);
            $title      = filenametotitle($filename);
            $db->query('INSERT INTO videometadata ( title, filename, host, showlevel, browse )
                                           VALUES (     ?,        ?,     ?,        1,      ? )',
                       strlen($title) > 0 ? $title : $filename,
                       $file,
                       hostname,
                       setting('VideoNewBrowsable', hostname)
                       );
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
