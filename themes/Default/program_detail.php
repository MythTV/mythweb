<?
/***                                                                        ***\
	program_detail.php                       Last Updated: 2004.01.14 (xris)

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
			<td><span class="huge"><a href="search.php?searchstr=<?=urlencode($this_program->title)?>&search_title=yes">"<?=$this_program->title?>"</a>
			<? if (strlen($this_program->starstring) > 0) echo ", $this_program->starstring";?>
			</span><BR>"
				<span class="small">
				<?=date('g:i A', $this_program->starttime)?> to <?=date('g:i A', $this_program->endtime)?> (<?=(int)($this_program->length/60)?> minutes)<BR>
				<?
				if ($this_program->previouslyshown)
					echo '(Rerun) ';
				echo " (<a href=\"http://www.imdb.com/Find?select=Titles&for=" . urlencode($this_program->title) . "\">Search IMDB</a>)";
				echo " (<a href=\"http://www.google.com/search?q=" . urlencode($this_program->title) . "\">Search Google</a>)";					
				?></span></td>
		</tr><tr>
			<td colspan="3">&nbsp;</td>
		</tr><? if (!isset($_GET[recordid]) && strlen($this_program->subtitle)) { ?><tr>
			<td colspan="2" align="right">Episode:&nbsp;</td>
			<td><?=$this_program->subtitle?></td>
		</tr><? }
				if (!isset($_GET[recordid]) && strlen($this_program->description)) {?><tr>
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
			<td><?=$this_program->rating?></td>
		</tr><? } ?>
		</table>

	<td valign="top" align="right" rowspan="2">

		<form action="program_detail.php" method="get" name="record_settings">
		<? if (isset($_GET[recordid])) {?>
		<input type="hidden" name="recordid" value="<?=$_GET['recordid']?>">
		<? } else {?>
		<input type="hidden" name="chanid" value="<?=$_GET['chanid']?>">
		<input type="hidden" name="starttime" value="<?=$_GET['starttime']?>">
		<? } ?>

		<table class="command command_border_l command_border_t command_border_b command_border_r" align="center" border="0" cellspacing="0" cellpadding="5">
		<tr>
			<td><p align="center">Recording Options:</p></td></tr>
		<tr><td>
				<input type="radio" class="radio" name="record" value="never" id="record_never"<?=
				$this_program->will_record ? '' : ' CHECKED'?>></input>
				<a onclick="get_element('record_never').checked=true;">Don't record this program.</a>
				<br/>
				<input type="radio" class="radio" name="record" value="once" id="record_once"<?=
				$this_program->record_once ? ' CHECKED' : ''?>></input>
				<a onclick="get_element('record_once').checked=true;">Record only this showing.</a>
				<br/>
				<input type="radio" class="radio" name="record" value="daily" id="record_daily"<?=
				$this_program->record_daily ? ' CHECKED' : ''?>></input>
				<a onclick="get_element('record_daily').checked=true;">Record this program in this timeslot every day.</a>
				<br/>
				<input type="radio" class="radio" name="record" value="weekly" id="record_weekly"<?=
				$this_program->record_weekly ? ' CHECKED' : ''?>></input>
				<a onclick="get_element('record_weekly').checked=true;">Record this program in this timeslot every week.</a>
				<br/>
				<input type="radio" class="radio" name="record" value="channel" id="record_channel"<?=
				$this_program->record_channel ? ' CHECKED' : ''?>></input>
				<a onclick="get_element('record_channel').checked=true;">Always record this program on this channel.</a>
				<br/>
				<input type="radio" class="radio" name="record" value="always" id="record_always"<?=
				$this_program->record_always ? ' CHECKED' : ''?>></input>
				<a onclick="get_element('record_always').checked=true;">Always record this program on any channel.</a>
				<br/>
				<input type="radio" class="radio" name="record" value="findone" id="record_findone"<?=
				$this_program->record_findone ? ' CHECKED' : ''?>></input>
				<a onclick="get_element('record_always').checked=true;">Record one showing of this program at any time.</a>
		</td></tr>
		<tr><td><p>
				<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td nowrap align="right">Recording Profile:&nbsp;</td>
					<td><select align=right name="profile"><?php
						global $Profiles;
						foreach($Profiles as $profile) {
							echo '<option value="'.htmlentities($profile).'"';
							if ($this_program->profile == $profile)
								echo ' SELECTED';
							echo '>'.htmlentities($profile).'</option>';
						}
						?></select></td>
				</tr><tr>
					<td nowrap align="right">Recpriority:&nbsp;</td>
					<td><select align=right name="recpriority"><?php
						for($recprioritycount=99;$recprioritycount>=-99;--$recprioritycount) {
							echo '<option value="'.$recprioritycount.'"';
							if ($this_program->recpriority == $recprioritycount)
								echo ' SELECTED';
							echo ">$recprioritycount</option>";
						}
						?></select></td>
				</tr><tr>
					<td nowrap align="right">Record Duplicates?&nbsp;</td>
					<td><input type="checkbox" class="radio" name="recorddups"<?php if ($this_program->recorddups) echo ' CHECKED' ?>></td>
				</tr><tr>
					<td nowrap align="right">Auto-expire Recordings?&nbsp;</td>
					<td><input type="checkbox" class="radio" name="autoexpire" <?php if ($this_program->autoexpire) echo "CHECKED" ?>></td>
				</tr><tr>
					<td nowrap align="right">No of recordings to keep?&nbsp;</td>
					<td><input type="input" name="maxepisodes" size="1" value="<?php echo htmlentities($this_program->maxepisodes) ?>"></td>
				</tr><tr>
					<td nowrap align="right">Record new and expire old?&nbsp;</td>
					<td><input type="checkbox" class="radio" name="maxnewest" <?php if ($this_program->maxnewest) echo "CHECKED" ?>></td>
				</tr>
				</table>
				</p>

				<p align="center"><input type="submit" class="submit" name="save" value="Update Recording Settings"></p></td>

		</tr>
		</table>

		</form>
	</td>
</tr>
<tr>
	<td height="100%" align="center" valign="bottom">
		<? if (isset($_GET[recordid])) { ?>
	<a href="all_recordings.php">Back to All recordings!</a></td>
		<? } else { ?>
	<a href="program_listing.php?time=<?php echo $this_program->starttime?>">What else is on at this time?</a>&nbsp;&nbsp;&nbsp;
        <a href="program_listing.php?time=<?php echo $_SESSION['list_time']?>">Back to the program listing!</a></td> <? } ?>
	</td>
</tr>
</table>
<?
	// Print the main page footer
		parent::print_footer();
	}

}

?>
