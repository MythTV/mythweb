<?php
/**
 * Program class
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

/**
 * Program class
/**/
class Program extends MythBase {

// The following fields are (in order) the fields returned from the backend on
// a standard query.
// everything above this line is serialized

    public $duplicate;
    public $shareable;

// Audio and Video properties
    public $stereo             = 0;
    public $mono               = 0;
    public $surround           = 0;
    public $dolby              = 0;
    public $audiohardhear      = 0;
    public $audiovisimpair     = 0;
    public $hdtv               = 0;
    public $widescreen         = 0;
    public $avc                = 0;
    public $hd_ready           = 0;
    public $fullhd             = 0;
    public $damaged            = 0;
    public $closecaptioned     = 0;
    public $has_subtitles      = 0;
    public $subtitled          = 0;
    public $deaf_signed        = 0;

// The rest of these variables (which really need to get organized) are
// calculated or queried separately from the db.
    public $auto_expire        = 0;
    public $bookmark           = 0;
    public $category_type;
// this should be a reference to the $Channel array value
    public $channel;
    public $conflicting        = false;
    public $credits            = array();
// css class, based on category and/or category_type
    public $css_class;
    public $fancy_description;
    public $group              = '';
    public $has_commflag       = 0;
    public $has_cutlist        = 0;
    public $is_recording;
    public $is_playing;
    public $can_delete         = false;
    public $inputname;
    public $is_editing         = 0;
    public $is_movie;
    public $is_watched         = 0;
    public $is_transcoded      = 0;
    public $length;
    public $max_episodes       = 0;
    public $max_newest         = 0;
    public $profile            = 0;
    public $rater;
    public $rating;
    public $recording          = false;
    public $starstring;
    public $url;
// recent/pending jobqueue entries
    public $jobs               = array();
// Jobs this program can be assigned to
    public $jobs_possible      = array();

