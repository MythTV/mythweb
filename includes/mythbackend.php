<?php
/***																		***\
	mythbackend.php                          Last Updated: 2004.01.27 (xris)

	Routines that allow mythweb to communicate with mythbackend
\***																		***/

// The character string used by the backend to separate records
	define('backend_sep', '[]:[]');

// A couple of global variables to keep duplicate queries to a minimum
	$Scheduled_Recordings = array();
	$Recorded_Programs    = array();

// Make sure we're connected to mythbackend
	if (backend_command('ANN Playback '.trim(`hostname`).' 0') != 'OK')
		trigger_error("Unable to connect to mythbackend, is it running?\n", FATAL);


/*
	get_backend_setting:
	queries the database settings table for a particular setting, and returns its value
*/
	function get_backend_setting($setting, $host = false) {
		static $cache = array();
	// Do we have a hostname?
		if ($host) {
		// Do we have a cached value for this host?
			if (isset($cache[$host][$setting]))
				return $cache[$host][$setting];
		// Nope, continue formatting the query
			$extra = ' AND hostname='.escape($host);
		}
	// No hostname, but do we have a cached value?
		elseif (isset($cache['-unknown-'][$setting]))
			return $cache['-unknown-'][$setting];
	// Make the query
		$result = mysql_query('SELECT data FROM settings WHERE value='.escape($setting).$extra)
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
		list($value) = mysql_fetch_row($result);
		mysql_free_result($result);
	// Cache the result
		if ($host)
			$cache[$host][$setting] = $value;
		else
			$cache['-unknown-'][$setting] = $value;
	// Return
		return $value;
	}

/*
	backend_command:
	executes the requested command and returns the backend's response string
	JS: haven't tested UTF-8
*/
	function backend_command($command) {
	// Use a static file pointer so we can leave the same connection open
		static $fp;
		return backend_command2($command, $fp);
	}

	// A second backend command, so we can allow certain routines to use their own file pointer
	function backend_command2($command, &$fp) {
	// Load some information about the master backend
		$host = get_backend_setting('MasterServerIP');
		$port = get_backend_setting('MasterServerPort');
                $host = "127.0.0.1";
		if (!$host || !$port)
			trigger_error("MasterServerIP or MasterServerPort not found! You man need to check your settings.php file or re-run setup mythtv's setup", FATAL);

	// Open a connection to the master backend, unless we've already done so
		if (!$fp) {
			$fp = fsockopen($host, $port, $errno, $errstr, 25);
                        if ($fp)
                                check_proto_version($fp);
                }
	// Connection opened, let's do something
		if ($fp) {
		// Build the command string
		// The format should be <length + whitespace to 8 total bytes><data>
			$command = strlen($command) . str_repeat(' ', 8 - strlen(strlen($command))) . $command;
		// If we don't get a response back in 4 seconds, something went wrong
			socket_set_timeout($fp, 25);
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
				$size = min(8192, $length);
				$data = fread($fp, $size);
				if (strlen($data) < 1)
					break; // EOF
				$ret .= $data;
				$length -= strlen($data);
			}
		// Return
			return $ret;
		}
	}

/*
        check_proto_version:
        Check that we are speaking a version of the protocol that is compatible with the backend
*/
        function check_proto_version($fp) {
                $our_version = "1";
                $response = explode($backend_sep,backend_command2("MYTH_PROTO_VERSION " . $our_version, $fp));
                if ($response[0] == "ACCEPT")
                        return;
                if ($response[0] == "REJECT")
                        trigger_error("Incompatible protocol version (mythweb=" . $our_version . ", backend=" . $response[1] . ")");
                trigger_error("Unexpected response to MYTH_PROTO_VERSION: " . $response[0]);
        }

