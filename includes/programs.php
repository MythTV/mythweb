<?php
/***                                                                        ***\
    programs.php                             Last Updated: 2004.01.27 (xris)

	This contains the Program class
\***                                                                        ***/

// Make sure the "Channels" class gets loaded   (yes, I know this is recursive, but require_once will handle things nicely)
	require_once 'includes/channels.php';

// Reasons a recording wouldn't be happening (from libs/libmythtv/programinfo.h)
	$RecStatus_Types = array(
							  '-5' => 'Deleted',
							  '-4' => 'Stopped',
							  '-3' => 'Recorded',
							  '-2' => 'Recording',
							  '-1' => 'WillRecord',
								0  => 'Unknown',
								1  => 'ManualOverride',
								2  => 'PreviousRecording',
								3  => 'CurrentRecording',
								4  => 'EarlierShowing',
								5  => 'TooManyRecordings',
								6  => 'Cancelled',
								7  => 'Conflict',
								8  => 'LaterShowing',
								10 => 'Overlap',
								11 => 'LowDiskSpace',
								12 => 'TunerBusy'
							);

	$RecStatus_Reasons = array(
							   'Deleted' 			=> _LANG_RECSTATUS_LONG_DELETED,
							   'Stopped' 			=> _LANG_RECSTATUS_LONG_STOPPED,
							   'Recorded'			=> _LANG_RECSTATUS_LONG_RECORDED,
							   'Recording'			=> _LANG_RECSTATUS_LONG_RECORDING,
							   'WillRecord'			=> _LANG_RECSTATUS_LONG_WILLRECORD,
							   'Unknown'			=> _LANG_RECSTATUS_LONG_UNKNOWN,
		                       'ManualOverride'		=> _LANG_RECSTATUS_LONG_MANUALOVERRIDE,
		                       'PreviousRecording'	=> _LANG_RECSTATUS_LONG_PREVIOUSRECORDING,
		                       'CurrentRecording'	=> _LANG_RECSTATUS_LONG_CURRENTRECORDING,
		                       'EarlierShowing'		=> _LANG_RECSTATUS_LONG_EARLIERSHOWING,
		                       'TooManyRecordings'	=> _LANG_RECSTATUS_LONG_TOOMANYRECORDINGS,
		                       'Cancelled' 			=> _LANG_RECSTATUS_LONG_CANCELLED,
		                       'Conflict'			=> _LANG_RECSTATUS_LONG_CONFLICT,
		                       'LaterShowing'		=> _LANG_RECSTATUS_LONG_LATERSHOWING,
		                       'Overlap'	   		=> _LANG_RECSTATUS_LONG_OERLAP,
		                       'LowDiskSpace'  		=> _LANG_RECSTATUS_LONG_LOWDISKSPACE,
			                   'TunerBusy'	   		=> _LANG_RECSTATUS_LONG_TUNERBUSY
							  );

/*
	load_one_program:
	a shortcut to load_all_program_data's single-program query
*/
	function &load_one_program($start_time, $chanid) {
		$program = &load_all_program_data($start_time, $start_time, $chanid, true);
		return $program;
	}

