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
 * Query handler for MySQL
 *
 * @copyright   Silicon Mechanics
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Database
 *
 * @uses        Database.php
 * @uses        Database_mysql.php
 * @uses        Database_Query.php
 *
/**/

/**
 * The basic MySQL database query type.
/**/
class Database_Query_mysql extends Database_Query {

/**
 * Executes the query that was previously passed to the constructor.
 *
 * @param mixed  $arg      Query arguments to escape and insert at ? placeholders in $query
 * @param mixed  ...       Additional arguments
/**/
    function execute() {
    // Load the function arguments, minus the query itself, which we already extracted
        $args = func_get_args();
    // Split out sub-arrays, etc..
        $args = Database::smart_args($args);
    // Were enough arguments passed in?
        if (count($args) != $this->num_args_needed)
            trigger_error('Database_Query called with '.count($args)." arguments, but requires $this->num_args_needed.", E_USER_ERROR);
    // Finish any previous statements
        $this->finish();
    // Replace in the arguments
        $this->last_query = '';
        foreach ($this->query as $part) {
            $this->last_query .= $part;
            if (count($args)) {
                $arg = array_shift($args);
                $this->last_query .= is_null($arg)
                                        ? 'NULL'
                                        : "'".mysql_real_escape_string($arg)."'";
            }
        }
    // Perform the query
    // If we don't have a valid connection, fataly error out.
        if ($this->dbh === false) {
            $this->db->error();
            trigger_error($this->db->error, E_USER_ERROR);
        }
        $this->sh = mysql_query($this->last_query, $this->dbh);

    // Cache these
        if (is_bool($this->sh)) {
            $this->insert_id     = mysql_insert_id($this->dbh);
            $this->affected_rows = mysql_affected_rows($this->dbh);
        }
        else {
            $this->num_rows      = mysql_num_rows($this->sh);
        }

        if ($this->sh === false) {
            if ($this->db->fatal_errors)
                trigger_error('SQL Error: '.mysql_error($this->dbh).' [#'.mysql_errno($this->dbh).']', E_USER_ERROR);
            else
                $this->db->error();
        }
    }

/**
 * The following routines basically replicate the mysql functions built into
 * php.  The only difference is that the resource handle gets passed-in
 * automatically.  eg.
 *
 *      mysql_fetch_row($result);   ->  $sh->fetch_row();
 *      mysql_affected_rows($dbh);  ->  $sh->affected_rows();
/**/

/**
 * Fetch a single column
 * @return mixed
/**/
    function fetch_col() {
        list($return) = mysql_fetch_row($this->sh);
        return $return;
    }

    function fetch_cols() {
        $return = array();
        while ($col = $this->fetch_col())
            $return[] = $col;
        return $return;
    }

/**
 * Fetch a single row
 *
 * @link http://www.php.net/manual/en/function.mysql-fetch-row.php
 * @return array
/**/
    function fetch_row() {
        return mysql_fetch_row($this->sh);
    }

/**
 * Fetch a single assoc row
 *
 * @link http://www.php.net/manual/en/function.mysql-fetch-assoc.php
 * @return assoc
/**/
    function fetch_assoc() {
        return mysql_fetch_assoc($this->sh);
    }

/**
 * Fetch a single row as an array containing both numeric and assoc fields
 *
 * @link http://www.php.net/manual/en/function.mysql-fetch-array.php
 * @return assoc
/**/
    function fetch_array($result_type=MYSQL_BOTH) {
        return mysql_fetch_array($this->sh, $result_type);
    }

/**
 * Fetch a single row as an object
 *
 * @link http://www.php.net/manual/en/function.mysql-fetch-object.php
 * @return object
/**/
    function fetch_object() {
        return mysql_fetch_object($this->sh);
    }

/**
 * @link http://www.php.net/manual/en/function.mysql-data-seek.php
 * @return bool
/**/
    function data_seek($row_number) {
        return mysql_data_seek($this->sh, $row_number);
    }

/**
 * @link http://www.php.net/manual/en/function.mysql-num-rows.php
 * @return int
/**/
    function num_rows() {
        return $this->num_rows;
    }

/**
 * @link http://www.php.net/manual/en/function.mysql-data-seek.php
 * @return int
/**/
    function affected_rows() {
        return $this->affected_rows;
    }

/**
 * @link http://www.php.net/manual/en/function.mysql-insert-id.php
 * @return int
/**/
    function insert_id() {
        return $this->insert_id;
    }

/**
 * For anal people like me who like to free up memory manually
/**/
    function finish() {
        if ($this->sh && is_resource($this->sh))
            mysql_free_result($this->sh);
        unset($this->sh);
    }

}
