<?php
/**
 * Utility routines used throughout mythweb
 *
 * This file was originally written by Chris Petersen for several different open
 * source projects.  It is distrubuted under the GNU General Public License.
 * I (Chris Petersen) have also granted a special LGPL license for *portions* of
 * this code to several companies I do work for on the condition that these
 * companies will release any changes to this back to me and the open source
 * community as GPL, thus continuing to improve the open source version of the
 * library.  If you would like to inquire about the status of this arrangement,
 * please contact me personally.
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

/**
 * Get or set a database setting.
 *
 * @param string $field     The field (settings.value) to retrieve/set.
 * @param string $hostname  Hostname (or null) associated with $field.
 * @param string $new_value New value (settings.data) to set.
 *
 * @return string The value (settings.data) associated with $field and $hostname.
/**/
    function setting($field, $hostname=null, $new_value = "old\0old") {
        global $db;
        static $cache = array();
    // Best not to have an array index that's null
        $h = is_null($hostname) ? '-null-' : $hostname;
        if (!is_array($cache[$h]))
            $cache[$h] = array();
    // Assigning a new value
        if ($new_value !== "old\0old") {
            if (is_null($hostname))
                $db->query('DELETE FROM settings
                                  WHERE value=? AND hostname IS NULL',
                           $field);
            else
                $db->query('DELETE FROM settings
                                  WHERE value=? AND hostname=?',
                           $field, $hostname);
            $db->query('INSERT INTO settings (value, data, hostname) VALUES (?,?,?)',
                       $field, $new_value, $hostname);
            $cache[$h][$field] = $new_value;
        // Alert the rest of the MythTV network.  Though there are some
        // occasional times where setting() gets called before we're actually
        // connected to the backend, the only known instance is in db_update.php
        // and those settings don't affect anything but MythWeb.
            if (function_exists('backend_command')) {
                backend_command('CLEAR_SETTINGS_CACHE');
            }
        }
    // Not cached?
        elseif (!array_key_exists($field, $cache[$h])) {
            if (is_null($hostname))
                $cache[$h][$field] = $db->query_col('SELECT data
                                                       FROM settings
                                                      WHERE value=? AND hostname IS NULL',
                                                    $field);
            else
                $cache[$h][$field] = $db->query_col('SELECT data
                                                       FROM settings
                                                      WHERE value=? AND hostname=?',
                                                    $field, $hostname);
        }
    // Return the cached value
        return $cache[$h][$field];
    }

/**
 * Find a particular file in the current include_path
 *
 * @param        string     $file       Name of the file to look for
 * @return       mixed      Full path to the requested file, or null if it isn't found.
/**/
    function find_in_path($file) {
    // Split out each of the search paths
        foreach (explode(PATH_SEPARATOR, ini_get('include_path')) as $path) {
        // Formulate the absolute path
            $full_path = $path . DIRECTORY_SEPARATOR . $file;
        // Exists?
            if (file_exists($full_path))
                return $full_path;
        }
        return null;
    }

/**
 *  I like how in perl, you can pass variables into functions in lists or
 *  arrays, and they all show up to the function as one giant list.  This takes
 *  an array containing scalars and arrays of scalars, and returns one clean
 *  array of all values.
/**/
    function smart_args($args) {
        $new_args = array();
    // Not an array
        if (!is_array($args))
            return array($args);
    // Loop
        foreach ($args as $arg) {
            foreach (smart_args($arg) as $arg2) {
                $new_args[] = $arg2;
            }
        }
    // Return
        return $new_args;
    }

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

/**
 * Strips slashes ONLY before quotes, to get around php adding slashes in
 * preg_replace //e but not in such a way that stripslashes works properly.
/*/
    function strip_quote_slashes($str) {
        return preg_replace("/\\\\([\"'])/", '$1', $str);
    }

/**
 * Print a redirect header and exit
/**/
    function redirect_browser($url) {
        header("Location: $url");
        echo "\n";
        exit;
    }