/*
	load_all_program_data:
	loads all program data for the specified time range into the $Channels array.
	Set $single_program to true if you only want information about programs that
	start exactly at $start_time (used by program_detail.php)
*/
	function &load_all_program_data($start_time, $end_time, $chanid = false, $single_program = false, $extra_query = '') {
		global $Channels;
	// Make a local assoc of channel chanid's with references to the actual channel data
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
			$channel_hash[$Channels[$key]->chanid] = &$Channels[$key];
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
	// Find out if there are any recordings queued
		static $num_recordings = false;
		if ($num_recordings === false) {
			$result = mysql_query('SELECT count(*) FROM record')
				or trigger_error('SQL Error: '.mysql_error(), FATAL);
			list($num_recordings) = mysql_fetch_row($result);
			mysql_free_result($result);
		}
	// If there are recordings, we need to grab that info, too - if there aren't, this query info will interfere with the query
		if ($num_recordings > 0) {
			$record_table  = ' LEFT JOIN record ON '
							.' ((record.type = 5 AND program.title = record.title AND record.chanid = program.chanid AND '
							.'      record.starttime = SEC_TO_TIME(time_to_sec(program.starttime)) AND '
							.'      DAYOFWEEK(record.enddate) = DAYOFWEEK(program.endtime)) '
							.' OR (record.type = 4 AND program.title = record.title) '
							.' OR (record.type = 6 AND program.title = record.title) '
							.' OR (record.type = 3 AND program.title = record.title AND record.chanid = program.chanid)'
							.' OR (record.type = 2 AND program.title = record.title AND record.chanid = program.chanid AND '
							.'     record.starttime = SEC_TO_TIME(TIME_TO_SEC(program.starttime)) AND '
							.'     record.endtime = SEC_TO_TIME(TIME_TO_SEC(program.endtime))) '
							.' OR (record.type = 1 AND program.title = record.title AND record.chanid = program.chanid AND '
							.'     record.starttime = SEC_TO_TIME(TIME_TO_SEC(program.starttime)) AND '
							.'     record.startdate = FROM_DAYS(TO_DAYS(program.starttime))))'
							.' LEFT JOIN recordingprofiles ON record.profile=recordingprofiles.id ';
			$record_values = ' SUM(record.type = 6) > 0 AS record_findone,'
			                .' SUM(record.type = 5) > 0 AS record_weekly,'
							.' SUM(record.type = 4) > 0 AS record_always,'
							.' SUM(record.type = 3) > 0 AS record_channel,'
							.' SUM(record.type = 2) > 0 AS record_daily,'
							.' SUM(record.type = 1) > 0 AS record_once,'
							.' IF(record.profile > 0, recordingprofiles.name, \'Default\') as profilename,'
							.' record.profile, record.recpriority, record.dupin, record.dupmethod, record.maxnewest, record.maxepisodes, record.autoexpire, record.startoffset, record.endoffset,';
		}
		else {
			$record_table  = '';
			$record_values = '';
		}
	// Build the sql query, and execute it
		$star_char = escape(star_character);
		$max_stars = escape(max_stars);
		$query = "SELECT program.*,"
				 .$record_values
				 .' UNIX_TIMESTAMP(program.starttime) AS starttime_unix,'
				 .' UNIX_TIMESTAMP(program.endtime) AS endtime_unix,'
				 ." CONCAT(repeat($star_char, program.stars * $max_stars), IF((program.stars * $max_stars * 10) % 10, '&frac12;', '')) AS starstring,"
				 .' IFNULL(programrating.system, \'\') AS rater,'
				 .' IFNULL(programrating.rating, \'\') AS rating'
				 .' FROM program LEFT JOIN programrating USING (chanid, starttime)'
				 .$record_table;
	// Only loading a single channel worth of information
		if ($chanid > 0)
			$query .= ' WHERE program.chanid='.escape($chanid);
	// Loading a group of channels (probably all of them)
		elseif ($these_channels)
			$query .= ' WHERE program.chanid IN ('.$these_channels.')';
	// Requested start time is the same as the end time - don't bother with fancy calculations
		if ($start_time == $end_time)
			$query .= ' AND UNIX_TIMESTAMP(program.starttime) = ' . escape($start_time);
	// We're looking at a time range
		else
			$query .= ' AND (UNIX_TIMESTAMP(program.endtime) > ' . escape($start_time)
					   .' AND UNIX_TIMESTAMP(program.starttime) < ' . escape($end_time) .' AND program.starttime != program.endtime)';
	// The extra query, if there is one
		if ($extra_query)
			$query .= ' AND '.$extra_query;
	// Group, sort and query
		$query .= ' GROUP BY program.chanid, program.starttime ORDER BY program.starttime';
		$result = mysql_query($query)
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
	// Load in all of the programs (if any?)
		$these_programs = array();
		while ($program_data = mysql_fetch_assoc($result)) {
		// Add this as an object to the channel's programs array
			$program =& new Program($program_data);
			$channel_hash[$program_data['chanid']]->programs[] = &$program;
			$these_programs[] = &$program;
			unset($program);
		}
	// Cleanup
		mysql_free_result($result);
	// If channel-specific information was requested, return an array of those programs, or just the first/only one
		if ($chanid) {
			if ($single_program)
				return $channel_hash[$chanid]->programs[0];
			else
				return $channel_hash[$chanid]->programs;
		}
	// Just in case, return an array of all programs found
		return $these_programs;
	}

