<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
 *
 * Initialization routines.  This file basically loads all of the necessary
 * shared files for the entire program.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Start an output buffer to store up errors until the output
    ob_start();

// Attempt to load up firephp if installed on the server
    @include_once('FirePHPCore/fb.php');

    require_once 'includes/errors.php';

// Lazy load the classes...
    require_once 'includes/class_autoload.php';

// Load the generic utilities so we have access to stuff like DEBUG()
    require_once 'includes/utils.php';

// Clean up some stuff
    require_once 'includes/cleanup.php';

// Check out the php version info
    require_once 'includes/php_version_check.php';

// Load the error trapping and display routines
    require_once 'includes/errors.php';
    require_once 'includes/errordisplay.php';

// Define some common stuff
    require_once 'includes/defines.php';

// Setup the database
    require_once 'includes/database.php';

// Make sure the database is up to date
    require_once 'includes/db_update.php';

// Load the session handler routines
    require_once 'includes/session.php';

// Load the translation routines so the modules can translate their descriptions
    require_once 'includes/translate.php';

// Protect the users!
    require_once 'includes/lockdown.php';

// Include a few useful functions
    require_once 'includes/css.php';
    require_once 'includes/mouseovers.php';

// Detect mobile users
    require_once 'includes/mobile.php';

// Setup the skins and themes
    require_once 'includes/skin.php';

// Setup the data_dir
    require_once 'includes/data_dir.php';

// Load the session defaults and other config info
    require_once 'includes/config.php';

// And do some quick setup...
    MythBackend::find()->setTimezone();

	// Set some default types
    require_once 'includes/defaults.php';
