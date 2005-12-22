<?php
/**
 * Handler for all MythWeb TV routines
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Make sure the image cache path exists and is writable
    if (!is_dir('data/tv_icons') && !mkdir('data/tv_icons', 0755)) {
        $Error = 'Error creating data/tv_icons: Please check permissions on the data directory.';
        require_once 'templates/_error.php';
        exit;
    }
    if (!is_writable('data/tv_icons')) {
        $process_user = posix_getpwuid(posix_geteuid());
        $Error = 'data/tv_icons directory is not writable by '.$process_user['name'].'. Please check permissions.';
        require_once 'templates/_error.php';
        exit;
    }

// Load the tv-related libraries
    require_once "includes/channels.php";
    require_once "includes/programs.php";
    require_once "includes/recording_schedules.php";

// Unknown section?  Use the default
    if (!in_array($Path[1], array('detail', 'channel'))
            && empty($Modules['tv']['links'][$Path[1]]))
        $Path[1] = 'list';

// Show the requested section
    require_once 'modules/tv/'.$Path[1].'.php';