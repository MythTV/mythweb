<?php
/**
 * This contains the Program class
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

// Make sure the "Channels" class gets loaded   (yes, I know this is recursive, but require_once will handle things nicely)
    require_once 'includes/channels.php';

// Reasons a recording wouldn't be happening (from libs/libmythtv/programinfo.h)
    $RecStatus_Types = array(
                              '-8' => 'TunerBusy',
                              '-7' => 'LowDiskSpace',
                              '-6' => 'Cancelled',
                              '-5' => 'Deleted',
                              '-4' => 'Aborted',
                              '-3' => 'Recorded',
                              '-2' => 'Recording',
                              '-1' => 'WillRecord',
                                0  => 'Unknown',
                                1  => 'DontRecord',
                                2  => 'PreviousRecording',
                                3  => 'CurrentRecording',
                                4  => 'EarlierShowing',
                                5  => 'TooManyRecordings',
                                6  => 'NotListed',
                                7  => 'Conflict',
                                8  => 'LaterShowing',
                                9  => 'Repeat',
                                10 => 'Inactive',
                                11 => 'NeverRecord'
                            );

    $RecStatus_Reasons = array(
                               'TunerBusy'          => t('recstatus: tunerbusy'),
                               'LowDiskSpace'       => t('recstatus: lowdiskspace'),
                               'Cancelled'          => t('recstatus: cancelled'),
                               'Deleted'            => t('recstatus: deleted'),
                               'Aborted'            => t('recstatus: stopped'),
                               'Recorded'           => t('recstatus: recorded'),
                               'Recording'          => t('recstatus: recording'),
                               'WillRecord'         => t('recstatus: willrecord'),
                               'Unknown'            => t('recstatus: unknown'),
                               'DontRecord'         => t('recstatus: manualoverride'),
                               'PreviousRecording'  => t('recstatus: previousrecording'),
                               'CurrentRecording'   => t('recstatus: currentrecording'),
                               'EarlierShowing'     => t('recstatus: earliershowing'),
                               'TooManyRecordings'  => t('recstatus: toomanyrecordings'),
                               'NotListed'          => t('recstatus: notlisted'),
                               'Conflict'           => t('recstatus: conflict'),
                               'Repeat'             => t('recstatus: repeat'),
                               'LaterShowing'       => t('recstatus: latershowing'),
                               'Inactive'           => t('recstatus: inactive'),
                               'NeverRecord'        => t('recstatus: neverrecord'),
                            // A special category for mythweb, since this feature doesn't exist in the backend
                               'ForceRecord'        => t('recstatus: force_record'),
                              );

/**
 * a shortcut to load_all_program_data's single-program query
/**/
    function &load_one_program($start_time, $chanid) {
        $program =& load_all_program_data($start_time, $start_time, $chanid, true);
        if (!is_object($program) || strcasecmp(get_class($program), 'program'))
            return NULL;
        return $program;
    }

