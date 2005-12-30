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
                             $_SERVER['PATH_INFO']       // Grab the path info from various different places.
                                ? $_SERVER['PATH_INFO']
                                : ($_ENV['PATH_INFO']
                                    ? $_ENV['PATH_INFO']
                                    : $_GET['PATH_INFO']
                                  )
                         ))
                   );

// Clean the document root variable and make sure it doesn't have a trailing slash
    $_SERVER['DOCUMENT_ROOT'] = preg_replace('/\/+$/', '', $_SERVER['DOCUMENT_ROOT']);

// Are we running in SSL mode?
    define('is_ssl', ($_SERVER['SERVER_PORT'] == 443 || !empty($_SERVER['SSL_PROTOCOL']) || !empty($_SERVER['HTTPS']))
                     ? true
                     : false);

// Figure out the root path for this mythweb installation.  We need this in order
// to cleanly reference things like the /js directory from subpaths.
    define('root', str_replace('//', '/', dirname($_SERVER['SCRIPT_NAME']).'/'));;

// Several sections of this program require the current hostname
    define('hostname', trim(`hostname`));

// Load the user-defined configuration settings
    require_once 'config/conf.php';

// Load the generic utilities so we have access to stuff like DEBUG()
    require_once 'includes/utils.php';

// Load the error trapping and display routines
    require_once 'includes/errors.php';
    require_once 'includes/errordisplay.php';

// Make sure we're running a new enough version of php
    if (substr(phpversion(), 0, 3) < 4.3)
        trigger_error('You must be running at least php 4.3 to use this program.', FATAL);

// Load the translation routines so the modules can translate their descriptions
    require_once 'includes/translate.php';

// Clean up input data
    fix_crlfxy($_GET);
    fix_crlfxy($_POST);
    if (get_magic_quotes_gpc()) {
        fix_magic_quotes($_COOKIE);
        fix_magic_quotes($_ENV);
        fix_magic_quotes($_GET);
        fix_magic_quotes($_POST);
        fix_magic_quotes($_REQUEST);
        fix_magic_quotes($_SERVER);
    }

// No database connection info defined?
    if (empty($_SERVER['db_server']) || empty($_SERVER['db_name']) || empty($_SERVER['db_login'])) {
        require_once 'templates/_db_vars_error.php';
        exit;
    }

// Load the database connection routines
    require_once 'includes/db.php';

/**
 * All database connections should now go through this object.
 *
 * @global  Database    $GLOBALS['db']
 * @name    $db
/**/
    global $db;

// Connect to the database
    $db = new Database($_SERVER['db_name'],
                       $_SERVER['db_login'],
                       $_SERVER['db_password'],
                       $_SERVER['db_server']);

// Access denied -- probably means that there is no database
    if ($db->errno == 1045) {
        require_once 'templates/_db_access_denied.php';
        exit;
    }

// We don't need these security risks hanging around taking up memory.
    unset($_SERVER['db_name'],
          $_SERVER['db_login'],
          $_SERVER['db_password'],
          $_SERVER['db_server']);

/**
 * Support legacy database code.  :(
 * @deprecated  deprecated since the use of db.php
 *
 * @global  resource    $GLOBALS['dbh']
 * @name    $dbh
/**/
    global $dbh;
    $dbh = $db->dbh;

//
//  If there was a database connection error, this will send an email to
//    the administrator, and then present the user with a static page
//    informing them of the trouble.
//
    if ($db->error) {
    // Notify the admin that the database is offline!
        if (strstr(error_email, '@'))
            mail(error_email, "Database Connection Error" ,
                 $db->error,
                 'From:  PHP Error <php_errors@'.server_domain.">\n");
    // Let the user know in a nice way that something's wrong
        require_once 'templates/_site_down.php';
        exit;
    }

// Make sure the database is up to date
    require_once 'includes/db_update.php';

/**
 * Define each module individually in order because it's easier than storing a
 * sort-order setting in each module.
 *
 * @global  array       $GLOBALS['Modules']
 * @name    $Modules    A list of the available MythWeb modules
/**/
    $Modules = array('tv'          => null,
                     'video'       => null,
                     'music'       => null,
                     'weather'     => null,
                     'movietimes'  => null,
                     'settings'    => null,
                     'status'      => null,
                     'backend_log' => null,
                     'stream'      => null,
                    );

// Load the various modules (search for the "tv" subdirectory in case it might
// find some other "modules" directory, too.
    $path = find_in_path('modules/tv/init.php');
    if ($path) {
        $path = dirname(dirname($path));
        foreach (array_keys($Modules) as $module) {
            if (!file_exists("$path/$module/init.php"))
                continue;
            require_once "$path/$module/init.php";
            if (empty($Modules[$module]))
                unset($Modules[$module]);
        }
    }
    if (empty($Modules)) {
        require_once 'templates/_no_modules.php';
        exit;
    }

