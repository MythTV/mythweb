<?php
/***                                                                        ***\
    settings.php                            Last Updated: 2003.08.22 (xris)

	main configuration index
\***                                                                        ***/

// Load the parent class for all settings pages
	require_once theme_dir.'settings.php';

class Theme_settings_channels extends Theme_settings {

	function print_page() {
		global $Channels;
		$this->print_header();
?>
Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.

<form class="form" method="post" action="settings_channels.php">

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu" align="center">
	<td width="4%">sourceid</td>
	<td width="5%">channum</td>
	<td width="12%">callsign</td>
	<td width="25%">name</td>
	<td width="5%">freqid</td>
	<td width="5%">finetune</td>
	<td width="5%">videofilters</td>
	<td width="8%">brightness</td>
	<td width="8%">contrast</td>
	<td width="8%">colour</td>
	<td width="8%">hue</td>
	<td width="5%">recpriority</td>
</tr><?php
		foreach ($Channels as $channel) {
?><tr class="settings" align="center">
	<td><?php echo htmlentities($channel['sourceid'])?></td>
	<td><input type="text" size="3" name="channum_<?php echo $channel['chanid']?>" id="channum_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['channum'])?>"></td>
	<td><input type="text" size="15" name="callsign_<?php echo $channel['chanid']?>" id="callsign_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['callsign'])?>"></td>
	<td><input type="text" size="27" name="name_<?php echo $channel['chanid']?>" id="name_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['name'])?>"></td>
	<td><input type="text" size="3" name="freqid_<?php echo $channel['chanid']?>" id="freqid_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['freqid'])?>"></td>
	<td><input type="text" size="3" name="finetune_<?php echo $channel['chanid']?>" id="finetune_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['finetune'])?>"></td>
	<td><input type="text" size="3" name="videofilter_<?php echo $channel['chanid']?>" id="videofilter_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['videofilters'])?>"></td>
	<td><input type="text" size="6" name="brightness_<?php echo $channel['chanid']?>" id="brightness_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['brightness'])?>"></td>
	<td><input type="text" size="6" name="contrast_<?php echo $channel['chanid']?>" id="contrast_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['contrast'])?>"></td>
	<td><input type="text" size="6" name="colour_<?php echo $channel['chanid']?>" id="colour_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['colour'])?>"></td>
	<td><input type="text" size="6" name="hue_<?php echo $channel['chanid']?>" id="hue_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['hue'])?>"></td>
	<td><input type="text" size="2" name="recpriority_<?php echo $channel['chanid']?>" id="recpriority_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['recpriority'])?>"></td>
</tr><?php
		}
?>
</table>

<p align="center">
<input type="submit" name="save" value="Save">
</p>

</form>
<?php
		$this->print_footer();
	}

    function print_header() {
        parent::print_header("MythWeb - Configure Channels");
    }

	function print_footer() {
		parent::print_footer();
	}

}
?>
