<?php
/**
 * The Schedule class
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

class Schedule extends MythBase {
    static private $scheduledRecordings;

    public $recordid;
    public $type;
    public $chanid;
    public $starttime;
    public $endtime;
    public $title;
    public $subtitle;
    public $description;
    public $season;
    public $episode;
    public $profile;
    public $recpriority;
    public $category;
    public $maxnewest;
    public $inactive;
    public $maxepisodes;
    public $autoexpire;
    public $startoffset;
    public $endoffset;
    public $recgroup;
    public $storagegroup;
    public $dupmethod;
    public $dupin;
    public $station;
    public $seriesid;
    public $programid;
    public $inetref;
    public $search;
    public $autotranscode;
    public $autocommflag;
    public $autouserjob1;
    public $autouserjob2;
    public $autouserjob3;
    public $autouserjob4;
    public $autometadata;
    public $findday;
    public $findtime;
    public $findid;
    public $transcoder;
    public $parentid;
    public $filter;

    public $playgroup;
    public $prefinput;
    public $next_record;
    public $last_record;
    public $last_delete;

    public $texttype;
    public $channel;
    public $will_record = false;
    public $css_class;         // css class, based on category and/or category_type


    /**
     * Intended to be called as Schedule::availableRecordFilters()
     *
     * @return array sorted list of record filters available to the system keyed by filterid
    /**/
    public static function availableRecordFilters() {
        static $cache = array();
        if (empty($cache)) {
            global $db;
            $cache = $db->query_keyed_list_assoc('filterid',
                'SELECT filterid,description,newruledefault
                   FROM recordfilter
               ORDER BY filterid'
               );
        }
        return $cache;
    }

    /**
     *
     * @return an array of the filters for this Schedule.  Array includes
     * a property called "enabled" to indicate if the filter is enabled.
     * If this is not a real schedule "enabled" is from the newruledefault
     * property
     *
    /**/
    public function recordFilters() {
        $filters = array();
        foreach (Schedule::availableRecordFilters() as $id => $filter) {
            $filters[$id] = $filter;
            // if this is a real schedule, use the filter property
            if ($this->recordid) {
                $mask = 1 << $id;
                $filters[$id]['enabled'] = ($this->filter & $mask) == $mask;
                // otherwise it's not a real schedule, so use the default value
            } else {
                $filters[$id]['enabled'] = $filter['newruledefault'];
            }
        }
        return $filters;
    }

    public static function findAll($sort = true) {
        global $db;
        $orderby = '';
        if ($sort && count($_SESSION['schedules_sortby'])) {
            $orderby = 'ORDER BY ';
            foreach ($_SESSION['schedules_sortby'] AS $key => $sort) {
                if ($key > 0)
                    $orderby .= ', ';
                switch ($sort['field']) {
                    case 'airdate':
                        $orderby .= 'starttime';
                        break;
                    case 'recpriority':
                        $orderby .= 'record.recpriority';
                        break;
                    default:
                        $orderby .= $sort['field'];
                        break;
                }
                $orderby .= ($sort['reverse'] ? ' DESC' : ' ASC');
            }
            $recordIds = $db->query("
                SELECT    recordid
                FROM      record
                LEFT JOIN channel
                       ON channel.chanid = record.chanid
                $orderby"
                )->fetch_cols();
            }
            else {
            $recordIds = $db->query("SELECT recordid
            FROM record")->fetch_cols();
            }
        return $recordIds;
    }

    public static function &findScheduled() {
        if (is_null(self::$scheduledRecordings))
            self::$scheduledRecordings =& Cache::get('Schedule::findScheduled');

        if (is_null(self::$scheduledRecordings)) {
            foreach (MythBackend::find()->queryProgramRows('QUERY_GETALLPENDING', 2) as $key => $program) {
                if ($key === 'offset')
                    continue;
                if ($program[21] == 6)
                    continue;
                // Normal entry:  $scheduledRecordings[callsign][starttime][]
                self::$scheduledRecordings[$program[9]][$program[13]][] = new Program($program);
            }
            Cache::set('Schedule::findScheduled', self::$scheduledRecordings);
        }
        if (is_null(self::$scheduledRecordings))
            return array();
        return self::$scheduledRecordings;
    }

/**
 * constructor
/**/
    public function __construct($data) {
        global $db;

        $this->dupmethod = _or(setting('prefDupMethod'), 0);

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
            return;
        }
    // Something else
        else {
            // Are we passing in a set of chanid, starttime?
            if (func_num_args() == 2) {
                $chanid = func_get_arg(0);
                $start  = func_get_arg(1);
                $data = $db->query_col('
                    SELECT recordid
                    FROM   record
                    WHERE  record.chanid = ?
                       AND record.starttime = FROM_UNIXTIME(?)',
                    $chanid,
                    $start
                    );
            }
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
        if ($this->chanid > 0 && !isset($this->channel))
            $this->channel =& Channel::find($this->chanid);

    // Find out which css category this recording falls into
        if ($this->chanid != '')
            $this->css_class = category_class($this);
    }

/**
 * Alternative constructor for returning recording templates
 **/
    static function recording_template($name) {
        global $db;
        $sched = new Schedule(NULL);
        $data = $db->query_assoc('
            SELECT *
            FROM   record
            WHERE  type = ?
            AND    title = ?',
            rectype_template,
            $name.' (Template)'
        );

        $template_params = array(
            'recpriority', 'prefinput', 'startoffset', 'endoffset',
            'dupmethod', 'dupin', 'filter', 'inactive',
            'profile', 'recgroup', 'storagegroup', 'playgroup', 'autoexpire',
            'maxepisodes', 'maxnewest',
            'autocommflag', 'autotranscode', 'transcoder',
            'autouserjob1', 'autouserjob2', 'autouserjob3', 'autouserjob4',
            'autometadata');
        foreach ($template_params as $param)
            if (isset($data[$param]))
                $sched->$param = $data[$param];

        return $sched;
    }

/**
 * Merge values from another schedule
 **/
    public function merge($prog) {
        foreach (get_object_vars($prog) as $name => $value) {
            if (isset($value) && !isset($this->$name)) {
                $this->$name = $value;
            }
        }
    }

/**
 * Save this schedule
/**/
    public function save($new_type) {
        global $db;
    // Make sure that recordid is null if it's empty
        if (empty($this->recordid)) {
            $this->recordid = NULL;
            $this->findid   = Math.floor(date('U', $this->starttime)/60/60/24) + 719528;
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
    // Clear the the search column for non-manual overrides.
        if (($this->type == rectype_override || $this->type == rectype_dontrec)
            && $this->search != searchtype_manual) {
            $this->search = 0;
        }
    // Update the record
        $sh = $db->query('REPLACE INTO record (recordid,type,chanid,starttime,startdate,endtime,enddate,search,
                                               title,subtitle,description,profile,recpriority,category,
                                               maxnewest,inactive,maxepisodes,autoexpire,startoffset,endoffset,
                                               recgroup,dupmethod,dupin,station,seriesid,programid,autocommflag,
                                               findday,findtime,findid,autotranscode,parentid,transcoder,
                                               autouserjob1,autouserjob2,autouserjob3,autouserjob4,autometadata,
                                               playgroup,storagegroup,prefinput,
                                               next_record,last_record,last_delete,inetref,season,episode,filter)
                                       VALUES (?,?,?,
                                               FROM_UNIXTIME(?),FROM_UNIXTIME(?),FROM_UNIXTIME(?),FROM_UNIXTIME(?),
                                               ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
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
                         _or($this->autouserjob1,  0,          true),
                         _or($this->autouserjob2,  0,          true),
                         _or($this->autouserjob3,  0,          true),
                         _or($this->autouserjob4,  0,          true),
                         _or($this->autometadata,  0,          true),
                         _or($this->playgroup,     'Default'       ),
                         _or($this->storagegroup,  'Default'       ),
                         _or($this->prefinput,     0,          true),
                         _or($this->next_record,   '00:00:00'      ),
                         _or($this->last_record,   '00:00:00'      ),
                         _or($this->last_delete,   '00:00:00'      ),
                         _or($this->inetref,       ''              ),
                         _or($this->season,        0              ),
                         _or($this->episode,       0              ),
                         _or($this->filter,        0              )
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
    public function delete() {
        global $db;
    // Delete this schedule from the database
        $sh = $db->query('DELETE FROM record WHERE recordid=?',
                         $this->recordid);
    // Notify the backend of the changes
        if ($sh->affected_rows())
            MythBackend::find()->rescheduleRecording($this->recordid);
    // Finish
        $sh->finish();
    }

/**
 * The "details list" for recording schedules.  Very similar to that for
 * programs, but with a few extra checks, and some information arranged
 * differently.
/**/
    public function details_list() {
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
                case rectype_always:     $str .= t('rectype-long: always');     break;
                case rectype_weekly:     $str .= t('rectype-long: weekly');     break;
                case rectype_findone:    $str .= t('rectype-long: findone');    break;
                case rectype_override:   $str .= t('rectype-long: override');   break;
                case rectype_dontrec:    $str .= t('rectype-long: dontrec');    break;
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
    function playgroup_select($this_playgroup, $name = 'playgroup', $schedule = NULL, $id = NULL, $js = NULL) {
    // Make sure we have some data
        static $playgroups = array();
        if (!count($playgroups)) {
            global $db;
            $sh = $db->query('SELECT name FROM playgroup ORDER BY name = "Default" DESC, name');
            while (list($group) = $sh->fetch_row()) {
                $playgroups[] = $group;
            }
            $sh->finish();
        }
    // Do PlayGroup titlematch
        if (count($playgroups) > 1 && empty($this_playgroup) && is_object($schedule)) {
            $this_playgroup =& $schedule->this_playgroup;
            $sh = $db->query('SELECT DISTINCT name FROM playgroup
                              WHERE name = ? OR name = ? OR (titlematch <> "" AND ? REGEXP titlematch)
                              ORDER BY titlematch DESC',
                             $schedule->title, $schedule->category, $schedule->title);
            if (list($grp) = $sh->fetch_row())
                $this_playgroup = $grp;
            $sh->finish();
        }
        if (empty($this_playgroup))
            $this_playgroup = 'Default';
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
    function recgroup_select(&$schedule, $name = 'recgroup') {
        global $db;
        $this_group =& $schedule->recgroup;
        static $groups = array();
    // Load the recording groups?
        if (!count($groups)) {
        // Default
            $groups['Default'] = t('Default');
        // Current recgroups
            $sh = $db->query('SELECT DISTINCT recgroup FROM recorded '.
                'WHERE recgroup != "LiveTV" AND recgroup != "Deleted" UNION '.
                'SELECT DISTINCT recgroup FROM record '.
                'WHERE recgroup != "LiveTV" AND recgroup != "Deleted" '.
                'ORDER BY recgroup;');

            while (list($group) = $sh->fetch_row()) {
                if (empty($group) || $group == 'Default')
                    continue;
                $groups[$group] = $group;
            }
            $sh->finish();
        }
    // Guess at default. Try category match etc..
        if (count($groups) > 1 && empty($this_group)) {
            $program = load_one_program($schedule->starttime, $schedule->chanid, $schedule->manualid);
            $sh = $db->query('SELECT DISTINCT recgroup FROM record
                             WHERE recgroup REGEXP ? OR recgroup REGEXP ? OR recgroup REGEXP ?',
                             $schedule->category, $program->category_type, $schedule->station);
            if (list($grp) = $sh->fetch_row())
                $this_group = $grp;
            $sh->finish();
        }
        if (empty($this_group))
            $this_group = 'Default';
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
        global $db;
        static $groups = array();
    // Load the recording groups?
        if (!count($groups)) {
        // Default
            $groups['Default'] = 'Default';
        // Configured Storage Groups
            $sh = $db->query('SELECT DISTINCT groupname FROM storagegroup');
            while (list($group) = $sh->fetch_row()) {
                $group or $group = 'Default';
                $groups[$group]  = $group;
            }
            $sh->finish();
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
