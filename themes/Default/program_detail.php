<?
/***                                                                        ***\
	program_detail.php                       Last Updated: 2003.07.14 (xris)

	This file defines a theme class for the program details section.
	It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_program_detail extends Theme {

	function print_page() {
		global $this_channel, $this_program;
	// Print the main page header
		parent::print_header("MythWeb - Program Detail:  $this_program->title");
	// Print the page contents
?>
<table align="center" border="0" cellspacing="0" cellpadding="15">
<tr>
	<td valign="top"><table border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td width="<?=prefer_channum ? '80' : '120'?>px" class="menu menu_border_t menu_border_b menu_border_l menu_border_r" width="60" align="center" nowrap><?
				if (show_channel_icons === true) {
					?><table class="small" width="100%" border="0" cellspacing="0" cellpadding="2">
					<tr>
						<td width="50%" align="center" nowrap><a href="channel_detail.php?chanid=<?=$this_channel->chanid?>&time=<?=$start_time?>" class="huge"
														onmouseover="window.status='Details for: <?=$this_channel->channum?> <?=$this_channel->callsign?>';return true"
														onmouseout="window.status='';return true"><?=prefer_channum ? $this_channel->channum : $this_channel->callsign?></a>&nbsp;</td>
						<td width="50%" align="right"><?
							if (is_file($this_channel->icon)) {
								?><a href="channel_detail.php?chanid=<?=$this_channel->chanid?>&time=<?=$start_time?>"
									onmouseover="window.status='Details for: <?=$this_channel->channum?> <?=$this_channel->callsign?>';return true"
									onmouseout="window.status='';return true"><img src="<?=$this_channel->icon?>" height="30" width="30"></a><?
							} else {
								echo '&nbsp;';
							}?></td>
					</tr><tr>
						<td colspan="2" align="center" nowrap><a href="channel_detail.php?chanid=<?=$this_channel->chanid?>&time=<?=$start_time?>"
														onmouseover="window.status='Details for: <?=$this_channel->channum?> <?=$this_channel->callsign?>';return true"
														onmouseout="window.status='';return true"><?=prefer_channum ? $this_channel->callsign : $this_channel->channum?></a></td>
					</tr>
					</table><?
				} else {
					?><a href="channel_detail.php?chanid=<?=$this_channel->chanid?>" class="huge"
						onmouseover="window.status='Details for: <?=$this_channel->channum?> <?=$this_channel->callsign?>';return true"
						onmouseout="window.status='';return true"><?=prefer_channum ? $this_channel->channum : $this_channel->callsign?><BR>
					<?=prefer_channum ? $this_channel->callsign : $this_channel->channum?></a><?
				}
					?></td>
			<td width="24px">&nbsp;</td>
			<td><span class="huge"><?=$this_program->title?></span><BR>
				<span class="small">
				<?=date('g:i A', $this_program->starttime)?> to <?=date('g:i A', $this_program->endtime)?> (<?=(int)($this_program->duration/60)?> minutes)<BR>
				<?
				if ($this_program->previouslyshown)
					echo '(Rerun) ';
				if ($this_program->category_type == 'movie')
					echo " (<a href=\"http://www.imdb.com/Find?select=Titles&for=" . urlencode($this_program->title) . "\">Search IMDB</a>)";
				else
					echo " (<a href=\"http://www.google.com/search?q=" . urlencode($this_program->title) . "\">Search Google</a>)";
				?></span></td>
		</tr><tr>
			<td colspan="3">&nbsp;</td>
		</tr><? if (strlen($this_program->subtitle)) { ?><tr>
			<td colspan="2" align="right">Episode:&nbsp;</td>
			<td><?=$this_program->subtitle?></td>
		</tr><? }
				if (strlen($this_program->description)) {?><tr>
			<td colspan="2" align="right" valign="top">Description:&nbsp;</td>
			<td><?=wordwrap($this_program->description, 45, "<BR>\n")?></td>
		</tr><? } ?><tr>
			<td colspan="3">&nbsp;</td>
		</tr><? if (strlen($this_program->category)) {?><tr>
			<td colspan="2" align="right">Category:&nbsp;</td>
			<td><?=$this_program->category?></td>
		</tr><? }
				if (strlen($this_program->airdate)) {?><tr>
			<td nowrap colspan="2" align="right">Orig. Airdate:&nbsp;</td>
			<td><?=$this_program->airdate?></td>
		</tr><? }
				if (strlen($this_program->rating)) {?><tr>
			<td colspan="2" align="right"><?=strlen($this_program->rater) > 0 ? "$this_program->rater " : ''?>Rating:&nbsp;</td>
			<td><?=$this_program->rating?><?
				if (strlen($this_program->starstring) > 0)
					echo ", $this_program->starstring";
				?></td>
		</tr><? } ?>

		</table></td>
	<td valign="top" align="right">

		<form action="program_detail.php" method="get" name="record_settings">
		<input type="hidden" name="chanid" value="<?=$_GET['chanid']?>">
		<input type="hidden" name="starttime" value="<?=$_GET['starttime']?>">

		<table class="command command_border_l command_border_t command_border_b command_border_r" align="center" border="0" cellspacing="0" cellpadding="5">
		<tr>


			<td><p align="center">Recording Options:</p>
				<p onclick="get_element('record_never').checked=true;">
					<input type="radio" class="radio" name="record" value="never" id="record_never"<?=
					$this_program->will_record ? '' : ' CHECKED'?>></input>
					<a>Don't record this program.</a>
					</p>
				<p onclick="get_element('record_once').checked=true;">
					<input type="radio" class="radio" name="record" value="once" id="record_once"<?=
					$this_program->record_once ? ' CHECKED' : ''?>></input>
					<a>Record only this showing.</a>
					</p>
				<p onclick="get_element('record_timeslot').checked=true;">
					<input type="radio" class="radio" name="record" value="timeslot" id="record_timeslot"<?=
					$this_program->record_timeslot ? ' CHECKED' : ''?>></input>
					<a>Record this program in this timeslot every day.</a>
					</p>
				<p onclick="get_element('record_channel').checked=true;">
					<input type="radio" class="radio" name="record" value="channel" id="record_channel"<?=
					$this_program->record_channel ? ' CHECKED' : ''?>></input>
					<a>Always record this program on this channel.</a>
					</p>
				<p onclick="get_element('record_always').checked=true;">
					<input type="radio" class="radio" name="record" value="always" id="record_always"<?=
					$this_program->record_always ? ' CHECKED' : ''?>></input>
					<a>Always record this program on any channel.</a>
					</p>
				<p align="center"><input type="submit" class="submit" name="save" value="Update Recording Settings"></p></td>


		</tr>
		</table>

		</form></td>
</tr><tr>
	<td align="center"><a href="program_listing.php?time=<?php echo $this_program->starttime?>">What else is on at this time?</td>
	<td align="center"><a href="program_listing.php?time=<?php echo $_SESSION['list_time']?>">Back to the program listing!</a></td>
</tr>
</table>
<?
	// Print the main page footer
		parent::print_footer();
	}

}

?>