<?php
/***                                                                        ***\
    settings.php                            Last Updated: 2003.08.22 (xris)

	mythweb settings
\***                                                                        ***/

// Initialize the script, database, etc.
	require_once "includes/init.php";

// Load the class for this page
	require_once theme_dir.'settings_mythweb.php';

// Create an instance of this page from its theme object
	$Page = new Theme_settings_mythweb();

// Display the page
	$Page->print_page();

// Exit
	exit;

?>
