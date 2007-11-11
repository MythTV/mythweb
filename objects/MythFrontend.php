<?php
/**
 * Connection routines for the new socket interface to mythfrontend.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythTV
 *
/**/

/**
 * A connection to a particular frontend
/**/
class MythFrontend {

/** @var resource   File pointer to the socket connection. */
    var $fp;

/** @var bool       Connected?. */
    var $connected = false;

/** @var string     Hostname to connect to. */
    var $host;
/** @var string     Hostname to connect to. */
    var $port;

/** @var array      List of jump points available on this host. */
    var $jump_points = array();

/**
 * Object constructor
 *
 * @param string $host Hostname or IP for this frontend.
 * @param int    $port TCP port to connect to.
/**/
    function __construct($host, $port) {
        $this->host = $host;
        $this->port = $port;
    }

/**
 * Placeholder constructor for php4 compatibility
 *
 * @param string $host Hostname or IP for this frontend.
 * @param int    $port TCP port to connect to.
/**/
    function &MythFrontend($host, $port) {
        return $this->__construct($host, $port);
    }

/**
 * Disconnect when destroying the object.
/**/
    function __destruct() {
       $this->_disconnect();
   }

/**
 * Open a connection to this frontend.  This also serves as a ping to verify
 * that a frontend is running.
 *
 * @param int $timeout Connection timeout, set low in case the host isn't
 *                     actually on.
/**/
    function connect($timeout = 5) {
        if ($this->fp)
            return true;
    // Connect.
        $this->fp = @fsockopen($this->host, $this->port, $errno, $errstr, $timeout);
        if ($this->fp === false)
            return false;
    // Read the waiting data.
        $data = $this->_get_response(null, true);
        if (strstr($data, '#'))
            return $this->connected = true;
    // Something went wrong (returns false)
        return $this->_disconnect();
    }

/**
 * Disconnect from this frontend
/**/
    function _disconnect() {
        if ($this->fp) {
            fclose($this->fp);
            $this->fp = null;
        }
        return $this->connected = false;
    }

/**
 * Get the response to a query as a string, or an awaiting response buffer if
 * $query is null.
 *
 * @param string $query The query to send, or null
 *
 * @return string The response to $query
/**/
    function _get_response($query, $keep_hash=false) {
        if (!$this->connect())
            return null;
    // Write some data?
        if (!is_null($query))
            fputs($this->fp, preg_replace('/\s*$/', "\n", $query));
    // Get some results
        $recv = '';
        while (true) {
            $data = fread($this->fp, 1024);
            $recv .= $data;
            if (strlen($data) < 1 || strstr($data, '#'))
                break; // EOF
        }
        if ($keep_hash)
            return rtrim($recv);
        else
            return preg_replace('/[\s#]*$/', '', $recv);
    }

/**
 * Call _get_response and return its string broken into an array.
 *
 * @param string $query The query to send, or null
 *
 * @return array The response to $query, broken into an array
/**/
    function _get_rows($query, $sep="\n") {
        $r = $this->_get_response($query);
        return $r ? explode($sep, $r) : $r;
    }

/**
 * Load and return the jump points available for this frontend.
 *
 * @return array The jump points available for this frontend
/**/
    function get_jump_points() {
        if (empty($this->jump_points) || !is_array($this->jump_points)) {
            $this->jump_points = array();
            foreach ($this->_get_rows('help jump') as $line) {
                if (preg_match('/(\w+)\s+- (.*)/', $line, $matches)) {
                    $this->jump_points[$matches[1]] = $matches[2];
                }
            }
        }
        return $this->jump_points;
    }

/**
 * Return the location, or a status message that the frontend isn't running.
 *
 * @return string Location of the frontend.
/**/
    function query_location() {
        $ret = $this->_get_response('query location');
        if (empty($ret))
            return 'OFFLINE';
        return $ret;
    }

/**
 * Send a query to the frontend
 *
 * @param string $query The key to send.
/**/
    function query($query) {
        $lines = $this->_get_rows("query $query");
        return $lines;
    }

/**
 * Send a keypress to the frontend
 *
 * @param string $jump_point The key to send.
/**/
    function send_key($key) {
        $lines = $this->_get_rows("key $key");
        if (trim($lines[0]) == 'OK')
            return true;
        return false;
    }

/**
 * Send the frontend to a specific jump point.
 *
 * @param string $jump_point The jump point to send.
/**/
    function send_jump($jump_point) {
        $lines = $this->_get_rows("jump $jump_point");
        if (trim($lines[0]) == 'OK')
            return true;
        return false;
    }

/**
 * Send a playback command to the frontend.
 *
 * @param string $options The playback parameters to pass in.
/**/
    function send_play($options) {
        $lines = $this->_get_rows("play $options");
        if (trim($lines[0]) == 'OK')
            return true;
        return false;
    }


}

