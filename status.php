<?php
/***                                                                        ***\
	status.php                      Last Updated: 2004.01.27 (xris)

	This file is part of MythWeb, a php-based interface for MythTV.
	See README and LICENSE for details.
\***                                                                        ***/

// Initialize the script, database, etc.
	require_once "includes/init.php";

// Get the address/port of the master machine
	$masterhost = get_backend_setting('MasterServerIP');
	$statusport = get_backend_setting('BackendStatusPort');

// Print out the mythtv status page
	readfile("http://$masterhost:$statusport");

?>

