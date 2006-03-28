<?php
/**
 * Configuration/Session loading for MythWeb.
 *
 * This file also contains the default values for most config options.
 *
 * @todo Eventually, much of the stuff in this file should be split off into
 *       separate default-config files in each module, as well as the session
 *       editor settings that define them.  For now, this file will contain
 *       settings slowly moved from config/conf.php and related files.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Load/set default date formats
    if (!$_SESSION['date_statusbar'])       $_SESSION['date_statusbar']       = t('generic_date').', '.t('generic_time');
    if (!$_SESSION['date_scheduled'])       $_SESSION['date_scheduled']       = t('generic_date').' ('.t('generic_time').')';
    if (!$_SESSION['date_scheduled_popup']) $_SESSION['date_scheduled_popup'] = t('generic_date');
    if (!$_SESSION['date_recorded'])        $_SESSION['date_recorded']        = t('generic_date').'<br />('.t('generic_time').')';
    if (!$_SESSION['date_search'])          $_SESSION['date_search']          = t('generic_date').', '.t('generic_time');
    if (!$_SESSION['date_listing_key'])     $_SESSION['date_listing_key']     = t('generic_date').', '.t('generic_time');
    if (!$_SESSION['date_listing_jump'])    $_SESSION['date_listing_jump']    = t('generic_date');
    if (!$_SESSION['date_channel_jump'])    $_SESSION['date_channel_jump']    = t('generic_date');
    if (!$_SESSION['time_format'])          $_SESSION['time_format']          = t('generic_time');

// Show pixmaps on the recorded programs page?
    if (!isset($_SESSION['recorded_pixmaps'])) {
         $_SESSION['recorded_pixmaps'] = (tmpl == 'default') ? true : false;
    }
// height and width of generated pixmaps for recording thumbnails
    define('video_img_width',  94);
    define('video_img_height', 140);


###############################################################################
#######  Config below here has not yet been converted to session-configurable
###############################################################################

/*

    The following constants are used for the program listings page

*/

// Show mouseover information about programs?
    define('show_popup_info', true);

// show the channel icons?  true/false
    define('show_channel_icons', true);

// Prefer channum over callsign?
    define('prefer_channum', true);

// Sort channel list by channel nuber or by callsign?
    define('sortby_channum', true);

// The number of time slots to display in the channel listing
    define('num_time_slots', 36);

// How many timeslots to block together in headers and listing "now" rounds
    define('timeslot_blocks', 3);

// the size of timeslots, in seconds (1800 = 30 minutes)
    define('timeslot_size', 300);

// How many channels to skip between re-showing the timeslot bar
    define('timeslotbar_skip', 20);

// Display controls for movie "star" ratings
    define('max_stars', 4);                 // maximum star rating for movies
    define('star_character', '&diams;');    // the character(s) to represent stars with

/*

    The following constants are defined for the videos page

*/
    define('show_video_covers', true);


