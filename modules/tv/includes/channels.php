<?php
/**
 * The Channel object, and a couple of related subroutines.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythTV
 * @subpackage  TV
 *
/**/

// Load the channel objects
    require_once 'includes/objects/Channel.php';
    require_once 'includes/objects/Channel_List.php';

// Make sure the "Programs" class gets loaded   (yes, I know this is recursive, but require_once will handle things nicely)
    require_once 'includes/programs.php';

// Initialize the global channels array
    global $Channels;
    $Channels = array();

// Initialize the callsign hash
    global $Callsigns;
    $Callsigns = array();

/**
 * Loads all of the channels into channel objects, AND returns the global array $Channels
/**/
    function load_all_channels() {
        global $db;
        global $Channels;
        global $Callsigns;
        $Channels = array();
    // Initialize the query
        if ($_SESSION['guide_favonly'])
            $sql = 'SELECT channel.* FROM channel, favorites WHERE channel.chanid = favorites.chanid AND';
        else
            $sql = 'SELECT * FROM channel WHERE';
        $sql .= ' channel.visible=1';
        $sql .= ' GROUP BY channel.channum, channel.callsign';    
    // Sort
        $sql .= ' ORDER BY '
                .(sortby_channum ? '' : 'channel.callsign, ')
                .'(channel.channum + 0), channel.channum, channel.chanid';  // sort by channum as both int and string to grab subchannels
    // Query
        $sh = $db->query($sql);
        while ($channel_data = $sh->fetch_assoc())  {
            $Channels[$channel_data['chanid']] = new Channel($channel_data);
            if (empty($Callsigns[$channel_data['channum'].':'.$channel_data['callsign']]))
                $Callsigns[$channel_data['channum'].':'.$channel_data['callsign']] = $channel_data['chanid'];
        }
        $sh->finish();
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

/**
 * Loads the specified into a channel object, AND adds it to the global array $Channels
/**/
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


