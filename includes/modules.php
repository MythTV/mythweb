<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
 *
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/includes/init.php $
 * @date        $Date: 2007-07-28 21:46:51 -0700 (Sat, 28 Jul 2007) $
 * @version     $Revision: 14075 $
 * @author      $Author: xris $
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

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
