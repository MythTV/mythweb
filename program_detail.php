<?
/***                                                                        ***\
	program_detail.php                      Last Updated: 2003.11.22 (xris)

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
		if (isset($_GET['profile']))
			$this_program->profile = $_GET['profile'];
		if (isset($_GET['recpriority']))
			$this_program->recpriority = $_GET['recpriority'];
		if (isset($_GET['maxepisodes']))
			$this_program->maxepisodes=$_GET['maxepisodes'];
		$this_program->recorddups = (isset($_GET['recorddups']) && $_GET['recorddups'] == "on") ? 1 : 0;
		$this_program->autoexpire = (isset($_GET['autoexpire']) && $_GET['autoexpire'] == "on") ? 1 : 0;
		$this_program->maxnewest  = (isset($_GET['maxnewest']) && $_GET['maxnewest'] == "on")   ? 1 : 0;
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
			case 'daily':
				$this_program->record_daily();
				break;
			case 'weekly':
				$this_program->record_weekly();
				break;
		// Default to no recording
			default:
				$this_program->record_never();
		}
	}
	elseif (!$this_program->will_record) {
		//Load default settings for recpriority, autoexpire etc
		$recpriorityresult = mysql_query("SELECT recpriority from channel where chanid=".escape($this_program->chanid));
		while ($row = mysql_fetch_assoc($recpriorityresult)) {
			$this_program->recpriority = $row['recpriority'];
		}
		$autoexpire = mysql_query("SELECT data from settings where value='AutoExpireDefault'");
		while ($row = mysql_fetch_assoc($autoexpire)) {
			$this_program->autoexpire = $row['data'];
		}
	}

// Load the recording profiles
	$Profiles = array("Default", "Live TV", "High Quality", "Low Quality");

// Load the class for this page
	require_once theme_dir."program_detail.php";

// Create an instance of this page from its theme object
	$Page = new Theme_program_detail();

// Display the page
	$Page->print_page();

// Exit
	exit;


?>
