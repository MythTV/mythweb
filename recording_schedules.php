<?php
/***                                                                        ***\
    recording_schedules.php                 Last Updated: 2005.02.03 (xris)

    view and fix scheduling conflicts.
\***                                                                        ***/


// Which section are we in?
    define('section', 'tv');

// Initialize the script, database, etc.
    require_once "includes/init.php";
    require_once "includes/sorting.php";

// Load the recordings
    global $Schedules;

// Parse the recording list
    $All_Shows = array();
    foreach (array_keys($Schedules) as $key) {
        $All_Shows[] =& $Schedules[$key];
    }

// Sort the recordings
    if (count($All_Shows))
        sort_programs($All_Shows, 'scheduled_sortby');

// Load the class for this page
    require_once theme_dir."recording_schedules.php";

// Create an instance of this page from its theme object
    $Page = new Theme_recording_schedules();

// Display the page
    $Page->print_page();

// Exit
    exit;

?>
