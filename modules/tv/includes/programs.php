<?php
/**
 * This contains variables and functions related to the Program class
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Load the Program object
    require_once 'includes/objects/Program.php';

// Make sure the "Channels" class gets loaded   (yes, I know this is recursive, but require_once will handle things nicely)
    require_once 'includes/channels.php';

// Reasons a recording wouldn't be happening (from libs/libmythtv/programinfo.h)
    $RecStatus_Types = array(
                              '-8' => 'TunerBusy',
                              '-7' => 'LowDiskSpace',
                              '-6' => 'Cancelled',
                              '-5' => 'Deleted',
                              '-4' => 'Aborted',
                              '-3' => 'Recorded',
                              '-2' => 'Recording',
                              '-1' => 'WillRecord',
                                0  => 'Unknown',
                                1  => 'DontRecord',
                                2  => 'PreviousRecording',
                                3  => 'CurrentRecording',
                                4  => 'EarlierShowing',
                                5  => 'TooManyRecordings',
                                6  => 'NotListed',
                                7  => 'Conflict',
                                8  => 'LaterShowing',
                                9  => 'Repeat',
                                10 => 'Inactive',
                                11 => 'NeverRecord'
                            );

    $RecStatus_Reasons = array(
                               'TunerBusy'          => t('recstatus: tunerbusy'),
                               'LowDiskSpace'       => t('recstatus: lowdiskspace'),
                               'Cancelled'          => t('recstatus: cancelled'),
                               'Deleted'            => t('recstatus: deleted'),
                               'Aborted'            => t('recstatus: stopped'),
                               'Recorded'           => t('recstatus: recorded'),
                               'Recording'          => t('recstatus: recording'),
                               'WillRecord'         => t('recstatus: willrecord'),
                               'Unknown'            => t('recstatus: unknown'),
                               'DontRecord'         => t('recstatus: manualoverride'),
                               'PreviousRecording'  => t('recstatus: previousrecording'),
                               'CurrentRecording'   => t('recstatus: currentrecording'),
                               'EarlierShowing'     => t('recstatus: earliershowing'),
                               'TooManyRecordings'  => t('recstatus: toomanyrecordings'),
                               'NotListed'          => t('recstatus: notlisted'),
                               'Conflict'           => t('recstatus: conflict'),
                               'Repeat'             => t('recstatus: repeat'),
                               'LaterShowing'       => t('recstatus: latershowing'),
                               'Inactive'           => t('recstatus: inactive'),
                               'NeverRecord'        => t('recstatus: neverrecord'),
                            // A special category for mythweb, since this feature doesn't exist in the backend
                               'ForceRecord'        => t('recstatus: force_record'),
                              );

/**
 * a shortcut to load_all_program_data's single-program query
/**/
    function &load_one_program($start_time, $chanid, $manualid) {
        if ($manualid)
            $program =& load_all_program_data($start_time, $start_time, $chanid, true, 'program.manualid='.intval($manualid));
        else
            $program =& load_all_program_data($start_time, $start_time, $chanid, true);
        if (!is_object($program) || strcasecmp(get_class($program), 'program'))
            return NULL;
        return $program;
    }

/**
 * loads all program data for the specified time range into the $Channels array.
 * Set $single_program to true if you only want information about programs that
 * start exactly at $start_time (used by program_detail.php)
/**/
    function &load_all_program_data($start_time, $end_time, $chanid = false, $single_program = false, $extra_query = '') {
        global $Channels, $db;
    // Make a local hash of channel chanid's with references to the actual
    // channel data (Channels are not indexed by anything in particular, so
    // that the user can sort by chanid or channum).
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
            $channel_hash[$Channels[$key]->chanid] =& $Channels[$key];
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
    // Build the sql query, and execute it
        $query = 'SELECT program.*,
                         UNIX_TIMESTAMP(program.starttime) AS starttime_unix,
                         UNIX_TIMESTAMP(program.endtime) AS endtime_unix,
                         IFNULL(programrating.system, "") AS rater,
                         IFNULL(programrating.rating, "") AS rating,
                         channel.callsign,
                         channel.channum
                  FROM program
                       LEFT JOIN programrating USING (chanid, starttime)
                       LEFT JOIN channel ON program.chanid = channel.chanid
                 WHERE';
    // Only loading a single channel worth of information
        if ($chanid > 0)
            $query .= ' program.chanid='.$db->escape($chanid);
    // Loading a group of channels (probably all of them)
        else
            $query .= ' program.chanid IN ('.$these_channels.')';
    // Requested start time is the same as the end time - don't bother with fancy calculations
        if ($start_time == $end_time)
            $query .= ' AND program.starttime = FROM_UNIXTIME('.$db->escape($start_time).')';
    // We're looking at a time range
        else
            $query .= ' AND (program.endtime > FROM_UNIXTIME(' .$db->escape($start_time).')'
                     .' AND program.starttime < FROM_UNIXTIME('.$db->escape($end_time)  .')'
                     .' AND program.starttime != program.endtime)';
    // The extra query, if there is one
        if ($extra_query)
            $query .= ' AND '.$extra_query;
    // Group and sort
        $query .= "\nGROUP BY program.chanid, program.starttime, channel.callsign ORDER BY program.starttime";
    // Limit
        if ($single_program)
            $query .= "\n LIMIT 1";
    // Query
        $sh = $db->query($query);
    // No results
        if ($sh->num_rows() < 1) {
            $sh->finish();
            return NULL;
        }
    // Build two separate queries for optimized selecting of recstatus
        $sh2 = $db->prepare('SELECT recstatus
                               FROM oldrecorded
                              WHERE recstatus IN (-3, 11)
                                    AND programid = ?
                                    AND seriesid  = ?
                             LIMIT 1');
        $sh3 = $db->prepare('SELECT recstatus
                               FROM oldrecorded
                              WHERE recstatus IN (-3, 11)
                                    AND title       = ?
                                    AND subtitle    = ?
                                    AND description = ?
                             LIMIT 1');
    // Load in all of the programs (if any?)
        global $Scheduled_Recordings;
        $these_programs = array();
        while ($data = $sh->fetch_assoc()) {
            if (!$data['chanid'])
                continue;
        // This program has already been loaded, and is attached to a recording schedule
            if (!empty($data['title']) && $Scheduled_Recordings[$data['callsign']][$data['starttime_unix']][0]->title == $data['title']) {
                $program =& $Scheduled_Recordings[$data['callsign']][$data['starttime_unix']][0];
            // merge in data fetched from DB
                $program->merge(new Program($data));
            }
        // Otherwise, create a new instance of the program
            else {
            // Load the recstatus now that we can use an index
                if ($data['programid'] && $data['seriesid']) {
                   $sh2->execute($data['programid'], $data['seriesid']);
                   list($data['recstatus']) = $sh2->fetch_row();
                }
                elseif ($data['category_type'] == 'movie' || ($data['title'] && $data['subtitle'] && $data['description'])) {
                   $sh3->execute($data['title'], $data['subtitle'], $data['description']);
                   list($data['recstatus']) = $sh3->fetch_row();
                }
            // Create a new instance
                $program =& new Program($data);
            }
        // Add this program to the channel hash, etc.
            $these_programs[]                          =& $program;
            $channel_hash[$data['chanid']]->programs[] =& $program;
        // Cleanup
            unset($program);
        }
    // Cleanup
        $sh3->finish();
        $sh2->finish();
        $sh->finish();
    // If channel-specific information was requested, return an array of those programs, or just the first/only one
        if ($chanid && $single_program)
            return $these_programs[0];
    // Just in case, return an array of all programs found
        return $these_programs;
    }



