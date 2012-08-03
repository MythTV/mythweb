<?php
/**
 * The main brain script for all of MythWeb.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Add a custom include path?
    if (!empty($_SERVER['include_path']) && $_SERVER['include_path'] != '.') {
        ini_set('include_path', $_SERVER['include_path'].PATH_SEPARATOR.ini_get('include_path'));
    }

// Path to the MythTV bindings that are now installed by the MythTV package
    ini_set('include_path', '/usr/local/share/mythtv/bindings/php/'.PATH_SEPARATOR.'/usr/share/mythtv/bindings/php/'.PATH_SEPARATOR.ini_get('include_path'));

// Init
    require_once 'includes/init.php';

// Handle Feed requests
    if (   $Path[0] == 'rss'
        || $Path[0] == 'ical') {
        unset($Path[0]);
        $Path = array_values($Path);
    }

// Standard module?  Pass along the
    if (Modules::getModule($Path[0])) {
    // Add the current module directory to our search path, so modules can
    // define includes, etc.
        ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.modules_path.'/'.$Path[0]);
    // Load the module handler
        require_once 'handler.php';
    }
    elseif ($Path[0] == 'dcss')
        include_once 'skins/default/'.$Path[1];
    elseif (!empty($Path[0]) && preg_match('/\w/', $Path[0]))
        tailored_error('unknown_module');
    else
        require_once 'modules/welcome.php';