/**
 * Pass in a filesize in bytes, and receive a more human-readable version
 * JS: adapted from php.net: sponger 10-Jun-2002 12:28
/**/
    function nice_filesize($size) {
    //  If it's less than a kb we just return the size
        if ($size < kb)
            return t('$1 B', t($size));
    // Otherwise we keep going until the size is in the appropriate measurement range.
        elseif ($size < mb)
            return t('$1 KB', t(round($size / kb, ($size < 10 * kb))));
        elseif ($size < gb)
            return t('$1 MB', t(round($size / mb, ($size < 10 * mb))));
        elseif ($size < tb)
            return t('$1 GB', t(round($size / gb, ($size < 10 * gb))));
        else
            return t('$1 TB', t(round($size / tb, ($size < 10 * tb))));
    }

/**
 * Convert a unix timestamp into an day/hour/minute string
 *
 * @param int $length time to convert.
 *
 * @return string Translated hour/minute string.
/**/
    function nice_length($length) {
        $years  = intVal( $length / 31556926 );
        $length = $length - ( $years * 31556926 );
        $months = intVal( $length / 2629743 );
        $length = $length - ( $months * 2629743 );
        $days   = intVal( $length / 86400);
        $length = $length - ( $days * 86400 );
        $hours  = intVal( $length / 3600 );
        $length = $length - ( $hours * 3600 );
        $mins   = intVal( $length / 60 );
        $ret = '';
        if ($years > 0)
            $ret = tn('$1 year', '$1 years', $years);
        if ($months > 0)
            $ret .= ' '.tn('$1 month', '$1 months', $months);
        if ($days > 0)
            $ret .= ' '.tn('$1 day', '$1 days', $days);
        if ($hours > 0)
            $ret .= ' '.tn('$1 hr', '$1 hrs', $hours);
        if ($mins > 0)
            $ret .= ' '.tn('$1 min', '$1 mins', $mins);
        return trim($ret);
    }


/**
 * Converts an sql timestamp into unixtime
/**/
    function unixtime($sql_timestamp) {
        return mktime(substr($sql_timestamp, 8,  2),    // hour
                      substr($sql_timestamp, 10, 2),    // minute
                      substr($sql_timestamp, 12, 2),    // second
                      substr($sql_timestamp, 4,  2),    // month
                      substr($sql_timestamp, 6,  2),    // day
                      substr($sql_timestamp, 0,  4));   // year
    }

/**
 *  DEPRECATED (use the Database object instead)
 *
 *  For lack of a function that escapes strings AND adds quotes, I wrote one
 *  myself to make the rest of my code read a bit easier.
/**/
    function escape($string, $allow_null = false) {
    // Null?
        if ($allow_null && is_null($string))
            return $string = 'NULL';
    // Just a string
        return $string = "'".mysql_real_escape_string($string)."'";
    }

/**
 * Overloaded version of htmlentities() that requests the UTF-8 entities rather
 * than the default ISO-9660
 *
 * @param string $str   String to convert to html entities
 *
 * @return UTF-8 entities for $str
/**/
    function html_entities($str) {
        return htmlentities($str, ENT_COMPAT, 'UTF-8');
    }

/**
 * Returns a sorted list of files in a directory, minus . and ..
/**/
    function get_sorted_files($dir = '.', $regex = '', $negate = false) {
        $list = array();
        $handle = opendir($dir);
        while(false != ($file = readdir($handle))) {
            if ($file == '.' || $file == '..') continue;
            if (!$regex || (!$negate && preg_match($regex, $file)) || ($negate && !preg_match($regex, $file)))
                $list[] = $file;
        }
        closedir($handle);
        sort($list);
        return $list;
    }

/**
 * Start/display a microtime timer
 *
 * @param mixed $message The message to echo, or another value (see return)
 * @param int   $index   The index value of the cache to store the timer.
 *                       Useful for handling multiple simultaneous timers.
 *
 * @return mixed If $message is ommitted or null, the current time is returned.
 *               If a string, the string is returned after being passed through
 *               sprintf() with the current time delta (float) as an argument.
 *               If anything else, the current time differential is returned.
/**/
    function timer($message=null, $index=0) {
        static $cache = array();
    // Get the current time
        if (intVal(phpversion()) >= 5) {
            $time = microtime(true);
        }
        else {
            list($usec, $sec) = explode(' ', microtime());
            $time = floatVal($usec) + floatVal($sec);
        }
    // Print a string
        if (is_string($message))
            $ret = sprintf($message, $time - $cache[$index]);
        elseif (is_null($message))
            $ret = $time;
        else
            $ret = $time - $cache[$index];
    // Start/update the timer
        $cache[$index] = $time;
    // Return
        return $ret;
    }

