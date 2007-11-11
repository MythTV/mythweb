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

// mod_redirect can do some weird things when php is run in cgi mode
    $keys = preg_grep('/^REDIRECT_/', array_keys($_SERVER));
    if (!empty($keys)) {
        foreach ($keys as $key) {
            $key = substr($key, 9);
            if (!array_key_exists($key, $_SERVER))
                $_SERVER[$key] = $_SERVER["REDIRECT_$key"];
        }
    }

// Clean the document root variable and make sure it doesn't have a trailing slash
    $_SERVER['DOCUMENT_ROOT'] = preg_replace('/\/+$/', '', $_SERVER['DOCUMENT_ROOT']);

// Clean up input data
    fix_crlfxy($_GET);
    fix_crlfxy($_POST);
    fix_crlfxy($_REQUEST);
    if (get_magic_quotes_gpc()) {
        fix_magic_quotes($_COOKIE);
        fix_magic_quotes($_ENV);
        fix_magic_quotes($_GET);
        fix_magic_quotes($_POST);
        fix_magic_quotes($_REQUEST);
        fix_magic_quotes($_SERVER);
    }
