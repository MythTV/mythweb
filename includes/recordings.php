<?php
/***                                                                        ***\
    recordings.php                           Last Updated: 2005.01.21 (xris)

    The Recording object, and a couple of related subroutines.
\***                                                                        ***/

// Make sure the "Channels" class gets loaded   (yes, I know this is recursive, but require_once will handle things nicely)
    require_once 'includes/channels.php';

//
    $RecTypes = array(
                        1 => t('rectype: once'),
                        2 => t('rectype: daily'),
                        3 => t('rectype: channel'),
                        4 => t('rectype: always'),
                        5 => t('rectype: weekly'),
                        6 => t('rectype: findone'),
                        7 => t('rectype: override'),
                        8 => t('rectype: dontrec'),
                     );

/*
    load_all_recordings:
    loads all recording data for the specified time range into the $Channels array.
    Set $single_recording to true if you only want information about recordings that
    start exactly at $start_time (used by recording_detail.php)
*/
    function &load_all_recordings($recordid = 0) {
        global $Channels;
    // An array (that later gets converted to a string) containing the id's of channels we want to load
        $these_channels = array();
    // No channel data?  Load it
        if (!is_array($Channels) || !count($Channels))
            load_all_channels();

    // Build the sql query, and execute it
        $query = 'SELECT *, if(type=4,-1,chanid) as chanid, UNIX_TIMESTAMP(startdate)+TIME_TO_SEC(starttime) AS starttime_unix,'
                .' UNIX_TIMESTAMP(enddate)+TIME_TO_SEC(endtime) AS endtime_unix '
                .'FROM record ';
        if ($recordid > 0)
            $query .= " WHERE recordid = $recordid ";
        $query .= 'ORDER BY title, subtitle, description, startdate, starttime';

        $result = mysql_query($query)
            or trigger_error('SQL Error: '.mysql_error(), FATAL);
    // Load in all of the recordings (if any?)
        $these_recordings = array();
        while ($recording_data = mysql_fetch_assoc($result)) {
            $recording =& new Recording($recording_data);
            if ($recordid > 0) {
                mysql_free_result($result);
                return $recording;
            }
            $these_recordings[] = &$recording;
        }

    // Cleanup
        mysql_free_result($result);
    // Just in case, return an array of all recordings found

        return $these_recordings;
    }

//
//  Recordings class
//
class Recording {
    var $recordid;
    var $type;
    var $chanid;
    var $starttime;
    var $endtime;
    var $title;
    var $subtitle;
    var $description;
    var $category;
    var $profile;
    var $recgroup;
    var $recpriority;
    var $autoexpire;
    var $maxepisodes;
    var $maxnewest;
    var $dupin;
    var $dupmethod;
    var $startoffset;
    var $endoffset;

    var $seriesid;
    var $programid;

    var $texttype;
    var $channel;

    var $will_record    = false;
    var $record_daily   = false;
    var $record_weekly  = false;
    var $record_once    = false;
    var $record_channel = false;
    var $record_always  = false;

    var $class;         // css class, based on category and/or category_type

