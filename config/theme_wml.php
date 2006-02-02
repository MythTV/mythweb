<?php
/**
 * Configuration options for the MythWeb WML theme
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

/*

    The following constants are used for the program listings page

*/

// Show mouseover information about programs?
    define('theme_show_popup_info', false);

// show the channel icons?  true/false
    define('theme_show_channel_icons', false);

// Prefer channum over callsign?
    define('theme_prefer_channum', true);

// The number of time slots to display in the channel listing
    define('theme_num_time_slots', 1);

// How many timeslots to block together in headers and listing "now" rounds
    define('theme_timeslot_blocks', 3);

// the size of timeslots, in seconds (1800 = 30 minutes)
    define('theme_timeslot_size', 3600);

// Display controls for movie "star" ratings
    define('theme_max_stars', 4);                 // maximum star rating for movies
    define('theme_star_character', '&diams;');    // the character(s) to represent stars with

/*

    The following constants are defined for the recorded programs page

*/
    define('theme_show_recorded_pixmaps', false);

// height and width of generated pixmaps for video thumbnails
    define('theme_video_img_width',  94);
    define('theme_video_img_height', 140);

