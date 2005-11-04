<?php
/***                                                                        ***\
    confing/theme_compacy.php                Last Updated: 2003.08.19 (xris)

    configuration for the "compact" theme
\***                                                                        ***/

/*

    The following constants are used for the program listings page

*/

// Show mouseover information about programs?
    define('show_popup_info', true);

// Prefer channum over callsign?
    define('prefer_channum', true);

// The number of time slots to display in the channel listing
    define('num_time_slots', 6);

// the size of timeslots, in seconds (1800 = 30 minutes)
    define('timeslot_size', 1800);

// How many channels to skip between re-showing the timeslot bar
    define('timeslotbar_skip', 20);

// How many channels to show per page, 'All' to never break into multiple pages
    define('channels_per_page', 'All');

// Display controls for movie "star" ratings
    define('max_stars', 4);                 // maximum star rating for movies
    define('star_character', '&diams;');    // the character(s) to represent stars with

/*

    The following constants are defined for the recorded programs page

*/
    define('programs_per_page', 10); // 'All' to never break into multiple pages

    define('show_recorded_pixmaps', true);

// Height and width of generated pixmaps (for now, these are fixed - please do not change these numbers)
    define('pixmap_width',  160);
    define('pixmap_height', 120);

// height and width of generated pixmaps for video thumbnails
    define('video_img_width',  94);
    define('video_img_height', 140);

