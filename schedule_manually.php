<?php
/***                                                                        ***\
    schedule_manually.php                      Last Updated: 2005.01.23 (xris)

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


// Passed in a recording schedule id?  Load the starttime/endtime for it
//    if ($_GET['recordid'])
//        $this_program =& load_all_schedules($_GET['recordid']);
// Grab the one and only program on this channel that starts at the specified time
//    else
//        $this_program =& load_one_program($_GET['starttime'], $_GET['chanid']);

// Make sure we have channel info
    $this_channel = $Channels[$_POST['channel']];

// Make sure this is a valid program.  If not, forward the user back to the listings page
//    if (!strlen($this_program->title)) {
//        header("Location: program_listing.php?time=".$_SESSION['list_time']);
//        exit;
//    }

// The user tried to update the recording settings - update the database and the variable in memory
       if (isset($_POST['save'])) {
       if (isset($_POST['profile']))
            $this_program->profile     = $_POST['profile'];
        if (isset($_POST['recpriority']))
            $this_program->recpriority = $_POST['recpriority'];
        if (isset($_POST['maxepisodes']))
            $this_program->maxepisodes = $_POST['maxepisodes'];
        if (isset($_POST['startoffset']))
            $this_program->startoffset = $_POST['startoffset'];
        if (isset($_POST['endoffset']))
            $this_program->endoffset   = $_POST['endoffset'];
        if (isset($_POST['recgroup']))
            $this_program->recgroup    = $_POST['recgroup'];
        $this_program->dupin      = isset($_POST['dupin'])         ? $_POST['dupin']     : 15;
        $this_program->dupmethod  = isset($_POST['dupmethod'])     ? $_POST['dupmethod'] : 6;
        $this_program->autoexpire = ($_POST['autoexpire'] == 'on') ? 1 : 0;
        $this_program->maxnewest  = ($_POST['maxnewest']  == 'on') ? 1 : 0;
    // Which type of recording is this?
        $this_program->will_record    = false;
        $this_program->record_once    = false;
        $this_program->record_daily   = false;
        $this_program->record_channel = false;
        $this_program->record_always  = false;
        $this_program->record_weekly  = false;
        $this_program->record_findone = false;
        if ($_POST['record'])
            $this_program->type = $_POST['record'];
        else
            $this_program->type = 0;
        $this_program->chanid = $_POST['channel'];
        $this_program->starttime = $_POST['starttime'];
        $this_program->startdate = $_POST['startdate'];

        $start_timestamp = mktime(substr($_POST['starttime'],0,2), substr($_POST['starttime'],3,2), substr($_POST['starttime'],6,2), substr($_POST['startdate'], 5,2), substr($_POST['startdate'],8,2), substr($_POST['startdate'],0,4));

        $end_timestamp = $start_timestamp + ($_POST['length'] * 60);

        $this_program->endtime = date('H:i:s', $start_timestamp + ($_POST['length'] * 60));
        $this_program->enddate = date('Y-m-d', $start_timestamp + ($_POST['length'] * 60));

        if ($_POST['title'] == "use callsign")
            $this_program->title = $this_channel->channum . " " . $this_channel->callsign;
        else
            $this_program->title = $_POST['title'];

        if ($_POST['subtitle'] == "use datetime")
            $this_program->subtitle = $this_program->startdate . " " . $this_program->starttime . " (" . $_POST['length'] . " min)";
        else
            $this_program->subtitle = $_POST['subtitle'];
        $this_program->description = "Manually scheduled";

    // Insert this recording choice into the database?
        if ($this_program->type > 0) {
           $result = mysql_query('REPLACE INTO program (chanid,starttime,endtime,title,subtitle,description,category) values ('
                                        .escape($this_program->chanid)                     .','
                                        .'FROM_UNIXTIME('.escape($start_timestamp)         .'),'
                                        .'FROM_UNIXTIME('.escape($end_timestamp)           .'),'
                                        .escape($this_program->title)                      .','
                                        .escape($this_program->subtitle)                   .','
                                        .escape($this_program->description)                .','
                                        ."'Manual recording'"                              .')')
                    or trigger_error('SQL Error: '.mysql_error(), FATAL);



           $result = mysql_query('REPLACE INTO record (recordid,type,chanid,station,starttime,startdate,endtime,enddate,title,subtitle,description,profile,recpriority,recgroup,dupin,dupmethod,maxnewest,maxepisodes,autoexpire,startoffset,endoffset,seriesid,programid,category) values ('
                                        .escape($this_program->recordid, true)             .','
                                        .escape($this_program->type)                       .','
                                        .escape($this_program->chanid)                     .','
                                        .escape($this_channel->callsign)                   .','
                                        .escape($this_program->starttime)                  .','
                                        .escape($this_program->startdate)                  .','
                                        .escape($this_program->endtime)                    .','
                                        .escape($this_program->enddate)                    .','
                                        .escape($this_program->title)                      .','
                                        .escape($this_program->subtitle)                   .','
                                        .escape($this_program->description)                .','
                                        .escape($this_program->profile)                    .','
                                        .escape($this_program->recpriority)                .','
                                        .escape($this_program->recgroup)                   .','
                                        .escape($this_program->dupin)                      .','
                                        .escape($this_program->dupmethod)                  .','
                                        .escape($this_program->maxnewest)                  .','
                                        .escape($this_program->maxepisodes)                .','
                                        .escape($this_program->autoexpire)                 .','
                                        .escape($this_program->startoffset)                .','
                                        .escape($this_program->endoffset)                  .','
                                        .escape($this_program->seriesid)                   .','
                                        .escape($this_program->programid)                  .','
                                        ."'Manual recording'"                                .')')
                    or trigger_error('SQL Error: '.mysql_error(), FATAL);
                $recordid = mysql_insert_id();
                if (mysql_affected_rows() < 1 || $recordid < 1)
                    trigger_error('Error creating recording schedule - no id was returned', FATAL);
                elseif ($this_program->recordid && $this_program->recordid != $recordid)
                    trigger_errpr('Error updating recording schedule - different id was returned', FATAL);
                else
                    $this_program->recordid = $recordid;
            }
        // Make sure the variable in memory gets updated
            $this_program->will_record = true;
        }
        else
            $this_program->recordid = NULL;
// Notify the backend of the changes
    if ($this_program->recordid > 0)
        backend_notify_changes($this_program->recordid);
    else
        backend_notify_changes();


// Load the recording profiles
    $Profiles = array('Default', 'Live TV', 'High Quality', 'Low Quality');

// Load the recording groups
    $Groups['Default'] = 'Default';
    $result = mysql_query('SELECT DISTINCT recgroup FROM record');
    while (list($group) = mysql_fetch_row($result)) {
        $group or $group = 'Default';
        $Groups[$group]  = $group;
    }
    mysql_free_result($result);

    $result = mysql_query('SELECT DISTINCT recgroup FROM recorded');
    while (list($group) = mysql_fetch_row($result)) {
        $group or $group = 'Default';
        $Groups[$group]  = $group;
    }
    mysql_free_result($result);

// Load the class for this page
    require_once theme_dir.'schedule_manually.php';

// Create an instance of this page from its theme object
    $Page = new Theme_schedule_manually();

// Display the page
    $Page->print_page($Channels);

// Exit
    exit;


?>

