<?
/***                                                                        ***\
	scheduled_recordings.php                    Last Updated: 2003.12.18 (xris)

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

<script language="JavaScript" type="text/javascript">
<!--
	function changevisible() {
		var prev_visible_class = "no_padding";

		for (var i=1; i < document.getElementById("listings").rows.length; i++) {
			if (document.getElementById("listings").rows[i].className == "list_separator") {
				if (prev_visible_class == "list_separator")
					document.getElementById("listings").rows[i].style.display = "none";
				else
					document.getElementById("listings").rows[i].style.display = "";
				prev_visible_class = "list_separator";
			}
			else {
	 			if (document.getElementById(document.getElementById("listings").rows[i].className).checked) {
					document.getElementById("listings").rows[i].style.display = "";
					prev_visible_class = document.getElementById("listings").rows[i].className;
	 			}
				else
					document.getElementById("listings").rows[i].style.display = "none";
			}
      	}
	}
// -->
</script>

<table border="0" align="center">
<tr>
	<td>Display:</td>
	<td><input type="checkbox" id="scheduled" class="radio" onclick="changevisible()" CHECKED></td>
	<td>Scheduled</td>
	<td><input type="checkbox" id="duplicate" class="radio" onclick="changevisible()" CHECKED></td>
	<td>Duplicates</td>
	<td><input type="checkbox" id="deactivated" class="radio" onclick="changevisible()" CHECKED></td>
	<td>Deactivated</td>
	<td><input type="checkbox" id="conflict" class="radio" onclick="changevisible()" CHECKED></td>
	<td>Conflicts</td>
</tr>
</table>

<?
$group_field = $_GET['sortby'];
if ($group_field == "") {
    $group_field = "airdate";
} elseif ( ! (($group_field == "title") || ($group_field == "channum") || ($group_field == "airdate")) ) {
	$group_field = "";
}
?>

<table id="listings" width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
	<?php if ($group_field != "") { echo "<td>&nbsp;</td>"; } ?>
	<td><a href="scheduled_recordings.php?sortby=title">show</a></td>
	<td><a href="scheduled_recordings.php?sortby=channum">station</a></td>
	<td><a href="scheduled_recordings.php?sortby=airdate">air&nbsp;date</a></td>
	<td><a href="scheduled_recordings.php?sortby=length">length</a></td>
</tr><?
	$row = 0;

	$prev_group="";
	$cur_group="";

	foreach ($All_Shows as $show) {
	// Reset the command variable to a default URL
		$commands = array();
		$urlstr = 'chanid='.$show->chanid.'&starttime='.$show->starttime;
	// Which class does this show fall into?
# This needs a major overhaul, to support the new recording schedule types, etc
		if ($show->norecord == 'PreviousRecording' || $show->norecord == 'CurrentRecording') {
			$class = 'duplicate';
			$commands[] = '<a href="scheduled_recordings.php?record=yes&'.$urlstr.'">Record This</a>';
			$commands[] = '<a href="scheduled_recordings.php?forget_old=yes&'.$urlstr.'">Forget Old</a>';
		}
		elseif ($show->conflicting == 1) {
			$class   = 'conflict';
			$commands[] = '<a href="scheduled_recordings.php?record=yes&'.$urlstr.'">Record This</a>';
			$commands[] = '<a href="scheduled_recordings.php?suppress=yes&'.$urlstr.'">Don\'t&nbsp;Record</a>';
		}
		elseif ($show->norecord == 'AutoConflict') {
			$class   = 'deactivated';
			$commands[] = '<a href="scheduled_recordings.php?record=yes&'.$urlstr.'">Activate</a>';
			$commands[] = '<a href="scheduled_recordings.php?suppress=yes&'.$urlstr.'">Don\'t&nbsp;Record</a>';
		}
		elseif ($show->recording == 0 || $show->norecord) {
			$class   = 'deactivated';
			$commands[] = '<a href="scheduled_recordings.php?record=yes&'.$urlstr.'">Activate</a>';
			$commands[] = '<a href="scheduled_recordings.php?suppress=yes&'.$urlstr.'">Don\'t&nbsp;Record</a>';
		}
		else {
			$class   = 'scheduled';
			$commands[] = '<a href="scheduled_recordings.php?suppress=yes&'.$urlstr.'">Don\'t&nbsp;Record</a>';
		// Offer to suppress any recordings that have enough info to do so.
			if (preg_match('/\\S/', $show->title) && preg_match('/\\S/', $show->subtitle) && preg_match('/\\S/', $show->description))
				$commands[] = '<a href="scheduled_recordings.php?never_record=yes&'.$urlstr.'">Never&nbsp;Record</a>';
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
			<td>".date($_SESSION['date_scheduled_popup'].', '.$_SESSION['time_format'], $show->starttime).' to '.date($_SESSION['time_format'], $show->endtime)."</td>
		</tr><tr>
			<td align=\"right\">Program:</td>
			<td>$show->title</td>
		</tr>"
		.(preg_match('/\\S/', $show->subtitle) ? "<tr>
			<td align=\"right\">Episode:</td>
			<td>$show->subtitle</td>
		</tr>" : '')
		.(preg_match('/\\S/', $show->description) ? "<tr>
			<td align=\"right\" valign=\"top\">Description:</td>
			<td>".nl2br(wordwrap($show->description, 70))."</td>
		</tr>" : '')
		.(preg_match('/\\S/', $show->rating) ? "<tr>
			<td align=\"right\" valign=\"top\">Rating:</td>
			<td>$show->rating</td>
		</tr>" : '')
		.($show->airdate > 0 ? "<tr>
			<td align=\"right\">Orig.&nbsp;Airdate:</td>
			<td>$show->airdate</td>
		</tr>" : '')
		.(preg_match('/\\S/', $show->category) ? "<tr>
			<td align=\"right\">Category:</td>
			<td>$show->category</td>
		</tr>" : '')
		.($show->previouslyshown ? "<tr>
			<td align=\"right\">Rerun:</td>
			<td>Yes</td>
		</tr>" : '')
		.($show->will_record ? "<tr>
			<td align=\"right\">Schedule:</td>
			<td>".($show->record_daily       ? "Always record on this channel at this time"
					: ($show->record_weekly  ? "Always record on this channel at this time on this day of the week"
					: ($show->record_once    ? "Will be recorded once"
					: ($show->record_channel ? "Always record on this channel"
					: "Always record"))))."</td>
		</tr>" : '')
		.(preg_match('/\\S/', $show->profile) ? "<tr>
			<td align=\"right\">Profile:</td>
			<td>$show->profile</td>
		</tr>" : '')
		.($show->norecord ? "<tr>
			<td align=\"right\">Not recording:</td>
			<td>".$GLOBALS['No_Record_Reasons'][$show->norecord].' ('.$show->norecord.")</td>
		</tr>" : '')
		."</table></td>
</tr>
</table>
</div>";
		}

	// Print a dividing row if grouping changes
	if ($group_field == "airdate")
	    $cur_group = date($_SESSION['date_listing_jump'], $show->starttime);
	elseif ($group_field == "channum")
		$cur_group = $show->channel->name;
	elseif ($group_field == "title")
		$cur_group = $show->title;

	if ( $cur_group != $prev_group && $group_field != '' ) {
?><tr class="list_separator">
	<td colspan="6" class="list_separator"><?=$cur_group?></td>
</tr><?
	}

	// Print the content
	?><tr class="<?=$class?>">
	<?php if ($group_field != "") { echo "<td>&nbsp;</td>"; } ?>
	<td class="<?=$show->class?>"><?php
		// Print a link to record this show
		echo '<a id="program_'.$program_id_counter.'_anchor" href="program_detail.php?chanid='.$show->chanid.'&starttime='.$show->starttime.'"'
			 .(show_popup_info ? ' onmouseover="window.status=\'Details for: '.str_replace('\'', '\\\]', $show->title).'\';show(\'program_'.$program_id_counter.'\');return true"'
			 					.' onmouseout="window.status=\'\';hide(\'program_'.$program_id_counter.'\');return true"'
							   : '')
			 .'>'.$show->title
			 .(preg_match('/\\w/', $show->subtitle) ? ":  $show->subtitle" : '')
			 .'</a>';
		?></td>
	<td><?=$show->channel->name?></td>
	<td nowrap><?=date($_SESSION['date_scheduled'], $show->starttime)?></td>
	<td nowrap><?=nice_length($show->length)?></td>
<?	foreach ($commands as $command) { ?>
	<td nowrap width="5%" class="command command_border_l command_border_t command_border_b command_border_r" align="center"><?=$command?></td>
<?	} ?>
</tr><?
		$prev_group = $cur_group;
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
