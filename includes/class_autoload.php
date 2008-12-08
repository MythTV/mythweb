<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
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

// Sometimes a function will use if class_exists, and thus we shouldn't fail if we can't find it.

    function __autoload($className) {
        global $Path;
        $className = str_replace('_', '/', $className);
        if (file_exists("classes/$className.php"))
            include_once "classes/$className.php";
        elseif (file_exists(modules_path.'/'.module."/classes/$className.php"))
            include_once modules_path.'/'.module."/classes/$className.php";
        elseif (file_exists(modules_path.'/'.$Path[1]."/classes/$className.php"))
            include_once modules_path.'/'.$Path[1]."/classes/$className.php";
        elseif (file_exists(modules_path.'/'.$Path[0]."/classes/$className.php"))
            include_once modules_path.'/'.$Path[0]."/classes/$className.php";
        else
            trigger_error(t("Failure to autoload class $className!"), E_USER_ERROR);
    }
