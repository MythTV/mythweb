<?php
/***                                                                        ***\
    settings_mythweb.php                     Last Updated: 2003.11.18 (xris)

	main configuration index
\***                                                                        ***/

// Load the parent class for all settings pages
	require_once theme_dir.'settings.php';

class Theme_settings_mythweb extends Theme_settings {

	function print_page() {
		$this->print_header();
?>

<form class="form" method="post" action="settings_mythweb.php">

<table class="command command_border_l command_border_t command_border_b command_border_r" border="0" cellspacing="0" cellpadding="5">
<tr>
	<td>Date/Date Formats:</td>
	<td><div class="small" style="float:right"><a href="http://php.net/manual/en/function.date.php" target="_blank">format help</a></div></td>
</tr><tr>
	<td align="right">Status Bar:&nbsp;</td>
	<td><input type="text" size="12" name="date_statusbar" value="<?php    echo htmlentities($_SESSION['date_statusbar']) ?>"></td>
</tr><tr>
	<td align="right">Scheduled Recordings:&nbsp;</td>
	<td><input type="text" size="12" name="date_scheduled" value="<?php    echo htmlentities($_SESSION['date_scheduled']) ?>"></td>
</tr><tr>
	<td align="right">Scheduled Popup:&nbsp;</td>
	<td><input type="text" size="12" name="date_scheduled_popup" value="<?php    echo htmlentities($_SESSION['date_scheduled_popup']) ?>"></td>
</tr><tr>
	<td align="right">Recorded Programs:&nbsp;</td>
	<td><input type="text" size="12" name="date_recorded" value="<?php     echo htmlentities($_SESSION['date_recorded']) ?>"></td>
</tr><tr>
	<td align="right">Search Results:&nbsp;</td>
	<td><input type="text" size="12" name="date_search" value="<?php       echo htmlentities($_SESSION['date_search']) ?>"></td>
</tr><tr>
	<td align="right">Listing Time Key:&nbsp;</td>
	<td><input type="text" size="12" name="date_listing_key" value="<?php  echo htmlentities($_SESSION['date_listing_key']) ?>"></td>
</tr><tr>
	<td align="right">Listing &quot;Jump to&quot;&nbsp;</td>
	<td><input type="text" size="12" name="date_listing_jump" value="<?php echo htmlentities($_SESSION['date_listing_jump']) ?>"></td>
</tr><tr>
	<td align="right">Channel &quot;Jump to&quot;&nbsp;</td>
	<td><input type="text" size="12" name="date_channel_jump" value="<?php echo htmlentities($_SESSION['date_channel_jump']) ?>"></td>
</tr><tr>
	<td align="right">Hour Format&nbsp;</td>
	<td><select name="time_format" style="text-align: center"><?php
		foreach (array('g:i a', 'g:i A', 'h:i a', 'h:i A', 'G:i', 'H:i') as $code) {
			echo "<option value=\"$code\"";
			if ($_SESSION['time_format'] == $code)
				echo ' SELECTED';
			echo '>'.date($code, strtotime('9:00 AM')).' / '.date($code, strtotime('9:00 PM')).'</option>';
		}
		?></select></td>
</tr><tr>
	<td align="center"><input type="reset" value="Reset"></td>
	<td align="center"><input type="submit" name="save" value="Save"></td>
</tr>
</table>

</form>

<?php

		$this->print_footer();
	}

    function print_header() {
        parent::print_header("MythWeb - Configure Mythweb");
    }

	function print_footer() {
		parent::print_footer();
	}

}
?>
