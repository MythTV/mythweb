<?php
/***                                                                        ***\
    program_detail.php                      Last Updated: 2005.02.06 (xris)

    This file is part of MythWeb, a php-based interface for MythTV.
    See README and LICENSE for details.

    This displays details about a program, as well as provides recording
    commands.
\***                                                                        ***/

// Which section are we in?
    define('section', 'tv');

// Initialize the script, database, etc.
    require_once "includes/init.php";

// Load the program info, unless a schedule was requested
    if ($_GET['recordid'])
        $program = null;
    else
        $program =& load_one_program($_GET['starttime'], $_GET['chanid']);

// Get the schedule for this recording, if one exists
    global $Schedules;
    if ($program->recordid)
        $schedule =& $Schedules[$program->recordid];
    elseif ($_GET['recordid'])
        $schedule =& $Schedules[$_GET['recordid']];
    else
        $schedule = new Schedule(NULL);

// Make sure this is a valid program.  If not, forward the user back to the listings page
    if (!strlen($program->starttime) && !$schedule->recordid) {
        if ($_GET['recordid']) {
            add_warning(t('Unknown Recording Schedule.'));
            header('Location: recording_schedules.php');
        }
        else {
            add_warning(t('Unknown Program.'));
            header("Location: program_listing.php?time=".$_SESSION['list_time']);
        }
        save_session_errors();
        exit;
    }

// If there is a program for this, import its values into the schedule
    if ($program) {
        $schedule->chanid      = $program->chanid;
        $schedule->starttime   = $program->starttime;
        $schedule->endtime     = $program->endtime;
        $schedule->title       = $program->title;
        $schedule->subtitle    = $program->subtitle;
        $schedule->description = $program->description;
        $schedule->category    = $program->category;
        $schedule->station     = $program->channel->callsign;       // Note that "callsign" becomes "station"
        $schedule->seriesid    = $program->seriesid;
        $schedule->programid   = $program->programid;
    }

// The user tried to update the recording settings - update the database and the variable in memory
    if (isset($_POST['save'])) {
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
    // Cancelling a schedule?
        if ($type == 0) {
        // Cancel this schedule
            if ($schedule && $schedule->recordid) {
            // Delete the schedule
                $schedule->delete();
            // Deleted a schedule but not editing a specific program?  Redirect back to the schedule list
                if (!$program) {
                    add_warning(t('The requested recording schedule has been deleted.'));
                    save_session_errors();
                    header('Location: recording_schedules.php');
                    exit;
                }
            // Relocate back to the program details page
                header('Location: program_detail.php?chanid='.$schedule->chanid.'&starttime='.$schedule->starttime);
            }
        // Nothing to do -- it wasn't scheduled in the first place
        //  else { }
        }
    // Modifying an existing schedule, or adding a new one
        else {
        // Set things as the user requested
            $schedule->profile      = $_POST['profile'];
            $schedule->recgroup     = $_POST['recgroup'];
            $schedule->autoexpire   = $_POST['autoexpire']   ? 1 : 0;
            $schedule->autocommflag = $_POST['autocommflag'] ? 1 : 0;
            $schedule->maxnewest    = $_POST['maxnewest']    ? 1 : 0;
            $schedule->dupin        = _or($_POST['dupin'],    15);
            $schedule->dupmethod    = _or($_POST['dupmethod'], 6);
            $schedule->recpriority  = intval($_POST['recpriority']);
            $schedule->maxepisodes  = intval($_POST['maxepisodes']);
            $schedule->startoffset  = intval($_POST['startoffset']);
            $schedule->endoffset    = intval($_POST['endoffset']);
        // Back up the program type, and save the schedule
            $schedule->save($type);
        }
    }
// Load default settings for recpriority, autoexpire etc
    else {
    // auto-commercial-flag
        if (!isset($schedule->autocommflag))
            $schedule->autocommflag = get_backend_setting('AutoCommercialFlag');
    // recpriority
        if (!isset($schedule->recpriority)) {
            $result = mysql_query('SELECT recpriority from channel where chanid='.escape($program->chanid));
            list($schedule->recpriority) = mysql_fetch_row($result);
            mysql_free_result($result);
        }
    // autoexpire
        if (!isset($schedule->autoexpire)) {
            $result = mysql_query("SELECT data from settings where value='AutoExpireDefault'");
            list($schedule->autoexpire) = mysql_fetch_row($result);
            mysql_free_result($result);
        }
    }

// Load the channel
    if ($program)
        $channel =& $program->channel;
    else
        $channel =& load_one_channel($schedule->chanid);

// Load the class for this page
    require_once theme_dir.'program_detail.php';

// Create an instance of this page from its theme object
    $Page = new Theme_program_detail();

// Display the page
    $Page->print_page($program, $schedule, $channel);

// Exit
    exit;

?>
