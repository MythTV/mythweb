<?php
/***                                                                        ***\
	recorded_programs.php                    Last Updated: 2003.08.20 (xris)

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
<?php	foreach ($All_Shows as $show) { ?>
	files.push([<?php echo escape($show->title.': '.$show->subtitle)?>, <?php echo escape(urlencode($show->filename))?>]);
<?php	} ?>

	on_load['recorded_programs'] = fix_hrefs;
	function fix_hrefs() {
		for (i=0;i<<?php echo count($All_Shows)?>;i++) {
			if (get_element('delete_' + i))
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
		<option value="">All recordings</option><?php
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
	<td><a href="recorded_programs.php?sortby=subtitle">episode</a></td>
	<td><a href="recorded_programs.php?sortby=description">description</a></td>
	<td><a href="recorded_programs.php?sortby=channum">station</a></td>
	<td><a href="recorded_programs.php?sortby=airdate">air&nbsp;date</a></td>
	<td><a href="recorded_programs.php?sortby=length">length</a></td>
	<td><a href="recorded_programs.php?sortby=filesize">file&nbsp;size</a></td>
</tr><?php
	$row = 0;
	foreach ($All_Shows as $show) {
	?><tr class="recorded">
	<td><?php
		if (show_recorded_pixmaps) {
			generate_preview_pixmap($show);
			if (file_exists(image_cache.'/'.basename($show->filename).'.png'))
				echo '<img id="'.$show->filename."\" src=\"".image_cache.'/'.basename($show->filename).'.png" width="'.pixmap_width.'" height="'.pixmap_height.'">';
			else
				echo '&nbsp;';
		}
	?></td>
	<td><?php echo $show->title?></td>
	<td><?php echo $show->subtitle?></td>
	<td><?php echo $show->description?></td>
	<td><?php echo $show->channame?></td>
	<td nowrap><?php echo date('D, M j,Y (g:i A)', $show->starttime)?></td>
	<td nowrap><?php echo nice_length($show->length)?></td>
	<td nowrap><?php echo nice_filesize($show->filesize)?></td>
<?php	if ($show->endtime > time()) { ?>
	<td width="5%">currently recording</td>
<?php	} else { ?>
	<td width="5%" class="command command_border_l command_border_t command_border_b command_border_r" align="center">
		<span id="delete_<?php echo $row?>"><a href="recorded_programs.php?delete=yes&file=<?php echo urlencode($show->filename)?>">Delete</a></span></td>
<?php	} ?>
</tr><?
		$row++;
	}
?>

</table>
<?php
	echo '<p align="right" style="padding-right: 75px">'.$GLOBALS['Total_Programs'].' programs, using '.nice_filesize(disk_used).' out of '.nice_filesize(disk_size).'</p>';

	// Print the main page footer
		parent::print_footer();
	}

}

?>