    public function __construct($data) {
        global $db;
    // This is a mythbackend-formatted program - info about this data structure is stored in libs/libmythtv/programinfo.cpp
        if (!isset($data['chanid']) && isset($data[0])) {
        // Load the remaining info we got from mythbackend
            $this->title           = trim($data[0]);    # program name/title
            $this->subtitle        = $data[1];          # episode name
            $this->description     = $data[2];          # episode description
            $this->season          = $data[3];
            $this->episode         = $data[4];
            $this->syndicatedepisodenumber = $data[5];
            $this->category        = $data[6];
            $this->chanid          = $data[7];          # mysql chanid
            $this->channum         = $data[8];
            $this->callsign        = $data[9];
            $this->channame        = $data[10];
            $this->filename        = $data[11];
            $this->filesize        = $data[12];
            $this->starttime       = $data[13];         # show start-time
            $this->endtime         = $data[14];         # show end-time
            $this->findid          = $data[15];
            $this->hostname        = $data[16];
            $this->sourceid        = $data[17];
            $this->cardid          = $data[18];
            $this->inputid         = $data[19];
            $this->recpriority     = $data[20];
            $this->recstatus       = $data[21];
            $this->recordid        = $data[22];

            $this->rectype         = $data[23];
            $this->dupin           = $data[24];
            $this->dupmethod       = $data[25];
            $this->recstartts      = $data[26];         # ACTUAL start time (also maps to recorded.starttime)
            $this->recendts        = $data[27];         # ACTUAL end time
            $this->progflags       = $data[28];
            $this->recgroup        = $data[29];
            $this->outputfilters   = $data[30];
            $this->seriesid        = $data[31];
            $this->programid       = $data[32];
            $this->inetref         = $data[33];

            $this->lastmodified    = $data[34];
            $this->stars           = $data[35];
            $this->airdate         = $data[36];
            $this->playgroup       = $data[37];
            $this->recpriority2    = $data[38];
            $this->parentid        = $data[39];
            $this->storagegroup    = $data[40];
            $this->audioproperties = $data[41];
            $this->videoproperties = $data[42];
            $this->subtitletype    = $data[43];
            $this->year            = $data[44];
            $this->partnumber      = $data[45];
            $this->parttotal       = $data[46];
        // Is this a previously-recorded program?
            if (!empty($this->filename)) {
                $this->url = video_url($this); // get download info
            }
        // Assign the program flags
            $this->has_commflag   = ($this->progflags & 0x00000001) ? true : false;    // FL_COMMFLAG       = 0x00000001
            $this->has_cutlist    = ($this->progflags & 0x00000002) ? true : false;    // FL_CUTLIST        = 0x00000002
            $this->auto_expire    = ($this->progflags & 0x00000004) ? true : false;    // FL_AUTOEXP        = 0x00000004
            $this->is_editing     = ($this->progflags & 0x00000008) ? true : false;    // FL_EDITING        = 0x00000008
            $this->bookmark       = ($this->progflags & 0x00000010) ? true : false;    // FL_BOOKMARK       = 0x00000010
            $this->is_recording   = ($this->progflags & 0x00100000) ? true : false;    // FL_INUSERECORDING = 0x00100000
            $this->is_playing     = ($this->progflags & 0x00200000) ? true : false;    // FL_INUSEPLAYING   = 0x00200000
            $this->is_transcoded  = ($this->progflags & 0x00000100) ? true : false;    // FL_TRANSCODED     = 0x00000100
            $this->is_watched     = ($this->progflags & 0x00000200) ? true : false;    // FL_WATCHED        = 0x00000200
        // Can be deleted?
            $this->can_delete     = (!$this->is_recording && !$this->is_playing) || $this->recgroup != 'LiveTV';
        // Add a generic "will record" variable, too
            $this->will_record = ($this->rectype && $this->rectype != rectype_dontrec) ? true : false;
        }
    // SQL data
        else {
            if (in_array($data['airdate'], array('0000-00-00', '0000', '1900-01-01')))
                $this->airdate              = $data['originalairdate'];
            else
                $this->airdate              = $data['airdate'];
            $this->category                 = _or($data['category'],        t('Unknown'));
            $this->category_type            = _or($data['category_type'],   t('Unknown'));
            $this->chanid                   = $data['chanid'];
            $this->description              = $data['description'];
            $this->endtime                  = $data['endtime_unix'];
            $this->previouslyshown          = $data['previouslyshown'];
            $this->programid                = $data['programid'];
            $this->rater                    = $data['rater'];
            $this->rating                   = $data['rating'];
            $this->seriesid                 = $data['seriesid'];
            $this->showtype                 = $data['showtype'];
            $this->stars                    = $data['stars'];
            $this->starttime                = $data['starttime_unix'];
            $this->subtitle                 = $data['subtitle'];
            $this->subtitled                = $data['subtitled'];
            $this->title                    = $data['title'];
            $this->partnumber               = $data['partnumber'];
            $this->parttotal                = $data['parttotal'];
            $this->colorcode                = $data['colorcode'];
            $this->syndicatedepisodenumber  = $data['syndicatedepisodenumber'];
            $this->title_pronounce          = $data['title_pronounce'];
            $this->recstatus                = $data['recstatus'];

        // These db fields should really get renamed...
            $this->audioproperties          = $data['stereo'];
            $this->videoproperties          = $data['hdtv'];
            $this->subtitletype             = $data['closecaptioned'];
        }
    // Assign shortcut names to the new audio/video/subtitle property flags
        $this->stereo                       = $this->audioproperties & 0x01;
        $this->mono                         = $this->audioproperties & 0x02;
        $this->surround                     = $this->audioproperties & 0x04;
        $this->dolby                        = $this->audioproperties & 0x08;
        $this->audiohardhear                = $this->audioproperties & 0x10;
        $this->audiovisimpair               = $this->audioproperties & 0x20;
        $this->hdtv                         = $this->videoproperties & 0x01;
        $this->widescreen                   = $this->videoproperties & 0x02;
        $this->avc                          = $this->videoproperties & 0x04;
        $this->hd_ready                     = $this->videoproperties & 0x08;
        $this->fullhd                       = $this->videoproperties & 0x10;
        $this->damaged                      = $this->videoproperties & 0x20;
        $this->closecaptioned               = $this->subtitletype    & 0x01;
        $this->has_subtitles                = $this->subtitletype    & 0x02;
        $this->subtitled                    = $this->subtitletype    & 0x04;
        $this->deaf_signed                  = $this->subtitletype    & 0x08;
    // Generate the star string, since mysql has issues with REPEAT() and
    // decimals, and the backend doesn't do it for us, anyway.
        $this->starstring = @str_repeat(star_character, intVal($this->stars * max_stars));
        $frac = ($this->stars * max_stars) - intVal($this->stars * max_stars);
        if ($frac >= .75)
            $this->starstring .= '&frac34;';
        elseif ($frac >= .5)
            $this->starstring .= '&frac12;';
        elseif ($frac >= .25)
            $this->starstring .= '&frac14;';
    // Get the name of the input
        if ($this->inputid) {
            $this->inputname = $db->query_col('SELECT displayname
                                                 FROM cardinput
                                                WHERE cardinputid=?',
                                              $this->inputid);
        }
    // Turn recstatus into a word
        if (isset($this->recstatus) && $GLOBALS['RecStatus_Types'][$this->recstatus]) {
            $this->recstatus_orig   = $this->recstatus;
            $this->recstatus        = $GLOBALS['RecStatus_Types'][$this->recstatus];
            $this->conflicting      = ($this->recstatus == 'Conflict');   # conflicts with another scheduled recording?
            $this->recording        = ($this->recstatus == 'WillRecord'); # scheduled to record?
        }
    // No longer a null column, so check for blank entries
        if (in_array($this->airdate, array('0000-00-00', '0000', '1900-01-01')))
            $this->airdate = NULL;
    // Do we have a chanid?  Load some info about it
        if ($this->chanid && !isset($this->channel))
            $this->channel =& Channel::find($this->chanid);

    // Calculate the duration
        if ($this->recendts)
            $this->length = $this->recendts - $this->recstartts;
        else
            $this->length = $this->endtime  - $this->starttime;

    // A special recstatus for shows that this was manually set to record
        if ($this->rectype == rectype_override)
            $this->recstatus = 'ForceRecord';

    // Find out which css category this program falls into
        if ($this->chanid != '')
            $this->css_class = category_class($this);
    // Create the fancy description
        $this->update_fancy_desc();
    }

