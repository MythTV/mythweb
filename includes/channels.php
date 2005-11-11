<?php
/***                                                                        ***\
    channels.php                             Last Updated: 2005.02.28 (xris)

    This file is part of MythWeb, a php-based interface for MythTV.
    See README and LICENSE for details.

    The Channel object, and a couple of related subroutines.
\***                                                                        ***/

// Make sure the "Programs" class gets loaded   (yes, I know this is recursive, but require_once will handle things nicely)
    require_once 'includes/programs.php';

// Initialize the global channels array
    global $Channels;
    $Channels = array();

/*
    load_all_channels:
    Loads all of the channels into channel objects, AND returns the global array $Channels
*/
    function load_all_channels() {
        global $Channels;
        $Channels = array();
        if ($_SESSION['guide_favonly'])
            $sql = "SELECT channel.* FROM channel, favorites WHERE channel.chanid = favorites.chanid";
        else
            $sql = "SELECT * FROM channel";
    // Group and sort
        $sql .= ' GROUP BY channum, callsign ORDER BY '
                .(prefer_channum ? '' : 'callsign, ')
                .'(channum + 0), chanid';
    // Query
        $result = mysql_query($sql)
            or trigger_error('SQL Error: '.mysql_error(), FATAL);
        while ($channel_data = mysql_fetch_assoc($result))  {
            $Channels[$channel_data['chanid']] = new Channel($channel_data);
        }
        mysql_free_result($result);
    // No channels returned?
        if (empty($Channels)) {
            unset($_SESSION['guide_favonly']);
            trigger_error('No channels were detected.  '
                         .($_SESSION['guide_favonly']
                            ? 'The "favorites only" option has now been turned off, please reload this page to try again.'
                            : 'Are you sure that MythTV is properly configured?'),
                          FATAL);
        }
    }

/*
    load_one_channel:
    Loads the specified into a channel object, AND adds it to the global array $Channels
*/
    function &load_one_channel($chanid) {
        global $Channels;
        if (!is_array($Channels))
            $Channels = array();
        if (!isset($Channels[$chanid])) {
            $result = mysql_query('SELECT * FROM channel WHERE chanid='.escape($chanid))
                or trigger_error('SQL Error: '.mysql_error(), FATAL);
            $channel_data = mysql_fetch_assoc($result);
            mysql_free_result($result);
            if ($channel_data) {
                $Channels[$chanid] = new Channel($channel_data);
            }
            else
                $Channels[$chanid] = NULL;
        }
        return $Channels[$chanid];
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
    var $visible;
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
        $this->visible      = $channel_data['visible'];
        $this->icon         = "images/icons/" . basename($channel_data['icon']);
    // Try to copy over any missing channel icons
        if (!file_exists($this->icon))
            @copy($channel_data['icon'], $this->icon);
    }

/** @deprecated FIXME:  this routine should get split out on its own, accepting
 *                      $channel as a parameter, and put into modules/tv/list.php
 */
    function display_programs($start_time, $end_time) {
        global $Page;
    // Keep track of each program this routine handles (for unique id generation)
        static $program_id_counter;
        if (empty($program_id_counter))
            $program_id_counter = 0;
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
        // If there is a gap before the current program, put a NO DATA block in.
            if ($program_starts > $start_time) {
                $length = (($program_starts - $start_time) / timeslot_size);
                if ($length >= 0.5) {
                    $timeslots_used = ceil($length);
                    if (new_code)
                        require theme_dir.'/tv/list_cell_nodata.php';
                    else
                        $Page->print_nodata($timeslots_used);
                    $start_time += $timeslots_used * timeslot_size;
                    if ($timeslots_left < $timeslots_used)
                        $timeslots_used = $timeslots_left;
                    $timeslots_left -= $timeslots_used;
                }
            }
        // Calculate the number of time slots this program gets
            $length = (($program_ends - $program_starts) / timeslot_size);
            if ($length < .5) continue; // ignore shows that don't take up at least half a timeslot
            $timeslots_used = ceil($length);
        // Increment $start_time so we avoid putting tiny shows (ones smaller than a timeslot) into their own timeslot
            $start_time += $timeslots_used * timeslot_size;
        // Make sure this doesn't put us over
            if ($timeslots_left < $timeslots_used)
                $timeslots_used = $timeslots_left;
            $timeslots_left -= $timeslots_used;
            #if ($timeslots_left > 0)
            if (new_code)
                require theme_dir.'/tv/list_cell_program.php';
            else
                $Page->print_program(&$program, $timeslots_used, $start_time);
        // Cleanup is good
            unset($program);
        }
    // Uh oh, there are leftover timeslots - display a no data message
        if ($timeslots_left > 0) {
            $timeslots_left = $timeslots_used;
            if (new_code)
                require theme_dir.'/tv/list_cell_nodata.php';
            else
                $Page->print_nodata($timeslots_left);
        }
    }
}

