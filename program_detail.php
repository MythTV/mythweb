<?php
/***                                                                        ***\
    program_detail.php                      Last Updated: 2004.04.19 (xris)

    This file is part of MythWeb, a php-based interface for MythTV.
    See README and LICENSE for details.

    This displays details about a program, as well as provides recording
    commands.
\***                                                                        ***/

// Initialize the script, database, etc.
    require_once "includes/init.php";


// Passed in a recording schedule id?  Load the starttime/endtime for it
    if ($_GET['recordid'])
        $this_program =& load_all_recordings($_GET['recordid']);
// Grab the one and only program on this channel that starts at the specified time
    else
        $this_program =& load_one_program($_GET['starttime'], $_GET['chanid']);

// Make sure we have channel info
    $this_channel =& $this_program->channel;

// Make sure this is a valid program.  If not, forward the user back to the listings page
    if (!strlen($this_program->title)) {
        header("Location: program_listing.php?time=".$_SESSION['list_time']);
        exit;
    }

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
        switch ($_POST['record']) {
            case 'once':
                $this_program->type = 1;
                $this_program->record_once    = true;
                break;
            case 'daily':
                $this_program->type = 2;
                $this_program->record_daily   = true;
                break;
            case 'channel':
                $this_program->type = 3;
                $this_program->record_channel = true;
                break;
            case 'always':
                $this_program->type = 4;
                $this_program->record_always  = true;
                break;
            case 'weekly':
                $this_program->type = 5;
                $this_program->record_weekly  = true;
                break;
            case 'findone':
                $this_program->type = 6;
                $this_program->record_findone = true;
                break;
            default:
                $this_program->type = 0;
        }
    // Wipe out any pre-existing settings for this program
        if (!$_GET['recordid'] || ($_GET['recordid'] && $this_program->type == 0)) {
            $result = mysql_query('DELETE FROM record WHERE (type=1 AND chanid='.escape($this_program->chanid).' AND title='.escape($this_program->title).' AND starttime=FROM_UNIXTIME('.escape($this_program->starttime).') AND startdate=FROM_UNIXTIME('.escape($this_program->starttime).'))'
                                                      .' OR (type=2 AND chanid='.escape($this_program->chanid).' AND title='.escape($this_program->title).' AND starttime=FROM_UNIXTIME('.escape($this_program->starttime).'))'
                                                      .' OR (type=3 AND chanid='.escape($this_program->chanid).' AND title='.escape($this_program->title).')'
                                                      .' OR (type=4 AND title=' .escape($this_program->title).')'
                                                      .' OR (type=6 AND title=' .escape($this_program->title).')'
                                                      .' OR (type=5 AND chanid='.escape($this_program->chanid).' AND title='.escape($this_program->title).' AND starttime=FROM_UNIXTIME('.escape($this_program->starttime).') AND DAYOFWEEK(startdate)='.escape(date('w', $this_program->starttime)+1).')'
                                                      .' OR (recordid='.escape($this_program->recordid).')');
        }
    // Insert this recording choice into the database?
        if ($this_program->type > 0) {
            if ($_GET['recordid']) {
                $result = mysql_query('UPDATE record SET'
                                        .' type='          .escape($this_program->type)
                                        .', profile='      .escape($this_program->profile)
                                        .', recpriority='  .escape($this_program->recpriority)
                                        .', autoexpire='   .escape($this_program->autoexpire)
                                        .', maxnewest='    .escape($this_program->maxnewest)
                                        .', dupin='        .escape($this_program->dupin)
                                        .', dupmethod='    .escape($this_program->dupmethod)
                                        .', startoffset='  .escape($this_program->startoffset)
                                        .', endoffset='    .escape($this_program->endoffset)
                                        .' WHERE recordid='.escape($_GET['recordid']))
                    or trigger_error('SQL Error: '.mysql_error(), FATAL);
            }
            else {
				$AutoCommercialFlag = get_backend_setting("AutoCommercialFlag");
                $result = mysql_query('REPLACE INTO record (recordid,type,chanid,station,starttime,startdate,endtime,enddate,title,subtitle,description,category,profile,recpriority,recgroup,dupin,dupmethod,maxnewest,maxepisodes,autoexpire,startoffset,endoffset,seriesid,programid,autocommflag) values ('
                                        .escape($this_program->recordid, true)             .','
                                        .escape($this_program->type)                       .','
                                        .escape($this_program->chanid)                     .','
                                        .escape($this_channel->callsign)                   .','
                                        .'FROM_UNIXTIME('.escape($this_program->starttime).'),'
                                        .'FROM_UNIXTIME('.escape($this_program->starttime).'),'
                                        .'FROM_UNIXTIME('.escape($this_program->endtime)  .'),'
                                        .'FROM_UNIXTIME('.escape($this_program->endtime)  .'),'
                                        .escape($this_program->title)                      .','
                                        .escape($this_program->subtitle)                   .','
                                        .escape($this_program->description)                .','
                                        .escape($this_program->category)                   .','
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
                                        .escape($AutoCommercialFlag)                       .')')
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
        backend_notify_changes();
    }
// Load default settings for recpriority, autoexpire etc
    elseif (!$this_program->will_record) {
        $result = mysql_query('SELECT recpriority from channel where chanid='.escape($this_program->chanid));
        list($this_program->recpriority) = mysql_fetch_row($result);
        mysql_free_result($result);
        $result = mysql_query("SELECT data from settings where value='AutoExpireDefault'");
        list($this_program->autoexpire) = mysql_fetch_row($result);
        mysql_free_result($result);
    }

// Load the recording profiles
    $Profiles = array('Default', 'Live TV', 'High Quality', 'Low Quality');

// Load the class for this page
    require_once theme_dir.'program_detail.php';

// Create an instance of this page from its theme object
    $Page = new Theme_program_detail();

// Display the page
    $Page->print_page();

// Exit
    exit;


?>
