<?
/***                                                                        ***\
	channels.php                             Last Updated: 2003.07.30 (xris)

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