<?php
/***                                                                        ***\
    schedule_manually.php                      Last Updated: 2005.02.08 (xris)

    This file is part of MythWeb, a php-based interface for MythTV.
    See README and LICENSE for details.

    This offers the possibility to manually schedule a recording.
\***                                                                        ***/

// Which section are we in?
    define('section', 'tv');

// Initialize the script, database, etc.
    require_once "includes/init.php";

// Populate the $Channels array
    load_all_channels();


// Create a new, empty schedule
    $schedule = new Schedule(NULL);

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
    // For now, we only have one schedule type
        $type = rectype_once;
    // Adding a new schedule
        if ($type != 0) {
        // Make sure we have channel info
            $channel = $Channels[$_POST['channel']];
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
        // Some settings specific to manual recordings (since we have no program to match against)
            $schedule->chanid      = $_POST['channel'];
            $schedule->station     = $Channels[$schedule->chanid]->callsign;
            $schedule->starttime   = strtotime($_POST['startdate'].' '.$_POST['starttime']);
            $schedule->endtime     = $schedule->starttime + ($_POST['length'] * 60);
            $schedule->description = 'Manually scheduled';
            $schedule->category    = 'Manual recording';
        // Figure out the title
            if (strcasecmp($_POST['title'], 'use callsign') == 0) {
                if (prefer_channum)
                    $schedule->title = $channel->channum.' ('.$channel->callsign.')';
                else
                    $schedule->title = $channel->callsign.' ('.$channel->channum.')';
            }
            else
                $schedule->title = $_POST['title'];
        // Now the subtitle
            if (strcasecmp($_POST['subtitle'], 'use datetime') == 0)
                $schedule->subtitle = date('Y-m-d H:i:s', $schedule->starttime)
                                     .' ('.tn('$1 min', '$1 mins', $_POST['length']).')';
            else
                $schedule->subtitle = $_POST['subtitle'];
        // Insert a blank program entry so the scheduler has something to match against
           $result = mysql_query('REPLACE INTO program (chanid,starttime,endtime,title,subtitle,description,category) VALUES ('
                                        .escape($schedule->chanid)                    .','
                                        .'FROM_UNIXTIME('.escape($schedule->starttime).'),'
                                        .'FROM_UNIXTIME('.escape($schedule->endtime)  .'),'
                                        .escape($schedule->title)                     .','
                                        .escape($schedule->subtitle)                  .','
                                        .escape($schedule->description)               .','
                                        .escape($schedule->category)                  .')')
                    or trigger_error('SQL Error: '.mysql_error(), FATAL);
        // Save the schedule
            $schedule->save($type);
        // Redirect to the new schedule
            header('Location: program_detail.php?recordid='.$schedule->recordid);
            exit;
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

// Load the class for this page
    require_once theme_dir.'schedule_manually.php';

// Create an instance of this page from its theme object
    $Page = new Theme_schedule_manually();

// Display the page
    $Page->print_page($Channels);

// Exit
    exit;


/*
    channel_select:
    prints a <select> of the available channels
*/
    function channel_select($name = 'channel') {
        global $Channels;
        echo "<select name=\"$name\">";
        foreach ($Channels as $channel) {
        // Ignore invisible channels
            if ($channel->visible == 0)
                continue;
        // Print the option
            echo '<option value="'.$channel->chanid.'">';
            if (prefer_channum)
                echo $channel->channum.'&nbsp;&nbsp;('.htmlentities($channel->callsign).')';
            else
                echo htmlentities($channel->callsign).'&nbsp;&nbsp;('.$channel->channum.')';
            echo '</option>';
        }
        echo '</select>';
    }
?>