/*
	load_pending:
	Loads the pending recordings from mythbackend.  Encapsulated here, so it's
	only called when needed.
*/
	function load_pending() {
		global $Pending_Programs;
	// No need to run this more than once
		if (is_array($Pending_Programs))
			return;
	// Load the mythbackend pending programs
		$Pending_Programs = array();
		$programs = get_backend_rows('QUERY_GETALLPENDING', 2);
		$Pending_Programs['offset'] = $programs['offset'];
		foreach ($programs as $program) {
		// Fix some things that need fixing
			$program[11] = myth2unixtime($program[11]);			// show start-time in myth time format (eg. 2003-06-28T06:30:00)
			$program[12] = myth2unixtime($program[12]);			// show end-time in myth time format (eg. 2003-06-28T06:30:00)
		// $Pending_Programs[chanid][starttime]
			$Pending_Programs[$program[4]][$program[11]] = $program;
		}
	}

//
//	Programs class
//
class Program {
	var $chanid;
	var $channel;	// this should be a reference to the $Channel array value

	var $title;
	var $subtitle;
	var $description;
	var $category;
	var $category_type;
	var $class;			// css class, based on category and/or category_type
	var $airdate;
	var $stars;
	var $previouslyshown;

	var $starttime;
	var $endtime;
	var $length;

	var $channame;
	var $filename;
	var $filesize;
	var $hostname;

	var $will_record    = false;
	var $record_daily   = false;
	var $record_weekly  = false;
	var $record_once    = false;
	var $record_channel = false;
	var $record_always  = false;
	var $record_findone = false;
	var $profile        = 0;
	var $max_newest		= 0;
	var $max_episodes	= 0;
	var $auto_expire	= 0;

	var $conflicting    = false;
	var $recording      = false;

	var $recpriority	= 0;
	var $recstatus      = NULL;

	var $rater;
	var $rating;
	var $starstring;
	var $is_movie;

