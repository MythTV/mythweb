<?php
/***                                                                        ***\
    scheduled_recordings.php                 Last Updated: 2005.01.31 (xris)

    view and fix scheduling conflicts.
\***                                                                        ***/


// Which section are we in?
    define('section', 'tv');

// Initialize the script, database, etc.
    require_once "includes/init.php";
    require_once "includes/sorting.php";

// Make sure we get the form data
    isset($_GET['chanid'])    or $_GET['chanid']    = $_POST['chanid'];
    isset($_GET['starttime']) or $_GET['starttime'] = $_POST['starttime'];

// Doing something to a program?  Load its detailed info
    if ($_GET['chanid'] && $_GET['starttime']) {
        $program = load_one_program($_GET['starttime'], $_GET['chanid']);

    // Forget all knowledge of old recordings
        if ($_GET['forget_old'] || $_POST['forget_old']) {
            $program->rec_forget_old();
        }
    // Fake an old recording so that this show won't record again
        elseif ($_GET['never_record'] || $_POST['never_record']) {
            $program->rec_never_record();
        }
    // Revert to default recording rules
        elseif ($_GET['default'] || $_POST['default']) {
            $program->rec_default();
        }
    // Suppress something that shouldn't be recorded
        elseif ($_GET['dontrec'] || $_POST['dontrec']) {
            $program->rec_override(rectype_dontrec);
        }
    // Record a show that wouldn't otherwise record (various reasons, read below)
        elseif ($_GET['record'] || $_POST['record']) {
            $program->rec_override(rectype_override);
        }

    // Redirect back to the page again, but without the query string, so reloads are cleaner
        header('Location: scheduled_recordings.php');
        exit;
    }

// Parse the list of scheduled recordings
    global $Scheduled_Recordings;
    $All_Shows = array();
    foreach ($Scheduled_Recordings as $chanid => $shows) {
    // Now the shows in this channel
        foreach ($shows as $starttime => $show) {
        // Skip things we've already recorded
            if ($starttime <= time())
                continue;
        // Make sure this is a valid show (ie. skip in-progress recordings and other junk)
            if (!$chanid || $show->length < 1)
                continue;
        // Assign a reference to this show to the various arrays
            $All_Shows[] =& $Scheduled_Recordings[$chanid][$starttime];
        }
    }

// Sort the programs
    if (count($All_Shows))
        sort_programs($All_Shows, 'scheduled_sortby');

// Load the class for this page
    require_once theme_dir."scheduled_recordings.php";

// Create an instance of this page from its theme object
    $Page = new Theme_scheduled_recordings();

// Display the page
    $Page->print_page();

// Exit
    exit;

?>
