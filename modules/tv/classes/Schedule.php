<?php
/**
 * The Schedule class
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
    var $storagegroup;
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

    var $playgroup;
    var $prefinput;
    var $next_record;
    var $last_record;
    var $last_delete;

    var $texttype;
    var $channel;
    var $will_record = false;
    var $css_class;         // css class, based on category and/or category_type
    var $tsdefault;

/**
 * constructor
/**/
    function Schedule($data) {
        global $db;
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
                $data = $db->query_assoc('SELECT *, IF(type='.rectype_always.',-1,chanid)         AS chanid,
                                                 UNIX_TIMESTAMP(startdate)+TIME_TO_SEC(starttime) AS starttime,
                                                 UNIX_TIMESTAMP(enddate)+TIME_TO_SEC(endtime)     AS endtime
                                            FROM record
                                           WHERE recordid=?',
                                         $data);
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
            $this->css_class = category_class($this);
    }

/**
 * Save this schedule
/**/
    function save($new_type) {
        global $db;
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
        $sh = $db->query('REPLACE INTO record (recordid,type,chanid,starttime,startdate,endtime,enddate,search,
                                               title,subtitle,description,profile,recpriority,category,
                                               maxnewest,inactive,maxepisodes,autoexpire,startoffset,endoffset,
                                               recgroup,dupmethod,dupin,station,seriesid,programid,autocommflag,
                                               findday,findtime,findid,autotranscode,parentid,transcoder,tsdefault,
                                               autouserjob1,autouserjob2,autouserjob3,autouserjob4,
                                               playgroup,storagegroup,prefinput,
                                               next_record,last_record,last_delete)
                                       VALUES (?,?,?,
                                               FROM_UNIXTIME(?),FROM_UNIXTIME(?),FROM_UNIXTIME(?),FROM_UNIXTIME(?),
                                               ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                         _or($this->recordid,      0,          true),
                         _or($this->type,          0,          true),
                         $this->chanid,
                         $this->starttime,
                         $this->starttime,
                         $this->endtime,
                         $this->endtime,
                         _or($this->search,        0,          true),
                         _or($this->title,         'Untitled'      ),
                         _or($this->subtitle,      ''              ),
                         _or($this->description,   ''              ),
                         _or($this->profile,       'Default'       ),
                         _or($this->recpriority,   0               ),
                         _or($this->category,      0               ),
                         _or($this->maxnewest,     0,          true),
                         _or($this->inactive,      0,          true),
                         _or($this->maxepisodes,   0,          true),
                         _or($this->autoexpire,    0,          true),
                         _or($this->startoffset,   0               ),
                         _or($this->endoffset,     0               ),
                         _or($this->recgroup,      'Default'       ),
                         _or($this->dupmethod,     0,          true),
                         _or($this->dupin,         15,         true),
                         _or($this->station,       ''              ),  // callsign!
                         _or($this->seriesid,      ''              ),
                         _or($this->programid,     ''              ),
                         _or($this->autocommflag,  0,          true),
                         _or($this->findday,       0,          true),
                         _or($this->findtime,      '00:00:00'      ),
                         _or($this->findid,        0,          true),
                         _or($this->autotranscode, 0,          true),
                         _or($this->parentid,      0,          true),
                         _or($this->transcoder,    0,          true),
                         _or($this->tsdefault,     1,          true),
                         _or($this->autouserjob1,  0,          true),
                         _or($this->autouserjob2,  0,          true),
                         _or($this->autouserjob3,  0,          true),
                         _or($this->autouserjob4,  0,          true),
                         _or($this->playgroup,     'Default'       ),
                         _or($this->storagegroup,  'Default'       ),
                         _or($this->prefinput,     0,          true),
                         _or($this->next_record,   '00:00:00'      ),
                         _or($this->last_record,   '00:00:00'      ),
                         _or($this->last_delete,   '00:00:00'      )
                        );
    // Get the id that was returned
        $recordid = $sh->insert_id();
    // New recordid?
        if (empty($this->recordid))
            $this->recordid = $recordid;
    // Errors?
        if ($sh->affected_rows() < 1 || $recordid < 1)
            trigger_error('Error creating recording schedule - no id was returned', FATAL);
        elseif ($this->recordid && $this->recordid != $recordid)
            trigger_error('Error updating recording schedule - different id was returned', FATAL);
    // Finish
        $sh->finish();
    // Notify the backend of the changes
        if ($this->recordid)
            MythBackend::find()->rescheduleRecording($this->recordid);
        else
            MythBackend::find()->rescheduleRecording();
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
            MythBackend::find()->rescheduleRecording($this->recordid);
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
                    $str     .= t('rectype-long: channel', $_SESSION["prefer_channum"] ? $channel->channum : $channel->callsign);
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
                case 8:  $str .= t('Subtitle then Description');    break;
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
    // Storage Group
        if (!empty($this->storagegroup)) {
            $str .= "\t<dt>".t('Storage Group').":</dt>\n"
                   ."\t<dd>".html_entities($this->storagegroup)
                            ."</dd>\n";
        }
    // Finish off the table and return
        $str .= "\n</dl>";
        return $str;
    }

}