/**
 * returns $this or $or_this
 * if $gt is set to true, $this will only be returned if it's > 0
 * if $gt is set to a number, $this will only be returned if it's > $gt
/**/
    function _or($this, $or_this, $gt = false) {
        if ($gt === true)
            return $this > 0 ? $this : $or_this;
        if (!empty($gt))
            return $this > $gt ? $this : $or_this;
        return $this ? $this : $or_this;
    }

/**
 * Someday, we may even be able to pass in a recording and get back a specific
 * hostname.  For now, you get either the hard-coded global video_url, or one
 * determined based on the browser.
 *
 * @return string URL to access recordings
/**/
    function video_url($show, $ext = false) {
    // URL override?
        if (!$ext && $_SESSION['file_url_override'])
            return 'file://'.$_SESSION['file_url_override'].str_replace('%2F', '/', rawurlencode(basename($show->filename)));
    // Which protocol should we use for downloads?

        $url = (($_SESSION['stream']['force_http'] || !isset($_SERVER['HTTPS']))
                 ? 'http://' . http_host .':'._or($_SESSION['stream']['force_http_port'], '80')
                 : 'https://'. http_host .':'._or($_SESSION['stream']['force_http_port'], '443')
               )
               .root."pl/stream/$show->chanid/$show->recstartts";
    // Handle specific file extension modes
        switch ($ext) {
        // ASX mode gets the streaming module, with a slight addition
            case 'asx' : return "$url.asx";
            case 'flvp': return "$url.flvp";
            case 'flv' : return "$url.flv";
        }
    // No more dsmyth filters, so return the URL no matter what the browser is.
        return $url;
    }

/**
 * @return $str converted UTF-8 to local encoding
/**/
    function utf8tolocal($str) {
        if (empty($_SERVER['fs_encoding']))
            return $str;
        if (function_exists('mb_convert_encoding'))
            return mb_convert_encoding($str, $_SERVER['fs_encoding'], 'UTF-8');
        if (function_exists('iconv'))
            return iconv('UTF-8', $_SERVER['fs_encoding'], $str);
        if (function_exists('recode_string'))
            return recode_string('UTF-8..' . $_SERVER['fs_encoding'], $str);
        return $str;
    }

/**
 * Prints out a piece of data to the firebug console.
/**/
    function debug($data, $file = false) {
    // Put our data into a string
        if (is_array($data) || is_object($data))
            $str = print_r($data, TRUE);
        elseif (isset($data))
            $str = $data;
        $search = array("\n", '"');
        $replace = array("\\n", '\"');
        $back_trace = debug_backtrace();
    // If this is a string, int or float
        if (is_string($str) || is_int($str) || is_float($str)) {
        // Allow XML/HTML to be treated as normal text
            $str = htmlspecialchars($str, ENT_NOQUOTES);
        }
    // If this is a boolean
        elseif (is_bool($str))
            $str = $str ? '<i>**TRUE**</i>' : '<i>**FALSE**</i>';
    // If this is null
        elseif (is_null($str))
            $str = '<i>**NULL**</i>';
    // If it is not a string, we return a get_type, because it would be hard to generically come up with a way
    // to display anything
        else
            $str = '<i>Type : '.gettype($str).'</i>';
    // Show which line caused the debug message
        $str = $str."\n<hr>\n".'Line #'.$back_trace[0]['line'].' in file '.$back_trace[0]['file']."\n";
    // Print the message
        echo '<script type="text/javascript">console.log("'.str_replace($search, $replace, $str).'");</script>';
        echo '<noscript><pre>'.$str.'</pre></noscript>';
    // Print to a file?
        if ($file) {
            $out = fopen('/tmp/debug.txt', 'a');
            fwrite($out, "$str\n");
            fclose($out);
        }
    }

// wth does this do?
    function fequals($lhs, $rhs) {
        $epsilon = 1e-3;
        return abs($lhs - $rhs) <= $epsilon * abs($lhs);
    }
