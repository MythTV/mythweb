<?php
/***                                                                        ***\
    program_listing.php                      Last Updated: 2004.02.05 (xris)

	This file defines a theme class for the program listing section.
	It must define several methods, some of which have specific
	parameters.   documentation will be added someday.
\***                                                                        ***/


#class theme_program_listing extends Theme {
class Theme_program_listing extends Theme {

	/*
		print_header:
		This function prints the header portion of the page specific to the program listing
	*/
	function print_header($start_time, $end_time) {
	// Print the main page header
		parent::print_header('MythWeb - Program Listing:  '.date('D F j, Y, g:i A', $start_time));
	// Print the header info specific to the program listing
?>
<p>
<table align="center" width="90%" cellspacing="2" cellpadding="2">
<tr>
	<td width="50%" align="center"><?php echo _LANG_CURRENTLY_BROWSING?>:<?php echo date('D, F j, Y, g:i A', $start_time)?></td>
	<td class="command command_border_l command_border_t command_border_b command_border_r" align="center">
		<form class="form" id="program_listing" action="program_listing.php" method="get">
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>

			<td align="center"><? echo _LANG_JUMP_TO?>:&nbsp;&nbsp;</td>
			<td align="right"><? echo _LANG_HOUR?>:&nbsp;</td>
			<td><select name="hour" style="text-align: right" onchange="get_element('program_listing').submit()"><?php
				for ($h=0;$h<24;$h++) {
					echo "<option value=\"$h\"";
					if ($h == date('H', $start_time))
						echo ' SELECTED';
					echo '>'.date($_SESSION['time_format'], strtotime("$h:00")).'</option>';
				}
				?></select></td>
			<td align="right"><?echo _LANG_DATE?>:&nbsp;</td>
			<td><select name="date" onchange="get_element('program_listing').submit()"><?php
			// Find out how many days into the future we should bother checking
				$result = mysql_query('SELECT TO_DAYS(max(starttime)) - TO_DAYS(NOW()) FROM program')
					or trigger_error('SQL Error: '.mysql_error(), FATAL);
				list($max_days) = mysql_fetch_row($result);
				mysql_free_result($result);
			// Print out the list
				for ($i=-1;$i<=$max_days;$i++) {
					$time = mktime(0,0,0, date('m'), date('d') + $i, date('Y'));
					$date = date("Ymd", $time);
					echo "<option value=\"$date\"";
					if ($date == date("Ymd", $start_time)) echo " selected";
					echo ">".date($_SESSION['date_listing_jump'] , $time)."</option>";
				}
				?></select></td>
			<td align="center"><input type="submit" class="submit" value="<? echo _LANG_JUMP?>"></td>


		</tr>
		</table>
		</form></td>
</tr>
</table>
</p>

<p>
<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<?php
	}


	function print_page(&$Channels, &$Timeslots, $list_starttime, $list_endtime) {
	// Display the listing page header
		$this->print_header($list_starttime, $list_endtime);

		$this->print_timeslots($Timeslots, $list_starttime, $list_endtime, 'first');

		// Go through each channel and load/print its info - use references to avoid "copy" overhead
		$channel_count = 0;
		foreach (array_keys($Channels) as $key) {
		// Ignore channels with no number
			if (strlen($Channels[$key]->channum) < 1)
				continue;

			// Ignore invisible channels
			if ($Channels[$key]->visible == 0) {
				continue;
			}
		// Count this channel
			$channel_count++;
		// Grab the reference
			$channel = &$Channels[$key];
		// Print the data
			$this->print_channel(&$channel, $list_starttime, $list_endtime);
		// Cleanup is a good thing
			unset($channel);
		// Display the timeslot bar?
			if ($channel_count % timeslotbar_skip == 0)
				$this->print_timeslots($Timeslots, $list_starttime, $list_endtime, $channel_count);
		}

	// Display the listing page footer
		$this->print_footer();
	}


	/*
		print_footer:
		This function prints the footer portion of the page specific to the program listing
	*/
	function print_footer() {
?>
</table>
</p>
<?php
	// Print the main page's footer
		parent::print_footer();
	}

