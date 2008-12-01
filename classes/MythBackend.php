<?php
/**
 *
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/classes/MythFrontend.php $
 * @date        $Date: 2008-11-25 22:47:35 -0800 (Tue, 25 Nov 2008) $
 * @version     $Revision: 19160 $
 * @author      $Author: kormoc $
 * @license     GPL
 *
 * @package     MythTV
 *
/**/

class MythBackend {

// MYTH_PROTO_VERSION is defined in libmyth in mythtv/libs/libmyth/mythcontext.h
// and should be the current MythTV protocol version.
    static $protocol_version        = 42;

// The character string used by the backend to separate records
    static $backend_separator       = '[]:[]';

// NUMPROGRAMLINES is defined in mythtv/libs/libmythtv/programinfo.h and is
// the number of items in a ProgramInfo QStringList group used by
// ProgramInfo::ToSringList and ProgramInfo::FromStringList.
    static $program_line_number     = 47;

    private $fp                     = null;
    private $connected              = false;
    private $host                   = null;
    private $port                   = null;

    static function find($host = null, $port = 6543) {
        static $Backends = array();

    // Looking for the master backend?
        if (is_null($host)) {
            $host = setting('MasterServerIP');
            $port = setting('MasterServerPort');
            if (!$host || !$port)
                trigger_error("MasterServerIP or MasterServerPort not found! You may"
                            ."need to check your settings.php file or re-run mythtv-setup",
                            FATAL);
        }

        if (!isset($Backend[$host][$port]))
            $Backend[$host][$port] = new MythBackend($host, $port);
        return $Backend[$host][$port];
    }

    function __construct($host, $port) {
        $this->host = $host;
        $this->port = $port;
    }

    function __destruct() {
        $this->disconnect();
    }

    private function connect() {
        if ($this->connected)
            return;
        $this->fp = @fsockopen($this->host, $this->port, $errno, $errstr, 25);
        if (!$this->fp)
            custom_error("Unable to connect to the master backend at {$this->host}:{$this->port}.\nIs it running?");
        $this->connected = true;
        socket_set_timeout($this->fp, 20);
        $this->checkProtocolVersion();
        $this->announce();
    }

    private function disconnect() {
        if (!$this->connected)
            return;
        $this->sendCommand('DONE');
        fclose($this->fp);
        $this->connected = false;
    }

    private function checkProtocolVersion() {
    // Allow overriding this check
        if ($_SERVER['ignore_proto'] == true )
            return true;

        if ($_SESSION['backend']['proto_version']['last_check_time'] - time() < 60*60*24)
            return true;

        $response = $this->sendCommand('MYTH_PROTO_VERSION '.MythBackend::$protocol_version);

        if ($response == 'ACCEPT') {
            $_SESSION['backend']['proto_version']['last_check_time'] = time();
            return true;
        }

        if ($response == 'REJECT')
            trigger_error("Incompatible protocol version (mythweb=" . MythBackend::$protocol_version . ", backend=" . $response . ")");
        else
            trigger_error("Unexpected response to MYTH_PROTO_VERSION '".MythBackend::$protocol_version."': ".$response);
        return false;
    }

    private function announce() {
        $response = $this->sendCommand('ANN Monitor '.hostname.' 0');
        if ($response == 'OK')
            return true;
        return false;
    }

    public function setTimezone() {
        if (!is_string($_SESSION['backend']['timezone']['value']) || $_SESSION['backend']['timezone']['last_check_time'] - time() > 60*60*24) {
            $timezone = $this->sendCommand('QUERY_TIME_ZONE');
            $timezone = str_replace(' ', '_', $timezone[0]);
            $_SESSION['backend']['timezone']['value']           = $timezone;
            $_SESSION['backend']['timezone']['last_check_time'] = time();
        }

        if (!@date_default_timezone_set($_SESSION['backend']['timezone']['value']))
            trigger_error('Failed to set php timezone to '.$_SESSION['backend']['timezone']['value']);
    }

    public function sendCommand($command = null) {
        $this->connect();
        if (is_array($command))
            $command = implode(MythBackend::$backend_separator, $command);
    // The format should be <length + whitespace to 8 total bytes><data>
        $command = strlen($command) . str_repeat(' ', 8 - strlen(strlen($command))) . $command;
        fputs($this->fp, $command);

    // Read the response header to find out how much data we'll be grabbing
        $length = rtrim(fread($this->fp, 8));

    // Read and return any data that was returned
        $response = '';
        while ($length > 0) {
            $data = fread($this->fp, min(8192, $length));
            if (strlen($data) < 1)
                break; // EOF
            $response .= $data;
            $length -= strlen($data);
        }
        $response = explode(MythBackend::$backend_separator, $response);
        if (count($response) == 1)
            return $response[0];
        if (count($response) == 0)
            return false;
        return $response;
    }

    public function queryProgramRows($query = null, $offset = 1) {
        $records = $this->sendCommand($query);
    // Parse the records, starting at the offset point
        $row = 0;
        $col = 0;
        $count = count($records);
        for($i = $offset; $i < $count; $i++) {
            $rows[$row][$col] = $records[$i];
        // Every $NUMPROGRAMLINES fields (0 through ($NUMPROGRAMLINES-1)) means
        // a new row.  Please note that this changes between myth versions
            if ($col == (MythBackend::$program_line_number - 1)) {
                $col = 0;
                $row++;
            }
        // Otherwise, just increment the column
            else
                $col++;
        }
    // Lastly, grab the offset data (if there is any)
        for ($i=0; $i < $offset; $i++) {
            $rows['offset'][$i] = $recs[$i];
        }
    // Return the data
        return $rows;
    }

/**
 * Tell the backend to reschedule a particular record entry.  If the change
 * isn't specific to a single record entry (e.g. channel or record type
 * priorities), then use 0.  I don't think mythweb should need it, but if you
 * need to indicate every record rule is affected, then use -1.
/**/
    public function rescheduleRecording($recordid = -1) {
        $this->sendCommand('RESCHEDULE_RECORDINGS '.$recordid);
    }
}