    public function merge($prog) {
        foreach (get_object_vars($prog) as $name => $value) {
            if ($value && !$this->$name) {
                $this->$name = $value;
            }
        }
    // Special case for the original airdate, which the backend seems to misplace
        if (!in_array($prog->airdate, array('0000-00-00', '0000', '1900-01-01')))
            $this->airdate = $prog->airdate;
    // update fancy description in case a part of it changed
        $this->update_fancy_desc();
    }

    public function update_fancy_desc() {
    // Get a nice description with the full details
        $details = array();

        if ($this->hdtv)
            $details[] = t('HDTV');
        if ($this->widescreen)
            $details[] = t('Widescreen');
        if ($this->avc)
            $details[] = t('AVC/H.264');
        if ($this->hd_ready)
            $details[] = t('720');
        if ($this->fullhd)
            $details[] = t('1080');
        if ($this->damaged)
            $details[] = t('Damaged');
        if ($this->parttotal > 1 || $this->partnumber > 1)
            $details[] = t('Part $1 of $2', $this->partnumber, $this->parttotal);
        if ($this->rating)
            $details[] = $this->rating;
        if ($this->closecaptioned)
            $details[] = t('CC');
        if ($this->has_subtitles)
            $details[] = t('Subtitles Available');
        if ($this->subtitled)
            $details[] = t('Subtitled');
        if ($this->deaf_signed)
            $details[] = t('Deaf Signed');
        if ($this->stereo)
            $details[] = t('Stereo');
        if ($this->mono)
            $details[] = t('Mono');
        if ($this->surround)
            $details[] = t('Surround Sound');
        if ($this->dolby)
            $details[] = t('Dolby Surround');
        if ($this->audiohardhear)
            $details[] = t('Audio for Hearing Impaired');
        if ($this->audiovisimpair)
            $details[] = t('Audio for Visually Impaired');
        if ($this->previouslyshown)
            $details[] = t('Repeat');

        $this->fancy_description = $this->description;
        if (count($details) > 0)
            $this->fancy_description .= ' ('.implode(', ', $details).')';
    }

/**
 * Load info about any queued or recently finished jobs
/**/
    public function load_jobs() {
        if (empty($this->filename))
            return;
    // Make sure the jobqueue constants are defined
        require_once 'includes/jobqueue.php';
    // Keep track of which jobs are possible to be started (due to not already
    // being in the queue).
        global $Jobs;
        $this->jobs_possible = $Jobs;
    // Load the info
        global $db;
        $sh = $db->query('SELECT *,
                                 UNIX_TIMESTAMP(statustime) AS statustime
                            FROM jobqueue
                           WHERE starttime  = FROM_UNIXTIME(?)
                                 AND chanid = ?
                        ORDER BY statustime DESC',
                         $this->recstartts,
                         $this->chanid);
        $this->jobs      = array();
        while ($row = $sh->fetch_assoc()) {
            if ($row['status'] & JOB_DONE)
                $this->jobs['done'][] = $row;
            else {
                $this->jobs['queue'][] = $row;
                unset($this->jobs_possible[$row['type']]);
            }
        }
        $sh->finish();

    }

/**
 * Generate a mythproto-compatible row of data for this show.
/**/
    public function backend_row() {
        return implode(MythBackend::$backend_separator,
                       array(
                             $this->title          , // 00 title
                             $this->subtitle       , // 01 subtitle
                             $this->description    , // 02 description
                             $this->season         , // 03 season
                             $this->episode        , // 04 episode
                             $this->syndicatedepisodenumber, // 05 syndicatedepisode
                             $this->category       , // 06 category
                             $this->chanid         , // 07 chanid
                             $this->channum        , // 08 chanstr
                             $this->callsign       , // 09 chansign
                             $this->channame       , // 10 channame
                             $this->filename       , // 11 pathname
                             $this->filesize       , // 12 filesize

                             $this->starttime      , // 13 startts
                             $this->endtime        , // 14 endts
                             $this->findid         , // 15 findid
                             $this->hostname       , // 16 hostname
                             $this->sourceid       , // 17 sourceid
                             $this->cardid         , // 18 cardid
                             $this->inputid        , // 19 inputid
                             $this->recpriority    , // 20 recpriority
                             $this->recstatus      , // 21 recstatus
                             $this->recordid       , // 22 recordid

                             $this->rectype        , // 23 rectype
                             $this->dupin          , // 24 dupin
                             $this->dupmethod      , // 25 dupmethod
                             $this->recstartts     , // 26 recstartts
                             $this->recendts       , // 27 recendts
                             $this->progflags      , // 28 programflags
                             $this->recgroup       , // 29 recgroup
                             $this->outputfilters  , // 30 chanOutputFilters
                             $this->seriesid       , // 31 seriesid
                             $this->programid      , // 32 programid
                             $this->inetref        , // 33 inetref

                             $this->lastmodified   , // 34 lastmodified
                             $this->stars          , // 35 stars
                             $this->airdate        , // 36 originalAirDate
                             $this->playgroup      , // 37 playgroup
                             $this->recpriority2   , // 38 recpriority2
                             $this->parentid       , // 39 parentid
                             $this->storagegroup   , // 40 storagegroup
                             $this->audioproperties, // 41 audioprop
                             $this->videoproperties, // 42 videoprop
                             $this->subtitletype   , // 43 subtitletype
                             $this->year           , // 44 year
                             $this->partnumber     , // 45 partnumber
                             $this->parttotal      , // 46 parttotal
                            )
                      );
    }

/**
 * Get the last modification date of the pixmap that corresponds to this
 * recording.
/**/
    public function pixmap_last_mod() {
        $mod = MythBackend::find()->sendCommand(array('QUERY_PIXMAP_LASTMODIFIED', $this->backend_row()));
        if ($mod == 'BAD')
            return 0;
        return $mod;
    }

/**
 * Generate a new preview pixmap for this recording.
/**/
    public function generate_pixmap() {
        $ret = MythBackend::find()->sendCommand(array('QUERY_GENPIXMAP2', "do_not_care", $this->backend_row()));
        if ($ret == 'ERROR') {
            return 0;
        }
        return 1;
    }

/**
 * Generate a thumbnail of the requested size, and return the URL to its cache
 * location.
/**/
    public function thumb_url($width=160, $height=120, $secs_in=-1) {

        $filename = explode('/', $this->filename);
        $filename = array_pop($filename);

        if ($height == 0)
            $height = floor($width / $this->getAspect());

        return root_url."tv/get_pixmap/{$this->hostname}/{$this->chanid}/{$this->recstartts}/$width/$height/$secs_in/$filename.{$width}x{$height}x$secs_in.png";
    }

/**
 * Gets a preview image of the requested show
 *
 * @todo, this should get put into a "recording" class or something like that.
/**/
    public static function get_preview_pixmap($hostname, $chanid, $starttime, $width=160, $height=120, $secs_in=null) {

        return MythBackend::find($hostname)->httpRequest('Content/GetPreviewImage', array('ChanId'      => $chanid,
                                                                         'StartTime'   => unix2mythtime($starttime),
                                                                         'Height'      => $height,
                                                                         'Width'       => $width));
    }

/**
 * The "details list" for each program.
/**/
    public function details_list() {
    // Start the list, and print the show airtime and title
        $str = "<dl class=\"details_list\">\n"
            // Airtime
              ."\t<dt>".t('Airtime').":</dt>\n"
              ."\t<dd>".t('$1 to $2',
                          strftime($_SESSION['time_format'], $this->starttime),
                          strftime($_SESSION['time_format'], $this->endtime))
                       ."</dd>\n"
        // Channel
              ."\t<dt>".t('Channel').":</dt>\n"
              ."\t<dd>".($_SESSION["prefer_channum"] ? $this->channel->channum : $this->channel->callsign)
                       .' - '.$this->channel->name
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
                case rectype_always:     $str .= t('rectype-long: always');     break;
                case rectype_weekly:     $str .= t('rectype-long: weekly');     break;
                case rectype_findone:    $str .= t('rectype-long: findone');    break;
                case rectype_override:   $str .= t('rectype-long: override');   break;
                case rectype_dontrec:    $str .= t('rectype-long: dontrec');    break;
                default:                 $str .= t('Unknown');
            }
            $str .= "</dd>\n";
        }
    // Recording Priority
        if ($this->recpriority != null)
            $str .= "\t<dt>".t('Recording Priority')."</dt><dd>".$this->recpriority."</dd>\n";
        elseif ($this->recpriority2 != null)
            $str .= "\t<dt>".t('Recording Priority')."</dt><dd>".$this->recpriority2."</dd>\n";
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

    public function has_credits() {
        global $db;
        return $db->query_col('SELECT COUNT(people.name)
                                 FROM credits, people
                                WHERE credits.person    = people.person
                                  AND credits.chanid    = ?
                                  AND credits.starttime = FROM_UNIXTIME(?)',
                              $this->chanid,
                              $this->starttime
                              );
    }

    public function get_credits($role, $add_search_links = FALSE) {
        global $db;
    // Not enough info in this object
        if (!$this->chanid || !$this->starttime)
            return '';
    // No cached value -- load it
        if (!isset($this->credits[$role][$add_search_links])) {
        // Get the credits for the requested role
            $result = $db->query('SELECT people.name
                                     FROM credits, people
                                    WHERE credits.person    = people.person
                                      AND credits.role      = ?
                                      AND credits.chanid    = ?
                                      AND credits.starttime = FROM_UNIXTIME(?)',
                                   $role,
                                   $this->chanid,
                                   $this->starttime
                                   );
            $people = array();
            while ($name = $result->fetch_col()) {
                if (!$add_search_links)
                    $people[] = $name;
                else
                    $people[] = '<a href="'.root_url.'tv/search/'.str_replace('%2F', '/', rawurlencode('^'.$name.'$')).'?field=people">'.$name.'</a>';
            }
        // Cache it
            $this->credits[$role][$add_search_links] = trim(implode(', ', $people));
        }
        return $this->credits[$role][$add_search_links];
    }

