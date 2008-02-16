<?php

class MythTVProgram {

    var $MythTV;

    var $title          = 'Untitled';
    var $subtitle       = 'Untitled';
    var $description    = 'No Description';
    var $category;
    var $chanid;
    var $channum;
    var $callsign;
    var $channame;
    var $filename;
    var $fs_high;
    var $fs_low;
    var $starttime;
    var $endtime;
    var $duplicate;
    var $shareable;
    var $findid;
    var $hostname;
    var $sourceid;
    var $cardid;
    var $inputid;
    var $recpriority;
    var $recstatus;
    var $recordid;
    var $rectype;
    var $dupin;
    var $dupmethod;
    var $recstartts;
    var $recendts;
    var $previouslyshown;
    var $progflags;
    var $recgroup;
    var $commfree;
    var $outputfilters;
    var $seriesid;
    var $programid;
    var $lastmodified;
    var $stars;
    var $airdate;
    var $hasairdate;
    var $playgroup;
    var $recpriority2;
    var $parentid;
    var $storagegroup;

    var $has_commflag;
    var $has_cutlist;
    var $auto_expire;
    var $is_editing;
    var $bookmark;
    var $stereo;
    var $closecaptioned;
    var $hdtv;
    var $is_watched;
    var $will_record;

    function __construct(&$MythTV, $ProgramID = NULL) {
        if (get_class($MythTV) != 'MythTV')
            die 'MythTVChannel requires class MythTV to be passed';
        $this->MythTV = &$MythTV;
        if (is_null($ProgramID))
            die '$ProgramID can not be NULL';
        $program = $this->MythTV->DB->query_assoc('SELECT ');
        foreach ($program as $key => $value)
            $this->$key = $value;
    }
}
