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

// Figure out the root path for this mythweb installation.  We need this in order
// to cleanly reference things like the /js directory from subpaths.
    if (isset($_SERVER['ORIG_SCRIPT_NAME']) && !isset($_SERVER['FCGI_ROLE']))
        define('root', str_replace('//', '/', dirname($_SERVER['ORIG_SCRIPT_NAME']).'/'));
    else
        define('root', str_replace('//', '/', dirname($_SERVER['SCRIPT_NAME']).'/'));

// Several sections of this program require the current hostname
    if (!empty($_SERVER['hostname']))
        define('hostname', $_SERVER['hostname']);
    elseif (function_exists('posix_uname')) {
        $uname = posix_uname();
        define('hostname', trim($uname['nodename']));
    }
    elseif (function_exists('php_uname'))
        define('hostname', php_uname('n'));
    else
        throw new Exception('Failed to get server hostname!');

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
    $Path = '';

    if (isset($_SERVER['ORIG_PATH_INFO']) && !isset($_SERVER['FCGI_ROLE']))
        $Path = $_SERVER['ORIG_PATH_INFO'];
    elseif (isset($_SERVER['PATH_INFO']))
        $Path = $_SERVER['PATH_INFO'];
    elseif (isset($_ENV['PATH_INFO']))
        $Path = $_ENV['PATH_INFO'];
    elseif (isset($_GET['PATH_INFO']))
        $Path = $_GET['PATH_INFO'];

// Convert extra whitespace
    $Path = preg_replace('/[\s]+/', ' ', $Path);

// Remove leading slashes
    $Path = preg_replace('/^\/+/', '', $Path);

    $Path = explode('/', $Path);

// Find the modules path
    $paths = array(
        dirname(dirname(find_in_path('modules/tv/init.php'))),
        dirname(find_in_path('modules/welcome.php')),
        dirname(__FILE__).'/../modules/',
        );
    foreach ($paths as $path) {
        $path = realpath($path);
        if (!is_dir($path))
            continue;
        define('modules_path', $path);
        break;
    }

    if (!defined('modules_path'))
        trigger_error("modules_path is undefined!\nFile is ".__file__, FATAL);

// Handy reference to the current module
    foreach ($Path as $path) {
        if (is_dir(modules_path.'/'.$path)) {
            define('module', $path);
            break;
        }
    }

// Set up some constants used by nice_filesystem()
    define('kb', 1024);         // Kilobyte
    define('mb', 1024 * kb);    // Megabyte
    define('gb', 1024 * mb);    // Gigabyte
    define('tb', 1024 * gb);    // Terabyte

// Define the http host used for access

// Handle multiple http forwarded proxies by only using the first one in the list
    if(isset($_SERVER['HTTP_X_FORWARDED_HOST']))
        list($_SERVER['HTTP_X_FORWARDED_HOST']) = explode(',', $_SERVER['HTTP_X_FORWARDED_HOST']);

    define('http_host', isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']);

    $host = http_host;
    $port = $_SERVER['SERVER_PORT'];

    if (strpos(http_host, ':') !== false)
        list($host, $port) = explode(':', http_host);

    $_SERVER['HTTP_HOST'] = $host;
    $_SERVER['HTTP_PORT'] = $port;

    if ($_SERVER['HTTP_PORT'] == '443' || $_SERVER['HTTP_PORT'] == '8443' || $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
        $_SERVER['HTTPS'] = 'on';

    $root_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
    $root_auth_url = $root_url;

    if (isset($_SERVER['PHP_AUTH_PW']))
        $_SERVER['PHP_AUTH_PW'] = urlencode($_SERVER['PHP_AUTH_PW']);

    if (!ini_get('safe_mode') && isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
        $root_auth_url .= $_SERVER['PHP_AUTH_USER'].':'.$_SERVER['PHP_AUTH_PW'].'@';
    elseif (!ini_get('safe_mode') && isset($_SERVER['PHP_AUTH_USER']))
        $root_auth_url .= $_SERVER['PHP_AUTH_USER'].'@';

    $root_url .= http_host.root;
    $root_auth_url .= http_host.root;

    if (!$_SESSION['stream']['include_user_and_password'])
        $root_auth_url = $root_url;

    define('root_url',   $root_url);
    define('root_auth_url', $root_auth_url);

    unset($root_auth_url, $root_url);

    $stream_url = 'http';
    if (@$_SERVER['HTTPS'] == 'on' && !@$_SESSION['stream']['force_http'])
        $stream_url .='s';
    $stream_url .= '://';
    if ($_SESSION['stream']['include_user_and_password'] && !ini_get('safe_mode') && isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
        $stream_url .= $_SERVER['PHP_AUTH_USER'].':'.$_SERVER['PHP_AUTH_PW'].'@';
    elseif ($_SESSION['stream']['include_user_and_password'] && !ini_get('safe_mode') && isset($_SERVER['PHP_AUTH_USER']))
        $stream_url .= $_SERVER['PHP_AUTH_USER'].'@';
    $stream_url .= $_SERVER['HTTP_HOST'];
    if (@$_SESSION['stream']['force_http'] && @$_SESSION['stream']['force_http_port'] > 0)
        $stream_url .= ":{$_SESSION['stream']['force_http_port']}";
    elseif ($_SERVER['HTTP_PORT'] > 0)
        $stream_url .= ":{$_SERVER['HTTP_PORT']}";
    $stream_url .= '/'.root;

    define('stream_url', $stream_url);

    $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen(root)-1);
