<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
 *
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
