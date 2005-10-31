<?php
/*
 *  $Date$
 *  $Revision$
 *  $Author$
 *
 *  utils.php
 *
 *    utility routines used throughout mythweb
 *
/*/

// Set up some constants used by nice_filesystem()
    define('kb', 1024);         // Kilobyte
    define('mb', 1024 * kb);    // Megabyte
    define('gb', 1024 * mb);    // Gigabyte
    define('tb', 1024 * gb);    // Terabyte

/*
 *  setting:
 *    get or set a database setting
/*/
    function setting($field, $new_value = "old\0old") {
        static $cache = array();
        global $db;
    // Assigning a new value
        if ($new_value !== "old\0old") {
            $db->query('REPLACE INTO settings (value, data) VALUES (?,?)',
                       $field, $new_value);
            $cache[$field] = $new_value;
        }
    // Not cached?
        elseif (!array_key_exists($field, $cache)) {
            $sh = $db->query('SELECT data FROM settings WHERE value=?',
                             $field);
            list($cache[$field]) = $sh->fetch_row();
            $sh->finish();
        }
    // Return the cached value
        return $cache[$field];
    }

/**
 * smart_args:
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

/*
 *  fix_crlfxy:
 *    Recursively fixes silly \r\n stuff that some browsers send.
 *    Also adds a generic entry for fiends ending in _x or _y to better deal
 *    with image inputs.
/*/
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

/*
 *  fix_magic_quotes:
 *    Recursively strip slashes from an array (eg. $_GET).
/*/
	function &fix_magic_quotes(&$array) {
		foreach ($array as $key => $val) {
			if (is_array($val))
				fix_magic_quotes($array[$key]);
			else
				$array[$key] = stripslashes($val);
		}
		return $array;
	}

/*
 *  redirect_browser:
 *  Print a redirect header and exit
/*/
    function redirect_browser($url) {
        header("Location: $url");
        echo "\n";
        exit;
    }

/*
 *  nice_filesize:
 *  pass in a filesize in bytes, and receive a more human-readable version
 *  JS: adapted from php.net: sponger 10-Jun-2002 12:28
/*/
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

    function nice_length($length) {
        $mins  = (int) (($length % 3600) / 60);
        $hours = (int) ($length / 3600);
        if ($hours)
            $ret = tn('$1 hr', '$1 hrs', $hours);
        else
            $ret = '';
        if ($mins > 0) {
            if ($ret)
                $ret .= ' ';
            $ret .= tn('$1 min', '$1 mins', $mins);
        }
        return $ret;
    }


/*
 *  unixtime:
 *  converts an sql timestamp into unixtime
/*/
    function unixtime($sql_timestamp) {
        return mktime(substr($sql_timestamp, 8, 2),     // hour
                      substr($sql_timestamp, 10, 2),    // minute
                      substr($sql_timestamp, 12, 2),    // second
                      substr($sql_timestamp, 4, 2),     // month
                      substr($sql_timestamp, 6, 2),     // day
                      substr($sql_timestamp, 0, 4));    // year
    }

/*  DEPRECATED -- use db.php routines instead!!
 *  escape:
 *  For lack of a function that escapes strings AND adds quotes, I wrote one
 *  myself to make the rest of my code read a bit easier.
/*/
    function escape($string, $allow_null = false) {
    // Null?
        if ($allow_null && is_null($string))
            return 'NULL';
    // Just a string
        $string = mysql_escape_string($string); // Do this beforehand in case someone passes in a reference
        return "'$string'";
    }

/*
 *  get_sorted_files:
 *  Returns a sorted list of files in a directory, minus . and ..
/*/
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

/*
 *  _or:
 *  returns $this or $or_this
 *  if $gt is set to true, $this will only be returned if it's > 0
 *  if $gt is set to a number, $this will only be returned if it's > $gt
/*/
    function _or($this, $or_this, $gt = false) {
        if ($gt === true)
            return $this > 0 ? $this : $or_this;
        if (!empty($gt))
            return $this > $gt ? $this : $or_this;
        return $this ? $this : $or_this;
    }

/*
 *  video_url:
 *  returns video_url constant, or sets it according to the browser type
/*/
    function video_url() {
    // Not defined?
        if (!video_url || video_url == 'video_url') {
        // Mac and Linux just get a link to the direectory
            if (preg_match('/\b(?:linux|macintosh|mac\s+os\s*x)\b/i', $_SERVER['HTTP_USER_AGENT']))
                define('video_url', video_dir);
        // Windows likely gets a myth:// url
            else {
                global $Master_Host, $Master_Port;
            // Is either the browser xor the master in an rfc 1918 zone?
                if (preg_match('/^(?:10|192\.168|172\.(?:1[6-9]|2[0-9]|3[0-6]))\./', $Master_Host)
                        xor preg_match('/^(?:10|192\.168|172\.(?:1[6-9]|2[0-9]|3[0-6]))\./', $_SERVER['REMOTE_ADDR'])) {
                    define('video_url', video_dir);
                }
            // Send the myth url
                else {
                    define('video_url', "myth://$Master_Host:$Master_Port");
                }
            }
        }
    // Return
        return video_url;
    }

/*
 *  utf8tolocal:
 *  returns strings convert UTF-8 to local encoding
/*/
    function utf8tolocal($str) {
        if (!defined("fs_encoding") || fs_encoding == '')
            return $str;
        if (function_exists('mb_convert_encoding'))
            return mb_convert_encoding($str, fs_encoding, 'UTF-8');
        if (function_exists('iconv'))
            return iconv($int_encoding, fs_encoding, $str);
        if (function_exists('recode_string'))
            return recode_string("UTF-8.." . fs_encoding, $str);

        return $str;
    }

/*
 *  DEBUG:
 *  prints out a piece of data
/*/
    function DEBUG($data, $file = false) {
    // Catch our data into a string
        ob_start();
        if (is_array($data) || is_object($data))
            print_r($data);
        elseif (isset($data))
            echo $data;
        else
            echo 'NULL';
        $str = ob_get_contents();
        ob_end_clean();
    // Print the message
        echo '<hr><pre>'.$str.'</pre><hr>';
    // Print to a file?
        if ($file) {
            $out = fopen('/tmp/debug.txt', 'a');
            fwrite($out, "$str\n");
            fclose($out);
        }
    }

    function fequals($lhs, $rhs) {
        $epsilon = 1e-3;
        return abs($lhs - $rhs) <= $epsilon * abs($lhs);
    }

