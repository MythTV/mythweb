<?php
/***                                                                        ***\
	conf.php                                  Last Updated: 2003.08.20 (xris)

	global configuration for mythweb
\***                                                                        ***/

//
//	All end-user customizations (should?) happen here
//	Most of this should really by in a MySQL table with
//	a php interface to change it (someday...)
//


	define('Theme', 'Default');

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


// Path to the image cache directory
	define('image_cache', 'image_cache');

// Path to the mythvideo "covers" directory
	define('video_img_path', '');

?>
