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


/**
 * By default, php will always search the current directory for include files,
 * but if you wish to install these directories outside of the current path
 * (eg. for security reasons), set this variable to the directory that the
 * directories like languages and templates are located inside of.  eg.
 *
 *  define('search_path', '/usr/share/mythweb');
/**/
    define('search_path', '.');

// Add the aforementioned path to the global search path, though don't bother if
// it's '.' because php already searches the current directory.
    if (search_path != '.')
        ini_set('include_path', ini_get('include_path').':'.search_path);

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

