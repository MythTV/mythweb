<?php
/**
 * View and fix scheduling conflicts.
 *
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
        }
        else {
            if ($_REQUEST['dontrec'])
                $schedule =& Schedule::find($_GET['chanid'], $_GET['starttime'])->save(rectype_dontrec);
            else
                add_warning('Unknown program.');
        }

    // Redirect back to the page again, but without the query string, so reloads are cleaner
        redirect_browser(root_url.'tv/upcoming');
    }

// Ignore certain shows?
    if ($_POST['change_display']) {
        $_SESSION['scheduled_recordings']['disp_scheduled']   = $_POST['disp_scheduled']   ? true : false;
        $_SESSION['scheduled_recordings']['disp_duplicates']  = $_POST['disp_duplicates']  ? true : false;
        $_SESSION['scheduled_recordings']['disp_deactivated'] = $_POST['disp_deactivated'] ? true : false;
        $_SESSION['scheduled_recordings']['disp_conflicts']   = $_POST['disp_conflicts']   ? true : false;
        $_SESSION['scheduled_recordings']['disp_recgroup']    = $_POST['disp_recgroup'];
        $_SESSION['scheduled_recordings']['disp_title']       = $_POST['disp_title'];
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
    $all_shows = array();
    $Groups = array();
    $Program_Titles = array();
    if (empty($scheduled)) {
        $scheduled = array();
    }

    foreach (Schedule::findScheduled() as $callsign => $shows) {
    // Now the shows in this channel
        foreach ($shows as $starttime => $show_group) {
        // Parse each show group
            foreach ($show_group as $key => &$show) {
                $Groups[$show->recgroup]++;
            // Skip things we've already recorded (or missed)
                if ($starttime <= time() && $show->recstatus != 'Recording')
                    continue;
            // Make sure this is a valid show (ie. skip in-progress recordings and other junk)
                if (!$callsign || $show->length < 1)
                    continue;
                $Program_Titles[$show->title]++;
            // Skip scheduled shows?
                if (in_array($show->recstatus, array('WillRecord', 'ForceRecord'))) {
                    if (!$_SESSION['scheduled_recordings']['disp_scheduled'] || $_GET['skip_scheduled'])
                        continue;
                }
            // Skip conflicting shows?
                elseif (in_array($show->recstatus, array('Conflict', 'Overlap'))) {
                    if (!$_SESSION['scheduled_recordings']['disp_conflicts'] || $_GET['skip_conflicts'])
                        continue;
                }
            // Skip duplicate or ignored shows?
                elseif (in_array($show->recstatus, array('NeverRecord', 'PreviousRecording', 'CurrentRecording'))) {
                    if (!$_SESSION['scheduled_recordings']['disp_duplicates'] || $_GET['skip_duplicates'])
                        continue;
                }
            // Skip deactivated shows?
                elseif ($show->recstatus != 'Recording') {
                    if (!$_SESSION['scheduled_recordings']['disp_deactivated'] || $_GET['skip_deactivated'])
                        continue;
                }
            // Show specific recgroup only
                if (($_SESSION['scheduled_recordings']['disp_recgroup'] && $show->recgroup != $_SESSION['scheduled_recordings']['disp_recgroup'])
                    || ($_GET['recgroup'] && $show->recgroup != $_GET['recgroup']))
                    continue;
            // Show specific title only
                if (($_SESSION['scheduled_recordings']['disp_title'] && $show->title != $_SESSION['scheduled_recordings']['disp_title'])
                    || ($_GET['title'] && $show->title != $_GET['title']))
                    continue;
            // Assign a reference to this show to the various arrays
                $all_shows[] =& $show;
            }
        }
    }
    unset($show);

// Sort the programs
    if (count($all_shows))
    {
        sort_programs($all_shows, 'scheduled_sortby');

        uksort($Groups, 'by_no_articles');
        uksort($Program_Titles, 'by_no_articles');
    }

// Load the class for this page
    require tmpl_dir.'upcoming.php';

// Exit
    exit;
