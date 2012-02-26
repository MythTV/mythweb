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

/**
 * Recursively fixes silly \r\n stuff that some browsers send.
 * Also adds a generic entry for fiends ending in _x or _y to better deal
 * with image inputs.
/**/
    function &fix_crlfxy(&$array) {
        foreach ($array as $key => $val) {
            if (is_array($val))
                fix_crlfxy($array[$key]);
            elseif (is_string($val)) {
                $array[$key] = str_replace("\r\n", "\n", $val);
            // Process any imagemap submissions to make sure we also get the name itself
                if ($key != ($new_key = preg_replace('/_[xy]$/', '', $key))) {
                    if (!array_key_exists($new_key, $array))
                        $array[$new_key] = true;
                }
            }
        }
        return $array;
    }

// Clean up input data
    fix_crlfxy($_GET);
    fix_crlfxy($_POST);
    fix_crlfxy($_REQUEST);
    if (get_magic_quotes_gpc()) {

    /**
     * Recursively strip slashes from an array (eg. $_GET).
    /**/
        function &fix_magic_quotes(&$array) {
            foreach ($array as $key => $val) {
                if (is_array($val))
                    fix_magic_quotes($array[$key]);
                else
                    $array[$key] = stripslashes($val);
            }
            return $array;
        }

        fix_magic_quotes($_COOKIE);
        fix_magic_quotes($_ENV);
        fix_magic_quotes($_GET);
        fix_magic_quotes($_POST);
        fix_magic_quotes($_REQUEST);
        fix_magic_quotes($_SERVER);
    }
