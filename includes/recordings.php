<?php
/***                                                                        ***\
	recordings.php                           Last Updated: 2004.04.19 (xris)

	The Recording object, and a couple of related subroutines.
\***                                                                        ***/

// Make sure the "Channels" class gets loaded   (yes, I know this is recursive, but require_once will handle things nicely)
	require_once 'includes/channels.php';

//
	$RecTypes = array(
						1 => _LANG_RECTYPE_ONCE,
						2 => _LANG_RECTYPE_DAILY,
						3 => _LANG_RECTYPE_CHANNEL,
						4 => _LANG_RECTYPE_ALWAYS,
						5 => _LANG_RECTYPE_WEEKLY,
						6 => _LANG_RECTYPE_FINDONE
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
		$query = 'SELECT *, UNIX_TIMESTAMP(startdate)+TIME_TO_SEC(starttime) AS starttime_unix,'
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
//	Recordings class
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

	var $class;			// css class, based on category and/or category_type

	function Recording($recording_data) {

		if (isset($recording_data['recordid'])) {
	// SQL data
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
		} else {
			$this->recordid    = $recording_data->recordid;
			$this->type        = $recording_data->type;
			$this->chanid      = $recording_data->chanid;
			$this->starttime   = $recording_data->starttime;
			$this->startdate   = $recording_data->startdate;
			$this->endtime     = $recording_data->endtime;
			$this->enddate     = $recording_data->enddate;
			$this->title       = $recording_data->title;
			$this->subtitle    = $recording_data->subtitle;
			$this->description = $recording_data->description;
			$this->category    = $recording_data->category;
			$this->profile     = $recording_data->profile;
			$this->recpriority = $recording_data->recpriority;
			$this->autoexpire  = $recording_data->autoexpire;
			$this->maxepisodes = $recording_data->maxepisodes;
			$this->maxnewest   = $recording_data->maxnewest;
			$this->dupin       = $recording_data->dupin;
			$this->dupmethod   = $recording_data->dupmethod;
			$this->startoffset = $recording_data->startoffset;
			$this->endoffset   = $recording_data->endoffset;
			$this->seriesid    = $recording_data->seriesid;
			$this->programid   = $recording_data->programid;
		}

		// We get various recording-related information, too
		if ($this->type == 1)
			$this->record_once = true;
		elseif ($this->type == 2)
			$this->record_daily = true;
		elseif ($this->type == 3)
			$this->record_channel = true;
		elseif ($this->type == 4)
			$this->record_always = true;
		elseif ($this->type == 5)
			$this->record_weekly = true;
		elseif ($this->type == 6)
			$this->record_findone = true;

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

}

?>
