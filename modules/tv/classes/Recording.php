<?php
/**
 * The Recording object, and a couple of related subroutines.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Make sure the recording schedule type data gets loaded
    require_once 'includes/recording_schedules.php';

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
    var $season;
    var $episode;
    var $category;
    var $profile;
    var $recgroup;
    var $storagegroup;
    var $recpriority;
    var $autoexpire;
    var $maxepisodes;
    var $maxnewest;
    var $dupin;
    var $dupmethod;
    var $startoffset;
    var $endoffset;
    var $progstart;
    var $progend;
    var $seriesid;
    var $programid;
    var $inetref;
    var $texttype;

    var $basename;

    var $channel;

    var $will_record    = false;
    var $record_daily   = false;
    var $record_weekly  = false;
    var $record_once    = false;
    var $record_always  = false;

    var $css_class;         // css class, based on category and/or category_type

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
            $this->season      = $recording_data['season'];
            $this->episode     = $recording_data['episode'];
            $this->category    = $recording_data['category'];
            $this->profile     = $recording_data['profile'];
            $this->recgroup    = $recording_data['recgroup'];
            $this->storagegroup = $recording_data['storagegroup'];
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
            $this->inetref     = $recording_data['inetref'];
            $this->progstart   = $recording_data['progstart'];
            $this->progend     = $recording_data['progend'];
            $this->basename    = $recording_data['basename'];
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
            case 4: $this->record_always  = true;  break;
            case 5: $this->record_weekly  = true;  break;
            case 6: $this->record_findone = true;  break;
        }

    // Add a generic "will record" variable, too
        $this->will_record = ($this->record_daily
                              || $this->record_weekly
                              || $this->record_once
                              || $this->record_findone
                              || $this->record_always ) ? true : false;
    // Turn type int a word
        $this->texttype = $GLOBALS['RecTypes'][$this->type];
    // Do we have a chanid?  Load some info about it
        if ($this->chanid && !isset($this->channel))
            $this->channel =& Channel::find($this->chanid);

    // Find out which css category this recording falls into
        if ($this->chanid != '')
            $this->css_class = category_class($this);
    }

}
