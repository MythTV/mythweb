<?php
/***                                                                        ***\
	recorded_programs.php                    Last Updated: 2004.05.04 (xris)

	This file defines a theme class for the recorded programs section.
	It must define one method.   documentation will be added someday.

\***                                                                        ***/

require_once theme_dir . 'utils.php';

#class theme_program_detail extends Theme {
class Theme_recorded_programs extends Theme {

	function print_page() {
	// Print the main page header
		parent::print_header("MythWeb - Recorded Programs");
	// Print the page contents
		global $All_Shows;

		$_GET['start'] or $_GET['start'] = $_POST['start'];
		$_GET['start'] or $_GET['start'] = 0;

		if (strcasecmp(programs_per_page, 'All'))
		{
			$page_start = $_GET['start'];
			if ($page_start >= count($All_Shows))
				$page_start = 0;
			$page_end = $page_start + programs_per_page;
			if ($page_end > count($All_Shows))
				$page_end = count($All_Shows);
		}
		else
		{
			$page_start = 0;
			$page_end = count($All_Shows);
		}
?>

<script language="JavaScript" type="text/javascript">
<!--

// javascript to rewrite the "delete" links so they bring up a confirmation box.
//  by default, these will just submit, but if javascript is enabled, we want to
//  require confirmation.
	var files = new Array();
<?
		$row = 0;
		foreach ($All_Shows as $show) {
			++$row;
			if ($row <= $page_start || $row > $page_end)
				continue;
	?>
	files.push([<?=escape($show->title.': '.$show->subtitle)?>, <?=escape(urlencode($show->filename))?>]);
<?		} ?>

	on_load['recorded_programs'] = fix_hrefs;
	function fix_hrefs() {
		for (i=<?=$page_start?>;i<<?=$page_end?>;i++) {
			get_element('delete_' + i).innerHTML = '<a onclick="confirm_delete('+(i-<?=$page_start?>)+')">Delete</a>';
		}
	}

	function confirm_delete(id) {
		if (confirm("Are you sure you want to delete the following show?\n\n     "+files[id][0]))
			location.href = "recorded_programs.php?delete=yes&file="+files[id][1]+"&start="+<?=$page_start?>;
	}

// -->
</script>

<p>
<form class="form" id="program_titles" action="recorded_programs.php" method="get">
	Show recordings: &nbsp;
	<select name="title" onchange="get_element('program_titles').submit()">
		<option value="">All recordings</option><?
		global $Program_Titles;
		foreach($Program_Titles as $title => $count) {
			echo '<option value="'.$title.'"';
			if ($_GET['title'] == $title)
				echo ' SELECTED';
			echo '>'.$title.($count > 1 ? " ($count episodes)" : "").'</option>';
		}
		?>
	</select> &nbsp;
	<input type="submit" value="Go">
</form>
</p>

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
<?php	if (show_recorded_pixmap) { ?>
	<td>preview</td>
<?php	} ?>
	<td><a href="recorded_programs.php?sortby=title">show</a></td>
	<td>description</td>
	<td><a href="recorded_programs.php?sortby=channum">station</a></td>
	<td><a href="recorded_programs.php?sortby=airdate">air&nbsp;date</a></td>
	<td><a href="recorded_programs.php?sortby=length">length</a></td>
	<td><a href="recorded_programs.php?sortby=filesize">file&nbsp;size</a></td>
</tr><?php
		$row = 0;
		$TotalSize = 0;
		$TotalLength = 0;
		foreach ($All_Shows as $show) {
			++$row;
			$TotalSize += $show->filesize;
			$TotalLength += $show->length;
			if ($row <= $page_start || $row > $page_end)
				continue;
	?><tr class="recorded">
<?php
			if (show_recorded_pixmaps) {
				generate_preview_pixmap($show);
?>
	<td><img id="<?php echo $show->filename?>" src="<?=image_cache?>/<?=basename($show->filename)?>.png" width="<?php echo pixmap_width?>" height="<?php echo pixmap_height?>"></td>
<?php
			}
?>
	<td><?=$show->title?><?=trim($show->subtitle) != "" ? ": $show->subtitle" : ""?></td>
	<td><?=$show->description?></td>
	<td><?=$show->channame?></td>
	<td nowrap><?=nice_date($show->starttime)?><br><?php strftime('%i', $show->starttime)?></td>
	<td nowrap align="right"><?=nice_duration($show->length)?></td>
	<td nowrap align="right"><?=nice_filesize($show->filesize)?></td>
	<td width="5%" class="command command_border_l command_border_t command_border_b command_border_r" align="center">
		<span id="delete_<?=$row-1?>"><a href="recorded_programs.php?delete=yes&file=<?=urlencode($show->filename)?>">Delete</a></span></td>
</tr><?
		}
?>

<tr class="recorded">
	<td class="list" colspan="<?=show_recorded_pixmaps ? 7 : 6?>" align="right">
		<?=nice_filesize($TotalSize)?> used for <?=count($All_Shows)?> shows totaling <?=nice_duration($TotalLength)?><br>
		<?=nice_filesize(disk_size - disk_used)?> available for recording
	</td>
</tr>

</table>

<?
		if (programs_per_page < count($All_Shows) && strcasecmp(programs_per_page, 'All'))
		{
			echo '<p align="center">';

			if ($page_start > 0)
			{
				$back = $page_start - programs_per_page;
				if ($back < 0)
					$back = 0;
				echo "	<a href=\"recorded_programs.php?start=$back\">&lt;&lt; Back</a> &nbsp; | &nbsp;";
			}

			for($i=0; $i<count($All_Shows); $i += programs_per_page)
			{
				if (0 != $i)
					echo " &nbsp; | &nbsp;";

				$end = $i + programs_per_page;
				if ($end > count($All_Shows))
					$end = count($All_Shows);

				if ($i != $page_start)
					print "<a href=\"recorded_programs.php?start=$i\">".($i+1)." - $end</a>";
				else
					print "<b>".($i+1)." - $end</b>";
			}

			if ($page_end < count($All_Shows))
				print "\n	&nbsp; | &nbsp; <a href=\"recorded_programs.php?start=$page_end\">Next &gt;&gt;</a>";

			print "\n</p><br>";
		}

	// Print the main page footer
		parent::print_footer();
	}

}

?>
