<?php
/**
 * Handler for all MythWeb TV routines
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Make sure the image cache path exists and is writable
    if (!is_dir('data/tv_icons') && !mkdir('data/tv_icons', 0755)) {
        custom_error('Error creating data/tv_icons: Please check permissions on the data directory.');
        exit;
    }
    if (!is_writable('data/tv_icons')) {
        $process_user = posix_getpwuid(posix_geteuid());
        custom_error('data/tv_icons directory is not writable by '.$process_user['name'].'. Please check permissions.');
        exit;
    }

// Call the opensearch module early, before loading all kinds of stuff it
// doesn't need.  Plus, it's not "enabled" like other modules, so we skip that
// check, too.
    if ($Path[1] == 'opensearch')
        require_once 'modules/tv/opensearch.php';

    if ($Path[1] == 'get_pixmap')
        require_once 'modules/tv/get_pixmap.php';

/**
 * @global  array   $GLOBALS['Categories']
 * @name    $Categories
/**/
    global $Categories;
    $Categories = array();

// Load the tv categories
    if (file_exists(modules_path.'/_shared/lang/'.$_SESSION['language'].'.cat'))
        load_tv_categories(modules_path.'/_shared/lang/'.$_SESSION['language'].'.cat');
    else
        load_tv_categories(modules_path.'/_shared/lang/English.cat');

// Two categories that don't need regex matches, but do need translation
//    $Categories['Unknown'] = array(t('Unknown'));
//    $Categories['movie']   = array(t('movie'));

// Don't forget to sort
    function category_name_sort($a, $b) {
        return strnatcasecmp($a[0], $b[0]);
    }
    uasort($Categories, 'category_name_sort');

// Load the tv-related libraries
    require_once 'includes/programs.php';
    require_once 'includes/recording_schedules.php';

// Restore the last used path?
    if (empty($Path[1]) && is_array($_SESSION['tv']['last']))
        array_splice($Path, 1, count($Path), $_SESSION['tv']['last']);

// Flash player?
    if (preg_match('/\.swf/', $Path[1])) {
        header('Content-Type: application/x-shockwave-flash');
        readfile('modules/tv/'.$Path[1]);
        exit;
    }

// Unknown section?  Use the default
    if (!file_exists('modules/tv/'.$Path[1].'.php'))
        $Path[1] = 'list';

// Keep track of this path for the next visit
    if (   $Path[1] != 'get_show_details'
        && $Path[1] != 'get_schedule_details'
        && $Path[1] != 'get_pixmap'
        )
        $_SESSION['tv']['last'] = array_slice($Path, 1);

// Show the requested section
    require_once 'modules/tv/'.$Path[1].'.php';

/**
 * Load translation file for tv category names and regular expressions
 *
 * @param string $path The path to the translation file
/**/
    function load_tv_categories($path) {
        $file = file_get_contents($path);
    // Error?
        if ($file === false)
            trigger_error("Failed to open tv category file:  $path", FATAL);
    // Parse the file
        global $Categories;
        foreach (preg_split('/\n(?=\S)/', $file) as $group) {
            list($key, $trans, $regex) = preg_split('/\s*\n\s*/', $group);
        // Cleanup
            if (preg_match('/^["\']/', $key))
                $key = preg_replace('/^(["\'])(.+)\\1$/', '$2', $key);
        // Store
            $Categories[$key] = array($trans, $regex);
        }
    }
