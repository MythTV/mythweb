<?php
/***                                                                        ***\
    settings_keys.php
	keybindings config
\***                                                                        ***/

// Load the parent class for all settings pages
	require_once theme_dir.'settings.php';

class Theme_settings_keys extends Theme_settings {

	function print_page() {
		global $Hosts;
		global $usehost;
		global $Jumps;
		global $Keys;
		$this->print_header();
?>
<form class="form" action="settings_keys.php" method="get">
Editing keybindings on: <select name="host">
<?php
		foreach ($Hosts as $availhost) {
			echo '<option value='.$availhost['hostname'];
			if ($availhost['hostname'] == $usehost)
				echo ' SELECTED';
			echo '>'.$availhost['hostname'].'</option>';
		}
?>
</select>&nbsp;&nbsp;&nbsp;<input type="submit" class="submit" value="Set Host">
<p>
<form class="form" method="post" action="settings_keys.php">
<table width = "100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu" align="center">
	<td width="20%">Destination</td>
	<td width="65%">Description</td>
	<td width="15%">Key bindings</td>
</tr><?php
		foreach ($Jumps as $jumppoint) {
?><tr class="settings" align="center">
	<td><?php echo htmlentities($jumppoint['destination'])?></td>
	<td><?php echo htmlentities($jumppoint['description'])?></td>
	<td><input type="text" size="20" name="jump_<?php echo $jumppoint['destination'].'_'.$usehost?>" value="<?php echo htmlentities($jumppoint['keylist'])?>"></td>
</tr>
<?php
		}
?>
</table>

<table width = "100%" border="0" cellpadding="4" cellspacing="2" class="list sma
ll">
<tr class="menu" align="center">
        <td width="15%">Context</td>
        <td width="25%">Action</td>
        <td width="40%">Description</td>
        <td width="20%">Key bindings</td>
</tr><?php
                foreach ($Keys as $keyb) {
?><tr class="settings" align="center">
        <td><?php echo htmlentities($keyb['context'])?></td>
        <td><?php echo htmlentities($keyb['action'])?></td>
        <td><?php echo htmlentities($keyb['description'])?></td>
        <td><input type="text" size="25" name="key_<?php echo $keyb['context'].'_'.$keyb['action'].'_'.$usehost?>" value="<?php echo htmlentities($keyb['keylist'])?>
"></td>
</tr>
<?php
                }
?>
</table>

<?php
		$this->print_footer();
    	}

    function print_header() {
        parent::print_header("MythWeb - Configure Keybindings");
    }

	function print_footer() {
		parent::print_footer();
	}

}
?>