    function Recording($recording_data) {

    // SQL data
        if (is_array($recording_data) && isset($recording_data['recordid'])) {
            $this->recordid    = $recording_data['recordid'];
            $this->type        = $recording_data['type'];
            $this->chanid      = $recording_data['chanid'];
            $this->starttime   = $recording_data['starttime_unix'];
            $this->endtime     = $recording_data['endtime_unix'];
            $this->title       = $recording_data['title'];
            $this->subtitle    = $recording_data['subtitle'];
            $this->description = $recording_data['description'];
            $this->category    = $recording_data['category'];
            $this->profile     = $recording_data['profile'];
            $this->recgroup    = $recording_data['recgroup'];
            $this->recpriority = $recording_data['recpriority'];
            $this->autoexpire  = $recording_data['autoexpire'];
            $this->maxepisodes = $recording_data['maxepisodes'];
            $this->maxnewest   = $recording_data['maxnewest'];
            $this->dupin       = $recording_data['dupin'];
            $this->dupmethod   = $recording_data['dupmethod'];
            $this->startoffset = $recording_data['startoffset'];
            $this->endoffset   = $recording_data['endoffset'];
            $this->seriesid    = $recording_data['seriesid'];
            $this->programid   = $recording_data['programid'];
        }
    // Recording object data
        else {
            $tmp = @get_object_vars($recording_data);
            if (count($tmp) > 0) {
                foreach ($tmp as $key => $value) {
                    $this->$key = $value;
                }
            }
        }

    // We get various recording-related information, too
        switch ($this->type) {
            case 1: $this->record_once    = true;  break;
            case 2: $this->record_daily   = true;  break;
            case 3: $this->record_channel = true;  break;
            case 4: $this->record_always  = true;  break;
            case 5: $this->record_weekly  = true;  break;
            case 6: $this->record_findone = true;  break;
        }

    // Add a generic "will record" variable, too
        $this->will_record = ($this->record_daily
                              || $this->record_weekly
                              || $this->record_once
                              || $this->record_findone
                              || $this->record_channel
                              || $this->record_always ) ? true : false;
    // Turn type int a word
        $this->texttype = $GLOBALS['RecTypes'][$this->type];
    // Do we have a chanid?  Load some info about it
        if ($this->chanid && !isset($this->channel)) {
        // No channel data?  Load it
            global $Channels;
            if (!is_array($Channels) || !count($Channels))
                load_all_channels($this->chanid);
        // Now we really should scan the $Channel array and add a link to this recording's channel
            foreach (array_keys($Channels) as $key) {
                if ($Channels[$key]->chanid == $this->chanid) {
                    $this->channel = &$Channels[$key];
                    break;
                }
            }
        }

    // Find out which css category this recording falls into
        if ($this->chanid != '')
            $this->class = category_class($this);
    }

/*
    details_table:
    The "details table" for recordings.  Very similar to that for programs, but
    with a few extra checks, and some information arranged differently.
*/
    function details_table() {
    // Start the table, and print the show title
        $str = "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n<tr>\n\t<td align=\"right\">"
              .t('Title')
              .":</td>\n\t<td>"
              .$this->title
              ."</td>\n</tr>";
    // Type
        $str .= "<tr>\n\t<td align=\"right\">"
               .t('Type')
               .":</td>\n\t<td>"
               .$this->texttype
               ."</td>\n</tr>";
    // Only show these fields for recording types where they're relevant (1:once, 2:daily, 5:weekly, 7:override, 8:dontrec)
        if (($this->type == 1) || ($this->type == 2) || ($this->type == 5) || ($this->type == 7) || ($this->type == 8)) {
        // Airtime
            $str .= "<tr>\n\t<td align=\"right\">"
                   .t('Airtime')
                   .":</td>\n\t<td>"
                   .strftime($_SESSION['date_scheduled_popup'].', '.$_SESSION['time_format'], $this->starttime)
                   .' to '.strftime($_SESSION['time_format'], $this->endtime)
                   ."</td>\n</tr>";
        // Subtitle
            if (preg_match('/\\S/', $this->subtitle)) {
                $str .= "<tr>\n\t<td align=\"right\">"
                       .t('Subtitle')
                       .":</td>\n\t<td>"
                       .$this->subtitle
                       ."</td>\n</tr>";
            }
        // Description
            if (preg_match('/\\S/', $this->description)) {
                $str .= "<tr>\n\t<td align=\"right\" valign=\"top\">"
                       .t('Description')
                       .":</td>\n\t<td>"
                       .nl2br(wordwrap($this->description, 70))
                       ."</td>\n</tr>";
            }
        // Rating
            if (preg_match('/\\S/', $this->rating)) {
                $str .= "<tr>\n\t<td align=\"right\">"
                       .t('Rating')
                       .":</td>\n\t<td>"
                       .$this->rating
                       ."</td>\n</tr>";
            }
        }
    // Category
        if (preg_match('/\\S/', $this->category)) {
            $str .= "<tr>\n\t<td align=\"right\">"
                   .t('Category')
                   .":</td>\n\t<td>"
                   .$this->category
                   ."</td>\n</tr>";
        }
    // Rerun?
        if (!empty($this->previouslyshown)) {
            $str .= "<tr>\n\t<td align=\"right\">"
                   .t('Rerun')
                   .":</td>\n\t<td>"
                   .t('Yes')
                   ."</td>\n</tr>";
        }
    // Will be recorded at some point in the future?
        if (!empty($this->will_record)) {
            $str .= "<tr>\n\t<td align=\"right\">"
                   .t('Schedule')
                   .":</td>\n\t<td>";
            if ($this->record_daily)       { $str .= t('rectype-long: daily');   }
            elseif ($this->record_weekly)  { $str .= t('rectype-long: weekly');  }
            elseif ($this->record_once)    { $str .= t('rectype-long: once');    }
            elseif ($this->record_channel) { $str .= t('rectype-long: channel'); }
            elseif ($this->record_findone) { $str .= t('rectype-long: findone'); }
            else                           { $str .= t('rectype-long: always');  }
            $str .= "</td>\n</tr>";
        }
    // Which duplicate-checking method will be used
        if ($this->dupmethod > 0) {
            $str .= "<tr>\n\t<td align=\"right\">"
                   .t('Dup Method')
                   .":</td>\n\t<td>";
            switch ($this->dupmethod) {
                case 1:  $str .= t('None');                         break;
                case 2:  $str .= t('Subtitle');                     break;
                case 4:  $str .= t('Description');                  break;
                case 6:  $str .= t('Subtitle and Description');     break;
                case 22: $str .= t('Sub and Desc (Empty matches)'); break;
            }
            $str .= "</td>\n</tr>";
        }
    // Profile
        if (preg_match('/\\S/', $this->profile)) {
            $str .= "<tr>\n\t<td align=\"right\">"
                   .t('Profile')
                   .":</td>\n\t<td>"
                   .$this->profile
                   ."</td>\n</tr>";
        }
    // Recording Group
        if (!empty($this->recgroup)) {
            $str .="<tr>\n\t<td align=\"right\">"
                   .t('Recording Group')
                   .":</td>\n\t<td>"
                   .$this->recgroup
                   ."</td>\n</tr>";
        }
    // Recording status
        if (!empty($this->recstatus)) {
            $str .= "<tr>\n\t<td align=\"right\">"
                   .t('Notes')
                   .":</td>\n\t<td>"
                   .$GLOBALS['RecStatus_Reasons'][$this->recstatus]
                   ."</td>\n</tr>";
        }
    // Finish off the table and return
        $str .= "\n</table>";
        return $str;
    }

}

?>
