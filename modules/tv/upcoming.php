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
    // Wait for a second so the backend can catch up
        sleep(1);

    // Redirect back to the page again, but without the query string, so reloads are cleaner
        header('Location: '.root.'tv/upcoming');
        exit;
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
        $_SESSION['scheduled_recordings'] = array('disp_scheduled'   => true,
                                                  'disp_duplicates'  => true,
                                                  'disp_deactivated' => true,
                                                  'disp_conflicts'   => true
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
                elseif (in_array($show->recstatus, array('PreviousRecording', 'CurrentRecording', 'EarlierShowing', 'LaterShowing'))) {
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

