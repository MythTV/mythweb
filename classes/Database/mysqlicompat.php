<?php
/**
 * This file was originally written by Chris Petersen for several different open
 * source projects.  It is distrubuted under the GNU General Public License.
 * I (Chris Petersen) have also granted a special LGPL license for this code to
 * several companies I do work for on the condition that these companies will
 * release any changes to this back to me and the open source community as GPL,
 * thus continuing to improve the open source version of the library.  If you
 * would like to inquire about the status of this arrangement, please contact
 * me personally.
 *
 * ---
 *
 * This is a special object intended to allow users to connect to the mysqli
 * engine provided that it is available and the database version is recent
 * enough.  The parent Database class will first connect with the legacy mysql
 * engine and then check the database version.  If everything checks out, a new
 * connection will be opened using this library.  This library contains fewer
 * feature than the full mysqli library, but attempts better backwards
 * compatibility so programs can take advantage of the better integration of
 * mysqli but still run on older installations.
 *
 * @copyright   Silicon Mechanics
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Database
 *
 * @uses        Database.php
 * @uses        Database_Query_mysqlicompat.php
 *
/**/

/**
 * Database connection class for mysqli, the improved mysql engine.
/**/
class Database_mysqlicompat extends Database {

/**
 * Constructor
 *
 * @param string $db_name   Name of the database we're connecting to
 * @param string $login     Login name to use when connecting
 * @param string $password  Password to use when connecting
 * @param string $server    Database server to connect to (Default: localhost)
 * @param string $port      Port or socket address to connect to
/**/
    function __construct($db_name, $login, $password, $server='localhost', $port=NULL) {
    // Attempt to make sure the extension is loaded
        if (!extension_loaded('mysql')) {
        // This function is deprecated as of php5, so we see if we can use it
            if (function_exists('dl')) {
            // Attempt to allow dl to be used
                ini_set('enable_dl', true);
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
                    dl('php_mysql.dll');
                else
                    dl('mysql.so');
            }
        }
    // Connect to the database
        $this->dbh = @mysqli_connect($server, $login, $password, NULL, $port)
            or $this->error("Can't connect to the database server.");
        if ($this->dbh) {
            @mysqli_select_db($this->dbh, $db_name)
                or $this->error("Can't access the database file.");
        }
    }

/**
 * Escapes a string and returns it with added quotes. On top of normal escaping,
 * this also escapes ? characters so it's safe to use in other db queries.
 *
 * @param string $string    string to escape
 *
 * @return string           escaped string
/**/
    function escape($string) {
    // Null?
        if (is_null($string))
            return 'NULL';
    // Just a string
        return str_replace('?', '\\?', "'".mysqli_real_escape_string($this->dbh, $string)."'");
    }

/**
 * Changes the regexp-special square brackets used for character class/range
 * operations to the "match any single character" operator, '.'.  This function
 * does not do database-special character escapes.
 *
 * @param string $string    string to escape
 *
 * @return string           escaped string
/**/
    function escape_regex($string) {
    // Null?
        if (is_null($string))
            return 'NULL';
    // Just a string
        $escaped_string = str_replace('[', '.', $string);
        return str_replace(']', '.', $escaped_string);
    }

/**
 *  Returns an un-executed Database_Query_mysqlicompat object
 *
 *  @param string $query    The query string
 *
 *  @return Database_Query_mysqli
/**/
    function &prepare($query) {
        $new_query = new Database_Query_mysqlicompat($this, $query);
        return $new_query;
    }

/**
 * @return string The most recent error string
/**/
    function _errstr() {
        return $this->dbh ? mysqli_error($this->dbh) : mysqli_connect_error();
    }

/**
 * @return int The most recent error number
/**/
    function _errno() {
        return $this->dbh ? mysqli_errno($this->dbh) : mysqli_connect_errno();
    }

/**
 * @return string Information about the mysql server
/**/
    function server_info() {
        return mysqli_get_server_info($this->dbh);
    }

/**
 * @return bool true on success
/**/
    function close() {
        return mysqli_close($this->dbh);
    }

}

