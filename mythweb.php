<?php
/**
 * The main brain script for all of MythWeb.
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

// Add a custom include path?
    if (!empty($_SERVER['include_path']) && $_SERVER['include_path'] != '.')
        ini_set('include_path', ini_get('include_path').':'.$_SERVER['include_path']);

// Init
    require_once 'includes/init.php';

// Where are we headed?
    switch ($Path[0]) {
        case 'upcoming':
            require_once 'scheduled_recordings.php';
            break;
        case 'schedules':
            require_once 'recording_schedules.php';
            break;
        case 'recordings':
            require_once 'recorded_programs.php';
            break;
        default:
            require_once 'program_listing.php';
    }

// Exit gracefully
    exit;

