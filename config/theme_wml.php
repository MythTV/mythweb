<?php

    //
    //  This file is part of MythWeb,
    //  a php-based interface into MythTV.
    //
    //  (c) 2002 by Thor Sigvaldason and Isaac Richards
    //  MythWeb is distributed under the
    //  GNU GENERAL PUBLIC LICENSE version 2
    //  (see http://www.gnu.org)
    //

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

// Height and width of generated pixmaps (for now, these are fixed - please do not change these numbers)
    define('theme_pixmap_width',  160);
    define('theme_pixmap_height', 120);

// height and width of generated pixmaps for video thumbnails
    define('theme_video_img_width',  94);
    define('theme_video_img_height', 140);

