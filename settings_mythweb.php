<?php
/***                                                                        ***\
    settings.php                            Last Updated: 2003.11.18 (xris)

	mythweb settings
\***                                                                        ***/

// Initialize the script, database, etc.
	require_once "includes/init.php";

// Save?
	if ($_POST['save']) {
		if ($_POST['date_statusbar'])       $_SESSION['date_statusbar']       = $_POST['date_statusbar'];
		if ($_POST['date_scheduled'])       $_SESSION['date_scheduled']       = $_POST['date_scheduled'];
		if ($_POST['date_scheduled_popup']) $_SESSION['date_scheduled_popup'] = $_POST['date_scheduled_popup'];
		if ($_POST['date_recorded'])        $_SESSION['date_recorded']        = $_POST['date_recorded'];
		if ($_POST['date_search'])          $_SESSION['date_search']          = $_POST['date_search'];
		if ($_POST['date_listing_key'])     $_SESSION['date_listing_key']     = $_POST['date_listing_key'];
		if ($_POST['date_listing_jump'])    $_SESSION['date_listing_jump']    = $_POST['date_listing_jump'];
		if ($_POST['date_channel_jump'])    $_SESSION['date_channel_jump']    = $_POST['date_channel_jump'];
		if ($_POST['time_format'])          $_SESSION['time_format']          = $_POST['time_format'];
	}

// Load the class for this page
	require_once theme_dir.'settings_mythweb.php';

// Create an instance of this page from its theme object
	$Page = new Theme_settings_mythweb();

// Display the page
	$Page->print_page();

// Exit
	exit;

?>
