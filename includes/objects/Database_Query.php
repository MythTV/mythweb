<?php
/**
 * This file was originally written by Chris Petersen for several different open
 * source projects.  It is distrubuted under the GNU General Public License.
 * I (Chris Petersen) have also granted a special LGPL license for this code to
 * several companies I do work for on the condition that these companies will
 * release any changes to this back to me and the open source community as GPL,
 * thus continuing to improve the open source version of the library.  If you
 * would like to inquire about the status of this arrangement, please contact
 * me personally.
 *
 * ---
 *
 * This is an abstract superclass that defines the basic variables and functions
 * used by possible subclasses.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @copyright   Silicon Mechanics
 * @license     GPL (LGPL for SiMech)
 *
 * @package     MythWeb
 * @subpackage  Database
 *
 * @uses        Database.php
 *
/**/

/**
 * Abstract superclass for all database query types.
/**/
class Database_Query {

/** @var resource   The related database connection handle */
    var $dbh = NULL;

/** @var resource   The current active statement handle */
    var $sh = NULL;

/** @var array      The query string, (depending on the engine, broken apart where arguments should be inserted) */
    var $query = array();

/** @var string     The most recent query sent to the server */
    var $last_query = '';

/** @var int        Number of arguments required by $query */
    var $num_args_needed = 0;

/**
 * Constructor.  Parses $query and splits it at ? characters for later
 * substitution in execute().  This should be overridden by engines like mysqli
 * that have their own variable insertion handlers.
 *
 * @param Database $dbh    The parent Database object
 * @param string   $query  The query string
/**/
    function __construct(&$db, $query) {
        $this->dbh             =  $db->dbh;
        $this->db              =& $db;
        $this->num_args_needed =  max(0, substr_count($query, '?') - substr_count($query, '\\?'));
    // Build an optimized version of the query
        if ($this->num_args_needed > 0) {
            $this->query = array();
            foreach (preg_split('/(\\\\?\\?)/', $query, -1, PREG_SPLIT_DELIM_CAPTURE) as $part) {
                switch ($part) {
                    case '?':
                        break;
                    case '\\?':
                        $this->query[min(0, count($this->query) - 1)] .= '?';
                        break;
                    default:
                        $this->query[] = $part;
                }
            }
        }
        else
            $this->query = array($query);
    }

/**
 * Legacy constructor.
/**/
    function Database_Query(&$db, $query) {
        return $this->__construct(&$db, $query);
    }

}

