<?
/***                                                                        ***\
	channel_detail.php                       Last Updated: 2003.08.06 (xris)


\***                                                                        ***/

// Initialize the script, database, etc.
	require_once "includes/init.php";

// Chanid?
	$_GET['chanid'] or $_GET['chanid'] = $_POST['chanid'];
	$this_channel = &load_one_channel($_GET['chanid']);

// No channel found
	if (!$_GET['chanid'] || !$this_channel->chanid) {
		header('Location: program_listing.php?time='.$_SESSION['list_time']);
		exit;
	}

// New list time?
	$_GET['time'] or $_GET['time'] = $_POST['time'];
	if ($_GET['time'])
		$_SESSION['list_time'] = $_GET['time'];

// Load the programs for today
	$this_channel->programs = load_all_program_data(mktime(0, 0, 0, date('n', $_SESSION['list_time']), date('j', $_SESSION['list_time']), date('Y', $_SESSION['list_time'])),
													mktime(0, 0, 0, date('n', $_SESSION['list_time']), date('j', $_SESSION['list_time']) + 1, date('Y', $_SESSION['list_time'])),
													$this_channel->chanid);

// Load the class for this page
	require_once theme_dir.'channel_detail.php';

// Create an instance of this page from its theme object
	$Page = new Theme_channel_detail();

// Display the page
	$Page->print_page();

// Exit
	exit;

?>
