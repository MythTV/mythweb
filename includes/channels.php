<?
/***                                                                        ***\
	channels.php                             Last Updated: 2003.06.30 (xris)

	This file is part of MythWeb, a php-based interface for MythTV.
	See README and LICENSE for details.

	The Channel object, and a couple of related subroutines.
\***                                                                        ***/

// Make sure the "Programs" class gets loaded   (yes, I know this is recursive, but require_once will handle things nicely)
	require_once 'includes/programs.php';

/*
	load_all_channels:
	Loads all of the channels into channel objects, AND returns the global array $Channels
*/
	function load_all_channels() {
		global $Channels;
		$Channels = array();
		$result = mysql_query('SELECT * FROM channel ORDER BY (channum + 0), chanid')
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
		while ($channel_data = mysql_fetch_assoc($result)) 	{
			$Channels[] = new Channel($channel_data);
		}
		mysql_free_result($result);
	}

/*
	load_one_channel:
	Loads the specified into a channel object, AND adds it to the global array $Channels
*/
	function &load_one_channel($chanid) {
		global $Channels;
		if (!is_array($Channels))
			$Channels = array();
		$result = mysql_query('SELECT * FROM channel WHERE chanid='.escape($chanid))
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
		$channel_data = mysql_fetch_assoc($result);
		$Channels[] = new Channel($channel_data);
		mysql_free_result($result);
		return $Channels[count($Channels)-1];
	}

/*
	Channel:
	A class to hold all channel-related data
*/
class Channel {
	var $chanid;
	var $channum;
	var $sourceid;
	var $callsign;
	var $name;
	var $finetune;
	var $videofilters;
	var $xmltvid;
	var $contrast;
	var $brightness;
	var $colour;
	var $programs = array();

	function Channel($channel_data) {
		$this->chanid       = $channel_data['chanid'];
		$this->channum      = $channel_data['channum'];
		$this->sourceid     = $channel_data['sourceid'];
		$this->callsign     = $channel_data['callsign'];
		$this->name         = $channel_data['name'];
		$this->finetune     = $channel_data['finetune'];
		$this->videofilters = $channel_data['videofilters'];
		$this->xmltvid      = $channel_data['xmltvid'];
		$this->contrast     = $channel_data['contrast'];
		$this->brightness   = $channel_data['brightness'];
		$this->colour       = $channel_data['colour'];
		$this->icon         = "images/icons/" . basename($channel_data['icon']);
	}

	function load_programs($start_time, $end_time) {
### this function is deprecated, and has been replaced by the single-query load_all_program_data in programs.php
	// Reinitialize the programs array
		$this->programs = array();
	// Find out if there are any recordings queued
		static $num_recordings = false;
		if ($num_recordings === false) {
			$result = mysql_query('SELECT count(*) FROM record')
				or trigger_error('SQL Error: '.mysql_error(), FATAL);
			list($num_recordings) = mysql_fetch_row($result);
			mysql_free_result($result);
		}
	// If there are recordings, we need to grab that info, too - if there aren't, the query info will interfere with the query
		if ($num_recordings > 0) {
			$record_table  = ', record';
			$record_values = ' SUM(record.type = 4 AND program.title = record.title) > 0 AS record_always, '
							.' SUM(record.type = 3 AND program.title = record.title AND record.chanid = program.chanid) > 0 AS record_channel, '
							.' SUM(record.type = 2 AND program.title = record.title AND record.chanid = program.chanid AND '
							.'     record.starttime = SEC_TO_TIME(TIME_TO_SEC(program.starttime)) AND '
							.'     record.endtime = SEC_TO_TIME(TIME_TO_SEC(program.endtime))) > 0 AS record_once, '
							.' SUM(record.type = 1 AND program.title = record.title AND record.chanid = program.chanid AND '
							.'     record.starttime = SEC_TO_TIME(TIME_TO_SEC(program.starttime)) AND '
							.'     record.startdate = FROM_DAYS(TO_DAYS(program.starttime))) > 0 AS record_timeslot,';
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
				 .' IFNULL(programrating.rating, \'\') AS rating,'
				 .' ((UNIX_TIMESTAMP(program.endtime) - UNIX_TIMESTAMP(program.starttime)) / 60 ) AS duration'
				 .' FROM program LEFT JOIN programrating USING (chanid, starttime)'
				 .$record_table
				 .' WHERE program.chanid='.escape($this->chanid)
				 .' AND (UNIX_TIMESTAMP(program.starttime) >= ' . escape($start_time)
					   .' AND UNIX_TIMESTAMP(program.starttime) <= '   . escape($end_time + round(timeslot_size/2))	# catch shows that start part way through the last timeslot
					 .' OR UNIX_TIMESTAMP(program.endtime) >= ' . escape($start_time - round(timeslot_size/2))		# catch shows that end part way through the first timeslot
					   .' AND UNIX_TIMESTAMP(program.endtime) <= '   . escape($end_time)
					 .' OR UNIX_TIMESTAMP(program.starttime) <= ' . escape($start_time)								# catch shows that start before and end after the requested times
					   .' AND UNIX_TIMESTAMP(program.endtime) >= '   . escape($end_time)
					 .')'
				 .' GROUP BY program.chanid, program.starttime ORDER BY program.starttime';
		$result = mysql_query($query)
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
	// Load in all of the programs (if any?)
		while ($program_data = mysql_fetch_assoc($result)) {
		// Add this as an object to the programs array
			$this->programs[] = new Program($program_data);
		}
	// Cleanup
		mysql_free_result($result);
	}

	function display_programs($start_time, $end_time) {
		global $Page;
	## we will eventually need to check for list vs "by channel" display
	#  for now, we only have the main list display
		$timeslots_left = num_time_slots;
		foreach (array_keys($this->programs) as $key) {
		// Leave early?  just in case
			if ($timeslots_left < 1)
				break;
		// Grab a reference
			$program = &$this->programs[$key];
		// Make sure this program happens within the specified timeslot
			if ($program->starttime >= $end_time || $program->endtime <= $start_time)
				continue;
		// Get a modified start/end time for this program (in case it starts/ends outside of the aloted time
			$program_starts = $program->starttime;
			$program_ends   = $program->endtime;
			if ($program->starttime < $start_time)
				$program_starts = $start_time;
			if ($program->endtime > $end_time)
				$program_ends = $end_time;
		// Make sure this program extends all the way through its timeslots
			if ($program->endtime > $program_ends + timeslot_size) {
				$program_ends += timeslot_size;
			}
			#$program->title .= date("g:i", $program_starts)." - ".date("g:i", $program_ends)."<BR>";
		// Calculate the number of time slots this program gets
			$timeslots_used = round(($program_ends - $program_starts) / timeslot_size);
		// We might need to add another timeslot
			#if ($program_ends < $program_starts + ($timeslots_used) * timeslot_size)
			#	$timeslots_used++;
		// Too short to fit into a timeslot - skip it
			if ($timeslots_used < 1)
				continue;
		// Increment $start_time so we avoid putting tiny shows (ones smaller than a timeslot) into their own timeslot
			$start_time += $timeslots_used * timeslot_size;
		// Make sure this doesn't put us over
			if ($timeslots_left < $timeslots_used)
				$timeslots_used = $timeslots_left;
			$timeslots_left -= $timeslots_used;
		#if ($timeslots_left > 0)
			$Page->print_program(&$program, $timeslots_used, $start_time);
		// Cleanup is good
			unset($program);
		}
	// Uh oh, there are leftover timeslots - display a no data message
		if ($timeslots_left > 0)
			$Page->print_nodata($timeslots_left);
	}
}

?>