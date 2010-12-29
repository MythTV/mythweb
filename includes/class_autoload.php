<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Sometimes a function will use if class_exists, and thus we shouldn't fail if we can't find it.

    function autoload($className) {
        global $Path;
        $className = str_replace('_', '/', $className);
        if (file_exists("classes/$className.php")) {
            include_once "classes/$className.php";
            return true;
        }
        foreach (explode(PATH_SEPARATOR, ini_get('include_path')) as $path) {
            if (!file_exists("$path/$className.php"))
                continue;
            include_once "$path/$className.php";
            return true;
        }
        if (file_exists(modules_path.'/'.module."/classes/$className.php"))
            include_once modules_path.'/'.module."/classes/$className.php";
        elseif (file_exists(modules_path.'/'.$Path[1]."/classes/$className.php"))
            include_once modules_path.'/'.$Path[1]."/classes/$className.php";
        elseif (file_exists(modules_path.'/'.$Path[0]."/classes/$className.php"))
            include_once modules_path.'/'.$Path[0]."/classes/$className.php";
        else
            return false;
    }

    spl_autoload_register('autoload');
