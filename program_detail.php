<?
/***                                                                        ***\
	program_detail.php                      Last Updated: 2003.07.23 (xris)

	This file is part of MythWeb, a php-based interface for MythTV.
	See README and LICENSE for details.

	This displays details about a program, as well as provides recording
	commands.
\***                                                                        ***/

// Initialize the script, database, etc.
	require_once "includes/init.php";

// Grab the one and only program on this channel that starts at the specified time
	$this_program = &load_one_program($_GET['starttime'], $_GET['chanid']);
	$this_channel = &$this_program->channel;

// Make sure this is a valid program.  If not, forward the user back to the listings page
	if (!strlen($this_program->title)) {
		header("Location: program_listing.php?time=".$_SESSION['list_time']);
		exit;
	}

// The user tried to update the recording settings - update the database and the variable in memory
	if (isset($_GET['save'])) {
	// Update
		switch ($_GET['record']) {
			case 'always':
				$this_program->record_always();
				break;
			case 'channel':
				$this_program->record_channel();
				break;
			case 'once':
				$this_program->record_once();
				break;
			case 'timeslot':
				$this_program->record_timeslot();
				break;
		// Default to no recording
			default:
				$this_program->record_never();
		}
	}


// Load the class for this page
	require_once theme_dir."program_detail.php";

// Create an instance of this page from its theme object
	$Page = new Theme_program_detail();

// Display the page
	$Page->print_page();

// Exit
	exit;


?>
