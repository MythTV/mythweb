<?php

class MythTVProgram {

    public $MythTV;

    public $title          = 'Untitled';
    public $subtitle       = 'Untitled';
    public $description    = 'No Description';
    public $category;
    public $chanid;
    public $channum;
    public $callsign;
    public $channame;
    public $filename;
    public $fs_high;
    public $fs_low;
    public $starttime;
    public $endtime;
    public $duplicate;
    public $shareable;
    public $findid;
    public $hostname;
    public $sourceid;
    public $cardid;
    public $inputid;
    public $recpriority;
    public $recstatus;
    public $recordid;
    public $rectype;
    public $dupin;
    public $dupmethod;
    public $recstartts;
    public $recendts;
    public $previouslyshown;
    public $progflags;
    public $recgroup;
    public $commfree;
    public $outputfilters;
    public $seriesid;
    public $programid;
    public $lastmodified;
    public $stars;
    public $airdate;
    public $hasairdate;
    public $playgroup;
    public $recpriority2;
    public $parentid;
    public $storagegroup;

    public $has_commflag;
    public $has_cutlist;
    public $auto_expire;
    public $is_editing;
    public $bookmark;
    public $stereo;
    public $closecaptioned;
    public $hdtv;
    public $is_watched;
    public $will_record;

    public function __construct(&$MythTV, $ChanID = NULL, $StartTime = NULL) {
        if (get_class($MythTV) != 'MythTV')
            die('MythTVChannel requires class MythTV to be passed');
        $this->MythTV       = &$MythTV;
        $this->chanid       = $ChanID;
        $this->starttime    = $StartTime;
        $this->load();
    }

    private function load() {
        $this->load_database();
    }

    private function load_database() {
        $program = $this->MythTV->DB->query_assoc('SELECT program.*
                                                     FROM program
                                                    WHERE program.chanid    = ?
                                                      AND program.starttime = ?',
                                                  $this->chanid,
                                                  $this->starttime);
        foreach ($program as $key => $value)
            $this->$key = $value;
    }
}