	/*
		print_timeslot:

	*/
	function print_timeslots($timeslots, $start_time, $end_time, $sequence = NULL) {
		static $timeslot_anchor = 0;
// Update the timeslot anchor
#	if (!isset($timeslot_anchor))
#		$timeslot_anchor = 0;
		$timeslot_anchor++;
?><tr>
	<td class="menu" width="4%" align="right"><a href="program_listing.php?time=<?php echo $start_time - (timeslot_size * num_time_slots)?>#anchor<?php echo $timeslot_anchor?>" name="anchor<?php echo $timeslot_anchor?>"><img src="images/left.gif" border="0" alt="left"></a></td>
<?php
		$count;
		foreach ($timeslots as $time) {
			if ($count++ % timeslot_blocks) continue;
?>
	<td class="menu" colspan="<?php echo timeslot_blocks ?>" width="<?php echo (int)(timeslot_blocks * 96 / num_time_slots)?>%" align="center"><a href="program_listing.php?time=<?php echo $time.'#anchor'.$timeslot_anchor ?>"><?php echo date($_SESSION['time_format'], $time)?></a></td>
<?php	} ?>
	<td class="menu" width="2%"><a href="program_listing.php?time=<?php echo $start_time + (timeslot_size * num_time_slots)?>#anchor<?php echo $timeslot_anchor?>"><img src="images/right.gif" border="0" alt="right"></a></td>
</tr><?php
	}

	/*
		print_channel:

	*/
	function print_channel($channel, $start_time, $end_time) {
?>
<tr>
	<td align="center" class="menu" nowrap><?php
	if (show_channel_icons === true) {
		?><table class="small" width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td width="50%" align="center" nowrap><a href="channel_detail.php?chanid=<?php echo $channel->chanid?>&time=<?php echo $start_time?>" class="huge"
											onmouseover="window.status='Details for: <?php echo $channel->channum?> <?php echo $channel->callsign?>';return true"
											onmouseout="window.status='';return true"><?php echo prefer_channum ? $channel->channum : $channel->callsign?></a>&nbsp;</td>
			<td width="50%" align="right"><?php
				if (is_file($channel->icon)) {
					?><a href="channel_detail.php?chanid=<?php echo $channel->chanid?>&time=<?php echo $start_time?>"
						onmouseover="window.status='Details for: <?php echo $channel->channum?> <?php echo $channel->callsign?>';return true"
						onmouseout="window.status='';return true"><img src="<?php echo $channel->icon?>" height="30" width="30"></a><?php
				} else {
					echo '&nbsp;';
				}?></td>
		</tr><tr>
			<td colspan="2" align="center" nowrap><a href="channel_detail.php?chanid=<?php echo $channel->chanid?>&time=<?php echo $start_time?>"
											onmouseover="window.status='Details for: <?php echo $channel->channum?> <?php echo $channel->callsign?>';return true"
											onmouseout="window.status='';return true"><?php echo prefer_channum ? $channel->callsign : $channel->channum?></a></td>
		</tr>
		</table><?php
	} else {
		?><a href="channel_detail.php?chanid=<?php echo $channel->chanid?>" class="huge"
			onmouseover="window.status='Details for: <?php echo $channel->channum?> <?php echo $channel->callsign?>';return true"
			onmouseout="window.status='';return true"><?php echo prefer_channum ? $channel->channum : $channel->callsign?><BR>
		<?php echo prefer_channum ? $channel->callsign : $channel->channum?></a><?php
	}
		?></td>
<?php
// Let the channel object figure out how to display its programs
	$channel->display_programs($start_time, $end_time);
?>
	<td>&nbsp;</td>
</tr><?php
	}

