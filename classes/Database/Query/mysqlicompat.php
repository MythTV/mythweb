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
 * Query handler for the "compatible" version of the improved MySQL engine.
 * This is also the parent class for the full/expanded mysqli query object,
 * since many of the routines are shared between them.
 *
 * @copyright   Silicon Mechanics
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Database
 *
 * @uses        Database.php
 * @uses        Database_mysqlicompat.php
 * @uses        Database_Query.php
 *
/**/

/**
 * The basic mysqli database query type.
/**/
class Database_Query_mysqlicompat extends Database_Query {

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
            trigger_error('Database_Query_mysqlicompat called with '.count($args)." arguments, but requires $this->num_args_needed.", E_USER_ERROR);
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
                                        : "'".mysqli_real_escape_string($this->dbh, $arg)."'";
            }
        }
    // Perform the query
    // If we don't have a valid connection, fataly error out.
        if ($this->dbh === false) {
            $this->db->error();
            trigger_error($this->db->error, E_USER_ERROR);
        }
        $this->sh = mysqli_query($this->dbh, $this->last_query);

    // Cache  these so the warning count below doesn't interfere
        if (is_bool($this->sh)) {
            $this->insert_id     = mysqli_insert_id($this->dbh);
            $this->affected_rows = mysqli_affected_rows($this->dbh);
        }
        else {
            $this->num_rows      = mysqli_num_rows($this->sh);
        }

    // On each execute, we clear the warnings of the statement handle, so it doesn't
    // store them up
        $this->warnings = array();
    // Check the warnings and store them
        if (mysqli_warning_count($this->dbh)) {
            if ($sh = mysqli_query($this->dbh, 'SHOW WARNINGS')) {
                while ($row = mysqli_fetch_row($sh))
                    $this->warnings[] = array( '#'   => $row[1],
                                               'MSG' => $row[2] );
                mysqli_free_result($sh);
            // This is used in errors.php to output in the backtrace
                global $_DEBUG;
                $_DEBUG['Database Warnings'][] = array( 'Query'    => $this->last_query,
                                                        'Warnings' => $this->warnings );
            }
        }

        if ($this->sh === false) {
            if ($this->db->fatal_errors)
                trigger_error('SQL Error: '.mysqli_error($this->dbh).' [#'.mysqli_errno($this->dbh).']', E_USER_ERROR);
            else
                $this->db->error();
        }
    }

/**
 * The following routines basically replicate the mysqli functions built into
 * php.  The only difference is that the resource handle gets passed-in
 * automatically.  eg.
 *
 *      mysqli_fetch_row($result);   ->  $sh->fetch_row();
 *      mysqli_affected_rows($dbh);  ->  $sh->affected_rows();
/**/

/**
 * Fetch a single column
 * @return mixed
/**/
    function fetch_col() {
        list($return) = mysqli_fetch_row($this->sh);
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
 * @link http://www.php.net/manual/en/function.mysqli-fetch-row.php
 * @return array
/**/
    function fetch_row() {
        return mysqli_fetch_row($this->sh);
    }

/**
 * Fetch a single assoc row
 *
 * @link http://www.php.net/manual/en/function.mysqli-fetch-assoc.php
 * @return assoc
/**/
    function fetch_assoc() {
        return mysqli_fetch_assoc($this->sh);
    }

/**
 * Fetch a single row as an array containing both numeric and assoc fields
 *
 * @link http://www.php.net/manual/en/function.mysqli-fetch-array.php
 * @return assoc
/**/
    function fetch_array($result_type=MYSQLI_BOTH) {
        return mysqli_fetch_array($this->sh, $result_type);
    }

/**
 * Fetch a single row as an object
 *
 * @link http://www.php.net/manual/en/function.mysqli-fetch-object.php
 * @return object
/**/
    function fetch_object() {
        return mysqli_fetch_object($this->sh);
    }

/**
 * @link http://www.php.net/manual/en/function.mysqli-data-seek.php
 * @return bool
/**/
    function data_seek($row_number) {
        return mysqli_data_seek($this->sh, $row_number);
    }

/**
 * @link http://www.php.net/manual/en/function.mysqli-num-rows.php
 * @return int
/**/
    function num_rows() {
        return $this->num_rows;
    }

/**
 * @link http://www.php.net/manual/en/function.mysqli-data-seek.php
 * @return int
/**/
    function affected_rows() {
        return $this->affected_rows;
    }

/**
 * @link http://www.php.net/manual/en/function.mysqli-insert-id.php
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
            mysqli_free_result($this->sh);
        unset($this->sh);
    }

}
