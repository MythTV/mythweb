<?
/***                                                                        ***\
	scheduled_recordings.php                    Last Updated: 2003.06.29 (xris)

	This file defines a theme class for the scheduled recordings section.
	It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_scheduled_recordings extends Theme {

	function print_page() {
	// Print the main page header
		parent::print_header('MythWeb - Scheduled Recordings');
	// Print the page contents
		global $All_Shows;
?>

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
	<td><a href="scheduled_recordings.php?sortby=title">show</a></td>
	<td><a href="scheduled_recordings.php?sortby=channum">station</a></td>
	<td><a href="scheduled_recordings.php?sortby=airdate">air&nbsp;date</a></td>
	<td><a href="scheduled_recordings.php?sortby=length">length</a></td>
</tr><?
	$row = 0;
	foreach ($All_Shows as $show) {
	// Reset the command variable
		$command = '';
	// Which class does this show fall into?
		if ($show->duplicate == 1) {
			$class = 'duplicate';
			$command = '<a href="scheduled_recordings.php?rerecord=yes&title='.urlencode($show->title).'&subtitle='.urlencode($show->subtitle).'&description='.urlencode($show->description).'">Rerecord</a>';
		}
		elseif ($show->conflicting == 1) {
			$class   = 'conflict';
			$command = '<a href="scheduled_recordings.php?record=yes&chanid='.$show->chanid.'&starttime='.$show->starttime.'&endtime='.$show->endtime.'">Record</a>';
		}
		elseif ($show->recording == 0) {
			$class   = 'deactivated';
			$command = '<a href="scheduled_recordings.php?activate=yes&chanid='.$show->chanid.'&starttime='.$show->starttime.'&endtime='.$show->endtime.'">Activate</a>';
		}
		else {
			$class   = 'scheduled';
			#$command = 'Don\'t&nbsp;Record';
			$command = '';
		}
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
			<td>".date('D, M j, g:i A', $show->starttime).' to '.date('g:i A', $show->endtime)."</td>
		</tr><tr>
			<td align=\"right\">Program:</td>
			<td>$show->title</td>
		</tr>"
		.(strlen($show->subtitle) > 0 ? "<tr>
			<td align=\"right\">Episode:</td>
			<td>$show->subtitle</td>
		</tr>" : '')
		.(strlen($show->description) > 0 ? "<tr>
			<td align=\"right\" valign=\"top\">Description:</td>
			<td>$show->description</td>
		</tr>" : '')
		.(strlen($show->rating) > 0 ? "<tr>
			<td align=\"right\" valign=\"top\">Rating:</td>
			<td>$show->rating</td>
		</tr>" : '')
		.($show->airdate > 0 ? "<tr>
			<td align=\"right\">Orig.&nbsp;Airdate:</td>
			<td>$show->airdate</td>
		</tr>" : '')
		.(strlen($show->category) > 0 ? "<tr>
			<td align=\"right\">Category:</td>
			<td>$show->category</td>
		</tr>" : '')
		.($show->previouslyshown ? "<tr>
			<td align=\"right\">Rerun:</td>
			<td>Yes</td>
		</tr>" : '')
		.($show->will_record ? "<tr>
			<td align=\"right\">Schedule:</td>
			<td>".($show->record_timeslot   ? "Always record on this channel at this time"
					: $show->record_once    ? "Will be recorded once"
					: $show->record_channel ? "Always record on this channel"
					: "Always record")."</td>
		</tr>" : '')
		."</table></td>
</tr>
</table>
</div>";
		}
	// Print the content
	?><tr class="<?=$class?>">
	<td class="<?=$show->class?>"><?php
		// Print a link to record this show
		echo '<a href="program_detail.php?chanid='.$show->chanid.'&starttime='.$show->starttime.'"'
			 .(show_popup_info ? ' onmouseover="window.status=\'Details for: '.str_replace('\'', '\\\]', $show->title).'\';show(\'program_'.$program_id_counter.'\');return true"'
			 					.' onmouseout="window.status=\'\';hide(\'program_'.$program_id_counter.'\');return true"'
							   : '')
			 .'>'.$show->title
			 .(preg_match('/\\w/', $show->subtitle) ? ":  $show->subtitle" : '')
			 .'</a>';
		?></td>
	<td><?=$show->channel->name?></td>
	<td nowrap><?=date('D, M j (g:i A)', $show->starttime)?></td>
	<td nowrap><?=$show->length?></td>
<?	if ($command) { ?>
	<td width="5%" class="command command_border_l command_border_t command_border_b command_border_r" align="center"><?=$command?></td>
<?	} ?>
</tr><?
		$row++;
	}
?>

</table>
<?

	// Print the main page footer
		parent::print_footer();
	}

}

?>