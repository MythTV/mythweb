<?
/***                                                                        ***\
    program_listing.php                      Last Updated: 2003.07.23 (xris)

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
		parent::print_header('MythWeb - Program Listing:  '.date('F j, Y, g:i A', $start_time));
	// Print the header info specific to the program listing
?>
<p>
<table align="center" width="90%" cellspacing="2" cellpadding="2">
<tr>
	<td width="50%" align="center">Currently Browsing:  <?=date('F j, Y, g:i A', $start_time)?></td>
	<td class="command command_border_l command_border_t command_border_b command_border_r" align="center">
		<form class="form" action="program_listing.php" method="get">
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>

			<td align="center">Jump&nbsp;to:&nbsp;&nbsp;</td>
			<td align="right">Hour:&nbsp;</td>
			<td><select name="hour"><?
				for ($h=0;$h<24;$h++) {
					echo "<option value=\"$h\"";
					if ($h == date('H', $start_time))
						echo ' SELECTED';
					echo ">$h:00</option>";
				}
				?></select></td>
			<td align="right">Date:&nbsp;</td>
			<td><select name="date"><?
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
					echo ">".date("F j, Y" , $time)."</option>";
				}
				?></select></td>
			<td align="center"><input type="submit" class="submit" value="Jump"></td>


		</tr>
		</table>
		</form></td>
</tr>
</table>
</p>

<p>
<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<?
	}

	/*
		print_footer:
		This function prints the footer portion of the page specific to the program listing
	*/
	function print_footer() {
?>
</table>
</p>
<?
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
	<td class="menu" width="4%" align="right"><a href="program_listing.php?time=<?=$start_time - (timeslot_size * num_time_slots)?>#anchor<?=$timeslot_anchor?>" name="anchor<?=$timeslot_anchor?>"><img src="images/left.gif" border="0" alt="left"></a></td>
<?		foreach ($timeslots as $time) { ?>
	<td class="menu" width="<?=(int)(96 / num_time_slots)?>%" align="center"><?=date('g:i', $time)?></td>
<?		} ?>
	<td class="menu" width="2%"><a href="program_listing.php?time=<?=$start_time + (timeslot_size * num_time_slots)?>#anchor<?=$timeslot_anchor?>"><img src="images/right.gif" border="0" alt="right"></a></td>
</tr><?
	}

	/*
		print_channel:

	*/
	function print_channel($channel, $start_time, $end_time) {
?>
<tr>
	<td align="center" class="menu" nowrap><?
	if (show_channel_icons === true) {
		?><table class="small" width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td width="50%" align="center" nowrap><a href="channel_detail.php?chanid=<?=$channel->chanid?>&time=<?=$start_time?>" class="huge"
											onmouseover="window.status='Details for: <?=$channel->channum?> <?=$channel->callsign?>';return true"
											onmouseout="window.status='';return true"><?=prefer_channum ? $channel->channum : $channel->callsign?></a>&nbsp;</td>
			<td width="50%" align="right"><?
				if (is_file($channel->icon)) {
					?><a href="channel_detail.php?chanid=<?=$channel->chanid?>&time=<?=$start_time?>"
						onmouseover="window.status='Details for: <?=$channel->channum?> <?=$channel->callsign?>';return true"
						onmouseout="window.status='';return true"><img src="<?=$channel->icon?>" height="30" width="30"></a><?
				} else {
					echo '&nbsp;';
				}?></td>
		</tr><tr>
			<td colspan="2" align="center" nowrap><a href="channel_detail.php?chanid=<?=$channel->chanid?>&time=<?=$start_time?>"
											onmouseover="window.status='Details for: <?=$channel->channum?> <?=$channel->callsign?>';return true"
											onmouseout="window.status='';return true"><?=prefer_channum ? $channel->callsign : $channel->channum?></a></td>
		</tr>
		</table><?
	} else {
		?><a href="channel_detail.php?chanid=<?=$channel->chanid?>" class="huge"
			onmouseover="window.status='Details for: <?=$channel->channum?> <?=$channel->callsign?>';return true"
			onmouseout="window.status='';return true"><?=prefer_channum ? $channel->channum : $channel->callsign?><BR>
		<?=prefer_channum ? $channel->callsign : $channel->channum?></a><?
	}
		?></td>
<?
// Let the channel object figure out how to display its programs
	$channel->display_programs($start_time, $end_time);
?>
	<td>&nbsp;</td>
</tr><?
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
			$Footnotes[] = "<div id=\"program_$program_id_counter\" class=\"hidden\">
<table class=\"menu small\" border=\"1\" cellpadding=\"5\" cellspacing=\"0\">
<tr>
	<td><table class=\"menu small\" cellpadding=\"2\" cellspacing=\"0\">
		<tr>
			<td align=\"right\">Airtime:</td>
			<td>".date('g:i A', $program->starttime).' to '.date('g:i A', $program->endtime)."</td>
		</tr><tr>
			<td align=\"right\">Program:</td>
			<td>$program->title</td>
		</tr>"
		.(strlen($program->subtitle) > 0 ? "<tr>
			<td align=\"right\">Episode:</td>
			<td>$program->subtitle</td>
		</tr>" : '')
		.(strlen($program->description) > 0 ? "<tr>
			<td align=\"right\" valign=\"top\">Description:</td>
			<td>$program->description</td>
		</tr>" : '')
		.(strlen($program->rating) > 0 ? "<tr>
			<td align=\"right\" valign=\"top\">Rating:</td>
			<td>$program->rating</td>
		</tr>" : '')
		.($program->airdate > 0 ? "<tr>
			<td align=\"right\">Orig.&nbsp;Airdate:</td>
			<td>$program->airdate</td>
		</tr>" : '')
		.(strlen($program->category) > 0 ? "<tr>
			<td align=\"right\">Category:</td>
			<td>$program->category</td>
		</tr>" : '')
		.($program->previouslyshown ? "<tr>
			<td align=\"right\">Rerun:</td>
			<td>Yes</td>
		</tr>" : '')
		.($program->will_record ? "<tr>
			<td align=\"right\">Schedule:</td>
			<td>".($show->record_daily       ? "Always record on this channel at this time"
					: ($show->record_weekly  ? "Always record on this channel at this time on this day of the week"
					: ($show->record_once    ? "Will be recorded once"
					: ($show->record_channel ? "Always record on this channel"
					: "Always record"))))."</td>
		</tr>" : '')
		."</table></td>
</tr>
</table>
</div>";
		}

// then, we just display the info
?>
	<td class="small <?php echo $program->class ?>" colspan="<?php echo $timeslots_used?>" valign="top"><?
	// Print a link to record this show
		echo '<a id="program_'.$program_id_counter.'_anchor" href="program_detail.php?chanid='.$program->chanid.'&starttime='.$program->starttime.'"'
			 .(show_popup_info ? ' onmouseover="window.status=\'Details for: '.str_replace('\'', '\\\]', $program->title).'\';show(\'program_'.$program_id_counter.'\');return true"'
			 					.' onmouseout="window.status=\'\';hide(\'program_'.$program_id_counter.'\');return true"'
							   : '')
			 .'>'.$program->title
			 .(strlen($program->subtitle) > 0 ? ":<BR>$program->subtitle" : '')
			 .'</a>';
	// Print some additional information for movies
		if ($program->category_type == 'movie') {
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
<?
	}

	/*
		print_nodata:

	*/
	function print_nodata($timeslots_left) {
		echo "\t<td class=\"small tv_Unknown\" colspan=\"$timeslots_left\" valign=\"top\">NO DATA</td>\n";
	}

}

?>
