<?php
/**
 *
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

class Channel extends MythBase {
    private static $channel_list = null;
    private static $callsign_list = null;

    public $chanid;
    public $channum;
    public $freqid;
    public $sourceid;
    public $callsign;
    public $name;
    public $icon;
    public $finetune;
    public $videofilters;
    public $xmltvid;
    public $recpriority;
    public $contrast;
    public $brightness;
    public $colour;
    public $hue;
    public $tvformat;
    public $visible;
    public $outputfilters;
    public $useonairguide;
    public $mplexid;
    public $serviceid;
    public $tmoffset;
    public $atsc_major_chan;
    public $atsc_minor_chan;
    public $last_record;
    public $default_authority;
    public $commmethod;

    public $programs = array();

    public static function getChannelList($filtered=True) {
        if ($filtered)
            $channel_list = Cache::get('[filtered_channelList]');
        else
            $channel_list = Cache::get('[channelList]');
        if (is_null($channel_list)) {
            global $db;
            $sql = 'SELECT channel.chanid FROM channel';
            if ($_SESSION['guide_favonly']) {
                $sql .= ', channelgroup, channelgroupnames WHERE channel.chanid = channelgroup.chanid AND channelgroup.grpid = channelgroupnames.grpid AND channelgroupnames.name = \'Favorites\'';
                if ($filtered)
                    $sql .= ' AND channel.visible = 1';
            } elseif ($filtered) {
                $sql .= ' WHERE channel.visible = 1';
            }
            $sql .= ' GROUP BY channel.channum, channel.callsign';
        // Sort
            $sql .= ' ORDER BY '
                    .($_SESSION["sortby_channum"] ? '' : 'channel.callsign, ')
                    .'(channel.channum + 0), channel.channum, channel.chanid';  // sort by channum as both int and string to grab subchannels
        // Query
            $sh = $db->query($sql);
            $channel_list = array();
            while ($chanid = $sh->fetch_col())
                $channel_list[] = $chanid;
            Cache::set('[channelList]', $channel_list);
        }
        return $channel_list;
    }

    public static function getCallsignList() {
        $callsign_list = Cache::get('[callsignList]');
        if (is_null($callsign_list)) {
            global $db;
            $sql = 'SELECT channel.chanid, channel.channum, channel.callsign FROM channel';
            if ($_SESSION['guide_favonly'])
                $sql .= ', channelgroup, channelgroupnames WHERE channel.chanid = channelgroup.chanid AND channelgroup.grpid = channelgroupnames.grpid AND channelgroupnames.name = \'Favorites\' AND';
            else
                $sql .= ' WHERE';
            $sql .= ' channel.visible = 1';
            $sql .= ' GROUP BY channel.channum, channel.callsign';
        // Sort
            $sql .= ' ORDER BY '
                    .($_SESSION["sortby_channum"] ? '' : 'channel.callsign, ')
                    .'(channel.channum + 0), channel.channum, channel.chanid';  // sort by channum as both int and string to grab subchannels
        // Query
            $sh = $db->query($sql);
            $callsign_list = array();
            while ($channel_data = $sh->fetch_assoc())
                $callsign_list[$channel_data['channum'].':'.$channel_data['callsign']] = $channel_data['chanid'];
            Cache::set('[callsignList]', $callsign_list);
        }
        return $callsign_list;
    }

    /* public */
    function __construct($chanid) {
    // Are we loading up an invalid channel?
        if ($chanid == -1)
            return;

        global $db;
        $channel_data = $db->query_assoc('SELECT * FROM channel WHERE chanid = ?', $chanid);

        if (!isset($channel_data['chanid']) || $channel_data['chanid'] != $chanid)
            return;

        foreach ($channel_data AS $key => $value)
            $this->$key = $value;
        $this->icon = 'data/tv_icons/'.basename($channel_data['icon']);
    // Try to copy over any missing channel icons
        if ($channel_data['icon'] && !file_exists($this->icon)) {
        // Local file?
            if (file_exists($channel_data['icon']))
                @copy($channel_data['icon'], $this->icon);
        // Otherwise, grab it from the backend
            else {
            // Make the request and store the result
                $data = MythBackend::find()->httpRequest('Guide/GetChannelIcon', array('ChanId' => $this->chanid));
                if ($data)
                    file_put_contents($this->icon, $data);
                unset($data);
            }
        }
    // Wipe the icon path completely if it doesn't exist.
        if (!is_file($this->icon))
            $this->icon = null;
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
        if (defined('theme_num_time_slots')) {
            $timeslots_left = theme_num_time_slots;
            $timeslot_size = theme_timeslot_size;
        } else {
            $timeslots_left = num_time_slots;
            $timeslot_size = timeslot_size;
        }

        $programs = &load_all_program_data($start_time, $end_time, $this->chanid);
        foreach ($programs as &$program) {
        // Leave early?  just in case
            if ($timeslots_left < 1)
                break;
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
                $length = (($program_starts - $start_time) / $timeslot_size);
                if ($length >= 0.5) {
                    $timeslots_used = ceil($length);
                    require tmpl_dir.'list_cell_nodata.php';
                    $start_time += $timeslots_used * timeslot_size;
                    if ($timeslots_left < $timeslots_used)
                        $timeslots_used = $timeslots_left;
                    $timeslots_left -= $timeslots_used;
                }
            }
        // Calculate the number of time slots this program gets
            $length = (($program_ends - $program_starts) / $timeslot_size);
            if ($length < .5) continue; // ignore shows that don't take up at least half a timeslot
            $timeslots_used = ceil($length);
        // Increment $start_time so we avoid putting tiny shows (ones smaller than a timeslot) into their own timeslot
            $start_time += $timeslots_used * $timeslot_size;
        // Make sure this doesn't put us over
            if ($timeslots_left < $timeslots_used)
                $timeslots_used = $timeslots_left;
            $timeslots_left -= $timeslots_used;
            #if ($timeslots_left > 0)
            require tmpl_dir.'list_cell_program.php';
        // Cleanup is good
            unset($program);
        }
    // Uh oh, there are leftover timeslots - display a no data message
        if ($timeslots_left > 0) {
            $timeslots_left = $timeslots_used;
            require tmpl_dir.'list_cell_nodata.php';
        }
    }

}
