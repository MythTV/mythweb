<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
 *
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/includes/php_version_check.php $
 * @date        $Date: 2008-02-05 19:39:00 -0800 (Tue, 05 Feb 2008) $
 * @version     $Revision: 15798 $
 * @author      $Author: kormoc $
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Sometimes a function will use if class_exists, and thus we shouldn't fail if we can't find it.

    function __autoload($className) {
        @include_once "classes/$className.php";
        @include_once modules_path.'/'.module."/classes/$className.php";
    }
