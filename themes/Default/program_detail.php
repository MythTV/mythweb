<?php
/***                                                                        ***\
	program_detail.php                       Last Updated: 2004.02.05 (xris)

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
			<td width="<?php echo prefer_channum ? '80' : '120'?>px" class="menu menu_border_t menu_border_b menu_border_l menu_border_r" width="60" align="center" nowrap><?php
				if (show_channel_icons === true) {
					?><table class="small" width="100%" border="0" cellspacing="0" cellpadding="2">
					<tr>
						<td width="50%" align="center" nowrap><a href="channel_detail.php?chanid=<?php echo $this_channel->chanid?>&time=<?php echo $start_time?>" class="huge"
														onmouseover="window.status='Details for: <?php echo $this_channel->channum?> <?php echo $this_channel->callsign?>';return true"
														onmouseout="window.status='';return true"><?php echo prefer_channum ? $this_channel->channum : $this_channel->callsign?></a>&nbsp;</td>
						<td width="50%" align="right"><?php
							if (is_file($this_channel->icon)) {
								?><a href="channel_detail.php?chanid=<?php echo $this_channel->chanid?>&time=<?php echo $start_time?>"
									onmouseover="window.status='Details for: <?php echo $this_channel->channum?> <?php echo $this_channel->callsign?>';return true"
									onmouseout="window.status='';return true"><img src="<?php echo $this_channel->icon?>" height="30" width="30"></a><?php
							} else {
								echo '&nbsp;';
							}?></td>
					</tr><tr>
						<td colspan="2" align="center" nowrap><a href="channel_detail.php?chanid=<?php echo $this_channel->chanid?>&time=<?php echo $start_time?>"
														onmouseover="window.status='Details for: <?php echo $this_channel->channum?> <?php echo $this_channel->callsign?>';return true"
														onmouseout="window.status='';return true"><?php echo prefer_channum ? $this_channel->callsign : $this_channel->channum?></a></td>
					</tr>
					</table><?php
				} else {
					?><a href="channel_detail.php?chanid=<?php echo $this_channel->chanid?>" class="huge"
						onmouseover="window.status='Details for: <?php echo $this_channel->channum?> <?php echo $this_channel->callsign?>';return true"
						onmouseout="window.status='';return true"><?php echo prefer_channum ? $this_channel->channum : $this_channel->callsign ?><BR>
					<?php echo prefer_channum ? $this_channel->callsign : $this_channel->channum?></a><?php
				}
					?></td>
			<td width="24px">&nbsp;</td>
			<td><span class="huge"><a href="search.php?searchstr=<?php echo urlencode($this_program->title)?>&search_title=yes">"<?php echo $this_program->title?>"</a>
			<?php if (strlen($this_program->starstring) > 0) echo ", $this_program->starstring";?>
			</span><BR>
				<span class="small">
				<?php
				if (isset($_GET[recordid])) echo "<em>";
				echo date('D, M jS', $this_program->starttime) . "<BR>";
				echo date('g:i A', $this_program->starttime) ." to " . date('g:i A', $this_program->endtime);
				if (!isset($_GET[recordid])) echo "(" . (int)($this_program->length/60) . " minutes)";?><BR>
				<?php
				if ($this_program->previouslyshown)
					echo '(Rerun) ';
				if (isset($_GET[recordid])) echo "</em>";
				echo " (<a href=\"http://www.imdb.com/Find?select=Titles&for=" . urlencode($this_program->title) . "\">Search IMDB</a>)";
				echo " (<a href=\"http://www.google.com/search?q=" . urlencode($this_program->title) . "\">Search Google</a>)";
				?></span></td>
		</tr><tr>
			<td colspan="3">&nbsp;</td>
		</tr><?php if (strlen($this_program->subtitle)) { ?><tr>
			<td colspan="2" align="right"> <?php if (isset($_GET[recordid])) echo "<em>"; ?>Episode:&nbsp;
							<?php if (isset($_GET[recordid])) echo "</em>"; ?></td>
			<td><?php if (isset($_GET[recordid])) echo "<em>";
				  echo $this_program->subtitle;
				  if (isset($_GET[recordid])) echo "</em>"; ?></td>
		</tr><?php }
				if (strlen($this_program->description)) { ?><tr>
			<td colspan="2" align="right" valign="top"> <?php if (isset($_GET[recordid])) echo "<em>";?>
				Description:&nbsp;<?php if (isset($_GET[recordid])) echo "</em>"; ?></td>
			<td><?php if (isset($_GET[recordid])) echo "<em>";
				  echo wordwrap($this_program->description, 45, "<BR>\n");
				  if (isset($_GET[recordid])) echo "</em>"; ?></td>
		</tr><?php } ?><tr>
			<td colspan="3">&nbsp;</td>
		</tr><?php if (strlen($this_program->category)) {?><tr>
			<td colspan="2" align="right">Category:&nbsp;</td>
			<td><?php echo $this_program->category?></td>
		</tr><?php }
				if (strlen($this_program->airdate)) {?><tr>
			<td nowrap colspan="2" align="right">Orig. Airdate:&nbsp;</td>
			<td><?php echo $this_program->airdate?></td>
		</tr><?php }
				if (strlen($this_program->rating)) {?><tr>
			<td colspan="2" align="right"><?php echo strlen($this_program->rater) > 0 ? "$this_program->rater " : ''?>Rating:&nbsp;</td>
			<td><?php echo $this_program->rating?></td>
		</tr><?php } ?>
		</table>

	<td valign="top" align="right" rowspan="2">

		<form action="program_detail.php" method="get" name="record_settings">
		<?php if (isset($_GET[recordid])) {?>
		<input type="hidden" name="recordid" value="<?php echo $_GET['recordid']?>">
		<?php } else {?>
		<input type="hidden" name="chanid" value="<?php echo $_GET['chanid']?>">
		<input type="hidden" name="starttime" value="<?php echo $_GET['starttime']?>">
		<?php } ?>

		<table class="command command_border_l command_border_t command_border_b command_border_r" align="center" border="0" cellspacing="0" cellpadding="5">
		<tr>
			<td><p align="center">Recording Options:</p></td></tr>
		<tr><td>
				<input type="radio" class="radio" name="record" value="never" id="record_never"<?php echo
				$this_program->will_record ? '' : ' CHECKED'?>></input>
				<a onclick="get_element('record_never').checked=true;"><?php if (isset($_GET[recordid])) { ?>
					Cancel this schedule.
				<?php } else { ?>
					Don't record this program. <?php } ?></a>
				<br/>
				<?php if (($this_program->type == 1) || ($this_program->starttime > time())) { ?>
				<input type="radio" class="radio" name="record" value="once" id="record_once"<?php echo
				$this_program->record_once ? ' CHECKED' : ''?>></input>
				<a onclick="get_element('record_once').checked=true;">Record only this showing.</a>
				<br/>
				<?php } ?>
				<input type="radio" class="radio" name="record" value="daily" id="record_daily"<?php echo
				$this_program->record_daily ? ' CHECKED' : ''?>></input>
				<a onclick="get_element('record_daily').checked=true;">Record this program in this timeslot every day.</a>
				<br/>
				<input type="radio" class="radio" name="record" value="weekly" id="record_weekly"<?php echo
				$this_program->record_weekly ? ' CHECKED' : ''?>></input>
				<a onclick="get_element('record_weekly').checked=true;">Record this program in this timeslot every week.</a>
				<br/>
				<input type="radio" class="radio" name="record" value="channel" id="record_channel"<?php echo
				$this_program->record_channel ? ' CHECKED' : ''?>></input>
				<a onclick="get_element('record_channel').checked=true;">Always record this program on channel <?php echo prefer_channum ? $this_channel->channum : $this_channel->callsign ?>.</a>
				<br/>
				<input type="radio" class="radio" name="record" value="always" id="record_always"<?php echo
				$this_program->record_always ? ' CHECKED' : ''?>></input>
				<a onclick="get_element('record_always').checked=true;">Always record this program on any channel.</a>
				<br/>
				<input type="radio" class="radio" name="record" value="findone" id="record_findone"<?php echo
				$this_program->record_findone ? ' CHECKED' : ''?>></input>
				<a onclick="get_element('record_findone').checked=true;">Record one showing of this program at any time.</a>
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
					<td nowrap align="right">Check For Duplicates In:&nbsp;</td>
					<td><select align=right name="dupin"><?php
							echo '<option value="1"';
							if ($this_program->dupin == 1)
								echo ' SELECTED';
							echo '>Current Recordings</option>';
							echo '<option value="2"';
							if ($this_program->dupin == 2)
								echo ' SELECTED';
							echo '>Previous Recordings</option>';
							echo '<option value="15"';
							if (($this_program->dupin == 15) ||
								($this_program->dupin == 0))
								echo ' SELECTED';
							echo '>All Recordings</option>';
					   ?></select></td>
				</tr><tr>
					<td nowrap align="right">Duplicate Check Method:&nbsp;</td>
					<td><select align=right name="dupmethod"><?php
							echo '<option value="1"';
							if ($this_program->dupmethod == 1)
								echo ' SELECTED';
							echo '>None</option>';
							echo '<option value="2"';
							if ($this_program->dupmethod == 2)
								echo ' SELECTED';
							echo '>Subtitle</option>';
							echo '<option value="4"';
							if ($this_program->dupmethod == 4)
								echo ' SELECTED';
							echo '>Description</option>';
							echo '<option value="6"';
							if (($this_program->dupmethod == 6) ||
								($this_program->dupmethod == 0))
								echo ' SELECTED';
							echo '>Subtitle & Description</option>';
					   ?></select></td>
				</tr><tr>
					<td nowrap align="right">Auto-expire Recordings?&nbsp;</td>
					<td><input type="checkbox" class="radio" name="autoexpire" <?php if ($this_program->autoexpire) echo "CHECKED" ?>></td>
				</tr><tr>
					<td nowrap align="right">No of recordings to keep?&nbsp;</td>
					<td><input type="input" name="maxepisodes" size="1" value="<?php echo htmlentities($this_program->maxepisodes) ?>"></td>
				</tr><tr>
					<td nowrap align="right">Record new and expire old?&nbsp;</td>
					<td><input type="checkbox" class="radio" name="maxnewest" <?php if ($this_program->maxnewest) echo "CHECKED" ?>></td>
				</tr><tr>
					<td nowrap align="right">Start Early (minutes):&nbsp;</td>
					<td><input type="input" name="startoffset" size="1" value="<?php echo htmlentities($this_program->startoffset) ?>"></td>
				</tr><tr>
					<td nowrap align="right">End Late (minutes):&nbsp;</td>
					<td><input type="input" name="endoffset" size="1" value="<?php echo htmlentities($this_program->endoffset) ?>"></td>
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
		<?php if (isset($_GET[recordid])) { ?>
	<a href="recording_schedules.php">Back to Recording Schedules</a></td>
		<?php } else { ?>
	<a href="program_listing.php?time=<?php echo $this_program->starttime?>">What else is on at this time?</a>&nbsp;&nbsp;&nbsp;
	<a href="search.php?searchstr=<?php echo $this_program->title?>&search_title=1&search_exact=1">Find other showings of this program</a>&nbsp;&nbsp;&nbsp;
        <a href="program_listing.php?time=<?php echo $_SESSION['list_time']?>">Back to the program listing!</a></td> <?php } ?>
	</td>
</tr>
</table>
<?php
	// Print the main page footer
		parent::print_footer();
	}

}

?>
