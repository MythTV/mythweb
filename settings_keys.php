<?php
/***                                                                        ***\
    settings_keys.php                    
	mythtv keybindings config
\***                                                                        ***/

// Initialize the script, database, etc.
	require_once "includes/init.php";

// Save?
	if ($_POST['save']) {
	}

        $result = mysql_query('SELECT hostname FROM jumppoints GROUP BY hostname ORDER BY hostname')
		or trigger_error('SQL Error: '.mysql_error(), FATAL);
	$Hosts = array();
	$usehost = "";
	while ($row = mysql_fetch_assoc($result))
	{
		$Hosts[] = $row;
		if ($usehost == "")
			$usehost = $row['hostname'];
	}
	mysql_free_result($result);

        if ($_GET['host'])
		$usehost = $_GET['host'];

// Load all of the jump points from the database
	$result = mysql_query('SELECT * FROM jumppoints WHERE hostname='.escape($usehost))
		or trigger_error('SQL Error: '.mysql_error(), FATAL);
	$Jumps = array();
	while ($row = mysql_fetch_assoc($result))
		$Jumps[] = $row;
	mysql_free_result($result);

// Load all of the keys from the database
        $result = mysql_query('SELECT * FROM keybindings WHERE hostname='.escape($usehost))
                or trigger_error('SQL Error: '.mysql_error(), FATAL);
        $Keys = array();
        while ($row = mysql_fetch_assoc($result))
                $Keys[] = $row;
        mysql_free_result($result);

// Load the class for this page
	require_once theme_dir.'settings_keys.php';

// Create an instance of this page from its theme object
	$Page = new Theme_settings_keys();

// Display the page
	$Page->print_page();

// Exit
	exit;

?>
