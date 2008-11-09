<?php
/**
 * This displays details about a program, as well as provides recording
 * commands.
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

// Just a quick ajax responder to track show/hide of the advanced options
    if (isset($_REQUEST['show_advanced_schedule'])) {
        $_SESSION['tv']['show_advanced_schedule'] = !empty($_REQUEST['show_advanced_schedule']);
        exit;
    }

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

// Set to defaults
    if ( !isset($_SESSION['recording_details'] )) {
        $_SESSION['recording_details']['show_Conflict'] = true;
	$_SESSION['recording_details']['show_PreviousRecording'] = true;
	$_SESSION['recording_details']['show_EarlierShowing'] = true;
	$_SESSION['recording_details']['show_CurrentRecording'] = true;
	$_SESSION['recording_details']['show_WillRecord'] = true;
    }

    if ( isset($_POST['change_display'])) {
        $_SESSION['recording_details']['show_Conflict']          = $_POST['Conflict'];
        $_SESSION['recording_details']['show_PreviousRecording'] = $_POST['PreviousRecording'];
        $_SESSION['recording_details']['show_EarlierShowing']    = $_POST['EarlierShowing'];
        $_SESSION['recording_details']['show_CurrentRecording']  = $_POST['CurrentRecording'];
        $_SESSION['recording_details']['show_WillRecord']        = $_POST['WillRecord'];
    }

// Auto-expire -- only available for javascript templates
    if (isset($_REQUEST['toggle_autoexpire']) && $_GET['chanid'] && $_GET['starttime']) {
        $sh = $db->query('UPDATE recorded
                             SET autoexpire = ?
                           WHERE chanid = ? AND starttime = FROM_UNIXTIME(?)',
                         $_REQUEST['toggle_autoexpire'] ? 1 : 0,
                         $_GET['chanid'],
                         $_GET['starttime']);
    // Report back, and then exit.
        if ($sh->affected_rows())
            echo 'success';
        exit;
    }

// Load the jobqueue info
    require_once 'includes/jobqueue.php';

// Load the sorting routines
    require_once 'includes/sorting.php';

// Load the program info, unless a schedule was requested
    $program = null;
    if (empty($_GET['recordid'])) {
    // Starttime in the past -- See if it's a recording
        if ($_GET['starttime'] < time()) {
            $record = get_backend_rows('QUERY_RECORDING TIMESLOT '.$_GET['chanid'].' '.unix2mythtime($_GET['starttime']), 1);
            if (is_array($record[0]) && $_GET['chanid'] == $record[0][4] && $_GET['starttime'] == $record[0][26]) {
                $program =& new Program($record[0]);
            }
        }
    // Load the program
        if (empty($program) || !$program->recstartts)
            $program =& load_one_program($_GET['starttime'], $_GET['chanid'], $_GET['manualid']);
    }

// Get the schedule for this recording, if one exists
    global $Schedules;
    if ($program->recordid)
        $schedule =& $Schedules[$program->recordid];
    elseif ($_GET['recordid'])
        $schedule =& $Schedules[$_GET['recordid']];
    else
        $schedule = new Schedule(NULL);

// Handle custom search schedules.  This will cause the "cancel" or "don't"
// option to be selected as "schedule via custom search"
    if ($schedule->search && $schedule->search != searchtype_manual) {
        $schedule->type = null;
    }

// Make sure this is a valid program.  If not, forward the user back to the listings page
    if (!strlen($program->starttime) && !$schedule->recordid) {
        if ($_GET['recordid']) {
            add_warning(t('Unknown Recording Schedule.'));
            header('Location: '.root.'tv/schedules');
        }
        else {
            add_warning(t('Unknown Program.'));
            header('Location: '.root.'tv/list?time='.$_SESSION['list_time']);
        }
        save_session_errors();
        exit;
    }

// If there is a program for this, import its values into the schedule
    if ($program) {
    // Back up the search title
        if ($schedule->search) {
            $schedule->search_title = $schedule->title;
        }
        $schedule->chanid            = $program->chanid;
        $schedule->starttime         = $program->starttime;
        $schedule->endtime           = $program->endtime;
        $schedule->title             = $program->title;
        $schedule->subtitle          = $program->subtitle;
        $schedule->description       = $program->description;
        $schedule->fancy_description = $program->fancy_description;
        $schedule->category          = $program->category;
        $schedule->station           = $program->channel->callsign;       // Note that "callsign" becomes "station"
        $schedule->seriesid          = $program->seriesid;
        $schedule->programid         = $program->programid;
    }

// Queue a job?
    if ($program && $program->filename && $_REQUEST['job']) {
        $db->query('INSERT INTO jobqueue
                       SET chanid     = ?,
                           starttime  = FROM_UNIXTIME(?),
                           inserttime = NOW(),
                           type       = ?,
                           hostname   = "",
                           args       = "",
                           status     = ?,
                           statustime = NOW(),
                           comment    = "Queued via MythWeb",
                           flags      = ?',
                   $program->chanid,
                   $program->recstartts,
                   $_REQUEST['job'],
                   JOB_QUEUED,
                   JOB_USE_CUTLIST
                  );
        backend_notify_changes();
    // Redirect back to the page again, but without the query string, so the
    // user doesn't accidentally repost this request on a page reload.
        redirect_browser(root.'tv/detail/'.$program->chanid.'/'.$program->recstartts);
    }

// The user tried to update the recording settings - update the database and the variable in memory
    if (isset($_POST['save'])) {
        if ($schedule) {
        // Which type of recording is this?  Make sure an illegal one isn't specified
            switch ($_POST['record']) {
                case rectype_once:        $type = rectype_once;        break;
                case rectype_daily:       $type = rectype_daily;       break;
                case rectype_channel:     $type = rectype_channel;     break;
                case rectype_always:      $type = rectype_always;      break;
                case rectype_weekly:      $type = rectype_weekly;      break;
                case rectype_findone:     $type = rectype_findone;     break;
                case rectype_finddaily:   $type = rectype_finddaily;   break;
                case rectype_findweekly:  $type = rectype_findweekly;  break;
                case rectype_override:    $type = rectype_override;    break;
                case rectype_dontrec:     $type = rectype_dontrec;     break;
                default:                  $type = 0;
            }
        // Probably cancelling a schedule?
            if ($type == 0) {
            // Changing something about the currently selected search schedule?
            /** @todo Search schedules go a little funny here.  If we try to save them,
             *  the search settings will be overwritten by the program's info
             *  subtitle, etc). */
                if ($schedule->search) {
                    add_warning('Modifications to search schedules cannot yet be made from this page.');
                }
            // Cancel this schedule
                elseif ($schedule && $schedule->recordid) {
                // Delete the schedule
                    $schedule->delete();
                // Try to cancel the currently recording program if we can
                    if ($program)
                        $program->stopRecording();
                // Deleted a schedule but not editing a specific program?  Redirect back to the schedule list
                    if (!$program) {
                        add_warning(t('The requested recording schedule has been deleted.'));
                        save_session_errors();
                        header('Location: '.root.'tv/schedules');
                        exit;
                    }
                // Relocate back to the program details page
                    redirect_browser(root.'tv/detail/'.$schedule->chanid.'/'.$schedule->starttime);
                }
            }
        // Modifying an existing schedule, or adding a new one
            else {
            // Set things as the user requested
                $schedule->profile       = $_POST['profile'];
                $schedule->recgroup      = $_POST['recgroup'];
                $schedule->storagegroup  = $_POST['storagegroup'];
                $schedule->playgroup     = $_POST['playgroup'];
                $schedule->autoexpire    = $_POST['autoexpire']   ? 1 : 0;
                $schedule->autocommflag  = $_POST['autocommflag'] ? 1 : 0;
                $schedule->autouserjob1  = $_POST['autouserjob1'] ? 1 : 0;
                $schedule->autouserjob2  = $_POST['autouserjob2'] ? 1 : 0;
                $schedule->autouserjob3  = $_POST['autouserjob3'] ? 1 : 0;
                $schedule->autouserjob4  = $_POST['autouserjob4'] ? 1 : 0;
                $schedule->maxnewest     = $_POST['maxnewest']    ? 1 : 0;
                $schedule->inactive      = $_POST['inactive']     ? 1 : 0;
                $schedule->dupin         = _or($_POST['dupin'] + $_POST['dupin2'], dupsin_all);
                $schedule->dupmethod     = _or($_POST['dupmethod'], 6);
                $schedule->recpriority   = intval($_POST['recpriority']);
                $schedule->maxepisodes   = intval($_POST['maxepisodes']);
                $schedule->startoffset   = intval($_POST['startoffset']);
                $schedule->endoffset     = intval($_POST['endoffset']);
                $schedule->autotranscode = $_POST['autotranscode'] ? 1 : 0;
                $schedule->transcoder    = $_POST['transcoder'];
                $schedule->tsdefault     = $_POST['timestretch'];
                $schedule->prefinput     = $_POST['prefinput'];
            // Keep track of the parent recording for overrides
                if ($_POST['record'] == rectype_override) {
                    $schedule->parentid = $schedule->recordid;
                }
            // Search schedules saved here will create a new standard schedule,
            // so we should wipe out the old search-type data.
                if ($schedule->search) {
                    $schedule->recordid = null;
                }
                $schedule->search = 0;
            // Back up the program type, and save the schedule
                $schedule->save($type);
            }
        }
    // Redirect back to the page again, but without the query string, so reloads are cleaner
        redirect_browser(root.'tv/detail/'.$program->chanid.'/'.$program->starttime);
    }
    elseif ($_REQUEST['forget_old']) {
        $program->rec_forget_old();
    // Wait for a second so the backend can catch up
        sleep(1);

    // Redirect back to the page again, but without the query string, so reloads are cleaner
        redirect_browser(root.'tv/detail/'.$program->chanid.'/'.$program->starttime);
    }
    elseif (isset($_GET['never_record']) || isset($_POST['never_record'])) {
        $program->rec_never_record();
    // Wait for a second so the backend can catch up
        sleep(1);

    // Redirect back to the page again, but without the query string, so reloads are cleaner
        redirect_browser(root.'tv/detail/'.$program->chanid.'/'.$program->starttime);
    }
