<?php
/**
 * The Schedule object and a couple of related subroutines.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Include our dependencies -- these are probably called elsewhere, but require_once will handle it
    require_once 'includes/mythbackend.php';
    require_once 'includes/channels.php';
    require_once 'includes/programs.php';
    require_once 'includes/css.php';

// Constants for the recording types
    define('rectype_once',        1);
    define('rectype_daily',       2);
    define('rectype_channel',     3);
    define('rectype_always',      4);
    define('rectype_weekly',      5);
    define('rectype_findone',     6);
    define('rectype_override',    7);
    define('rectype_dontrec',     8);
    define('rectype_finddaily',   9);
    define('rectype_findweekly', 10);

// Define the search types
    define('searchtype_power',    1);
    define('searchtype_title',    2);
    define('searchtype_keyword',  3);
    define('searchtype_people',   4);
    define('searchtype_manual',   5);

// Recording types -- enum at the top of libs/libmythtv/recordingtypes.h
    $RecTypes = array(
                      rectype_once       => t('rectype: once'),
                      rectype_daily      => t('rectype: daily'),
                      rectype_channel    => t('rectype: channel'),
                      rectype_always     => t('rectype: always'),
                      rectype_weekly     => t('rectype: weekly'),
                      rectype_findone    => t('rectype: findone'),
                      rectype_override   => t('rectype: override'),
                      rectype_dontrec    => t('rectype: dontrec'),
                      rectype_finddaily  => t('rectype: finddaily'),
                      rectype_findweekly => t('rectype: findweekly'),
                     );

// Global lists of recording schedules and scheduled recordings
    global $Schedules;
    $Schedules = array();
// Build the sql query, and execute it
    $query = 'SELECT *, IF(type='.rectype_always.',-1,chanid) as chanid,'
            .' UNIX_TIMESTAMP(startdate)+TIME_TO_SEC(starttime) AS starttime,'
            .' UNIX_TIMESTAMP(enddate)+TIME_TO_SEC(endtime) AS endtime'
            .' FROM record ';
    $result = mysql_query($query)
        or trigger_error('SQL Error: '.mysql_error(), FATAL);
// Load in all of the recordings (if any?)
    while ($row = mysql_fetch_assoc($result)) {
        $Schedules[$row['recordid']] =& new Schedule($row);
    }
// Cleanup
    mysql_free_result($result);

// Initialize
    global $Scheduled_Recordings, $Num_Conflicts, $Num_Scheduled;
    $Scheduled_Recordings = array();
    $Num_Conflicts        = 0;
    $Num_Scheduled        = 0;

// Load all of the scheduled recordings.  We will need them at some point, so we
// might as well get it overwith here.
    foreach (get_backend_rows('QUERY_GETALLPENDING', 2) as $key => $program) {
    // The offset entry
        if ($key === 'offset') {
            list($Num_Conflicts, $Num_Scheduled) = $program;
        }
    // Normal entry:  $Scheduled_Recordings[channum][starttime][]
        else {
            $Scheduled_Recordings[$program[5]][$program[11]][] =& new Program($program);
        }
    }

// Transcoder names
    global $Transcoders;
    $Transcoders = array();
    $Transcoders[0] = 'Autodetect';
    $result = mysql_query('SELECT r.id, r.name'
                    .' FROM recordingprofiles AS r, profilegroups AS p'
                    .' WHERE cardtype = "TRANSCODE"'
                    .'   AND r.profilegroup = p.id')
            or trigger_error('SQL Error: '.mysql_error(), FATAL);
    while ($row = mysql_fetch_assoc($result)) {
        if ($row['name'] != "RTjpeg/MPEG4" && $row['name'] != "MPEG2") {
            $Transcoders[$row['id']] = $row['name'];
        }
    }
    mysql_free_result($result);

/**
 * Recording Schedule class
/**/
class Schedule {

    var $recordid;
    var $type;
    var $chanid;
    var $starttime;
    var $endtime;
    var $title;
    var $subtitle;
    var $description;
    var $profile;
    var $recpriority;
    var $category;
    var $maxnewest;
    var $inactive;
    var $maxepisodes;
    var $autoexpire;
    var $startoffset;
    var $endoffset;
    var $recgroup;
    var $dupmethod;
    var $dupin;
    var $station;
    var $seriesid;
    var $programid;
    var $search;
    var $autotranscode;
    var $autocommflag;
    var $autouserjob1;
    var $autouserjob2;
    var $autouserjob3;
    var $autouserjob4;
    var $findday;
    var $findtime;
    var $findid;
    var $transcoder;
    var $parentid;

    var $texttype;
    var $channel;
    var $will_record = false;
    var $class;         // css class, based on category and/or category_type
    var $tsdefault;

