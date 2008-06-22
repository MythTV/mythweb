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

// Lazy load the classes...
    require_once 'includes/class_autoload.php';

// Load the generic utilities so we have access to stuff like DEBUG()
    require_once 'includes/utils.php';

// Clean up some stuff
    require_once 'includes/cleanup.php';

// Define some common stuff
    require_once 'includes/defines.php';
// Check out the php version info
    require_once 'includes/php_version_check.php';

// Load the error trapping and display routines
    require_once 'includes/errors.php';
    require_once 'includes/errordisplay.php';

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

// Connect to the backend and load some more handy utilities
    require_once 'includes/mythbackend.php';

// Detect mobile users
    require_once 'includes/mobile.php';

// Setup the skins and themes
    require_once 'includes/skin.php';

// Setup the modules
    require_once 'includes/modules.php';

// Setup the data_dir
    require_once 'includes/data_dir.php';

// Load the session defaults and other config info
    require_once 'includes/config.php';