/*
 *  The following methods relate to a program's control over its recording options.
 */

/**
 * Forget everything about a previously recorded program
 *
 * @todo Eventually, all of this should get separated out of the Program class
 * and into something more generic, since this backend command is called from
 * several places depending on if a program or a non-expanded data row is being
 * used.
/**/
    public function rec_forget_old() {
        global $db;
    // The FORGET_RECORDING command requires the specific record to be
    // forgotten, so we have to search for matching rows
        $sh = $db->query("SELECT *
                            FROM oldrecorded
                           WHERE title = ? AND
                                 ((programid = '' AND subtitle = ?
                                   AND description = ?) OR 
                                  (programid <> '' AND programid = ?) OR 
                                  (findid <> 0 AND findid = ?))",
                         $this->title,
                         $this->subtitle,
                         $this->description,
                         $this->programid,
                         $this->findid);
        while ($row = $sh->fetch_assoc()) {
            $prog =& new Program($row);
            MythBackend::find()->sendCommand(array('FORGET_RECORDING', $prog->backend_row(), '0'));
        }
        $sh->finish();
        MythBackend::find()->listenForEvent('SCHEDULE_CHANGE');
    }

/**
 * "Never" record this show, by telling mythtv that it was already recorded
/**/
    public function rec_never_record() {
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
                                .escape(isset($this->recordid) ? $this->recordid : 0)                  .','
                                .escape($this->channel->callsign)         .','
                                .escape(isset($this->rectype) ? $this->rectype : 0)                   .','
                                .'11'                                     .','
                                .'1'                                      .')')
            or trigger_error('SQL Error: '.mysql_error(), FATAL);
    // Notify the backend of the changes
        MythBackend::find()->rescheduleRecording();
    }

