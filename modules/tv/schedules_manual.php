<?php
/**
 * Schedule a custom recording by manually specifying starttime and length
 *
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Path-based
    if ($Path[3])
        $_GET['recordid'] = $Path[3];

// Load an existing schedule?
    if ($_GET['recordid']) {
        $schedule =& Schedule::find($_GET['recordid']);
    // Not a manual schedule
        if (empty($schedule->search) || $schedule->search != searchtype_manual)
            redirect_browser(root_url.'tv/schedules');
    }
// Create a new, empty schedule
    else
        $schedule = new Schedule(NULL);

// The user tried to update the recording settings - update the database and the variable in memory
    if (isset($_POST['save'])) {
    // Which type of recording is this?  Make sure an illegal one isn't specified
        switch ($_POST['record']) {
        // Only certain rectypes are allowed
            case rectype_once:        $type = rectype_once;        break;
            case rectype_daily:       $type = rectype_daily;       break;
            case rectype_weekly:      $type = rectype_weekly;      break;
        // Can override
            case rectype_override:    $type = rectype_override;    break;
            case rectype_dontrec:     $type = rectype_dontrec;     break;
        // Everything else gets ignored
            default:                  $type = 0;
        }
    // Cancelling a schedule?
        if ($type == 0) {
        // Cancel this schedule
            if ($schedule && $schedule->recordid) {
            // Delete the schedule
                $schedule->delete();
            // Redirect back to the schedule list
                add_warning(t('The requested recording schedule has been deleted.'));
                save_session_errors();
                header('Location: '.root_url.'tv/schedules');
                exit;
            }
        }
    // Adding a new schedule
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
            $schedule->autometadata  = $_POST['autometadata'] ? 1 : 0;
            $schedule->maxnewest     = $_POST['maxnewest']    ? 1 : 0;
            $schedule->dupin         = _or($_POST['dupin'] + $_POST['dupin2'], dupsin_all);
            $schedule->dupmethod     = _or($_POST['dupmethod'], 6);
            $schedule->recpriority   = intval($_POST['recpriority']);
            $schedule->maxepisodes   = intval($_POST['maxepisodes']);
            $schedule->startoffset   = intval($_POST['startoffset']);
            $schedule->endoffset     = intval($_POST['endoffset']);
            $schedule->prefinput     = $_POST['prefinput'];
        // Some settings specific to manual recordings (since we have no program to match against)
            $schedule->chanid        = $_POST['channel'];
            $schedule->station       = Channel::find($schedule->chanid)->callsign;
            $schedule->starttime     = strtotime($_POST['startdate'].' '.$_POST['starttime']);
            $schedule->endtime       = $schedule->starttime + ($_POST['length'] * 60);
            $schedule->description   = 'Manually scheduled';
            $schedule->category      = 'Manual recording';
            $schedule->search        = searchtype_manual;
            $schedule->findday       = date('w',     $schedule->starttime);
            $schedule->findtime      = date('H:m:s', $schedule->starttime);
            $schedule->autotranscode = $_POST['autotranscode'] ? 1 : 0;
            $schedule->transcoder    = $_POST['transcoder'];
        // Figure out the title
            $channel =& Channel::find($_POST['channel']);
            if (strcasecmp($_POST['title'], t('Use callsign')) == 0) {
                if ($_SESSION["prefer_channum"])
                    $schedule->title = $channel->channum.' ('.$channel->callsign.')';
                else
                    $schedule->title = $channel->callsign.' ('.$channel->channum.')';
            }
            else
                $schedule->title = $_POST['title'];
        // Now the subtitle
            if (strcasecmp($_POST['subtitle'], t('Use date/time')) == 0)
                $schedule->subtitle = date('Y-m-d H:i:s', $schedule->starttime)
                                     .' ('.tn('$1 min', '$1 mins', $_POST['length']).')';
            else
                $schedule->subtitle = $_POST['subtitle'];
        // Save the schedule
            $schedule->save($type);
        // Redirect to the new schedule
            header('Location: '.root_url.'tv/schedules/manual/'.$schedule->recordid);
            exit;
        }
    }
// Load default settings for recpriority, autoexpire etc
    else {
    // Default title/subtitle
        if (!$schedule->title) {
            $schedule->title    = t('Use callsign');
            $schedule->subtitle = t('Use date/time');
        }
    // Make sure we have a default rectype
        if (!$schedule->type)
            $schedule->type = rectype_once;
    // Date/time/etc
        if (!$schedule->starttime)
            $schedule->starttime = time();
    // Load default values from Default recording rule template
        $schedule->merge(Schedule::recording_template('Default'));
    }

// Calculate the length
    $schedule->length = intval(($schedule->endtime - $schedule->starttime) / 60);
    if ($schedule->length < 1)
        $schedule->length = 120;

// Load the utility/display functions for scheduling
    require_once 'includes/schedule_utils.php';

// Load the class for this page
    require_once tmpl_dir.'schedules_manual.php';

// Exit
    exit;

/**
 * prints a <select> of the available channels
/**/
    function channel_select($chanid) {
        $Channel_list = Channel::getChannelList();
        echo '<select name="channel">';
        $seen = array();
        foreach ($Channel_list as $this_chanid) {
            $channel =& Channel::find($this_chanid);

        // Print the option
            echo '<option value="', $channel->chanid, '"',
                 ' title="', html_entities($channel->name), '"';
        // Selected?
            if ($channel->chanid == $chanid)
                echo ' SELECTED';
        // Print the rest of the content
            echo '>';
            if ($_SESSION["prefer_channum"])
                echo $channel->channum.'&nbsp;&nbsp;('.html_entities($channel->callsign).')';
            else
                echo html_entities($channel->callsign).'&nbsp;&nbsp;('.$channel->channum.')';
            echo '</option>';
        }
        echo '</select>';
    }
