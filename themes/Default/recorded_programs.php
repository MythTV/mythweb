<?php
/***                                                                        ***\
	recorded_programs.php                    Last Updated: 2003.06.30 (xris)

	This file defines a theme class for the recorded programs section.
	It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_recorded_programs extends Theme {

	function print_page() {
	// Print the main page header
		parent::print_header("MythWeb - Recorded Programs");
	// Print the page contents
		global $All_Shows;
?>

<script language="JavaScript" type="text/javascript">
<!--

// javascript to rewrite the "delete" links so they bring up a confirmation box.
//  by default, these will just submit, but if javascript is enabled, we want to
//  require confirmation.
	var files = new Array();
<?	foreach ($All_Shows as $show) { ?>
	files.push([<?=escape($show->title.': '.$show->subtitle)?>, <?=escape(urlencode($show->filename))?>]);
<?	} ?>

	on_load['recorded_programs'] = fix_hrefs;
	function fix_hrefs() {
		for (i=0;i<<?=count($All_Shows)?>;i++) {
			get_element('delete_' + i).innerHTML = '<a onclick="confirm_delete('+i+')">Delete</a>';
		}
	}

	function confirm_delete(id) {
		if (confirm("Are you sure you want to delete the following show?\n\n     "+files[id][0]))
			location.href = "recorded_programs.php?delete=yes&file="+files[id][1];
	}

// -->
</script>

<p>
<form class="form" id="program_titles" action="recorded_programs.php" method="get">
<table class="command command_border_l command_border_t command_border_b command_border_r" border="0" cellspacing="0" cellpadding="4" align="center">
<tr>
	<td>Show recordings:</td>
	<td><select name="title" onchange="get_element('program_titles').submit()">
		<option value="">All recordings</option><?
		global $Program_Titles;
		foreach($Program_Titles as $title => $count) {
			echo '<option value="'.$title.'"';
			if ($_GET['title'] == $title)
				echo ' SELECTED';
			echo '>'.$title.($count > 1 ? " ($count episodes)" : "").'</option>';
		}
		?>
	</select></td>
	<td><input type="submit" value="Go"></td>
</tr>
</table>
</form>
</p>

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
<?php	if (show_recorded_pixmap) { ?>
	<td>preview</td>
<?php	} ?>
	<td><a href="recorded_programs.php?sortby=title">show</a></td>
	<td>episode</td>
	<td>description</td>
	<td><a href="recorded_programs.php?sortby=channum">station</a></td>
	<td><a href="recorded_programs.php?sortby=airdate">air&nbsp;date</a></td>
	<td><a href="recorded_programs.php?sortby=length">length</a></td>
	<td><a href="recorded_programs.php?sortby=filesize">file&nbsp;size</a></td>
</tr><?php
	$row = 0;
	foreach ($All_Shows as $show) {
	?><tr class="recorded">
<?php
		if (show_recorded_pixmaps) {
			generate_preview_pixmap($show);
?>
	<td><img id="<?php echo $show->filename?>" src="<?=pixmap_web_path?>/<?=basename($show->filename)?>.png" width="<?php echo pixmap_width?>" height="<?php echo pixmap_height?>"></td>
<?php
		}
?>
	<td><?=$show->title?></td>
	<td><?=$show->subtitle?></td>
	<td><?=$show->description?></td>
	<td><?=$show->channame?></td>
	<td nowrap><?=date('D, M j,Y (g:i A)', $show->starttime)?></td>
	<td nowrap><?=$show->length?></td>
	<td nowrap><?=$show->filesize?></td>
	<td width="5%" class="command command_border_l command_border_t command_border_b command_border_r" align="center">
		<span id="delete_<?=$row?>"><a href="recorded_programs.php?delete=yes&file=<?=urlencode($show->filename)?>">Delete</a></span></td>
</tr><?
		$row++;
	}
?>

</table>
<?
	echo '<p align="right" style="padding-right: 75px">'.disk_free.' out of '.disk_size.' used</p>';

	// Print the main page footer
		parent::print_footer();
	}

}

?>