/**
 * Revert a show to its default recording schedule settings
/**/
    public function rec_default() {
        $schedule =& Schedule::findAll($this->recordid);
        if ($schedule && ($schedule->type == rectype_override || $schedule->type == rectype_dontrec))
            $schedule->delete();
    }

/**
 * Add an override or dontrec record to force this show to/not record pass in
 * rectype_dontrec or rectype_override constants
/**/
    public function rec_override($rectype) {
        $schedule =& Schedule::find($this->recordid);
    // Unknown schedule?
        if (!$schedule) {
            add_error('Unknown schedule for this program\'s recordid:  '.$this->recordid);
            return;
        }
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
//        $schedule->search      = 0;
        $schedule->inactive    = 0;
    // Save the schedule -- it'll know what to do about the override
        $schedule->save($rectype);
    }

/**
 * Activate a program to record, even if it's in progress
/**/
    public function activate() {
        global $db;
    // If we have already started recording, allow the reactivate to happen, re #4814
        $db->query('UPDATE oldrecorded
                       SET oldrecorded.reactivate = 1
                     WHERE oldrecorded.starttime  = ?
                       AND oldrecorded.chanid     = ?',
                    $this->starttime,
                    $this->chanid
                  );
        $this->rec_override(rectype_override);
    }

/**
 * Intended to be called as program::category_types()
 *
 * @return array sorted list of category_type fields from the program table
/**/
    public function category_types() {
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
    public function categories() {
        static $cache = array();
        if (empty($cache)) {
            global $db;
            $cache = $db->query_list('SELECT DISTINCT category
                                                 FROM program
                                                WHERE LENGTH(category) > 0
                                             ORDER BY category ASC'
                                    );
        }
        return $cache;
    }

/**
 * Stop recording the program is we are currently recording...
 *
 * @return bool did we actually stop recording?
/**/
    public function stopRecording() {
        if ($this->recstatus != 'Recording')
            return false;
        MythBackend::find()->sendCommand(array('STOP_RECORDING', $prog->backend_row(), '0'));
        return true;
    }

    public function findDiskPath() {
        global $db;
        $dirs = $db->query('SELECT DISTINCT storagegroup.dirname
                              FROM storagegroup
                             WHERE storagegroup.groupname = ?',
                             $this->storagegroup
                             );
        while ($dir = $dirs->fetch_col()) {
            if (file_exists($dir.$this->filename))
                return $dir.$this->filename;
        }
        return false;
    }

    public function hasAlternativeFormat($format = 'mp4') {
        $path = preg_replace('/\.[a-z0-9]+$/i', '.'.$format, $this->findDiskPath());
        return file_exists($path);
    }

    public function getAspect() {
        global $db;
        $sh = $db->query('SELECT recordedmarkup.type,
                                 recordedmarkup.data
                            FROM recordedmarkup
                           WHERE recordedmarkup.chanid    = ?
                             AND recordedmarkup.starttime = FROM_UNIXTIME(?)
                             AND recordedmarkup.type      IN (10, 11, 12, 13, 14)
                        GROUP BY recordedmarkup.type
                        ORDER BY SUM((SELECT IFNULL(rm.mark, recordedmarkup.mark)
                                        FROM recordedmarkup AS rm
                                       WHERE rm.chanid = recordedmarkup.chanid
                                         AND rm.starttime = recordedmarkup.starttime
                                         AND rm.type IN (10, 11, 12, 13, 14)
                                         AND rm.mark > recordedmarkup.mark
                                ORDER BY rm.mark ASC LIMIT 1)- recordedmarkup.mark) DESC
                           LIMIT 1',
                           $this->chanid,
                           $this->recstartts
                           );
        $row = $sh->fetch_assoc();
        $sh->finish();

        switch($row['type']) {
            case 10:
                return 1;
            case 11:
                return 4/3;
            case 12:
                return 16/9;
            case 13:
                return 2.21/1;
            case 14:
                return $row['data']/1000000.0;
            default:
                return 4/3;
        }
    }
}
