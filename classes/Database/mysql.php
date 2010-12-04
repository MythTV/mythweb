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
 * MySQL Database connection class.
 *
 * @copyright   Silicon Mechanics
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Database
 *
 * @uses        Database.php
 * @uses        Database_Query_mysql.php
 *
/**/

/**
 * Database connection class for mysql.
/**/
class Database_mysql extends Database {

/**
 * Constructor
 *
 * @param string $db_name      Name of the database we're connecting to
 * @param string $login        Login name to use when connecting
 * @param string $password     Password to use when connecting
 * @param string $server       Database server to connect to (Default: localhost)
 * @param string $port         Port or socket address to connect to
/**/
    function __construct($db_name, $login, $password, $server='localhost', $port=NULL, $options=NULL) {
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
        $this->dbh = @mysql_connect($port ? "$server:$port" : $server, $login, $password)
            or $this->error("Can't connect to the database server.");
        if ($this->dbh) {
            @mysql_select_db($db_name, $this->dbh)
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
        return str_replace('?', '\\?', "'".mysql_real_escape_string($string, $this->dbh)."'");
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
 *  Returns an un-executed Database_Query_mysql object
 *
 *  @param string $query    The query string
 *
 *  @return Database_Query_mysql
/**/
    function &prepare($query) {
        $new_query = new Database_Query_mysql($this, $query);
        return $new_query;
    }

/**
 * @return string The most recent error string
/**/
    function _errstr() {
        return $this->dbh ? mysql_error($this->dbh) : mysql_error();
    }

/**
 * @return int The most recent error number
/**/
    function _errno() {
        return $this->dbh ? mysql_errno($this->dbh) : mysql_errno();
    }

/**
 * @return string Information about the mysql server
/**/
    function server_info() {
        return mysql_get_server_info($this->dbh);
    }

/**
 * @return bool true on success
/**/
    function close() {
        return mysql_close($this->dbh);
    }

}
