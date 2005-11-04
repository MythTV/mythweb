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
    define('show_popup_info', true);

// show the channel icons?  true/false
    define('show_channel_icons', true);

// Prefer channum over callsign?
    define('prefer_channum', true);

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

    The following constants are defined for the recorded programs page

*/
    define('show_recorded_pixmaps', true);

// Height and width of generated pixmaps (for now, these are fixed - please do not change these numbers)
    define('pixmap_width',  160);
    define('pixmap_height', 120);

// height and width of generated pixmaps for video thumbnails
    define('video_img_width',  94);
    define('video_img_height', 140);

