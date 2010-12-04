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
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

    if (!isset($_SESSION['cache_engine']))
        $_SESSION['cache_engine'] = 'Cache_Null';

// Force a null engine for now
    $_SESSION['cache_engine'] = 'Cache_Null';

// Do we encode passwords
    if (!isset($_SESSION['stream']['include_user_and_password']))
        $_SESSION['stream']['include_user_and_password'] = false;

// Prefer channum over callsign?
    if (empty($_SESSION['prefer_channum']))
        $_SESSION['prefer_channum'] = setting('WebPrefer_Channum');
    define('prefer_channum', $_SESSION['prefer_channum']);

// Show pixmaps on the recorded programs page?
    if (!isset($_SESSION['recorded_pixmaps']))
         $_SESSION['recorded_pixmaps'] = (tmpl == 'default') ? true : false;

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

if (!isset($_SESSION['recorded_paging']))
    $_SESSION['recorded_paging'] = null;

if (!isset($_SESSION['genre_colors']))
    $_SESSION['genre_colors'] = 1;

// The following constants are defined for the videos page

if (!isset($_SESSION['show_video_covers']))
    $_SESSION['show_video_covers'] = 1;

// Screens
    if (!is_array($_SESSION['settings']['screens']['tv']['upcoming recordings']))
        $_SESSION['settings']['screens']['tv']['upcoming recordings']   = array('title' => 'on', 'channel' => 'on', 'record date' => 'on', 'length' => 'on');
