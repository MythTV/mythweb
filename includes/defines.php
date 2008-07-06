<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
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

// Figure out the root path for this mythweb installation.  We need this in order
// to cleanly reference things like the /js directory from subpaths.
    define('root', str_replace('//', '/', dirname($_SERVER['SCRIPT_NAME']).'/'));

// Several sections of this program require the current hostname
    $uname = posix_uname();
    define('hostname', empty($_SERVER['hostname']) ? trim($uname['nodename']) : $_SERVER['hostname']);
    unset($uname);

// Define the error email, or set it to a null string if there isn't a valid one
    define('error_email', array_key_exists('error_email', $_SERVER) && strstr($_SERVER['error_email'], '@')
                          ? $_SERVER['error_email']
                          : '');

/**
 * $Path is an array of PATH_INFO passed into the script via mod_rewrite or some
 * other lesser means.  It contains most of the information required for
 * figuring out what functions the user wants to access.
 *
 * @global  array   $GLOBALS['Path']
 * @name    $Path
/**/
    $Path = explode('/', preg_replace('/^\/+/',   '',    // Remove leading slashes
                         preg_replace('/[\s]+/', ' ',    // Convert extra whitespace
                                                         // Grab the path info from various different places.
                             array_key_exists('PATH_INFO', $_SERVER)
                             && $_SERVER['PATH_INFO']
                                ? $_SERVER['PATH_INFO']
                                : (array_key_exists('PATH_INFO', $_ENV)
                                   && $_ENV['PATH_INFO']
                                    ? $_ENV['PATH_INFO']
                                    : (array_key_exists('PATH_INFO', $_GET)
                                       ? $_GET['PATH_INFO']
                                       : ''
                                      )
                                  )
                         ))
                   );

// Handy reference to the current module
    if ($Path[0] != 'rss')
        define('module', $Path[0]);
    else
        define('module', $Path[1]);

// Find the modules path
    $path = dirname(dirname(find_in_path('modules/tv/init.php')));
    if ($path == '')
       $path = dirname(find_in_path('modules/welcome.php'));
    define('modules_path', $path);

// Set up some constants used by nice_filesystem()
    define('kb', 1024);         // Kilobyte
    define('mb', 1024 * kb);    // Megabyte
    define('gb', 1024 * mb);    // Gigabyte
    define('tb', 1024 * gb);    // Terabyte

// Define the http host used for access

    define('http_host', isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']);

    define('root_url', ($_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://' ).http_host.':'.$_SERVER['SERVER_PORT'].root);
