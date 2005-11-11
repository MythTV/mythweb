<?php
/*
 *  $Date$
 *  $Revision$
 *  $Author$
 *
 *  conf.php
 *
 *    Global configuration for MythWeb.
 *
 *    All end-user customizations (should?) happen here
 *    Most of this should really by in a MySQL table with
 *    a php interface to change it (someday...)
/*/

// The domain of this webserver, for cookie validation and other things.  This
//  *should* work automatically as-is, but if cookies don't work, you may need
//  to manually set this to the full domain name of this server.
//
//    eg.  define('server_domain', 'example.com')
//
    define('server_domain', $_SERVER['SERVER_NAME'] ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST']);

// Email address to which php and database errors are mailed to.
//
//    eg. define('error_email', 'mythweb_errors@example.com');
//
//    Or the match below will send mail to your server, such that if your box is
//    defined as mythtv.mydomain.com in server_domain above, mail will go to
//    mythweb_errors@mydomain.com.
//
    define('error_email', 'mythweb_errors@'.preg_replace('/.*?\b([\w\-]+\.[\w\-]+)$/', '$1', server_domain));

// For the "movies" search -- set this to the word your listings provider uses to
//   describe movies/films/peliculas/etc.
    define('movie_word', 'movie');

/*
 *  You probably don't need to edit anything below here, but the variables are
 *  provided for your convenience.
/*/

// The hostname of this machine -- so you can override manually as needed
    define('hostname', chop(`/bin/hostname`));

// file system encoding, uses music and video file link to local file
    define('fs_encoding', 'ISO-8859-1');

// Path to the image cache directory
    define('image_cache', 'cache');

// Local (web-friendly) path to the mythtv video dir (use a symlink to the real one - one will be auto-created if it can be)
    define('video_dir', 'video_dir');

// Type of url for the links to mythmusic files. Filename will be added to the end.
// For this to work, create a 'music' symlink in mythweb which points to the path for mythmusic files.
    define('music_url', 'music');

// Path to the mythvideo "covers" directory
    define('video_img_path', '');

// Where in the local filesystem are the mythvideo files stored
    define('mythvideo_dir', '/pub/video');

// URL path to the mythvideo files directory (most likely a symlink to mythvideo_dir)
    define('mythvideo_url', 'mythvideo');

// video_url is normally determined automatically (a local link to video_dir for
//   Linux/MacOS, and a myth:// URL for windows machines), but you can override
//   it here to something else if you really need to.
#   define('video_url', video_dir);
#   define('video_url', 'file://machine_name/path_to_videos');
#   define('video_url', 'myth://slave_backend_ip:6543');


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

