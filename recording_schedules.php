<?php
/***                                                                        ***\
    recording_schedules.php                 Last Updated: 2004.02.07 (alden)

    view and fix scheduling conflicts.
\***                                                                        ***/


// Initialize the script, database, etc.
    require_once "includes/init.php";
    require_once "includes/sorting.php";

// Load the recordings
    $records = load_all_recordings();

// Parse the recording list
    $All_Shows = array();
    $Channels  = array();

    foreach ($records as $record) {
        $show = new Recording($record);
    // Assign a reference to this show to the various arrays
        $All_Shows[]                 = &$show;
        $Channels[$show['chanid']][] = &$show;
        unset($show);
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