	function Program($program_data) {
	// This is a mythbackend-formatted program - info about this data structure is stored in libs/libmythtv/programinfo.cpp
		if (!isset($program_data['chanid']) && isset($program_data[0])) {
		// Grab some initial data so we can see if extra information is needed
			$this->chanid      = $program_data[4];					# mysql chanid
			$this->filename    = $program_data[8];					# filename
			$fs_high           = $program_data[9];					# high-word of file size
			$fs_low            = $program_data[10];					# low-word of file size
			$this->starttime   = myth2unixtime($program_data[11]);	# show start-time in myth time format (eg. 2003-06-28T06:30:00)
			$this->endtime     = myth2unixtime($program_data[12]);	# show end-time in myth time format (eg. 2003-06-28T06:30:00)
		// Is this a previously-recorded program?  Calculate the filesize
			if (preg_match('/\\d+_\\d+/', $this->filename)) {
				$this->filesize = ($fs_high + ($fs_low < 0)) * 4294967296 + $fs_low;
			}
		// Ah, a scheduled recording - let's load more information about it, to be parsed in below
			elseif ($this->chanid) {
				unset($this->filename);
			// Redefine this object - we won't need any filesize information because this isn't a recorded program
				$this = load_one_program($this->starttime, $this->chanid);
			}
		// Load the remaining info we got from mythbackend
			$this->title       = $program_data[0];					# program name/title
			$this->subtitle    = $program_data[1];					# episode name
			$this->description = $program_data[2];					# episode description
			$this->category    = $program_data[3];					#
			#$chanid           = $program_data[4];
			#$channum          = $program_data[5];					# channel number
			#$callsign         = $program_data[6];					# callsign (eg. FOOD or SCIFI)
			$this->channame    = $program_data[7];					# Channel 35 FOOD
			#$pathname         = $program_data[8];
			#$fs_high          = $program_data[9];
			#$fs_low           = $program_data[10];
			#$starttime        = $program_data[11];
			#$endtime          = $program_data[12];
			$this->override    = $program_data[15] ? true : false;	 # matches an item in oldrecorded, and won't be recorded
			$this->hostname    = $program_data[16];					 #  myth
			#$this->sourceid   = $program_data[17];					 #  -1
			#$this->cardid     = $program_data[18];					 #  -1
			#$this->inputid    = $program_data[19];					 #
			$this->recpriority = $program_data[20];					 #
			$this->recstatus   = $program_data[21];					 #
			$this->conflicting = ($this->recstatus == 'Conflict');	 # conflicts with another scheduled recording?
			$this->recording   = ($this->recstatus == 'WillRecord'); # scheduled to record?
			$this->recordid    = $program_data[22];			         #
			#$this->rectype     = $program_data[23];
			$this->dupin       = $program_data[24];
			$this->dupmethod   = $program_data[25];
			#$this->recstartts  = $program_data[26];
			#$this->recendts    = $program_data[27];
			#$this->repeat      = $program_data[28];
			#$this->progflags  = $program_data[29];
			#$this->recgroup    = $program_data[30];
			#$this->commfree    = $program_data[31];
		}
	// SQL data
		else {
			$this->chanid          = $program_data['chanid'];
			$this->starttime       = $program_data['starttime_unix'];
			$this->endtime         = $program_data['endtime_unix'];
			$this->title           = $program_data['title'];
			$this->subtitle        = $program_data['subtitle'];
			$this->description     = $program_data['description'];
			$this->category        = $program_data['category']      ? $program_data['category']       : _LANG_UNKNOWN;
			$this->category_type   = $program_data['category_type'] ? $program_data['category_type'] : 'Unknown';
			$this->airdate         = $program_data['airdate'];
			$this->stars           = $program_data['stars'];
			$this->previouslyshown = $program_data['previouslyshown'];
			$this->starstring      = $program_data['starstring'];
			$this->rater           = $program_data['rater'];
			$this->rating          = $program_data['rating'];
			$this->profile         = $program_data['profile'];
			$this->profilename     = $program_data['profilename'];
			$this->recpriority     = $program_data['recpriority'];
			$this->dupin           = $program_data['dupin'];
			$this->dupmethod       = $program_data['dupmethod'];
			$this->maxnewest       = $program_data['maxnewest'];
			$this->maxepisodes     = $program_data['maxepisodes'];
			$this->autoexpire      = $program_data['autoexpire'];
			$this->startoffset     = $program_data['startoffset'];
			$this->endoffset       = $program_data['endoffset'];
		// Check to see if there is any additional data from mythbackend about this program
			global $Pending_Programs;
			load_pending();
			if ($Pending_Programs[$this->chanid][$this->starttime]) {
				$this->recpriority = $Pending_Programs[$this->chanid][$this->starttime][20];
				$this->recstatus   = $Pending_Programs[$this->chanid][$this->starttime][21];
				$this->conflicting = ($this->recstatus == 'Conflict');
				$this->recording   = ($this->recstatus <= 'WillRecord');
				$this->recordid    = $Pending_Programs[$this->chanid][$this->starttime][22];
			}
		// We get various recording-related information, too
			if ($program_data['record_findone'])
				$this->record_findone = true;
			else if ($program_data['record_always'])
				$this->record_always  = true;
			elseif ($program_data['record_channel'])
				$this->record_channel =  true;
			elseif ($program_data['record_once'])
				$this->record_once    =  true;
			elseif ($program_data['record_daily'])
				$this->record_daily   =  true;
			elseif ($program_data['record_weekly'])
				$this->record_weekly  =  true;
		// Add a generic "will record" variable, too
			$this->will_record     = ($this->record_daily
									  || $this->record_weekly
									  || $this->record_once
									  || $this->record_channel
									  || $this->record_always
                                      || $this->record_findone ) ? true : false;
		}
	// Turn recstatus into a word
		if (isset($this->recstatus) && $GLOBALS['RecStatus_Types'][$this->recstatus])
			$this->recstatus = $GLOBALS['RecStatus_Types'][$this->recstatus];
	// Do we have a chanid?  Load some info about it
		if ($this->chanid && !isset($this->channel)) {
		// No channel data?  Load it
			global $Channels;
			if (!is_array($Channels) || !count($Channels))
				load_all_channels($this->chanid);
		// Now we really should scan the $Channel array and add a link to this program's channel
			foreach (array_keys($Channels) as $key) {
				if ($Channels[$key]->chanid == $this->chanid) {
					$this->channel = &$Channels[$key];
					break;
				}
			}
		}

	// Calculate the duration
		$this->length = $this->endtime - $this->starttime;

	// Find out which css category this program falls into
		if ($this->chanid != "")
			$this->category_class();

	}

