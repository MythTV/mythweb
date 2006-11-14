<?php
/**
 * Routines that allow mythweb to communicate with mythbackend
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// The character string used by the backend to separate records
    define('backend_sep', '[]:[]');

// MYTH_PROTO_VERSION is defined in libmyth in mythtv/libs/libmyth/mythcontext.h
// and should be the current MythTV protocol version.
    define('MYTH_PROTO_VERSION', 31);

// NUMPROGRAMLINES is defined in mythtv/libs/libmythtv/programinfo.h and is
// the number of items in a ProgramInfo QStringList group used by
// ProgramInfo::ToSringList and ProgramInfo::FromStringList.
    $NUMPROGRAMLINES = 42;

// Keep track of the master backend port/ip
    $Master_Host = get_backend_setting('MasterServerIP');
    $Master_Port = get_backend_setting('MasterServerPort');
    if (!$Master_Host || !$Master_Port)
        trigger_error("MasterServerIP or MasterServerPort not found! You may"
                      ."need to check your settings.php file or re-run mythtv-setup",
                      FATAL);

// Make sure we're connected to mythbackend
    if (backend_command('ANN Monitor '.hostname.' 0') != 'OK')
        trigger_error("Unable to connect to mythbackend, is it running?\n", FATAL);

/**
 * Queries the database settings table for a particular setting, and returns its value
/**/
    function get_backend_setting($setting, $host = false) {
        global $db;
        static $cache = array();
    // Initialize the extra parameter as an empty array so the query doesn't
    // freak out if $extra_query doesn't get set.
        $extra_param  = array();
    // Do we have a hostname?
        if ($host) {
        // Do we have a cached value for this host?
            if (isset($cache[$host][$setting]))
                return $cache[$host][$setting];
        // Nope, continue formatting the query
            $extra_query = ' AND hostname=?';
            $extra_param = $host;
        }
    // No hostname, but do we have a cached value?
        elseif (isset($cache['-unknown-'][$setting]))
            return $cache['-unknown-'][$setting];
    // Make the query
        $value = $db->query_col('SELECT data FROM settings WHERE value=?'.$extra_query,
                                $setting,
                                $extra_param);
    // Cache the result
        if ($host)
            $cache[$host][$setting] = $value;
        else
            $cache['-unknown-'][$setting] = $value;
    // Return
        return $value;
    }

/**
 * Executes the requested command and returns the backend's response string
 * @todo JS: haven't tested UTF-8
/**/
    function backend_command($command, $host = NULL, $port = NULL) {
        global $Master_Host, $Master_Port;
    // Use a static cache of hosts
        static $cache;
        if (!$cache)
            $cache = array($Master_Host => array($Master_Port => $fp));
    // Default values
        if (!$host || !$port) {
            $host = $Master_Host;
            $port = $Master_Port;
        }
    // Need a new file pointer?
        if (!$cache[$host][$port]) {
            $cache[$host][$port] = NULL;
        }
    // Execute the command
        return backend_command2($command, $cache[$host][$port], $host, $port);
    }

/**
 * A second backend command, so we can allow certain routines to use their own file pointer
/**/
    function backend_command2($command, &$fp, $host=NULL, $port=NULL) {
    // Command is an array -- join it
        if (is_array($command))
            $command = implode(backend_sep, $command);
    // Default values
        if (!$host || !$port) {
            global $Master_Host, $Master_Port;
            $host = $Master_Host;
            $port = $Master_Port;
        }
    // Open a connection to the master backend, unless we've already done so
        if (!$fp) {
            $fp = @fsockopen($host, $port, $errno, $errstr, 25);
            if ($fp)
                check_proto_version($host, $port);
            else
                custom_error("Unable to connect to the master backend at $host:$port.\n"
                             ."Is it running?");
        }
    // Connection opened, let's do something
        if ($fp) {
        // Build the command string
        // The format should be <length + whitespace to 8 total bytes><data>
            $command = strlen($command) . str_repeat(' ', 8 - strlen(strlen($command))) . $command;
        // If we don't get a response back in 20 seconds, something went wrong
            socket_set_timeout($fp, 20);
        // Send our command
            fputs ($fp, $command);
        // Did we send the close command?  Close the socket and set the file pointer to null - don't even bother waiting for a response
            if ($command == 'DONE') {
                fclose($fp);
                $fp = NULL;
                return;
            }
        // Read the response header to find out how much data we'll be grabbing
            $length = rtrim(fread($fp, 8));
        // Read and return any data that was returned
            $ret = '';
            while ($length > 0) {
                $data = fread($fp, min(8192, $length));
                if (strlen($data) < 1)
                    break; // EOF
                $ret .= $data;
                $length -= strlen($data);
            }
        // Return
            return $ret;
        }
    }

/**
 * Check that we are speaking a version of the protocol that is compatible with the backend
/**/
    function check_proto_version($host, $port) {
        static $cache;
        if (!$cache)
            $cache = array();
    // Cache?
        if ($cache[$host][$port])
            return;
    // No cache
        $cmd = 'MYTH_PROTO_VERSION '.MYTH_PROTO_VERSION;
        $response = explode(backend_sep, backend_command($cmd, $host, $port));
        if ($response[0] == "ACCEPT") {
            $cache[$host][$port] = true;
            return;
        }
        if ($response[0] == "REJECT") {
            trigger_error("Incompatible protocol version (mythweb=" . MYTH_PROTO_VERSION . ", backend=" . $response[1] . ")");
            return;
        }
        trigger_error("Unexpected response to MYTH_PROTO_VERSION '$cmd': ".$response[0]);
    }

