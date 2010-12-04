<?php
/**
 * Handling Modules
 *
 * @license     GPL
 *
 * @package     MythTV
 *
/**/

class Modules implements Cache_Enabled {
    static private $Modules;

    public static function load() {
        global $Settings;

        if (is_array(self::$Modules) && count(self::$Modules))
            return;

    // Load the various modules (search for the "tv" subdirectory in case it might
    // find some other "modules" directory, too.
        if (modules_path && modules_path != 'modules_path') {
            foreach (get_sorted_files(modules_path) as $module) {
                if (preg_match('/^_/', $module))
                    continue;
                if (!is_dir(modules_path."/$module"))
                    continue;
                if (!file_exists(modules_path."/$module/init.php"))
                    continue;
                require_once modules_path."/$module/init.php";
            }
        }

        if (empty($Modules))
            tailored_error('no_modules');

    // Sort the modules
        uasort($Modules, 'Modules::by_module_sort');

        self::$Modules = $Modules;
        unset($Modules);
    }

    public static function getModules() {
        self::load();
        return self::$Modules;
    }

    public static function getModule($module) {
        self::load();
        return self::$Modules[$module];
    }

    public static function getModuleProperty($module, $key) {
        self::load();
        return self::$Modules[$module][$key];
    }

    private static function by_module_sort(&$a, &$b) {
        if ($a['sort'] == $b['sort'])
            return strcasecmp($a['name'], $b['name']);
        if (is_null($a['sort']))
            return 99999;
        if (is_null($b['sort']))
            return -99999;
        return ($a['sort'] > $b['sort']) ? 1 : -1;
    }
}
