<?php
/***                                                                        ***\
	conf.php                                  Last Updated: 2004.03.28 (xris)

	global configuration for mythweb
\***                                                                        ***/

//
//	All end-user customizations (should?) happen here
//	Most of this should really by in a MySQL table with
//	a php interface to change it (someday...)
//


//
//	How to access the database
//

	define('db_host',     'localhost');
	define('db_username', 'mythtv');
	define('db_password', 'mythtv');
	define('db_dbname',   'mythconverg');

// The domain of this webserver, for cookie validation and other things.  If you
// don't have "canonical names" turned on in apache, you need to set this to the
// name or IP you use to access this server, or session data will not work.
// Turning on "canonical names" in apache's httpd.conf is the preferred option.
	define('server_domain', $_SERVER['SERVER_NAME'] ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST']);

// Email address to which php and database errors are mailed to
    define('Error_Email', 'php_errors@'.server_domain);

// Path to the image cache directory
	define('image_cache', 'image_cache');

// Local (web-friendly) path to the mythtv video dir (use a symlink to the real one - one will be auto-created if it can be)
	define('video_dir', 'video_dir');

// Type of url for the links to recorded programs. Filename will be added at the end
	define('video_url', video_dir);		//Normal http url

	//Url for windows filters. This need to be changed if you use a different
	//port or the webserver is not running on the backend machine.
	//You may have to adjust the playback app in the filter configuration program.
	#define('video_url', 'myth://'.$_SERVER['HTTP_HOST'].':6543');
	#define('video_url', 'myth://ip_of_mythbackend:6543');

// Path to the mythvideo "covers" directory
	define('video_img_path', '');

// Movie word
	define('movie_word', 'Movie');

// Date formats
	define('generic_date', 'D, M j');
	define('generic_time', 'h:i A');

// Language
	define('default_language', 'English');

?>
