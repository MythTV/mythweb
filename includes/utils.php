<?php
/***                                                                        ***\
    utils.php                                Last Updated: 2004.04.12 (xris)

    utility routines used throughout mythweb
\***                                                                        ***/

    //
    //  This file is part of MythWeb,
    //  a php-based interface into MythTV.
    //
    //  (c) 2002 by Thor Sigvaldason and Isaac Richards
    //  MythWeb is distributed under the
    //  GNU GENERAL PUBLIC LICENSE version 2
    //  (see http://www.gnu.org)
    //

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
        return $size.' B';
// Otherwise we keep going until the size is in the appropriate measurement range.
    elseif ($size < mb)
        return round($size / kb, ($size < 10 * kb)).' KB';
    elseif ($size < gb)
        return round($size / mb, ($size < 10 * mb)).' MB';
    elseif ($size < tb)
        return round($size / gb, ($size < 10 * gb)).' GB';
    else
        return round($size / tb, ($size < 10 * tb)).' TB';
}

function nice_length($length) {
    $mins  = (int) (($length % 3600) / 60);
    $hours = (int) ($length / 3600);
    if ($hours == 1)
        $ret = '1 '._LANG_HR;
    elseif ($hours > 0)
        $ret = $hours.' '._LANG_HRS;
    if ($mins > 0) {
        if ($ret)
            $ret .= ' ';
        $ret .= $mins.' '._LANG_MINS;
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
