<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Make sure the data directory exists and is writable
    if (!is_dir('data') && !mkdir('data', 0755)) {
        custom_error('Error creating the data directory. Please check permissions.');
    }
    if (!is_writable('data')) {
        $process_user = posix_getpwuid(posix_geteuid());
        custom_error('data directory is not writable by '.$process_user['name'].'. Please check permissions.');
    }

// New hard-coded cache directory
    define('cache_dir', 'data/cache');
    define('cache_url', root.cache_dir.'/');

// Make sure the image cache path exists and is writable
    if (!is_dir(cache_dir) && !mkdir(cache_dir, 0755)) {
        custom_error('Error creating '.cache_dir.': Please check permissions on the data directory.');
    }
    if (!is_writable(cache_dir)) {
        $process_user = posix_getpwuid(posix_geteuid());
        custom_error(cache_dir.' directory is not writable by '.$process_user['name'].'. Please check permissions.');
    }

// Clean out stale thumbnails
    if (is_dir(cache_dir)) {
        if ($dir = opendir(cache_dir)) {
            while (($file = readdir($dir))) {
                if (!preg_match('/\\.(png|jpg|gif)$/', $file) || !is_file(cache_dir.'/'.$file))
                    continue;
            // Delete files older than the last week.
                if (filemtime(cache_dir.'/'.$file) < time() - 7 * 24 * 60 * 60)
                    unlink(cache_dir.'/'.$file);
            }
            closedir($dir);
            clearstatcache();
        }
    }