/**
 * Performs a mythbackend query and splits the response into the appropriate number of rows.
/**/
    function get_backend_rows($query, $offset = 1) {
        global $NUMPROGRAMLINES;
        $rows = array();
    // Query the backend, and split the response into an array
        $recs = explode(backend_sep, backend_command($query));
    // Parse the records, starting at the offset point
        $row = 0;
        $col = 0;
        for($i = $offset; $i < count($recs); $i++) {
            $rows[$row][$col] = $recs[$i];
        // Every $NUMPROGRAMLINES fields (0 through ($NUMPROGRAMLINES-1)) means
        // a new row.  Please note that this changes between myth versions
            if ($col == ($NUMPROGRAMLINES - 1)) {
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
    function backend_notify_changes($recordid = -1, $sleep = 1) {
    // Tell the master backend that something has changed
        backend_command('RESCHEDULE_RECORDINGS ' . $recordid);
    // Give the backend time to catch up?
        if ($sleep > 0)
            sleep($sleep);
    }

/**
 * Sends the disconnect/DONE command to the backend
/**/
    # This is disabled because it seems to REALLY slow things down....
    #register_shutdown_function('backend_disconnect');
    function backend_disconnect() {
        backend_command('DONE');
    }

/**
 * Gets a preview image of the requested show
 *
 * @todo, this should get put into a "recording" class or something like that.
/**/
    function generate_preview_pixmap($show) {
        $fileurl  = $show->filename;
        $pngpath  = cache_dir . '/' . basename($fileurl) . '.png';
        $host     = $GLOBALS['Master_Host'];
        $port     = $GLOBALS['Master_Port'];
        $cmd = array('QUERY_PIXMAP_LASTMODIFIED',
                     $show->backend_row());
        $lastmodified = strtotime(backend_command($cmd));
    // Delete outdated images, but not until the show has finished recording
        if (is_file($pngpath) && $lastmodified < $show->lastmodified && $show->lastmodified >= $show->endtime) {
            unlink($pngpath);
            clearstatcache();
        }
    // Need a new pixmap?
        if (!is_file($pngpath)) {
            if (substr($fileurl, 0, 7) != 'myth://') {
                $generate_pixmap = (is_file("$fileurl.png") && is_readable("$fileurl.png")) ? false : true;
                $path = $fileurl;
            }
            else {
                preg_match('#myth://(.+?):(\d+)/(.+)$#', $fileurl, $matches);
                list($matches, $host, $port, $path) = $matches;
                $recs = explode(backend_sep, backend_command2(array('ANN FileTransfer '.hostname, "$fileurl.png"),
                                                              $datasocket,
                                                              $host, $port));
                $generate_pixmap = (0 == $recs[3]) ? true : false;
            }

        // Regenerate backend pixmap if outdated
            $generate_pixmap = ($lastmodified < $show->lastmodified) ? true : false;

            if ($generate_pixmap) {
                if ($datasocket) {
                    fclose($datasocket);
                    $datasocket = NULL;
                }

            // Replace QUERY_PIXMAP_LASTMODIFIED with QUERY_GENPIXMAP
                $cmd[0] = 'QUERY_GENPIXMAP';

                $ret = backend_command($cmd);

                $recs = explode(backend_sep, backend_command2(array('ANN FileTransfer '.hostname, "$fileurl.png"),
                                                              $datasocket,
                                                              $host, $port));
            }

            if (substr($fileurl, 0, 7) != 'myth://' && is_file("$fileurl.png") && is_readable("$fileurl.png")) {
                copy("$fileurl.png", $pngpath);
            }
            elseif ($datasocket && $recs[3]) {
                backend_command('ANN Playback '.hostname.' 0',
                                $host, $port);
                backend_command(array('QUERY_FILETRANSFER '.$recs[1], 'REQUEST_BLOCK', $recs[3]),
                                $host, $port);

                $length = $recs[3];
                $data   = '';
                while ($length > 0) {
                    $size = min(8192, $length);
                    $data = fread($datasocket, $size);
                    if (strlen($data) < 1)
                        break; // EOF
                    $pngdata .= $data;
                    $length -= strlen($data);
                }

            // Make sure the local path exists
                $path = '';
                foreach (split('/+', dirname($pngpath)) as $dir) {
                    $path .= $path ? '/' . $dir : $dir;
                    if(!is_dir($path) && !mkdir($path, 0755))
                        trigger_error('Error creating path for '.$path.': Please check permissions.', FATAL);
                }

                $pngfile = fopen($pngpath, 'wb');
                if ($pngfile) {
                    fwrite($pngfile, $pngdata, $recs[3]);
                    fclose($pngfile);
                }
            }

            if ($datasocket) {
                #backend_command2('DONE', $datasocket, $host, $port);
                fclose($datasocket);
                $datasocket = NULL;
            }
        }
    }

/**
 * Converts a myth timestamp into a unix timestamp
 * 1.0 cvs changed the format to:  2003-06-28T06:30:00
/**/
    function myth2unixtime($mythtime) {
        if (strlen($mythtime) < 1)
            return '';
        return strtotime(str_replace('T', ' ', $mythtime));
    }

/**
 * Converts a unix timestamp into a myth timestamp
/**/
    function unix2mythtime($time) {
        return date('Y-m-d\TH:i:s', $time);
    }

