<?php
/**
 * View and fix scheduling conflicts.
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

// Load the sorting routines
    require_once 'includes/sorting.php';

// Use the new directory structure?
    if (!$_REQUEST['chanid'] && !$_REQUEST['starttime']) {
        $_REQUEST['chanid']    = $Path[2];
        $_REQUEST['starttime'] = $Path[3];
        $_REQUEST['manualid']  = $Path[4];
    }
// Just in case
    $_GET['chanid']    = intVal($_REQUEST['chanid']);
    $_GET['starttime'] = intVal($_REQUEST['starttime']);
    $_GET['manualid']  = intVal($_REQUEST['manualid']);

// Doing something to a program?  Load its detailed info
    if ($_GET['chanid'] && $_GET['starttime']) {
        $program = load_one_program($_GET['starttime'], $_GET['chanid'], $_GET['manualid']);

        if (is_object($program)) {
        // Forget all knowledge of old recordings
            if ($_REQUEST['forget_old'])
                $program->rec_forget_old();
        // Fake an old recording so that this show won't record again
            elseif ($_REQUEST['never_record'])
                $program->rec_never_record();
        // Revert to default recording rules
            elseif ($_REQUEST['default'])
                $program->rec_default();
        // Suppress something that shouldn't be recorded
            elseif ($_REQUEST['dontrec'])
                $program->rec_override(rectype_dontrec);
        // Record a show that wouldn't otherwise record (various reasons, read below)
            elseif ($_REQUEST['record'])
                $program->rec_override(rectype_override);
            elseif ($_REQUEST['activate'])
                $program->activate();
        // Wait for a second so the backend can catch up
            sleep(1);
        }
        else
            add_warning('Unknown program.');

    // Redirect back to the page again, but without the query string, so reloads are cleaner
        redirect_browser(root.'tv/upcoming');
    }

// Ignore certain shows?
    if ($_POST['change_display']) {
        $_SESSION['scheduled_recordings']['disp_scheduled']   = $_POST['disp_scheduled']   ? true : false;
        $_SESSION['scheduled_recordings']['disp_duplicates']  = $_POST['disp_duplicates']  ? true : false;
        $_SESSION['scheduled_recordings']['disp_deactivated'] = $_POST['disp_deactivated'] ? true : false;
        $_SESSION['scheduled_recordings']['disp_conflicts']   = $_POST['disp_conflicts']   ? true : false;
    }

// Defaults
    if (!is_array($_SESSION['scheduled_recordings'])
        || !($_SESSION['scheduled_recordings']['disp_scheduled']
             || $_SESSION['scheduled_recordings']['disp_duplicates']
             || $_SESSION['scheduled_recordings']['disp_deactivated']
             || $_SESSION['scheduled_recordings']['disp_conflicts'])) {
        $_SESSION['scheduled_recordings'] = array('disp_scheduled'   => TRUE,
                                                  'disp_duplicates'  => FALSE,
                                                  'disp_deactivated' => FALSE,
                                                  'disp_conflicts'   => TRUE
                                                 );
    }

// Parse the list of scheduled recordings
    global $Scheduled_Recordings;
    $all_shows = array();
    foreach ($Scheduled_Recordings as $callsign => $shows) {
    // Now the shows in this channel
        foreach ($shows as $starttime => $show_group) {
        // Parse each show group
            foreach ($show_group as $key => $show) {
            // Skip things we've already recorded (or missed)
                if ($starttime <= time() && $show->recstatus != 'Recording')
                    continue;
            // Make sure this is a valid show (ie. skip in-progress recordings and other junk)
                if (!$callsign || $show->length < 1)
                    continue;
            // Skip scheduled shows?
                if (in_array($show->recstatus, array('WillRecord', 'ForceRecord'))) {
                    if (!$_SESSION['scheduled_recordings']['disp_scheduled'])
                        continue;
                }
            // Skip conflicting shows?
                elseif (in_array($show->recstatus, array('Conflict', 'Overlap'))) {
                    if (!$_SESSION['scheduled_recordings']['disp_conflicts'])
                        continue;
                }
            // Skip duplicate shows?
                elseif (in_array($show->recstatus, array('PreviousRecording', 'CurrentRecording'))) {
                    if (!$_SESSION['scheduled_recordings']['disp_duplicates'])
                        continue;
                }
            // Skip deactivated shows?
                elseif ($show->recstatus != 'Recording') {
                    if (!$_SESSION['scheduled_recordings']['disp_deactivated'])
                        continue;
                }
            // Assign a reference to this show to the various arrays
                $all_shows[] =& $Scheduled_Recordings[$callsign][$starttime][$key];
            }
        }
    }

// Sort the programs
    if (count($all_shows))
        sort_programs($all_shows, 'scheduled_sortby');

// Load the class for this page
    require tmpl_dir.'upcoming.php';

// Exit
    exit;
