<?php
/***                                                                        ***\
    settings_keys.php                    
	mythtv keybindings config
\***                                                                        ***/

// Initialize the script, database, etc.
	require_once "includes/init.php";

	$usehost = "";

// Save?
	if ($_POST['save']) {
                foreach (array_keys($_POST) as $key) {
			if (preg_match('/^jump:([\\w_\/]+):(\\w+)$/', $key, $matches))
			{
				list($match, $dest, $host) = $matches;
                                $dest = str_replace("_", " ", $dest);
				$usehost = $host;
				$query = 'UPDATE jumppoints SET keylist='.escape($_POST[$key]).' WHERE destination='.escape($dest).' AND hostname='.escape($host).';';
				$result = mysql_query($query)
					or trigger_error('SQL Error: '.mysql_error(), FATAL);
			}
			else if (preg_match('/^key:([\\w_\/]+):(\\w+):(\\w+)$/', $key, $matches))
			{
				list($match, $context, $action, $host) = $matches;
				$usehost = $host;
				$context = str_replace("_", " ", $context);
				$query = 'UPDATE keybindings SET keylist='.escape($_POST[$key]).' WHERE context='.escape($context).' AND action='.escape($action).' AND hostname='.escape($host).';';
				$result = mysql_query($query)
					or trigger_error('SQL Error: '.mysql_error(), FATAL);
			}

		}
	}

        $result = mysql_query('SELECT hostname FROM jumppoints GROUP BY hostname ORDER BY hostname')
		or trigger_error('SQL Error: '.mysql_error(), FATAL);
	$Hosts = array();
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
        $Keys = array();

        $result = mysql_query('SELECT * FROM keybindings WHERE hostname='.escape($usehost).' AND context = \'Global\'')
		or trigger_error('SQL Error: '.mysql_error(), FATAL);
	while ($row = mysql_fetch_assoc($result))
		$Keys[] = $row;
	mysql_free_result($result);

        $result = mysql_query('SELECT * FROM keybindings WHERE hostname='.escape($usehost).' AND context != \'Global\' ORDER BY context')
                or trigger_error('SQL Error: '.mysql_error(), FATAL);
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
