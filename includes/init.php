<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
 *
 * Initialization routines.  This file basically loads all of the necessary
 * shared files for the entire program.
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

// mod_redirect can do some weird things when php is run in cgi mode
    $keys = preg_grep('/^REDIRECT_/', array_keys($_SERVER));
    if (!empty($keys)) {
        foreach ($keys as $key) {
            $key = substr($key, 9);
            if (!array_key_exists($key, $_SERVER))
                $_SERVER[$key] = $_SERVER["REDIRECT_$key"];
        }
    }

// Clean the document root variable and make sure it doesn't have a trailing slash
    $_SERVER['DOCUMENT_ROOT'] = preg_replace('/\/+$/', '', $_SERVER['DOCUMENT_ROOT']);

// Are we running in SSL mode?
    define('is_ssl', ($_SERVER['SERVER_PORT'] == 443 || !empty($_SERVER['SSL_PROTOCOL']) || !empty($_SERVER['HTTPS']))
                     ? true
                     : false);

// Figure out the root path for this mythweb installation.  We need this in order
// to cleanly reference things like the /js directory from subpaths.
    define('root', str_replace('//', '/', dirname($_SERVER['SCRIPT_NAME']).'/'));

// Several sections of this program require the current hostname
    define('hostname', empty($_SERVER['hostname']) ? trim(`hostname`) : $_SERVER['hostname']);

// Define the error email, or set it to a null string if there isn't a valid one
    define('error_email', array_key_exists('error_email', $_SERVER) && strstr($_SERVER['error_email'], '@')
                          ? $_SERVER['error_email']
                          : '');

// Load the generic utilities so we have access to stuff like DEBUG()
    require_once 'includes/utils.php';

// Load the error trapping and display routines
    require_once 'includes/errors.php';
    require_once 'includes/errordisplay.php';

// Make sure we're running a new enough version of php
    if (substr(phpversion(), 0, 3) < 4.3)
        trigger_error('You must be running at least php 4.3 to use this program.', FATAL);

// Clean up input data
    fix_crlfxy($_GET);
    fix_crlfxy($_POST);
    fix_crlfxy($_REQUEST);
    if (get_magic_quotes_gpc()) {
        fix_magic_quotes($_COOKIE);
        fix_magic_quotes($_ENV);
        fix_magic_quotes($_GET);
        fix_magic_quotes($_POST);
        fix_magic_quotes($_REQUEST);
        fix_magic_quotes($_SERVER);
    }

// No MySQL libraries installed in PHP
    if (!function_exists('mysql_connect')) {
        custom_error("Please install the MySQL libraries for PHP.\n"
                    .'The package is usually called something like php-mysql.');
    }

// No database connection info defined?
    if (empty($_SERVER['db_server']) || empty($_SERVER['db_name']) || empty($_SERVER['db_login'])) {
        tailored_error('db_vars_error');
    }

/**
 * $Path is an array of PATH_INFO passed into the script via mod_rewrite or some
 * other lesser means.  It contains most of the information required for
 * figuring out what functions the user wants to access.
 *
 * @global  array   $GLOBALS['Path']
 * @name    $Path
/**/
    global $Path;
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
    define('module', $Path[0]);

// Find the modules path
    $path = dirname(dirname(find_in_path('modules/tv/init.php')));
    define('modules_path', $path);

// Load the database connection routines
    foreach (get_sorted_files('includes/objects/', '/^Database/') as $file) {
        require_once "includes/objects/$file";
    }

/**
 * All database connections should now go through this object.
 *
 * @global  Database    $GLOBALS['db']
 * @name    $db
/**/
    global $db;

