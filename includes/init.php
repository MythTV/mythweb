<?php
/***                                                                        ***\
    init.php                                 Last Updated: 2005.05.16 (xris)

    This file is part of MythWeb, a php-based interface for MythTV.
    See README and LICENSE for details.

    Initialization routines.  This file basically loads all of the necessary
    shared files for the entire program.
\***                                                                        ***/

// Load in the error libraries before we do anything that might cause some.
    require_once 'includes/errors.php';
    require_once 'includes/errordisplay.php';

// Load the user-defined configuration settings
    require_once 'config/conf.php';

// Make sure that people have actually defined certain (new) config options
    if (hostname == 'hostname')
        trigger_error('Please configure "hostname" in conf.php', FATAL);

// Clean up some variables
    if (!ereg('/$', $_SERVER['DOCUMENT_ROOT']))
        $_SERVER['DOCUMENT_ROOT'] .= '/';

// Clean up any linefeed messiness we get from the form data
    foreach (array_keys($_GET) as $key) {
    // Fix linebreaks
        if (is_string($_GET[$key]))
            $_GET[$key] = ereg_replace("\r\n", "\n", $_GET[$key]);
    // Process any imagemap submissions to make sure we also get the name itself
        if (ereg('_[xy]$', $key)) {
            $key = ereg_replace('_[xy]$', '', $key);
            if (!isset($_GET[$key]))
                $_GET[$key] = true;
        }
    }
    foreach (array_keys($_POST) as $key) {
    // Fix linebreaks
        if (is_string($_POST[$key]))
            $_POST[$key] = ereg_replace("\r\n", "\n", $_POST[$key]);
    // Process any imagemap submissions to make sure we also get the name itself
        if (ereg('_[xy]$', $key)) {
            $key = ereg_replace('_[xy]$', '', $key);
            if (!isset($_POST[$key]))
                $_POST[$key] = true;
        }
    }

// Start the session, and set the cookie to expire in one year
    session_name('mythweb_id');
    session_set_cookie_params(60 * 60 * 24 * 355, '/', server_domain);
    session_start();

// Connect to the database (mysql_pconnect seems to use too many resources, so don't do it)
//  please note that calling mysql_close is unnecessary - see php documentation for details
    $dbh = mysql_connect(db_host, db_username, db_password)
        or trigger_error("Can't connect to the database server.  Did you use the correct settings in config/conf.php?", FATAL);
    mysql_select_db(db_dbname)
        or trigger_error("Can't access the database file:  " . mysql_error() . " [#" . mysql_errno() . "]", FATAL);

// Load the translation routines
    require_once 'includes/translate.php';

// Include a few useful functions
    require_once "includes/utils.php";
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

?>