	/*
		print_program:

	*/
	function print_program($program, $timeslots_used, $list_starttime) {
	// Build a popup table for the mouseover of the cell, with extra program information?
		if (show_popup_info) {
		// A program id counter
			static $program_id_counter = 0;
			$program_id_counter++;
		// Add a footnote
			global $Footnotes;
			$Footnotes[] = "<div id=\"program_{$program_id_counter}_popup\" class=\"hidden\">
<table class=\"menu small\" border=\"1\" cellpadding=\"5\" cellspacing=\"0\">
<tr>
	<td><table class=\"menu small\" cellpadding=\"2\" cellspacing=\"0\">
		<tr>
			<td align=\"right\">"._LANG_AIRTIME.":</td>
			<td>".date($_SESSION['time_format'], $program->starttime).' to '.date($_SESSION['time_format'], $program->endtime)."</td>
		</tr><tr>
			<td align=\"right\">"._LANG_TITLE.":</td>
			<td>$program->title</td>
		</tr>"
		.(strlen($program->subtitle) > 0 ? "<tr>
			<td align=\"right\">"._LANG_SUBTITLE.":</td>
			<td>$program->subtitle</td>
		</tr>" : '')
		.(strlen($program->description) > 0 ? "<tr>
			<td align=\"right\" valign=\"top\">"._LANG_DESCRIPTION.":</td>
			<td>".nl2br(wordwrap($program->description, 70))."</td>
		</tr>" : '')
		.(strlen($program->rating) > 0 ? "<tr>
			<td align=\"right\" valign=\"top\">"._LANG_RATING.":</td>
			<td>$program->rating</td>
		</tr>" : '')
		.($program->airdate > 0 ? "<tr>
			<td align=\"right\">"._LANG_ORIG_AIRDATE.":</td>
			<td>$program->airdate</td>
		</tr>" : '')
		.(strlen($program->category) > 0 ? "<tr>
			<td align=\"right\">"._LANG_CATEGORY.":</td>
			<td>$program->category</td>
		</tr>" : '')
		.($program->previouslyshown ? "<tr>
			<td align=\"right\">"._LANG_RERUN.":</td>
			<td>Yes</td>
		</tr>" : '')
		.($program->will_record ? "<tr>
			<td align=\"right\">"._LANG_SCHEDULE.":</td>
			<td>".($program->record_daily       ? _LANG_RECTYPE_LONG_DAILY
					: ($program->record_weekly  ? _LANG_RECTYPE_LONG_WEEKLY
					: ($program->record_once    ? _LANG_RECTYPE_LONG_ONCE
					: ($program->record_channel ? _LANG_RECTYPE_LONG_CHANNEL
					: ($program->record_findone ? _LANG_RECTYPE_LONG_FINDONE
					: _LANG_RECTYPE_LONG_ALWAYS)))))."</td>
		</tr>" : '')
		.($program->recstatus ? "<tr>
			<td align=\"right\">"._LANG_NOTES.":</td>
			<td>".$GLOBALS['RecStatus_Reasons'][$program->recstatus]."</td>
		</tr>" : '')
		."</table></td>
</tr>
</table>
</div>";
		}

// then, we just display the info
		$percent = (int)($timeslots_used * 96 / num_time_slots);
?>
	<td class="small <?php echo $program->class ?>" colspan="<?php echo $timeslots_used?>" width="<?php echo $percent?>%" valign="top"><?php
		$mouseover = 'onmouseover="window.status=\''.date($_SESSION['time_format'], $program->starttime).' - '.date($_SESSION['time_format'], $program->endtime).' -- '
					 .str_replace(array("'", '"'),array("\\'", '&quot;'), $program->title)
					 .($program->subtitle ? ':  '.str_replace(array("'", '"'),array("\\'", '&quot;'), $program->subtitle)
					 					  : '')
					 .'\';';
		if (show_popup_info)
			$mouseover .= 'show(\'program_'.$program_id_counter.'\');';
		$mouseover .= 'return true;" onmouseout="window.status=\'\';';
		if (show_popup_info)
			$mouseover .= 'hide();';
		$mouseover .= 'return true;"';
	// Print a link to record this show
		echo '<a id="program_'.$program_id_counter.'" href="program_detail.php?chanid='.$program->chanid.'&starttime='.$program->starttime.'"'.$mouseover.'>';
		if ($percent > 5) {
			echo $program->title;
			if (strlen($program->subtitle) > 0) {
				if ($percent > 8)
					echo ":<BR>$program->subtitle";
				else
					echo ': ...';
			}
		}
		else
			echo '...';
		echo '</a>';
	// Print some additional information for movies
		if ($program->category_type == 'movie'
				|| $program->category_type == 'Film') {
			if ($program->airdate > 0)
				$parens = sprintf('%4d', $program->airdate);
			if (strlen($program->rating) > 0) {
				if ($parens)
					$parens .= ", ";
				$parens .= "<i>$program->rating</i>";
			}
			if (strlen($program->starstring) > 0) {
				if ($parens)
					$parens .= ", ";
				$parens .= $program->starstring;
			}
			if ($parens)
				echo " ($parens)";
		}
	// Finally, print some other information
		if ($program->previouslyshown)
			echo "<BR><i>(Rerun)</i>";
	?></td>
<?php
	}

	/*
		print_nodata:

	*/
	function print_nodata($timeslots_left) {
		echo "\t<td class=\"small tv_Unknown\" colspan=\"$timeslots_left\" valign=\"top\">NO DATA</td>\n";
	}

}

?>
