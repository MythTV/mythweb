<?php
/***                                                                        ***\
    init.php                                 Last Updated: 2005.02.27 (xris)

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

// Detect WAP browsers
    $wap_agents = array('Noki', // Nokia phones and emulators
                        'Eric', // Ericsson WAP phones and emulators
                        'WapI', // Ericsson WapIDE 2.0
                        'MC21', // Ericsson MC218
                        'AUR ', // Ericsson R320
                        'R380', // Ericsson R380
                        'UP.B', // UP.Browser
                        'WinW', // WinWAP browser
                        'UPG1', // UP.SDK 4.0
                        'upsi', // another kind of UP.Browser ??
                        'QWAP', // unknown QWAPPER browser
                        'Jigs', // unknown JigSaw browser
                        'Java', // unknown Java based browser
                        'Alca', // unknown Alcatel-BE3 browser (UP based?)
                        'MITS', // unknown Mitsubishi browser
                        'MOT-', // unknown browser (UP based?)
                        'My S', // unknown Ericsson devkit browser ?
                        'WAPJ', // Virtual WAPJAG www.wapjag.de
                        'fetc', // fetchpage.cgi Perl script from www.wapcab.de
                        'ALAV', // yet another unknown UP based browser ?
                        'Wapa', // another unknown browser (Web based "Wapalyzer"?)
                        'LGE-', // LG phones
                        );
    if (strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0 // The browser/gateway says it accepts WML.
            || in_array(substr(trim($_SERVER['HTTP_USER_AGENT']), 0, 4), $wap_agents)) {
    // This browser is WAP.  Now check if it supports html or wml
        if (strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"TEXT/HTML") !== false) {
            define('Theme', 'wap');
        }
    // browser didn't explicitly state html, use wml only.
        else {
            define('Theme', 'wml');
        }
    }
    elseif (strpos($_SERVER['HTTP_USER_AGENT'],"MythPhone") !== false) // The browser is MythPhone
        define('Theme', 'vxml');
// Load the theme from session data?
    elseif (file_exists('themes/'.$_SESSION['Theme'].'/theme.php') && !$_GET['RESET_THEME'] && !$_POST['RESET_THEME'])
        define('Theme', $_SESSION['Theme']);
// Load the default theme, and set the session if someone opted to reset
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
