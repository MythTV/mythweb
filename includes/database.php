<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// No MySQL libraries installed in PHP
    if (!function_exists('mysql_connect')) {
        custom_error("Please install the MySQL libraries for PHP.\n"
                    .'The package is usually called something like php-mysql.');
    }

// Load the database connection routines
    require_once 'classes/Database.php';
    require_once 'classes/Database/mysql.php';
    require_once 'classes/Database/mysqlicompat.php';
    require_once 'classes/Database/Query.php';
    require_once 'classes/Database/Query/mysql.php';
    require_once 'classes/Database/Query/mysqlicompat.php';

/**
 * All database connections should now go through this object.
 *
 * @global  Database    $GLOBALS['db']
 * @name    $db
/**/
    global $db;

// Connect to the database
    if (!is_object($db)) {
        if (isset($_SERVER['db_name']) &&
            isset($_SERVER['db_login']) &&
            isset($_SERVER['db_password']) &&
            isset($_SERVER['db_server'])) {
            $db = Database::connect($_SERVER['db_name'],
                                    $_SERVER['db_login'],
                                    $_SERVER['db_password'],
                                    $_SERVER['db_server'],
                                    NULL, 'mysql');
        }
        else {
			if (!isset($_SESSION['upnp_db'])) {
				for ($i=0; $i<10; $i++) {
					$info = UPnP_Client::discoverDatabase();
					if ($info) {
						$_SESSION['upnp_db'] = $info;
						break;
					}
				}
			}
			
			if (!isset($_SESSION['upnp_db'])) {
				custom_error("UPnP Database Discovery failed!");
			}

			$db = Database::connect($_SESSION['upnp_db']['name'],
									$_SESSION['upnp_db']['user'],
									$_SESSION['upnp_db']['pass'],
									$_SESSION['upnp_db']['host'],
									NULL, 'mysql');
        }
		if (!is_object($db)) {
			custom_error("Database connection is not valid!");
		}

        $db->register_global_name('db');
    }

// Access denied -- probably means that there is no database
    if ($db->errno == 1045) {
        tailored_error('db_access_denied');
    }

// We don't need these security risks hanging around taking up memory.
    unset($_SERVER['db_name'],
          $_SERVER['db_login'],
          $_SERVER['db_password'],
          $_SERVER['db_server']);

//
//  If there was a database connection error, this will send an email to
//    the administrator, and then present the user with a static page
//    informing them of the trouble.
//
    if ($db->error) {
    // Notify the admin that the database is offline!
        if (strstr(error_email, '@'))
            mail(error_email, 'Database Connection Error' ,
                 $db->error,
                 'From:  MythWeb Error <'.error_email.">\n");
    // Let the user know in a nice way that something's wrong
        tailored_error('site_down');
    }
