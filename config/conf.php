<?

	//
	//	This file is part of MythWeb,
	//	a php-based interface into MythTV.
	//
	//	(c) 2002 by Thor Sigvaldason and Isaac Richards
	//	MythWeb is distributed under the
	//	GNU GENERAL PUBLIC LICENSE version 2
	//	(see http://www.gnu.org)
	//


//
//	All end-user customizations (should?) happen here
//	All of this should really by in a MySQL table with
//	a php interface to change it (someday...)
//


	//
	//	How to access the database
	//

	define('db_host',     'localhost');
	define('db_username', 'mythtv');
	define('db_password', 'mythtv');
	define('db_dbname',   'mythconverg');

// The domain of this webserver, for cookie validation and other things
	define('server_domain', $_SERVER['SERVER_NAME'] ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST']);

// Email address to which php and database errors are mailed to
    define('Error_Email', 'php_errors@'.server_domain);

// Date and time format used in menustrip
    define('longdate_format', "D, M d, g:i A");

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
	define('num_time_slots', 12);

// the size of timeslots, in seconds (1800 = 30 minutes)
	define('timeslot_size', 900);

// How many channels to skip between re-showing the timeslot bar
	define('timeslotbar_skip', 15);

// Display controls for movie "star" ratings
	define('max_stars', 4);					// maximum star rating for movies
	define('star_character', '&diams;');	// the character(s) to represent stars with

/*

	The following constants are defined for the recorded programs page

*/
	define('show_recorded_pixmaps', true);

// Locan and web paths to the pixmap image cache
	define('pixmap_local_path', 'image_cache');
	define('pixmap_web_path', '/image_cache');

// Height and width of generated pixmaps (for now, these are fixed - please do not change these numbers)
	define('pixmap_width',  160);
	define('pixmap_height', 120);

?>