// Load default settings for recpriority, autoexpire etc
    else {
    // auto-commercial-flag
        if (!isset($schedule->autocommflag))
            $schedule->autocommflag = get_backend_setting('AutoCommercialFlag');
    // auto-user-jobs
        if (!isset($schedule->autouserjob1))
            $schedule->autouserjob1 = get_backend_setting('AutoRunUserJob1');
        if (!isset($schedule->autouserjob2))
            $schedule->autouserjob2 = get_backend_setting('AutoRunUserJob2');
        if (!isset($schedule->autouserjob3))
            $schedule->autouserjob3 = get_backend_setting('AutoRunUserJob3');
        if (!isset($schedule->autouserjob4))
            $schedule->autouserjob4 = get_backend_setting('AutoRunUserJob4');
    // auto-transcode
        if (!isset($schedule->autotranscode))
            $schedule->autotranscode = get_backend_setting('AutoTranscode');
    // transcoder
        if (!isset($schedule->transcoder))
            $schedule->transcoder = get_backend_setting('DefaultTranscoder');
    // recpriority
        if (!isset($schedule->recpriority)) {
            $schedule->recpriority = $db->query_col('SELECT recpriority from channel where chanid=?',
                                                    $program->chanid);
        }
    // autoexpire
        if (!isset($schedule->autoexpire))
            $schedule->autoexpire = get_backend_setting('AutoExpireDefault');
    // start early / end late
        if (!isset($schedule->startoffset))
            $schedule->startoffset = get_backend_setting('DefaultStartOffset');
        if (!isset($schedule->endoffset))
            $schedule->endoffset = get_backend_setting('DefaultEndOffset');
    }

