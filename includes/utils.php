<?php
/***                                                                        ***\
    utils.php                                Last Updated: 2004.11.29 (xris)

    utility routines used throughout mythweb
\***                                                                        ***/

// Make sure we have the translation module loaded
    require_once('includes/translate.php');

// Set up some constants used by nice_filesystem()
    define('kb', 1024);         // Kilobyte
    define('mb', 1024 * kb);    // Megabyte
    define('gb', 1024 * mb);    // Gigabyte
    define('tb', 1024 * gb);    // Terabyte

/*
    nice_filesize:
    pass in a filesize in bytes, and receive a more human-readable version
    JS: adapted from php.net: sponger 10-Jun-2002 12:28
*/
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
    unixtime:
    converts an sql timestamp into unixtime
*/
    function unixtime($sql_timestamp) {
        return mktime(substr($sql_timestamp, 8, 2),     // hour
                      substr($sql_timestamp, 10, 2),    // minute
                      substr($sql_timestamp, 12, 2),    // second
                      substr($sql_timestamp, 4, 2),     // month
                      substr($sql_timestamp, 6, 2),     // day
                      substr($sql_timestamp, 0, 4));    // year
    }

/*
    escape:
    For lack of a function that escapes strings AND adds quotes, I wrote one
    myself to make the rest of my code read a bit easier.
*/
    function escape($string, $allow_null = false) {
    // Null?
        if ($allow_null && is_null($string))
            return 'NULL';
    // Just a string
        $string = mysql_escape_string($string); // Do this beforehand in case someone passes in a reference
        return "'$string'";
    }

/*
    get_sorted_files:
    Returns a sorted list of files in a directory, minus . and ..
*/
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
    _or:
    returns $this or $or_this
*/
    function _or($this, $or_this) {
        return $this ? $this : $or_this;
    }

/*
    video_url:
    returns video_url constant, or sets it according to the browser type
*/
    function video_url() {
    // Not defined?
        if (!video_url || video_url == 'video_url') {
        // Mac and Linux just get a link to the direectory
            if (preg_match('/\b(?:linux|macintosh|mac\s+os\s*x)\b/i', $_SERVER['HTTP_USER_AGENT']))
                define('video_url', video_dir);
        // Windows gets a myth:// url
            else {
                global $Master_Host, $Master_Port;
                define('video_url', "myth://$Master_Host:$Master_Port");
            }
        }
    // Return
        return video_url;
    }

/*
    utf8tolocal:
    returns strings convert UTF-8 to local encoding
*/
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
    DEBUG:
    prints out a piece of data
*/
    function DEBUG($data) {
        echo "<hr>";
        if (is_array($data) || is_object($data)) {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        }
        elseif (isset($data))
            echo $data;
        else
            echo "NULL";
        echo "<hr>";
    }

?>
