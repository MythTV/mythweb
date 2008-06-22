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

// Prefer channum over callsign?
    if (empty($_SESSION['prefer_channum']))
        $_SESSION['prefer_channum'] = setting('WebPrefer_Channum');
    define('prefer_channum', $_SESSION['prefer_channum']);

// Load/set default date formats
    if (!$_SESSION['date_statusbar'])       $_SESSION['date_statusbar']       = t('generic_date').', '.t('generic_time');
    if (!$_SESSION['date_scheduled'])       $_SESSION['date_scheduled']       = t('generic_date').' ('.t('generic_time').')';
    if (!$_SESSION['date_scheduled_popup']) $_SESSION['date_scheduled_popup'] = t('generic_date');
    if (!$_SESSION['date_recorded'])        $_SESSION['date_recorded']        = t('generic_date').' ('.t('generic_time').')';
    if (!$_SESSION['date_search'])          $_SESSION['date_search']          = t('generic_date').', '.t('generic_time');
    if (!$_SESSION['date_listing_key'])     $_SESSION['date_listing_key']     = t('generic_date').', '.t('generic_time');
    if (!$_SESSION['date_listing_jump'])    $_SESSION['date_listing_jump']    = t('generic_date');
    if (!$_SESSION['date_channel_jump'])    $_SESSION['date_channel_jump']    = t('generic_date');
    if (!$_SESSION['date_job_status'])      $_SESSION['date_job_status']      = t('generic_date').', '.t('generic_time');
    if (!$_SESSION['time_format'])          $_SESSION['time_format']          = t('generic_time');

// Show pixmaps on the recorded programs page?
    if (!isset($_SESSION['recorded_pixmaps'])) {
         $_SESSION['recorded_pixmaps'] = (tmpl == 'default') ? true : false;
    }

// Guide settings
    if (!isset($_SESSION['guide_favonly']))
        $_SESSION['guide_favonly'] = false;

// The size of timeslots, in seconds (1800 = 30 minutes)
    if ($_SESSION['timeslot_size'] < 300) {
        switch (tmpl) {
            case 'wap': $_SESSION['timeslot_size'] = 900;  break;
            default:    $_SESSION['timeslot_size'] = 300;  break;
        }
    }
    define('timeslot_size', $_SESSION['timeslot_size']);

// The number of time slots to display in the channel listing
    if ($_SESSION['num_time_slots'] < 3) {
        switch (tmpl) {
            case 'wap': $_SESSION['num_time_slots'] = 12; break;
            default:    $_SESSION['num_time_slots'] = 36; break;
        }
    }
    define('num_time_slots', $_SESSION['num_time_slots']);

// How many timeslots to block together in headers and listing "now" rounds
    if ($_SESSION['timeslot_blocks'] < 1)
        $_SESSION['timeslot_blocks'] = 3;
    define('timeslot_blocks', $_SESSION['timeslot_blocks']);

// How many channels to skip between re-showing the timeslot bar
    if ($_SESSION['timeslotbar_skip'] < 5)
        $_SESSION['timeslotbar_skip'] = 20;
    define('timeslotbar_skip', $_SESSION['timeslotbar_skip']);

// maximum star rating for movies
    if ($_SESSION['max_stars'] < 3)
        $_SESSION['max_stars'] = 4;
    define('max_stars', $_SESSION['max_stars']);

// the character(s) to represent stars with
    if (empty($_SESSION['star_character']))
        $_SESSION['star_character'] = '&#9733;';
    define('star_character', $_SESSION['star_character']);

//  The following constants are used for the program listings page

if (!isset($_SESSION['show_popup_info']))
    $_SESSION['show_popup_info'] = 1;

if (!isset($_SESSION['show_channel_icons']))
    $_SESSION['show_channel_icons'] = 1;

if (!isset($_SESSION['sortby_channum']))
    $_SESSION['sortby_channum'] = 1;

// The following constants are defined for the videos page

if (!isset($_SESSION['show_video_covers']))
    $_SESSION['show_video_covers'] = 1;