// Load the channel
    if ($program)
        $channel =& $program->channel;
    else
        $channel =& load_one_channel($schedule->chanid);

// Parse the list of scheduled recordings for possible conflicts
    global $Scheduled_Recordings;
    $conflicting_shows = array();
    foreach ($Scheduled_Recordings as $callsign => $shows) {
    // Now the shows in this channel
        foreach ($shows as $starttime => $show_group) {
        // Clearly not a match
            if ($starttime > $program->endtime)
                continue;
        // Parse each show group
            foreach ($show_group as $key => $show) {
            // Ignore this show
                if ($show->chanid == $program->chanid && $show->starttime == $program->starttime)
                    continue;
            // Make sure this is a valid show (ie. skip in-progress recordings and other junk)
                if (!$callsign || $show->length < 1)
                    continue;
            // Not a conflict
                if ($show->endtime < $program->starttime)
                    continue;
            // Assign a reference to this show to the various arrays
                $conflicting_shows[] =& $Scheduled_Recordings[$callsign][$starttime][$key];
            }
        }
    }

// Sort the programs -- but don't use a session variable
    if (count($conflicting_shows)) {
        $GLOBALS['user_sort_choice'] = array(array('field' => 'title'),
                                             array('field' => 'subtitle'),
                                             array('field' => 'airdate')
                                            );
        usort($conflicting_shows, 'by_user_choice');
    }

// Load the jobqueue info before displaying
    if ($program && $program->filename) {
        $program->load_jobs();
    }

// Load the utility/display functions for scheduling
    require_once 'includes/schedule_utils.php';

// Display the page
    require_once tmpl_dir.'detail.php';

// Exit
    exit;
