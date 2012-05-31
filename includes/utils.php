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
    function setting($field, $hostname=null, $new_value = "old\0old", $clearSettingsCache = true) {
        global $db;
        static $cache = array();
    // Best not to have an array index that's null
        $h = is_null($hostname) ? '-null-' : $hostname;
        if (!isset($cache[$h]) || !is_array($cache[$h]))
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
            if ($clearSettingsCache)
                MythBackend::find()->sendCommand(array('MESSAGE', 'CLEAR_SETTINGS_CACHE'));
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
                                                      WHERE value=? AND hostname LIKE ?',
                                                    $field, $hostname);
        }
    // Return the cached value
        return $cache[$h][$field];
    }

/**
 * Queries the database settings table for a particular setting, and returns its value
/**/
    function get_backend_setting($setting, $host = null) {
        if (is_null($host))
            $host = '%';
        return setting($setting, $host);
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
        return gmmktime(substr($sql_timestamp, 8,  2),    // hour
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
        global $db;
        return $db->escape($string);
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

        $url = stream_url."pl/stream/{$show->chanid}/{$show->recstartts}";
    // Handle specific file extension modes
        switch ($ext) {
        // ASX mode gets the streaming module, with a slight addition
            case 'asx' : return "$url.asx";
            case 'flvp': return "$url.flvp";
            case 'flv' : return "$url.flv";
            case 'mp4' : return "$url.mp4";
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

/**
 * Converts a myth timestamp into a unix timestamp
 * 1.0 cvs changed the format to:  2003-06-28T06:30:00
/**/
    function myth2unixtime($mythtime) {
        if (strlen($mythtime) < 1)
            return '';
        return strtotime(str_replace('T', ' ', $mythtime), "UTC");
    }

/**
 * Converts a unix timestamp into a myth timestamp
/**/
    function unix2mythtime($time) {
        return gmdate('Y-m-d\TH:i:s', $time);
    }