/**
 * prints a <select> of the various playback groups available
/**/
    function playgroup_select($this_playgroup, $name = 'playgroup', $id = NULL, $js = NULL)     {
    // Make sure we have some data
        static $playgroups = array();
        if (!count($playgroups)) {
            global $db;
            $sh = $db->query('SELECT name FROM playgroup ORDER BY name');
            while (list($group) = $sh->fetch_row()) {
                $playgroups[] = $group;
            }
            $sh->finish();
        }
    // Print the actual select
        echo "<select name=\"$name\"";
        if ($id)
            echo ' id="'.$id.'"';
        if (!empty($js))
            echo ' onchange="'.$js.'"';
        echo ">";
        foreach($playgroups as $group) {
            echo '<option';
            if ($this_playgroup == $group)
                echo ' SELECTED';
            echo '>', html_entities($group), '</option>';
        }
        echo '</select>';
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
        if (empty($this_group))
            $this_group = 'Default';
    // Load the recording groups?
        if (!count($groups)) {
        // Default
            $groups['Default'] = t('Default');
        // Current recgroups
            $result = mysql_query('SELECT DISTINCT recgroup FROM recorded '.
                'WHERE recgroup != "LiveTV" AND recgroup != "Deleted" UNION '.
                'SELECT DISTINCT recgroup FROM record '.
                'WHERE recgroup != "LiveTV" AND recgroup != "Deleted" '.
                'ORDER BY recgroup;');

            while (list($group) = mysql_fetch_row($result)) {
                if (empty($group) || $group == 'Default')
                    continue;
                $groups[$group] = $group;
            }
            mysql_free_result($result);
        }
    // Print the <select>
        echo "<select name=\"$name\">";
        foreach($groups as $group => $group_name) {
            echo '<option value="', html_entities($group), '"';
            if ($this_group == $group)
                echo ' SELECTED';
            echo '>', html_entities($group_name), '</option>';
        }
        if (!$groups[$this_group]) {
            echo '<option value="', html_entities($this_group), '" SELECTED',
                 '>', html_entities($this_group), '</option>';
        }
        echo '</select>';
    }

/**
 * prints a <select> of the various storagegroups available
/**/
    function storagegroup_select($this_group, $name = 'storagegroup') {
        static $groups = array();
    // Load the recording groups?
        if (!count($groups)) {
        // Default
            $groups['Default'] = 'Default';
        // Configured Storage Groups
            $result = mysql_query('SELECT DISTINCT groupname FROM storagegroup');
            while (list($group) = mysql_fetch_row($result)) {
                $group or $group = 'Default';
                $groups[$group]  = $group;
            }
            mysql_free_result($result);
        }
    // Print the <select>
        echo "<select name=\"$name\">";
        foreach($groups as $group) {
            echo '<option value="', html_entities($group), '"';
            if ($this_group == $group)
                echo ' SELECTED';
            echo '>', html_entities($group), '</option>';
        }
        echo '</select>';
    }