	function record_always() {
	// Wipe out any pre-existing settings for this program
		$this->record_never(false);
	// Insert this recording choice into the database
		$result = mysql_query('REPLACE INTO record (type ,title, profile,recpriority,dupin,dupmethod,maxnewest,maxepisodes,autoexpire,startoffset,endoffset)
																			VALUES (4,'.escape($this->title).','
																				.escape($this->profile).','
																				.escape($this->recpriority).','
																				.escape($this->dupin).','
																				.escape($this->dupmethod).','
																				.escape($this->maxnewest).','
																				.escape($this->maxepisodes).','
																				.escape($this->autoexpire).','
																				.escape($this->startoffset).','
																				.escape($this->endoffset).')')
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
	// Clean up the program variable
		$this->record_always = $this->will_record = true;
	// Notify the backend of the changes
		backend_notify_changes();
	}

	function record_findone() {
	// Wipe out any pre-existing settings for this program
		$this->record_never(false);
	// Insert this recording choice into the database
		$result = mysql_query('REPLACE INTO record (type ,title, profile,recpriority,dupin,dupmethod,maxnewest,maxepisodes,autoexpire)
																			VALUES (6,'.escape($this->title).','
																				.escape($this->profile).','
																				.escape($this->recpriority).','
																				.escape($this->dupin).','
																				.escape($this->dupmethod).','
																				.escape($this->maxnewest).','
																				.escape($this->maxepisodes).','
																				.escape($this->autoexpire).')')
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
	// Clean up the program variable
		$this->record_findone = $this->will_record = true;
	// Notify the backend of the changes
		backend_notify_changes();
	}

	function record_channel() {
	// Wipe out any pre-existing settings for this program
		$this->record_never(false);
	// Insert this recording choice into the database
		$result = mysql_query('REPLACE INTO record (type,title,chanid,profile,recpriority,dupin,dupmethod,maxnewest,maxepisodes,autoexpire,startoffset,endoffset)
																		VALUES (3,'.escape($this->title).','
																				.escape($this->chanid).','
																				.escape($this->profile).','
																				.escape($this->recpriority).','
																				.escape($this->dupin).','
																				.escape($this->dupmethod).','
																				.escape($this->maxnewest).','
																				.escape($this->maxepisodes).','
																				.escape($this->autoexpire).','
																				.escape($this->startoffset).','
																				.escape($this->endoffset).')')
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
	// Clean up the program variable
		$this->record_channel = $this->will_record = true;
	// Notify the backend of the changes
		backend_notify_changes();
	}

	function record_weekly() {
	// Wipe out any pre-existing settings for this program
		$this->record_never(false);
	// Insert this recording choice into the database
		$result = mysql_query('REPLACE INTO record (type,chanid,startdate,starttime,enddate,endtime,title,profile,recpriority,dupin,dupmethod,maxnewest,maxepisodes,autoexpire,startoffset,endoffset)
							VALUES (5,'	.escape($this->chanid) .','
								.'FROM_UNIXTIME('.escape($this->starttime).'),'
								.'FROM_UNIXTIME('.escape($this->starttime).'),'
								.'FROM_UNIXTIME('.escape($this->endtime).'),'
								.'FROM_UNIXTIME('.escape($this->endtime).'),'
								.escape($this->title)  .','
								.escape($this->profile).','
								.escape($this->recpriority).','
								.escape($this->dupin).','
								.escape($this->dupmethod).','
								.escape($this->maxnewest).','
								.escape($this->maxepisodes).','
								.escape($this->autoexpire).','
								.escape($this->startoffset).','
								.escape($this->endoffset).')')
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
	// Clean up the program variable
		$this->record_weekly = $this->will_record = true;
	// Notify the backend of the changes
		backend_notify_changes();
	}

	function record_daily() {
	// Wipe out any pre-existing settings for this program
		$this->record_never(false);
	// Insert this recording choice into the database
		$result = mysql_query('REPLACE INTO record (type,chanid,starttime,startdate,endtime,enddate,title,profile,recpriority,dupin,dupmethod,maxnewest,maxepisodes,autoexpire,startoffset,endoffset) VALUES (2,'
								.escape($this->chanid).','
								.'FROM_UNIXTIME('.escape($this->starttime).'),'
								.'FROM_UNIXTIME('.escape($this->starttime).'),'
								.'FROM_UNIXTIME('.escape($this->endtime).'),'
								.'FROM_UNIXTIME('.escape($this->endtime).'),'
								.escape($this->title)  .','
								.escape($this->profile).','
								.escape($this->recpriority).','
								.escape($this->dupin).','
								.escape($this->dupmethod).','
								.escape($this->maxnewest).','
								.escape($this->maxepisodes).','
								.escape($this->autoexpire).','
								.escape($this->startoffset).','
								.escape($this->endoffset).')')
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
	// Clean up the program variable
		$this->record_daily = $this->will_record = true;
	// Notify the backend of the changes
		backend_notify_changes();
	}

	function record_once() {
	// Wipe out any pre-existing settings for this program
		$this->record_never(false);
	// Insert this recording choice into the database
		$result = mysql_query('REPLACE INTO record (type,chanid,starttime,startdate,endtime,enddate,title,subtitle,description,profile,recpriority,dupin,dupmethod,maxnewest,maxepisodes,autoexpire,startoffset,endoffset) values (1,'
								.escape($this->chanid).','
								.'FROM_UNIXTIME('.escape($this->starttime).'),'
								.'FROM_UNIXTIME('.escape($this->starttime).'),'
								.'FROM_UNIXTIME('.escape($this->endtime).'),'
								.'FROM_UNIXTIME('.escape($this->endtime).'),'
								.escape($this->title).','
								.escape($this->subtitle).','
								.escape($this->description).','
								.escape($this->profile).','
								.escape($this->recpriority).','
								.escape($this->dupin).','
								.escape($this->dupmethod).','
								.escape($this->maxnewest).','
								.escape($this->maxepisodes).','
								.escape($this->autoexpire).','
								.escape($this->startoffset).','
								.escape($this->endoffset).')')
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
	// Clean up the program variable
		$this->record_once = $this->will_record = true;
	// Notify the backend of the changes
		backend_notify_changes();
	}

	function record_never($notify = true) {
	// Already set?  just return
		if ($notify && !$this->will_record)
			return;
	// Wipe out any pre-existing settings for this program
		$result = mysql_query('DELETE FROM record WHERE (type=1 AND chanid='.escape($this->chanid).' AND title='.escape($this->title).' AND starttime=FROM_UNIXTIME('.escape($this->starttime).') AND startdate=FROM_UNIXTIME('.escape($this->starttime).'))'
												  .' OR (type=2 AND chanid='.escape($this->chanid).' AND title='.escape($this->title).' AND starttime=FROM_UNIXTIME('.escape($this->starttime).'))'
												  .' OR (type=3 AND chanid='.escape($this->chanid).' AND title='.escape($this->title).')'
												  .' OR (type=4 AND title='.escape($this->title).')'
												  .' OR (type=6 AND title='.escape($this->title).')'
												  .' OR (type=5 AND chanid='.escape($this->chanid).' AND title='.escape($this->title).' AND starttime=FROM_UNIXTIME('.escape($this->starttime).') AND DAYOFWEEK(startdate)='.escape(date('w', $this->starttime)+1).')');
	// Clean up the program variable
		$this->will_record    = false;
		$this->record_always  = false;
		$this->record_channel = false;
		$this->record_once    = false;
		$this->record_daily   = false;
		$this->record_weekly  = false;
	// Notify the backend of the changes
		if ($notify)
			backend_notify_changes();
	}

	function category_class() {
		$this->class = '';
	// Recording classes?
		if ($this->will_record) {
			if ($this->recstatus == 'WillRecord')
				$this->class .= 'will_record ';
			elseif ($this->recstatus == 'Conflict' || $this->recstatus == 'Overlap')
				$this->class .= 'record_conflicting ';
			elseif ($this->recstatus == 'PreviousRecording' || $this->recstatus == 'CurrentRecording')
				$this->class .= 'record_duplicate ';
			else
				$this->class .= 'record_suppressed ';
		}
	// Category type?
		if ($this->category_type && !preg_match('/unknown/i', $this->category_type))
			$this->class .= 'type_'.preg_replace("/[^a-zA-Z0-9\-_]+/", '_', $this->category_type).' ';
	// Category cache
		$category = strtolower($this->category);	// user lowercase to avoid a little overhead later
		static $cache = array();
		if ($cache[$category])
			$this->class .= $cache[$category];
	// Now comes the hard part
		elseif (preg_match('/'._LANG_CATMATCH_ACTION.'/', $category))
			$this->class .= $cache[$category] = 'cat_Action';
		elseif (preg_match('/'._LANG_CATMATCH_ADULT.'/', $category))
			$this->class .= $cache[$category] = 'cat_Adult';
		elseif (preg_match('/'._LANG_CATMATCH_ANIMALS.'/', $category))
			$this->class .= $cache[$category] = 'cat_Animals';
		elseif (preg_match('/'._LANG_CATMATCH_ART_MUSIC.'/', $category))
			$this->class .= $cache[$category] = 'cat_Art_Music';
		elseif (preg_match('/'._LANG_CATMATCH_BISINESS.'/', $category))
			$this->class .= $cache[$category] = 'cat_Business';
		elseif (preg_match('/'._LANG_CATMATCH_CHILDREN.'/', $category))
			$this->class .= $cache[$category] = 'cat_Children';
		elseif (preg_match('/'._LANG_CATMATCH_COMEDY.'/', $category))
			$this->class .= $cache[$category] = 'cat_Comedy';
		elseif (preg_match('/'._LANG_CATMATCH_CRIME_MYSTERY.'/', $category))
			$this->class .= $cache[$category] = 'cat_Crime_Mystery';
		elseif (preg_match('/'._LANG_DOCUMENTARY.'/', $category))
			$this->class .= $cache[$category] = 'cat_Documentary';
		elseif (preg_match('/'._LANG_DRAMA.'/', $category))
			$this->class .= $cache[$category] = 'cat_Drama';
		elseif (preg_match('/'._LANG_CATMATCH_EDUCATIONAL.'/', $category))
			$this->class .= $cache[$category] = 'cat_Educational';
		elseif (preg_match('/'._LANG_CATMATCH_FOOD.'/', $category))
			$this->class .= $cache[$category] = 'cat_Food';
		elseif (preg_match('/'._LANG_CATMATCH_GAME.'/', $category))
			$this->class .= $cache[$category] = 'cat_Game';
		elseif (preg_match('/'._LANG_CATMATCH_HEALTH_MEDICAL.'/', $category))
			$this->class .= $cache[$category] = 'cat_Health_Medical';
		elseif (preg_match('/'._LANG_CATMATCH_HISTORY.'/', $category))
			$this->class .= $cache[$category] = 'cat_History';
		elseif (preg_match('/'._LANG_HOWTO.'/', $category))
			$this->class .= $cache[$category] = 'cat_HowTo';
		elseif (preg_match('/'._LANG_HORROR.'/', $category))
			$this->class .= $cache[$category] = 'cat_Horror';
		elseif (preg_match('/'._LANG_CATMATCH_MISC.'/', $category))
			$this->class .= $cache[$category] = 'cat_Misc';
		elseif (preg_match('/'._LANG_CATMATCH_NEWS.'/', $category))
			$this->class .= $cache[$category] = 'cat_News';
		elseif (preg_match('/'._LANG_CATMATCH_REALITY.'/', $category))
			$this->class .= $cache[$category] = 'cat_Reality';
		elseif (preg_match('/'._LANG_CATMATCH_ROMANCE.'/', $category))
			$this->class .= $cache[$category] = 'cat_Romance';
		elseif (preg_match('/'._LANG_CATMATCH_SCIENCE_NATURE.'/', $category))
			$this->class .= $cache[$category] = 'cat_SciFi_Fantasy';
		elseif (preg_match('/'._LANG_CATMATCH_SCIENCE_NATURE.'/', $category))
			$this->class .= $cache[$category] = 'cat_Science_Nature';
		elseif (preg_match('/'._LANG_CATMATCH_SHOPPING.'/', $category))
			$this->class .= $cache[$category] = 'cat_Shopping';
		elseif (preg_match('/'._LANG_CATMATCH_SOAPS.'/', $category))
			$this->class .= $cache[$category] = 'cat_Soaps';
		elseif (preg_match('/'._LANG_CATMATCH_SPIRITUAL.'/', $category))
			$this->class .= $cache[$category] = 'cat_Spiritual';
		elseif (preg_match('/'._LANG_CATMATCH_SPORTS.'/', $category))
			$this->class .= $cache[$category] = 'cat_Sports';
		elseif (preg_match('/'._LANG_CATMATCH_TALK.'/', $category))
			$this->class .= $cache[$category] = 'cat_Talk';
		elseif (preg_match('/'._LANG_CATMATCH_TRAVEL.'/', $category))
			$this->class .= $cache[$category] = 'cat_Travel';
		elseif (preg_match('/'._LANG_WAR.'/', $category))
			$this->class .= $cache[$category] = 'cat_War';
		elseif (preg_match('/'._LANG_WESTERN.'/', $category))
			$this->class .= $cache[$category] = 'cat_Western';
		else
			$this->class .= $cache[$category] = 'cat_Unknown';
	}
}

?>
