<?
/***                                                                        ***\
	program_listing.php                      Last Updated: 2003.07.23 (xris)

	This file is part of MythWeb, a php-based interface for MythTV.
	See README and LICENSE for details.

	This is the default viewing mode, and shows the current program listings.
\***                                                                        ***/

// Initialize the script, database, etc.
	require_once "includes/init.php";

// Were we passed a timestamp?  This is going to be the most common occurrence
	if ($_GET['time'])
		$list_starttime = (int)$_GET['time'];
// Did we get passed a date (and probably an hour, too)?
	elseif(isset($_GET['date']))
		$list_starttime = unixtime(sprintf('%08d%02d0000', $_GET['date'], $_GET['hour']));
// Default value - just use the current time
	else
		$list_starttime = time();

// Round *back* to the nearest timeslot size
	$list_starttime -= $list_starttime % timeslot_size;

// Setup the time slots
	$list_endtime = $list_starttime;
	$Timeslots = array();
	for ($i = 0; $i < num_time_slots; $i++) {
		$Timeslots[]  = $list_endtime;
		$list_endtime += timeslot_size;	// skip to the next timeslot
	}

// Set a session variable so other sections know how to get back to this particular page
	$_SESSION['list_time'] = $list_starttime;

// Populate the $Channels array
	load_all_channels();

// Load all relevant program information for all channels
	load_all_program_data($list_starttime, $list_endtime);

// Load the class for this page
	require_once theme_dir."program_listing.php";

// Create an instance of this page from its theme object
	$Page = new Theme_program_listing;

// Display the listing page header
	$Page->print_header($list_starttime, $list_endtime);

// Print the page content
	$Page->print_timeslots($Timeslots, $list_starttime, $list_endtime, 'first');

// Go through each channel and load/print its info - use references to avoid "copy" overhead
	$channel_count = 0;
	foreach (array_keys($Channels) as $key) {
		$channel_count++;
	// Grab the reference
		$channel = &$Channels[$key];
	// Print the data
		$Page->print_channel(&$channel, $list_starttime, $list_endtime);
	// Cleanup is a good thing
		unset($channel);
	// Display the timeslot bar?
		if ($channel_count % timeslotbar_skip == 0)
			$Page->print_timeslots($Timeslots, $list_starttime, $list_endtime, $channel_count);
	}

// Display the listing page footer
	$Page->print_footer();

?>
