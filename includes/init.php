<?php
/***                                                                        ***\
	init.php				                 Last Updated: 2003.12.19 (xris)

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
		$_GET[$key] = ereg_replace("\r\n", "\n", $_GET[$key]);
	// Process any imagemap submissions to make sure we also get the name itself
		if (ereg('_[xy]$', $key)) {
			$key = ereg_replace('_[xy]$', '', $key);
			if (!isset($_GET[$key]))
				$_GET[$key] = true;
		}
	}
	foreach (array_keys($_POST) as $key) {
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

// Connect to the database, or restore a persistent connection
//  please note that calling mysql_close is unnecessary - see php documentation for details
    #$dbh = mysql_pconnect(db_host, db_username, db_password)
    $dbh = mysql_connect(db_host, db_username, db_password)
        or trigger_error("Can't connect to the database server.  Did you use the correct settings in config/conf.php?", FATAL);
    mysql_select_db(db_dbname)
		or trigger_error("Can't access the database file:  " . mysql_error() . " [#" . mysql_errno() . "]", FATAL);

// Include a few useful functions
	require_once "includes/utils.php";

// Connect to the backend and load some more handy utilities
	require_once "includes/mythbackend.php";

// Load in the channel, program and recording classes
	require_once "includes/channels.php";
	require_once "includes/programs.php";
	require_once "includes/recordings.php";

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
						);
	if (strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0 // The browser/gateway says it accepts WML.
			|| in_array(substr(trim($_SERVER['HTTP_USER_AGENT']), 0, 4), $wap_agents))
		define('Theme', 'wap');
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
	if ($dir = opendir(image_cache)) {
		while (($file = readdir($dir))) {
			if (!is_file(image_cache.'/'.$file) || !ereg('\\.(png|jpg|gif)$', $file))
				continue;
		// Delete files that haven't been touched in the last 3 days
			if (fileatime(image_cache.'/'.$file) < time() - 3 * 24 * 60 * 60)
				unlink(image_cache.'/'.$file);
		}
		closedir($dir);
	}

// Load/set default session data
	if (!$_SESSION['date_statusbar'])       $_SESSION['date_statusbar']       = generic_date . ', ' . generic_time;
	if (!$_SESSION['date_scheduled'])       $_SESSION['date_scheduled']       = generic_date . ' (' . generic_time . ')';
	if (!$_SESSION['date_scheduled_popup']) $_SESSION['date_scheduled_popup'] = generic_date;
	if (!$_SESSION['date_recorded'])        $_SESSION['date_recorded']        = generic_date . ' (' . generic_time . ')';
	if (!$_SESSION['date_search'])          $_SESSION['date_search']          = generic_date . ', ' . generic_time;
	if (!$_SESSION['date_listing_key'])     $_SESSION['date_listing_key']     = generic_date . ', ' . generic_time;
	if (!$_SESSION['date_listing_jump'])    $_SESSION['date_listing_jump']    = generic_date;
	if (!$_SESSION['date_channel_jump'])    $_SESSION['date_channel_jump']    = generic_date;
	if (!$_SESSION['time_format'])          $_SESSION['time_format']          = generic_time;

?>
