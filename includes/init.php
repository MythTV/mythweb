<?php
/***                                                                        ***\
    init.php                                 Last Updated: 2005.05.16 (xris)

    This file is part of MythWeb, a php-based interface for MythTV.
    See README and LICENSE for details.

    Initialization routines.  This file basically loads all of the necessary
    shared files for the entire program.
\***                                                                        ***/

// Clean the document root variable and make sure it doesn't have a trailing slash
    $_SERVER['DOCUMENT_ROOT'] = preg_replace('/\/+$/', '', $_SERVER['DOCUMENT_ROOT']);

// Add the shared_code directory to our search path
    ini_set('include_path', ini_get('include_path').':'.dirname($_SERVER['DOCUMENT_ROOT']).':'.$_SERVER['DOCUMENT_ROOT']);

// Are we running in SSL mode?
    define('is_ssl', ($_SERVER['SERVER_PORT'] == 443 || !empty($_SERVER['SSL_PROTOCOL']) || !empty($_SERVER['HTTPS']))
                     ? true
                     : false);

// Load the user-defined configuration settings
    require_once 'config/conf.php';

// Load the generic utilities so we have access to stuff like DEBUG()
    require_once 'includes/utils.php';

// Load the error trapping and display routines
    require_once 'includes/errors.php';
    require_once 'includes/errordisplay.php';

// Load the translation routines
    require_once 'includes/translate.php';

// Make sure we're running a new enough version of php
    if (substr(phpversion(), 0, 3) < 4.3)
        trigger_error('You must be running at least php 4.3 to use this program.', FATAL);

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

// Load the database connection routines
    require_once 'includes/db.php';

// Connect to the database
    global $db;
    $db = new Database(db_name, db_login, db_password, db_server);

// Support legacy database code
    $dbh = $db->dbh;

// Access denied -- probably means that there is no database
    if ($db->errno == 1045) {
        require_once 'templates/_db_access_denied.php';
        exit;
    }

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

// Load the session handler routines
    require_once 'includes/session.php';

// Include a few useful functions
    require_once "includes/css.php";
    require_once "includes/mouseovers.php";

// Connect to the backend and load some more handy utilities
    require_once "includes/mythbackend.php";

// Load in the TV-related classes
    require_once "includes/channels.php";
    require_once "includes/programs.php";
    require_once "includes/recording_schedules.php";

// Detect different types of browsers and set the theme accordingly.
    require_once "includes/mobile.php";
    if (isMobileUser()) {
    // Browser is mobile but does it accept HTML? If not, use the WML theme.
        if (browserAcceptsMediaType(array('text/html'))) {
            define('Theme', 'wap');
        } else {
            define('Theme', 'wml');
        }
    }
// The browser is MythPhone.
    elseif (strpos($_SERVER['HTTP_USER_AGENT'],'MythPhone') !== false) {
        define('Theme', 'vxml');
    }
// Load theme from session if it exists and the user is not resetting the theme.
    elseif ((file_exists('themes/'.$_SESSION['Theme'].'/theme.php') && !$_GET['RESET_THEME']
           && !$_POST['RESET_THEME'])) {
        define('Theme', $_SESSION['Theme']);
    }
// Otherwise set the default theme.
    else {
        define('Theme', 'Default');
    }

// Update the session variable
    $_SESSION['Theme'] = Theme;

// Load the user's theme settings
    #
    # we'll eventually load theme settings from cookie/session info
    #
    define('theme_dir', 'themes/'.Theme.'/');

// Load the theme config
    require_once 'config/theme_'.Theme.'.php';

// Load the overall page theme class
    require_once theme_dir."theme.php";

// Make sure the image cache path exists
    $path = '';
    foreach (split('/+', image_cache) as $dir) {
        $path .= $path ? '/' . $dir : $dir;
        if(!is_dir($path) && !mkdir($path, 0755))
            trigger_error('Error creating path for '.$path.': Please check permissions.', FATAL);
    }

// Clean out stale thumbnails
    if (is_dir(image_cache)) {
        if ($dir = opendir(image_cache)) {
            while (($file = readdir($dir))) {
                if (!preg_match('/\\.(png|jpg|gif)$/', $file) || !is_file(image_cache.'/'.$file))
                    continue;
            // Delete files older than the last week.
                if (filemtime(image_cache.'/'.$file) < time() - 7 * 24 * 60 * 60)
                    unlink(image_cache.'/'.$file);
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
    if (!$_SESSION['date_recorded'])        $_SESSION['date_recorded']        = t('generic_date') . '<br>('.t('generic_time').')';
    if (!$_SESSION['date_search'])          $_SESSION['date_search']          = t('generic_date') . ', '  . t('generic_time');
    if (!$_SESSION['date_listing_key'])     $_SESSION['date_listing_key']     = t('generic_date') . ', '  . t('generic_time');
    if (!$_SESSION['date_listing_jump'])    $_SESSION['date_listing_jump']    = t('generic_date');
    if (!$_SESSION['date_channel_jump'])    $_SESSION['date_channel_jump']    = t('generic_date');
    if (!$_SESSION['time_format'])          $_SESSION['time_format']          = t('generic_time');