/**
 * loads all program data for the specified time range into the $Channels array.
 * Set $single_program to true if you only want information about programs that
 * start exactly at $start_time (used by program_detail.php)
/**/
    function &load_all_program_data($start_time, $end_time, $chanid = false, $single_program = false, $extra_query = '') {
        global $Channels, $db;
    // Make a local hash of channel chanid's with references to the actual
    // channel data (Channels are not indexed by anything in particular, so
    // that the user can sort by chanid or channum).
        $channel_hash = array();
    // An array (that later gets converted to a string) containing the id's of channels we want to load
        $these_channels = array();
    // Information was requested about a specific chanid - let's make sure it has an entry in the global array
        if ($chanid) {
            if (!is_array($Channels))
                $Channels = array();
            $found = false;
            foreach ($Channels as $channel) {
                if ($channel->chanid == $chanid) {
                    $found = true;
                    break;
                }
            }
            if (!$found)
                load_one_channel($chanid);
        }
    // No channel data?  Load it
        if (!is_array($Channels) || !count($Channels))
            load_all_channels();
    // Scan through the channels array and actually assign those references
        foreach (array_keys($Channels) as $key) {
            $channel_hash[$Channels[$key]->chanid] =& $Channels[$key];
        // Reinitialize the programs array for this channel
            $Channels[$key]->programs = array();
        // Keep track of this channel id in case we're only grabbing info for certain channels - workound included to avoid blank chanid's
            if ($Channels[$key]->chanid)
                $these_channels[] = $Channels[$key]->chanid;
        }
    // convert $these_channels into a string so it'll go straight into the query
        if (!count($these_channels))
            trigger_error("load_all_program_data() attempted with an empty \$Channels array", FATAL);
        $these_channels = implode(',', $these_channels);
    // Build the sql query, and execute it
        $query = 'SELECT program.*,
                         UNIX_TIMESTAMP(program.starttime) AS starttime_unix,
                         UNIX_TIMESTAMP(program.endtime) AS endtime_unix,
                         IFNULL(programrating.system, "") AS rater,
                         IFNULL(programrating.rating, "") AS rating,
                         channel.callsign,
                         channel.channum
                  FROM program
                       LEFT JOIN programrating USING (chanid, starttime)
                       LEFT JOIN channel ON program.chanid = channel.chanid
                 WHERE';
    // Only loading a single channel worth of information
        if ($chanid > 0)
            $query .= ' program.chanid='.$db->escape($chanid);
    // Loading a group of channels (probably all of them)
        else
            $query .= ' program.chanid IN ('.$these_channels.')';
    // Requested start time is the same as the end time - don't bother with fancy calculations
        if ($start_time == $end_time)
            $query .= ' AND program.starttime = FROM_UNIXTIME('.$db->escape($start_time).')';
    // We're looking at a time range
        else
            $query .= ' AND (program.endtime > FROM_UNIXTIME(' .$db->escape($start_time).')'
                     .' AND program.starttime < FROM_UNIXTIME('.$db->escape($end_time)  .')'
                     .' AND program.starttime != program.endtime)';
    // The extra query, if there is one
        if ($extra_query)
            $query .= ' AND '.$extra_query;
    // Group and sort
        $query .= "\nGROUP BY program.chanid, program.starttime, channel.callsign ORDER BY program.starttime";
    // Limit
        if ($single_program)
            $query .= "\n LIMIT 1";
    // Query
        $sh = $db->query($query);
    // No results
        if ($sh->num_rows() < 1) {
            $sh->finish();
            return NULL;
        }
    // Build two separate queries for optimized selecting of recstatus
        $sh2 = $db->prepare('SELECT recstatus
                               FROM oldrecorded
                              WHERE recstatus IN (-3, 11)
                                    AND programid = ?
                                    AND seriesid  = ?
                             LIMIT 1');
        $sh3 = $db->prepare('SELECT recstatus
                               FROM oldrecorded
                              WHERE recstatus IN (-3, 11)
                                    AND title       = ?
                                    AND subtitle    = ?
                                    AND description = ?
                             LIMIT 1');
    // Load in all of the programs (if any?)
        global $Scheduled_Recordings;
        $these_programs = array();
        while ($data = $sh->fetch_assoc()) {
            if (!$data['chanid'])
                continue;
        // Generate the star string, since mysql has issues with REPEAT() and decimals
            $data['starstring'] = str_repeat(star_character, intVal($data['stars'] * max_stars));
            $frac = ($data['stars'] * max_stars) - intVal($data['stars'] * max_stars);
            if ($frac >= .75)
                $data['starstring'] .= '&frac34;';
            elseif ($frac >= .5)
                $data['starstring'] .= '&frac12;';
            elseif ($frac >= .25)
                $data['starstring'] .= '&frac14;';
        // This program has already been loaded, and is attached to a recording schedule
            if (!empty($data['title']) && $Scheduled_Recordings[$data['callsign']][$data['starttime_unix']][0]->title == $data['title']) {
                $program =& $Scheduled_Recordings[$data['callsign']][$data['starttime_unix']][0];
            // merge in data fetched from DB
                $program->merge(new Program($data));
            }
        // Otherwise, create a new instance of the program
            else {
            // Load the recstatus now that we can use an index
                if ($data['programid'] && $data['seriesid']) {
                   $sh2->execute($data['programid'], $data['seriesid']);
                   list($data['recstatus']) = $sh2->fetch_row();
                }
                elseif ($data['category_type'] == 'movie' || ($data['title'] && $data['subtitle'] && $data['description'])) {
                   $sh3->execute($data['title'], $data['subtitle'], $data['description']);
                   list($data['recstatus']) = $sh3->fetch_row();
                }
            // Create a new instance
                $program =& new Program($data);
            }
        // Add this program to the channel hash, etc.
            $these_programs[]                          =& $program;
            $channel_hash[$data['chanid']]->programs[] =& $program;
        // Cleanup
            unset($program);
        }
    // Cleanup
        $sh3->finish();
        $sh2->finish();
        $sh->finish();
    // If channel-specific information was requested, return an array of those programs, or just the first/only one
        if ($chanid && $single_program)
            return $these_programs[0];
    // Just in case, return an array of all programs found
        return $these_programs;
    }


/**
 * Program class
/**/
class Program {
    var $chanid;
    var $channel;   // this should be a reference to the $Channel array value

    var $title;
    var $subtitle;
    var $description;
    var $fancy_description;
    var $category;
    var $category_type;
    var $css_class;         // css class, based on category and/or category_type
    var $airdate;
    var $stars;
    var $previouslyshown;
    var $hdtv;

    var $starttime;
    var $endtime;
    var $recstartts;
    var $recendts;
    var $length;
    var $lastmodified;

    var $channame;
    var $filename;
    var $filesize;
    var $hostname;

    var $seriesid;
    var $programid;

    var $profile        = 0;
    var $max_newest     = 0;
    var $max_episodes   = 0;
    var $group          = '';
    var $playgroup      = 'Default';

    var $has_commflag   = 0;
    var $has_cutlist    = 0;
    var $is_editing     = 0;
    var $bookmark       = 0;
    var $auto_expire    = 0;
    var $is_watched     = 0;

    var $conflicting    = false;
    var $recording      = false;

    var $recpriority    = 0;
    var $recpriority2   = 0;
    var $recstatus      = NULL;

    var $rater;
    var $rating;
    var $starstring;
    var $is_movie;

    var $timestretch;

    var $credits = array();

    var $url;
    var $thumb_url;

    function Program($data) {
    // This is a mythbackend-formatted program - info about this data structure is stored in libs/libmythtv/programinfo.cpp
        if (!isset($data['chanid']) && isset($data[0])) {
        // Load the remaining info we got from mythbackend
            $this->title           = $data[0];      # program name/title
            $this->subtitle        = $data[1];      # episode name
            $this->description     = $data[2];      # episode description
            $this->category        = $data[3];
            $this->chanid          = $data[4];      # mysql chanid
            $this->channum         = $data[5];
            $this->callsign        = $data[6];
            $this->channame        = $data[7];
            $this->filename        = $data[8];
            $fs_high               = $data[9];      # high-word of file size
            $fs_low                = $data[10];     # low-word of file size
            $this->starttime       = $data[11];     # show start-time
            $this->endtime         = $data[12];     # show end-time
            $this->hostname        = $data[16];
            #$this->sourceid       = $data[17];
            $this->cardid          = $data[18];
            #$this->inputid        = $data[19];
            $this->recpriority     = $data[20];
            $this->recstatus       = $data[21];
            $this->recordid        = $data[22];
            $this->rectype         = $data[23];
            $this->dupin           = $data[24];
            $this->dupmethod       = $data[25];
            $this->recstartts      = $data[26];     # ACTUAL start time (also maps to recorded.starttime)
            $this->recendts        = $data[27];     # ACTUAL end time
            $this->previouslyshown = $data[28];     # "repeat" field
            $progflags             = $data[29];
            $this->recgroup        = $data[30];
            $this->commfree        = $data[31];
            $this->outputfilters   = $data[32];
            $this->seriesid        = $data[33];
            $this->programid       = $data[34];
            $this->lastmodified    = $data[35];
            $this->recpriority     = $data[36];
            $this->airdate         = date('Y-m-d', $data[37]);
            $this->hasairdate      = $data[38];
            $this->playgroup       = $data[39];
            $this->recpriority2    = $data[40];
        // Is this a previously-recorded program?
            if (!empty($this->filename)) {
            // Calculate the filesize
                if (function_exists('gmp_add')) {
                // GMP functions should work better with 64 bit numbers.
                    $size = gmp_add($fs_low,
                                     gmp_mul('4294967296',
                                             gmp_add($fs_high, $fs_low < 0 ? '1' : '0'))
                                   );
                    $this->filesize = gmp_strval($size);
                }
                else {
                // This is inaccurate, but it's the best we can get without GMP.
                    $this->filesize = ($fs_high + ($fs_low < 0)) * 4294967296 + $fs_low;
                }
            // And get some download info
                $this->url       = video_url($this);
                $this->thumb_url = root.cache_dir.'/'.str_replace('%2F', '/', rawurlencode(basename($this->filename)));
            }
        // Assign the program flags
            $this->has_commflag   = ($progflags & 0x001) ? true : false;    // FL_COMMFLAG       = 0x001
            $this->has_cutlist    = ($progflags & 0x002) ? true : false;    // FL_CUTLIST        = 0x002
            $this->auto_expire    = ($progflags & 0x004) ? true : false;    // FL_AUTOEXP        = 0x004
            $this->is_editing     = ($progflags & 0x008) ? true : false;    // FL_EDITING        = 0x008
            $this->bookmark       = ($progflags & 0x010) ? true : false;    // FL_BOOKMARK       = 0x010
                                                                            // FL_INUSERECORDING = 0x020
                                                                            // FL_INUSEPLAYING   = 0x040
            $this->stereo         = ($progflags & 0x080) ? true : false;    // FL_STEREO         = 0x080
            $this->closecaptioned = ($progflags & 0x100) ? true : false;    // FL_CC             = 0x100
            $this->hdtv           = ($progflags & 0x200) ? true : false;    // FL_HDTV           = 0x200
                                                                            // FL_TRANSCODED     = 0x400
            $this->is_watched     = ($progflags & 0x800) ? true : false;    // FL_WATCHED        = 0x800
        // Add a generic "will record" variable, too
            $this->will_record = ($this->rectype && $this->rectype != rectype_dontrec) ? true : false;
        }
    // SQL data
        else {
            $this->airdate                 = _or($data['originalairdate'], $data['airdate']);
            $this->category                = _or($data['category'],        t('Unknown'));
            $this->category_type           = _or($data['category_type'],   t('Unknown'));
            $this->chanid                  = $data['chanid'];
            $this->description             = $data['description'];
            $this->endtime                 = $data['endtime_unix'];
            $this->hdtv                    = $data['hdtv'];
            $this->previouslyshown         = $data['previouslyshown'];
            $this->programid               = $data['programid'];
            $this->rater                   = $data['rater'];
            $this->rating                  = $data['rating'];
            $this->seriesid                = $data['seriesid'];
            $this->showtype                = $data['showtype'];
            $this->stars                   = $data['stars'];
            $this->starstring              = $data['starstring'];
            $this->starttime               = $data['starttime_unix'];
            $this->subtitle                = $data['subtitle'];
            $this->subtitled               = $data['subtitled'];
            $this->title                   = $data['title'];
            $this->partnumber              = $data['partnumber'];
            $this->parttotal               = $data['parttotal'];
            $this->stereo                  = $data['stereo'];
            $this->closecaptioned          = $data['closecaptioned'];
            $this->colorcode               = $data['colorcode'];
            $this->syndicatedepisodenumber = $data['syndicatedepisodenumber'];
            $this->title_pronounce         = $data['title_pronounce'];
            $this->recstatus               = $data['recstatus'];

            if ($data['tsdefault']) {
                $this->timestretch = $data['tsdefault'];
            } else {
                $this->timestretch = 1.0;
            }
        }
    // Turn recstatus into a word
        if (isset($this->recstatus) && $GLOBALS['RecStatus_Types'][$this->recstatus]) {
            $this->recstatus = $GLOBALS['RecStatus_Types'][$this->recstatus];
            $this->conflicting = ($this->recstatus == 'Conflict');   # conflicts with another scheduled recording?
            $this->recording   = ($this->recstatus == 'WillRecord'); # scheduled to record?
        }
    // No longer a null column, so check for blank entries
        if ($this->airdate == '0000-00-00' || $this->airdate == '0000')
            $this->airdate = NULL;
    // Do we have a chanid?  Load some info about it
        if ($this->chanid && !isset($this->channel)) {
        // No channel data?  Load it
            global $Channels;
            if (!is_array($Channels) || !count($Channels))
                load_all_channels();
        // Now we really should scan the $Channel array and add a link to this program's channel
            foreach (array_keys($Channels) as $key) {
                if ($Channels[$key]->chanid == $this->chanid) {
                    $this->channel =& $Channels[$key];
                    break;
                }
            }
        // Not found
            if (!$this->channel)
                $this->channel =& load_one_channel($this->chanid);
        }
    // Calculate the duration
        if ($this->recendts)
            $this->length = $this->recendts - $this->recstartts;
        else
            $this->length = $this->endtime - $this->starttime;

    // A special recstatus for shows that this was manually set to record
        if ($this->rectype == rectype_override)
            $this->recstatus = 'ForceRecord';

    // Find out which css category this program falls into
        if ($this->chanid != '')
            $this->css_class = category_class($this);
    // Create the fancy description
        $this->update_fancy_desc();
    }

    function merge($prog) {
        foreach (get_object_vars($prog) as $name => $value) {
            if ($value && !$this->$name) {
                $this->$name = $value;
            }
        }
    // Special case for the original airdate, which the backend seems to misplace
        $this->airdate = $prog->airdate;
    // update fancy description in case a part of it changed
        $this->update_fancy_desc();
    }

    function update_fancy_desc() {
        // Get a nice description with the full details
        $details = array();
        if ($this->hdtv)
            $details[] = t('HDTV');
        if ($this->parttotal > 1 || $this->partnumber > 1)
            $details[] = t('Part $1 of $2', $this->partnumber, $this->parttotal);
        if ($this->rating)
            $details[] = $this->rating;
        if ($this->subtitled)
            $details[] = t('Subtitled');
        if ($this->closecaptioned)
            $details[] = t('CC');
        if ($this->stereo)
            $details[] = t('Stereo');
        if ($this->previouslyshown)
            $details[] = t('Repeat');

        $this->fancy_description = $this->description;
        if (count($details) > 0)
            $this->fancy_description .= ' ('.implode(', ', $details).')';
    }

/**
 * The "details list" for each program.
/**/
    function details_list() {
    // Start the list, and print the show airtime and title
        $str = "<dl class=\"details_list\">\n"
            // Airtime
              ."\t<dt>".t('Airtime').":</dt>\n"
              ."\t<dd>".t('$1 to $2',
                          strftime($_SESSION['time_format'], $this->starttime),
                          strftime($_SESSION['time_format'], $this->endtime))
                       ."</dd>\n"
            // Title
              ."\t<dt>".t('Title').":</dt>\n"
              ."\t<dd>".html_entities($this->title)
                       ."</dd>\n";
    // Subtitle
        if (preg_match('/\\S/', $this->subtitle)) {
            $str .= "\t<dt>".t('Subtitle').":</dt>\n"
                   ."\t<dd>".html_entities($this->subtitle)
                            ."</dd>\n";
        }
    // Description
        if (preg_match('/\\S/', $this->fancy_description)) {
            $str .= "\t<dt>".t('Description').":</dt>\n"
                   ."\t<dd>".nl2br(html_entities($this->fancy_description))
                            ."</dd>\n";
        }
    // Original Airdate
        if (!empty($this->airdate)) {
            $str .= "\t<dt>".t('Original Airdate').":</dt>\n"
                   ."\t<dd>".html_entities($this->airdate)
                            ."</dd>\n";
        }
    // Category
        if (preg_match('/\\S/', $this->category)) {
            $str .= "\t<dt>".t('Category').":</dt>\n"
                   ."\t<dd>".html_entities($this->category)
                            ."</dd>\n";
        }
    // Will be recorded at some point in the future?
        if (!empty($this->will_record)) {
            $str .= "\t<dt>".t('Schedule').":</dt>\n"
                   ."\t<dd>";
            switch ($this->rectype) {
                case rectype_once:       $str .= t('rectype-long: once');       break;
                case rectype_daily:      $str .= t('rectype-long: daily');      break;
                case rectype_channel:    $str .= t('rectype-long: channel', prefer_channum ? $this->channel->channum : $this->channel->callsign);    break;
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
    // Recording status
        if (!empty($this->recstatus)) {
            $str .= "\t<dt>".t('Notes').":</dt>\n"
                   ."\t<dd>".$GLOBALS['RecStatus_Reasons'][$this->recstatus]
                            ."</dd>\n";
        }
    // Finish off the table and return
        $str .= "\n</dl>";
        return $str;
    }

    function get_credits($role) {
    // Not enough info in this object
        if (!$this->chanid || !$this->starttime)
            return '';
    // No cached value -- load it
        if (!isset($this->credits[$role])) {
        // Get the credits for the requested role
            $query  = 'SELECT people.name FROM credits, people'
                     .' WHERE credits.person=people.person'
                     .' AND credits.role='.escape($role)
                     .' AND credits.chanid='.escape($this->chanid)
                     .' AND credits.starttime=FROM_UNIXTIME('.escape($this->starttime).')';
            $result = mysql_query($query)
                or trigger_error('SQL Error: '.mysql_error(), FATAL);
            $people = array();
            while (list($name) = mysql_fetch_row($result)) {
                $people[] = $name;
            }
            mysql_free_result($result);
        // Cache it
            $this->credits[$role] = trim(implode(', ', $people));
        }
        return $this->credits[$role];
    }

/*
 *  The following methods relate to a programs control over its recording options.
 */

/**
 * Tell mythtv to forget that it already recorded this show.
/**/
    function rec_forget_old() {
        $result = mysql_query('DELETE FROM oldrecorded WHERE'
                                .' title='          .escape($this->title)
                                .' AND subtitle='   .escape($this->subtitle)
                                .' AND description='.escape($this->description))
            or trigger_error('SQL Error: '.mysql_error(), FATAL);
    // Notify the backend of the changes
        backend_notify_changes();
    }

/**
 * "Never" record this show, by telling mythtv that it was already recorded
/**/
    function rec_never_record() {
        $result = mysql_query('REPLACE INTO oldrecorded (chanid,starttime,endtime,title,subtitle,description,category,seriesid,programid,recordid,station,rectype,recstatus,duplicate) VALUES ('
                                .escape($this->chanid)                    .','
                                .'NOW()'                                  .','
                                .'NOW()'                                  .','
                                .escape($this->title)                     .','
                                .escape($this->subtitle)                  .','
                                .escape($this->description)               .','
                                .escape($this->category)                  .','
                                .escape($this->seriesid)                  .','
                                .escape($this->programid)                 .','
                                .escape($this->recordid)                  .','
                                .escape($this->station)                   .','
                                .escape($this->rectype)                   .','
                                .'11'                                     .','
                                .'1'                                      .')')
            or trigger_error('SQL Error: '.mysql_error(), FATAL);
    // Notify the backend of the changes
        backend_notify_changes();
    }

/**
 * Revert a show to its default recording schedule settings
/**/
    function rec_default() {
        $schedule =& $GLOBALS['Schedules'][$this->recordid];
        if ($schedule && ($schedule->type == rectype_override || $schedule->type == rectype_dontrec))
            $schedule->delete();
    }

/**
 * Add an override or dontrec record to force this show to/not record pass in
 * rectype_dontrec or rectype_override constants
/**/
    function rec_override($rectype) {
        $schedule =& $GLOBALS['Schedules'][$this->recordid];
    // Unknown schedule?
        if (!$schedule)
            trigger_error('Unknown schedule for this program\'s recordid:  '.$this->recordid, FATAL);
    // Update the schedule with the new program info
        $schedule->chanid      = $this->chanid;
        $schedule->starttime   = $this->starttime;
        $schedule->endtime     = $this->endtime;
        $schedule->title       = $this->title;
        $schedule->subtitle    = $this->subtitle;
        $schedule->description = $this->description;
        $schedule->category    = $this->category;
        $schedule->station     = $this->channel->callsign;       // Note that "callsign" becomes "station"
        $schedule->seriesid    = $this->seriesid;
        $schedule->programid   = $this->programid;
        $schedule->search      = 0;
    // Save the schedule -- it'll know what to do about the override
        $schedule->save($rectype);
    }

/**
 * Intended to be called as program::category_types()
 *
 * @return array sorted list of category_type fields from the program table
/**/
    function category_types() {
        static $cache = array();
        if (empty($cache)) {
            global $db;
            $cache = $db->query_list('SELECT DISTINCT category_type
                                        FROM program
                                    ORDER BY category_type');
        }
        return $cache;
    }

/**
 * Intended to be called as program::categories()
 *
 * @return array sorted list of category fields from the program table
/**/
    function categories() {
        static $cache = array();
        if (empty($cache)) {
            global $db;
            $cache = $db->query_list('SELECT DISTINCT category
                                        FROM program
                                    ORDER BY category');
        }
        return $cache;
    }

}