    /**
     * constructor
    /**/
    function Schedule($data) {
    // Schedule object data -- just copy it into place
        if (is_object($data)) {
        // Not the right type of object?
            if (strcasecmp(get_class($data), 'schedule'))
                trigger_error("Incorrect object of class ".get_class($data)." passed to new Schedule()", FATAL);
        // Copy its variables into place
            $a = @get_object_vars($data);
            if (is_array($a) && count($a) > 0) {
                foreach ($a as $key => $val) {
                    $this->$key = $val;
                }
            }
        }
    // Empty Schedule
        elseif (is_null($data)) {
            $this->tsdefault = defined('default_rec_ts') ? default_rec_ts : 1.0;
            return;
        }
    // Something else
        else {
        // Data is a recordid -- load its contents
            if (!is_array($data) && $data > 0) {
                $query = 'SELECT *, IF(type='.rectype_always.',-1,chanid) as chanid,'
                        .' UNIX_TIMESTAMP(startdate)+TIME_TO_SEC(starttime) AS starttime,'
                        .' UNIX_TIMESTAMP(enddate)+TIME_TO_SEC(endtime) AS endtime'
                        .' FROM record WHERE recordid='.escape($data);
                $result = mysql_query($query)
                    or trigger_error('SQL Error: '.mysql_error(), FATAL);
                $data = mysql_fetch_assoc($result);
                mysql_free_result($result);
            }
        // Array?
            if (is_array($data) && isset($data['recordid'])) {
                foreach ($data as $key => $val) {
                    $this->$key = $val;
                }
            }
        }

    // Custom power search needs to have fields split out
        if ($this->search == searchtype_power) {
            #########
            /** @todo actually split out the fields! */
        }

    // Add a generic "will record" variable, too
        $this->will_record = ($this->type && $this->type != rectype_dontrec) ? true : false;

    // Turn type into a word
        $this->texttype = $GLOBALS['RecTypes'][$this->type];

    // Do we have a chanid?  Load some info about it
        if ($this->chanid && !isset($this->channel)) {
            $this->channel =& load_one_channel($this->chanid);
        }

    // Find out which css category this recording falls into
        if ($this->chanid != '')
            $this->class = category_class($this);
    }

/**
 * Save this schedule
/**/
    function save($new_type) {
    // Make sure that recordid is null if it's empty
        if (empty($this->recordid)) {
            $this->recordid = NULL;
            $this->findid   = (date('U', $this->starttime)/60/60/24) + 719528;
        // Only auto-default these properties if we're not dealing with a
        // search-based recording rule, otherwise take the values we
        // received from the custom schedule input form
            if (!$this->search) {
                $this->findday  = (date('w', $this->starttime) + 1) % 7;
                $this->findtime = date('G:i:s', $this->starttime);
            }
        }
    // Changing the type of recording
        if ($this->recordid && $this->type && $new_type != $this->type) {
        // Delete this schedule?
            if (empty($new_type)) {
                $this->delete();
                return;
            }
        // Changing from one override type to another -- delete the old entry, and then reset recordid so a new record is created
            elseif ($new_type == rectype_override || $new_type == rectype_dontrec) {
            // Delete an old override schedule?
                if ($this->type == rectype_override || $this->type == rectype_dontrec) {
                    $this->delete();
                }
            // Wipe the recordid so we actually create a new record
                $this->recordid = NULL;
            }
        }
    // Update the type, in case it changed
        $this->type = $new_type;
    // Update the record
        $result = mysql_query('REPLACE INTO record (recordid,type,chanid,starttime,startdate,endtime,enddate,search,title,subtitle,description,profile,recpriority,category,maxnewest,inactive,maxepisodes,autoexpire,startoffset,endoffset,recgroup,dupmethod,dupin,station,seriesid,programid,autocommflag,findday,findtime,findid,autotranscode,transcoder,parentid,tsdefault,autouserjob1,autouserjob2,autouserjob3,autouserjob4) values ('
                                .escape($this->recordid, true)             .','
                                .escape($this->type)                       .','
                                .escape($this->chanid)                     .','
                                .'FROM_UNIXTIME('.escape($this->starttime).'),'
                                .'FROM_UNIXTIME('.escape($this->starttime).'),'
                                .'FROM_UNIXTIME('.escape($this->endtime)  .'),'
                                .'FROM_UNIXTIME('.escape($this->endtime)  .'),'
                                .escape($this->search)                     .','
                                .escape($this->title)                      .','
                                .escape($this->subtitle)                   .','
                                .escape($this->description)                .','
                                .escape($this->profile)                    .','
                                .escape($this->recpriority)                .','
                                .escape($this->category)                   .','
                                .escape($this->maxnewest)                  .','
                                .escape($this->inactive)                   .','
                                .escape($this->maxepisodes)                .','
                                .escape($this->autoexpire)                 .','
                                .escape($this->startoffset)                .','
                                .escape($this->endoffset)                  .','
                                .escape($this->recgroup)                   .','
                                .escape($this->dupmethod)                  .','
                                .escape($this->dupin)                      .','
                                .escape($this->station)                    .',' // callsign!
                                .escape($this->seriesid)                   .','
                                .escape($this->programid)                  .','
                                .escape($this->autocommflag)               .','
                                .escape($this->findday)                    .','
                                .escape($this->findtime)                   .','
                                .escape($this->findid)                     .','
                                .escape($this->autotranscode)              .','
                                .escape($this->transcoder)                 .','
                                .escape($this->parentid)                   .','
                                .escape($this->tsdefault)                  .','
                                .escape($this->autouserjob1)               .','
                                .escape($this->autouserjob2)               .','
                                .escape($this->autouserjob3)               .','
                                .escape($this->autouserjob4)               .')')
            or trigger_error('SQL Error: '.mysql_error(), FATAL);
    // Get the id that was returned
        $recordid = mysql_insert_id();
    // New recordid?
        if (empty($this->recordid))
            $this->recordid = $recordid;
    // Errors?
        if (mysql_affected_rows() < 1 || $recordid < 1)
            trigger_error('Error creating recording schedule - no id was returned', FATAL);
        elseif ($program->recordid && $program->recordid != $recordid)
            trigger_error('Error updating recording schedule - different id was returned', FATAL);
    // Notify the backend of the changes
        if ($this->recordid)
            backend_notify_changes($this->recordid);
        else
            backend_notify_changes();
    }

/**
 * Delete this schedule
/**/
    function delete() {
        global $db;
    // Delete this schedule from the database
        $sh = $db->query('DELETE FROM record WHERE recordid=?',
                         $this->recordid);
    // Notify the backend of the changes
        if ($sh->affected_rows())
            backend_notify_changes($this->recordid);
    // Finish
        $sh->finish();
    // Remove this from the $Schedules array in memory
        unset($GLOBALS['Schedules'][$this->recordid]);
    }

/**
 * The "details list" for recording schedules.  Very similar to that for
 * programs, but with a few extra checks, and some information arranged
 * differently.
/**/
    function details_list() {
    // Start the list, and print the title and schedule type
        $str = "<dl class=\"details_list\">\n"
            // Title
              ."\t<dt>".t('Title').":</dt>\n"
              ."\t<dd>".html_entities($this->title)
                       ."</dd>\n"
            // Type
              ."\t<dt>".t('Type').":</dt>\n"
              ."\t<dd>".html_entities($this->texttype)
                       ."</dd>\n";
    // Only show these fields for recording types where they're relevant
        if (in_array($this->type, array(rectype_once, rectype_daily, rectype_weekly, rectype_override, rectype_dontrec))) {
        // Airtime
            $str .= "\t<dt>".t('Airtime').":</dt>\n"
                   ."\t<dd>".strftime($_SESSION['date_scheduled_popup'].', '.$_SESSION['time_format'], $this->starttime)
                            .' to '
                            .strftime($_SESSION['time_format'], $this->endtime)
                            ."</dd>\n";
        // Subtitle
            if (preg_match('/\\S/', $this->subtitle)) {
                $str .= "\t<dt>".t('Subtitle').":</dt>\n"
                       ."\t<dd>".html_entities($this->subtitle)
                                ."</dd>\n";
            }
        // Description
            if (preg_match('/\\S/', $this->description)) {
                $str .= "\t<dt>".t('Description').":</dt>\n"
                       ."\t<dd>".nl2br(html_entities($this->description))
                                ."</dd>\n";
            }
        // Rating
            if (preg_match('/\\S/', $this->rating)) {
                $str .= "\t<dt>".t('Rating').":</dt>\n"
                       ."\t<dd>".html_entities($this->rating)
                                ."</dd>\n";
            }
        }
    // Category
        if (preg_match('/\\S/', $this->category)) {
            $str .= "\t<dt>".t('Category').":</dt>\n"
                   ."\t<dd>".html_entities($this->category)
                            ."</dd>\n";
        }
    // Rerun?
        if (!empty($this->previouslyshown)) {
            $str .= "\t<dt>".t('Repeat').":</dt>\n"
                   ."\t<dd>".t('Yes')
                            ."</dd>\n";
        }
    // Will be recorded at some point in the future?
        if (!empty($this->will_record)) {
            $str .= "\t<dt>".t('Schedule').":</dt>\n"
                   ."\t<dd>";
            switch ($this->type) {
                case rectype_once:       $str .= t('rectype-long: once');       break;
                case rectype_daily:      $str .= t('rectype-long: daily');      break;
                case rectype_channel:
                    $channel =& load_one_channel($this->chanid);
                    $str     .= t('rectype-long: channel', prefer_channum ? $channel->channum : $channel->callsign);
                    break;
                case rectype_always:     $str .= t('rectype-long: always');     break;
                case rectype_weekly:     $str .= t('rectype-long: weekly');     break;
                case rectype_findone:    $str .= t('rectype-long: findone');    break;
                case rectype_override:   $str .= t('rectype-long: override');   break;
                case rectype_dontrec:    $str .= t('rectype-long: dontrec');    break;
                case rectype_finddaily:  $str .= t('rectype-long: finddaily');  break;
                case rectype_findweekly: $str .= t('rectype-long: findweekly'); break;
                default:                 $str .= t('Unknown');
            }
            $str .= "</dd>\n";
        }
    // Which duplicate-checking method will be used
        if ($this->dupmethod > 0) {
            $str .= "\t<dt>".t('Dup Method').":</dt>\n"
                   ."\t<dd>";
            switch ($this->dupmethod) {
                case 1:  $str .= t('None');                         break;
                case 2:  $str .= t('Subtitle');                     break;
                case 4:  $str .= t('Description');                  break;
                case 6:  $str .= t('Subtitle and Description');     break;
                case 22: $str .= t('Sub and Desc (Empty matches)'); break;
            }
            $str .= "</dd>\n";
        }
    // Recording Priority
        if (preg_match('/\\S/', $this->recpriority)) {
            $str .= "\t<dt>".t('Recording Priority').":</dt>\n"
                   ."\t<dd>".html_entities($this->recpriority)
                            ."</dd>\n";
        }
    // Profile
        if (preg_match('/\\S/', $this->profile)) {
            $str .= "\t<dt>".t('Profile').":</dt>\n"
                   ."\t<dd>".html_entities($this->profile)
                            ."</dd>\n";
        }
    // Transcoder
        if (preg_match('/\\S/', $this->transcoder)) {
            global $Transcoders;
            $str .= "\t<dt>".t('Transcoder').":</dt>\n"
                   ."\t<dd>".html_entities(_or($Transcoders[$this->transcoder], '&nbsp;'))
                            ."</dd>\n";
        }
    // Recording Group
        if (!empty($this->recgroup)) {
            $str .= "\t<dt>".t('Recording Group').":</dt>\n"
                   ."\t<dd>".html_entities($this->recgroup)
                            ."</dd>\n";
        }
    // Finish off the table and return
        $str .= "\n</dl>";
        return $str;
    }

}