/*
	get_backend_rows:
	performs a mythbackend query and splits the response into the appropriate number of rows.
*/
	function get_backend_rows($query, $offset = 1) {
		$rows = array();
	// Query the backend, and split the response into an array
		$recs = explode(backend_sep, backend_command($query));
	// Parse the records, starting at the offset point
		$row = 0;
		$col = 0;
		for($i = $offset; $i < count($recs); $i++) {
			$rows[$row][$col] = $recs[$i];
		// Every 29 fields (0 through 28) means a new row - please note that this changes between myth versions
			if ($col == 28) {
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

/*
	backend_notify_changes:
	Updates or inserts a row to notify the backend that there have been database changes
*/
	function backend_notify_changes($sleep = 1) {
	// Tell mythfrontend that something has changed
		$result = mysql_query('UPDATE settings SET data="yes" WHERE value="RecordChanged"')
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
	// No affected rows?  Insert one
		if (mysql_affected_rows() < 1) {
			$result = mysql_query('INSERT INTO settings (data, value) VALUES ("yes", "RecordChanged")')
				or trigger_error('SQL Error: '.mysql_error(), FATAL);
		}
	// Give the backend time to catch up?
		if ($sleep > 0)
			sleep($sleep);
	}

/*
	backend_disconnect:
	sends the disconnect/DONE command to the backend
*/
	# This is disabled because it seems to REALLY slow things down....
	#register_shutdown_function('backend_disconnect');
	function backend_disconnect() {
		backend_command('DONE');
	}

/*
	generate_preview_pixmap:
	gets a preview image of the requested show
*/
	function generate_preview_pixmap($show) {
		$fileurl = $show->filename;
		$pngpath = image_cache . '/' . basename($fileurl) . ".png";
		if (!is_file($pngpath)) {
			$hostname = chop(`hostname`);
			if (substr($fileurl, 0, 7) != 'myth://') {
				$generate_pixmap = (is_file("$fileurl.png") && is_readable("$fileurl.png")) ? false : true;
			}
			else {
				$recs = explode(backend_sep, backend_command2('ANN FileTransfer '.$hostname.backend_sep.$fileurl.'.png',
															  $datasocket));
				$generate_pixmap = (0 == $recs[3]);
			}

			if ($generate_pixmap) {
				if ($datasocket) {
					#backend_command2('DONE', $datasocket);
					fclose($datasocket);
					$datasocket = NULL;
				}

				$cmd = 'QUERY_GENPIXMAP'              .backend_sep
					  .' '                            .backend_sep	// title
					  .' '                            .backend_sep	// subtitle
					  .' '                            .backend_sep	// description
					  .' '                            .backend_sep	// category
					  .$show->chanid                  .backend_sep	// chanid
					  .' '                            .backend_sep	// chanstr
					  .' '                            .backend_sep	// chansign
					  .' '                            .backend_sep	// channame
					  .$show->filename                .backend_sep	// filename
					  .'0'                            .backend_sep	// upper 32 bits
					  .'0'                            .backend_sep	// lower 32 bits
					  .unix2mythtime($show->starttime).backend_sep	// starttime
					  .unix2mythtime($show->endtime)  .backend_sep	// endtime
					  .'0'                            .backend_sep	// conflicting
					  .'1'                            .backend_sep	// recording
					  .'0'                            .backend_sep	// duplicate
					  .$show->hostname                .backend_sep	// hostname
					  .'-1'                           .backend_sep	// sourceid
					  .'-1'                           .backend_sep	// cardid
					  .'-1'                           .backend_sep	// inputid
					  .' '                            .backend_sep	// recpriority
					  .' '                            .backend_sep	// recstatus
					  .' '                            .backend_sep	// recordid
					  .' '                            .backend_sep	// rectype
					  .' '                            .backend_sep 	// recdups
					  .unix2mythtime($show->starttime).backend_sep  // recstarttime
					  .unix2mythtime($show->endtime)  .backend_sep 	// recendtime
					  .' '                            .backend_sep	// repeat
					  .' '				  .backend_sep; // program flags
				$ret = backend_command($cmd);

				$recs = explode(backend_sep, backend_command2('ANN FileTransfer '.$hostname.backend_sep.$fileurl.'.png',
															  $datasocket));
			}

			if (substr($fileurl, 0, 7) != 'myth://' && is_file("$fileurl.png") && is_readable("$fileurl.png")) {
				copy("$fileurl.png", $pngpath);
			}
			elseif ($datasocket && $recs[3]) {
				$cmd = "QUERY_FILETRANSFER " . $recs[1] . backend_sep . 'REQUEST_BLOCK' . backend_sep . $recs[3];
				$ret = backend_command($cmd);

				$length = $recs[3];
				$data = '';
				while($length > 0) {
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
				#backend_command2('DONE', $datasocket);
				fclose($datasocket);
				$datasocket = NULL;
			}
		}
	}

/*
	myth2unixtime:
	converts a myth timestamp into a unix timestamp
	1.0 cvs changed the format to:  2003-06-28T06:30:00
*/
	function myth2unixtime($mythtime) {
		return strtotime(str_replace('T', ' ', $mythtime));
	}

/*
	unix2mythtime:
	converts a unix timestamp into a myth timestamp
*/
	function unix2mythtime($time) {
		return date('Y-m-d\TH:i:s', $time);
	}

/*

	The following function is left over from an old incarnation of mythweb, and should be updated or deleted

*/
function getCardStatus() {
	// Get the current card status(es)
	$inputquery = "SELECT distinct cardid, inputname FROM cardinput ORDER BY cardid";
	$inputresult = mysql_query($inputquery) or die("Couldn't open the channel table in the mythconverg database.");
	while ($inputline = mysql_fetch_array($inputresult, MYSQL_ASSOC)) {
		$line = $inputline['cardid'];
		$recording = backendCommand("QUERY_RECORDER " . $line . backend_sep . "IS_RECORDING");
		$idStatus[$line] = $recording;
	}
	mysql_free_result($inputresult);
	return $idStatus;
}

?>