// Connect to the database
    if (!is_object($db)) {
        $db = Database::connect($_SERVER['db_name'],
                                $_SERVER['db_login'],
                                $_SERVER['db_password'],
                                $_SERVER['db_server'],
                                NULL, 'mysql');
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

// Make sure the database is up to date
    require_once 'includes/db_update.php';

// Load the session handler routines
    require_once 'includes/session.php';

// Load the translation routines so the modules can translate their descriptions
    require_once 'includes/translate.php';

// Include a few useful functions
    require_once 'includes/css.php';
    require_once 'includes/mouseovers.php';

// Connect to the backend and load some more handy utilities
    require_once 'includes/mythbackend.php';

// Detect mobile users
    require_once 'includes/mobile.php';

// Detect different types of browsers and set the theme accordingly.
    if (isMobileUser()) {
    // Browser is mobile but does it accept HTML? If not, use the WML theme.
        $_SESSION['tmpl'] = browserAcceptsMediaType(array('text/html', '\*/\*'))
                            ? 'wap'
                            : 'wml';
    // Make sure the skin is set to the appropriate phone-template type
        $_SESSION['skin'] = $_SESSION['tmpl'];
        define('skin', $_SESSION['skin']);
    }
// Reset the template?
    elseif ($_REQUEST['RESET_TMPL'] || $_REQUEST['RESET_TEMPLATE'])
        $_SESSION['tmpl'] = 'default';
// Deal with people who use the same login for mobile and non-mobile
    elseif (in_array($_SESSION['tmpl'], array('wap', 'wml'))) {
        $_SESSION['tmpl'] = 'default';
    }
// If the requested template is missing the welcome file, use the default template
    else if (!file_exists(modules_path.'/_shared/tmpl/'.$_SESSION['tmpl'].'/welcome.php')) {
         $_SESSION['tmpl'] = 'default';
    }

// Is there a preferred skin?
    if (file_exists('skins/'.$_SESSION['skin'].'/img/') && !$_REQUEST['RESET_SKIN']) {
        define('skin', $_SESSION['skin']);
    }
    else {
        define('skin', 'default');
    }
    $_SESSION['skin'] = skin;

// Set up some handy constants
    define('skin_dir', 'skins/'.skin);
    define('skin_url', root.skin_dir.'/');
    define('tmpl',     $_SESSION['tmpl']);
    define('tmpl_dir', 'modules/'.module.'/tmpl/'.tmpl.'/');

/**
 * @global  array       $GLOBALS['Modules']
 * @name    $Modules    A list of the available MythWeb modules
/**/
    $Modules = array();

// Load the various modules (search for the "tv" subdirectory in case it might
// find some other "modules" directory, too.
    if (modules_path && modules_path != 'modules_path') {
        foreach (get_sorted_files(modules_path) as $module) {
            if (preg_match('/^_/', $module))
                continue;
            if (!file_exists(modules_path."/$module/init.php"))
                continue;
            require_once modules_path."/$module/init.php";
        }
    }
    if (empty($Modules)) {
        tailored_error('no_modules');
    }

// Sort the modules
    uasort($Modules, 'by_module_sort');
    function by_module_sort(&$a, &$b) {
        if ($a['sort'] == $b['sort']) return strcasecmp($a['name'], $b['name']);
        if (is_null($a['sort']))      return 99999;
        if (is_null($b['sort']))      return -99999;
        return ($a['sort'] > $b['sort']) ? 1 : -1;
    }

// Make sure the data directory exists and is writable
    if (!is_dir('data') && !mkdir('data', 0755)) {
        custom_error('Error creating the data directory. Please check permissions.');
    }
    if (!is_writable('data')) {
        $process_user = posix_getpwuid(posix_geteuid());
        custom_error('data directory is not writable by '.$process_user['name'].'. Please check permissions.');
    }

// New hard-coded cache directory
    define('cache_dir', 'data/cache');

// Make sure the image cache path exists and is writable
    if (!is_dir(cache_dir) && !mkdir(cache_dir, 0755)) {
        custom_error('Error creating '.cache_dir.': Please check permissions on the data directory.');
    }
    if (!is_writable(cache_dir)) {
        $process_user = posix_getpwuid(posix_geteuid());
        custom_error(cache_dir.' directory is not writable by '.$process_user['name'].'. Please check permissions.');
    }

// Clean out stale thumbnails
    if (is_dir(cache_dir)) {
        if ($dir = opendir(cache_dir)) {
            while (($file = readdir($dir))) {
                if (!preg_match('/\\.(png|jpg|gif)$/', $file) || !is_file(cache_dir.'/'.$file))
                    continue;
            // Delete files older than the last week.
                if (filemtime(cache_dir.'/'.$file) < time() - 7 * 24 * 60 * 60)
                    unlink(cache_dir.'/'.$file);
            }
            closedir($dir);
            clearstatcache();
        }
    }

// Load the session defaults and other config info
    require_once 'includes/config.php';