/**
 * prints a <select> of the various recording profiles to choose from
/**/
    function profile_select($this_profile, $name='profile') {
        echo "<select name=\"$name\">";
        foreach(array('Default', 'Live TV', 'High Quality', 'Low Quality') as $profile) {
            echo '<option value="'.html_entities($profile).'"';
            if ($this_profile == $profile)
                echo ' SELECTED';
            echo '>'.html_entities($profile).'</option>';
        }
        echo '</select>';
    }

/**
 * prints a <select> of the various transcoders to choose from
/**/
    function transcoder_select($this_transcoder, $name='transcoder') {
        global $Transcoders;
        echo "<select name=\"$name\">";
        foreach ($Transcoders as $transcoderid => $transcoder) {
            echo '<option value="'.html_entities($transcoderid).'"';
            if ($this_transcoder == $transcoderid) {
                echo ' SELECTED';
            }
            echo '>'.html_entities($transcoder).'</option>';
        }
        echo '</select>';
    }

/**
 * prints a <select> of the various recgroups available
/**/
    function recgroup_select($this_group, $name = 'recgroup') {
        static $groups = array();
    // Load the recording groups?
        if (!count($groups)) {
        // Default
            $groups['Default'] = 'Default';
        // Current recgroups
            $result = mysql_query('SELECT DISTINCT recgroup FROM record');
            while (list($group) = mysql_fetch_row($result)) {
                $group or $group = 'Default';
                $groups[$group]  = $group;
            }
            mysql_free_result($result);
        // recgroups from current recordings
            $result = mysql_query('SELECT DISTINCT recgroup FROM recorded');
            while (list($group) = mysql_fetch_row($result)) {
                $group or $group = 'Default';
                $groups[$group]  = $group;
            }
            mysql_free_result($result);
        }
    // Print the <select>
        echo "<select name=\"$name\">";
        foreach($groups as $group) {
            echo '<option value="'.html_entities($group).'"';
            if ($this_group == $group)
                echo ' SELECTED';
            echo '>'.html_entities($group).'</option>';
        }
        echo '</select>';
    }