// Load the session handler routines
    require_once 'includes/session.php';

// Include a few useful functions
    require_once "includes/css.php";
    require_once "includes/mouseovers.php";

// Connect to the backend and load some more handy utilities
    require_once "includes/mythbackend.php";

// The browser is MythPhone.
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MythPhone') !== false) {
        define('Theme', 'vxml');
    }
// Load theme from session if it exists and the user is not resetting the theme.
    elseif (file_exists('themes/'.$_SESSION['Theme'].'/theme.php')
            && !$_REQUEST['RESET_THEME']) {
        define('Theme', $_SESSION['Theme']);
    }
// Now that we've tried a few things, we can load the mobile library
    else {
    // Detect different types of browsers and set the theme accordingly.
        require_once "includes/mobile.php";
        if (isMobileUser()) {
        // Browser is mobile but does it accept HTML? If not, use the WML theme.
            if (browserAcceptsMediaType(array('text/html', '\*/\*')))
                define('Theme', 'wap');
            else
                define('Theme', 'wml');
        }
    // Otherwise set the default theme.
        else {
            define('Theme', 'default');
        }
    }

// Update the session variable
    $_SESSION['Theme'] = Theme;

// Is there a preferred skin?
    if (file_exists('skins/'.$_SESSION['Skin'].'/img/') && !$_REQUEST['RESET_SKIN']) {
        define('Skin', $_SESSION['Skin']);
    }
    else {
        define('Skin', 'default');
    }
    $_SESSION['Skin'] = Skin;

// Set up some handy constants
    define('skin_dir', 'skins/'.Skin);
    define('skin_url', root.skin_dir);
    define('theme_dir', 'themes/'.Theme.'/');
    define('theme_url', root.theme_dir);

// Make sure the data directory exists and is writable
    if (!is_dir('data') && !mkdir('data', 0755)) {
        $Error = 'Error creating the data directory. Please check permissions.';
        require_once 'templates/_error.php';
        exit;
    }
    if (!is_writable('data')) {
        $process_user = posix_getpwuid(posix_geteuid());
        $Error = 'data directory is not writable by '.$process_user['name'].'. Please check permissions.';
        require_once 'templates/_error.php';
        exit;
    }

// New hard-coded cache directory
    define('cache_dir', 'data/cache');

// Make sure the image cache path exists and is writable
    if (!is_dir(cache_dir) && !mkdir(cache_dir, 0755)) {
        $Error = 'Error creating '.cache_dir.': Please check permissions on the data directory.';
        require_once 'templates/_error.php';
        exit;
    }
    if (!is_writable(cache_dir)) {
        $process_user = posix_getpwuid(posix_geteuid());
        $Error = cache_dir.' directory is not writable by '.$process_user['name'].'. Please check permissions.';
        require_once 'templates/_error.php';
        exit;
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

// Upgrading from an earlier version?  Wipe the session date data
    if (!strstr($_SESSION['date_statusbar'], '%')) {
        unset($_SESSION['date_statusbar'],
              $_SESSION['date_scheduled'],
              $_SESSION['date_scheduled_popup'],
              $_SESSION['date_recorded'],
              $_SESSION['date_search'],
              $_SESSION['date_listing_key'],
              $_SESSION['date_listing_jump'],
              $_SESSION['date_channel_jump'],
              $_SESSION['time_format']);
    }

// Load/set default session data
    if (!$_SESSION['date_statusbar'])       $_SESSION['date_statusbar']       = t('generic_date') . ', '  . t('generic_time');
    if (!$_SESSION['date_scheduled'])       $_SESSION['date_scheduled']       = t('generic_date') . ' ('  . t('generic_time') . ')';
    if (!$_SESSION['date_scheduled_popup']) $_SESSION['date_scheduled_popup'] = t('generic_date');
    if (!$_SESSION['date_recorded'])        $_SESSION['date_recorded']        = t('generic_date') . '<br />('.t('generic_time').')';
    if (!$_SESSION['date_search'])          $_SESSION['date_search']          = t('generic_date') . ', '  . t('generic_time');
    if (!$_SESSION['date_listing_key'])     $_SESSION['date_listing_key']     = t('generic_date') . ', '  . t('generic_time');
    if (!$_SESSION['date_listing_jump'])    $_SESSION['date_listing_jump']    = t('generic_date');
    if (!$_SESSION['date_channel_jump'])    $_SESSION['date_channel_jump']    = t('generic_date');
    if (!$_SESSION['time_format'])          $_SESSION['time_format']          = t('generic_time');

