<?php
/***                                                                        ***\
	recorded_programs.php                    Last Updated: 2004.02.05 (xris)

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
				get_element('delete_' + i).href = 'javascript:confirm_delete('+i+')';
		}
	}

	function confirm_delete(id) {
		if (confirm("<?php echo _LANG_CONFIRM_DELETE?>\n\n     "+files[id][0]))
			location.href = "recorded_programs.php?delete=yes&file="+files[id][1];
	}

// -->
</script>

<p>
<form class="form" id="program_titles" action="recorded_programs.php" method="get">
<table class="command command_border_l command_border_t command_border_b command_border_r" border="0" cellspacing="0" cellpadding="4" align="center">
<tr>
	<td><?php echo _LANG_SHOW_RECORDINGS?>:</td>
	<td><select name="title" onchange="get_element('program_titles').submit()">
		<option value=""><?php echo _LANG_ALL_RECORDINGS?></option><?php
		global $Program_Titles;
		foreach($Program_Titles as $title => $count) {
			echo '<option value="'.$title.'"';
			if ($_GET['title'] == $title)
				echo ' SELECTED';
			echo '>'.$title.($count > 1 ? " ($count episodes)" : "").'</option>';
		}
		?>
	</select></td>
	<td><input type="submit" value="<?php echo _LANG_GO?>"></td>
</tr>
</table>
</form>
</p>

<?
// Setup for grouping by various sort orders
$group_field = $_GET['sortby'];
if ($group_field == "") {
    $group_field = "airdate";
} elseif ( ! (($group_field == "title") || ($group_field == "channum") || ($group_field == "airdate")) ) {
	$group_field = "";
}

?>

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
<?php
	if ($group_field != "")
		echo "\t<td class=\"list\">&nbsp;</td>\n";
	if (show_recorded_pixmaps)
		echo "\t<td>"._LANG_PREVIEW."</td>\n";
?>
	<td><a href="recorded_programs.php?sortby=title"><?php echo _LANG_TITLE?></a></td>
	<td><a href="recorded_programs.php?sortby=subtitle"><?php echo _LANG_SUBTITLE?></a></td>
<?php
	if ($_SESSION['recorded_descunder'] != "on")
		echo "\t<td><a href=\"recorded_programs.php?sortby=description\">"._LANG_DESCRIPTION."</a></td>\n";
?>
	<td><a href="recorded_programs.php?sortby=channum"><?php echo _LANG_STATION?></a></td>
	<td><a href="recorded_programs.php?sortby=airdate"><?php echo _LANG_AIRDATE?></a></td>
	<td><a href="recorded_programs.php?sortby=length"><?php echo _LANG_LENGTH?></a></td>
	<td><a href="recorded_programs.php?sortby=filesize"><?php echo _LANG_FILE_SIZE?></a></td>
</tr><?php
	$row = 0;

	$prev_group="";
	$cur_group="";

	foreach ($All_Shows as $show) {

	// Print a dividing row if grouping changes
	if ($group_field == "airdate")
	    $cur_group = date($_SESSION['date_listing_jump'], $show->starttime);
	elseif ($group_field == "channum")
		$cur_group = $show->channel->name;
	elseif ($group_field == "title")
		$cur_group = $show->title;

	if ( $cur_group != $prev_group && $group_field != '' ) {
?><tr class="list_separator">
	<td colspan="9" class="list_separator"><?=$cur_group?></td>
</tr><?
	}
?><tr class="recorded">
<?php
	if ($group_field != "")
        if ($_SESSION['recorded_descunder'] != "on")
		    echo "\t<td class=\"list\">&nbsp;</td>\n";
        else
		    echo "\t<td class=\"list\" rowspan=\"2\">&nbsp;</td>\n";
	if (show_recorded_pixmaps) {
        if ($_SESSION['recorded_descunder'] != "on")
    	    echo "\t<td>";
        else
		    echo "\t<td rowspan=\"2\">";
		generate_preview_pixmap($show);
		if (file_exists(image_cache.'/'.basename($show->filename).'.png')) {
			if (@file_exists(video_dir.'/'.basename($show->filename)))
				echo '<a href="'.video_dir.'/'.basename($show->filename).'">';
			echo '<img id="'.$show->filename."\" src=\"".image_cache.'/'.basename($show->filename).'.png" width="'.pixmap_width.'" height="'.pixmap_height.'" border="0">';
			if (@file_exists(video_dir.'/'.basename($show->filename)))
				echo '</a>';
		}
		else
			echo '&nbsp;';
		echo "</td>\n";
	}
	?>
	<td><?php echo $show->title?></td>
	<td><?php echo $show->subtitle?></td>
<?php
    if ($_SESSION['recorded_descunder'] != "on")
        echo("<td>".$show->description."</td>");
?>
	<td><?php echo $show->channame?></td>
	<td nowrap><?php echo date($_SESSION['date_recorded'], $show->starttime)?></td>
	<td nowrap><?php echo nice_length($show->length)?></td>
	<td nowrap><?php echo nice_filesize($show->filesize)?></td>
<?php	if ($show->endtime > time()) { ?>
	<td width="5%">currently recording</td>
<?php	} else { ?>
	<td width="5%" class="command command_border_l command_border_t command_border_b command_border_r" align="center">
		<a id="delete_<?php echo $row?>" href="recorded_programs.php?delete=yes&file=<?php echo urlencode($show->filename)?>"><?php echo _LANG_DELETE?></a></td>
<?php	} ?>
</tr><?
		if ($_SESSION['recorded_descunder'] == "on")
			echo("<tr class=\"recorded\">\n\t<td colspan=\"7\">".$show->description."</td>\n</tr>");
		$prev_group = $cur_group;
		$row++;
	}
?>

</table>
<?php
	echo '<p align="right" style="padding-right: 75px">'.$GLOBALS['Total_Programs'].' '._LANG_PROGRAMS_USING.nice_filesize(disk_used)._LANG_OUT_OF.nice_filesize(disk_size).'</p>';

	// Print the main page footer
		parent::print_footer();
	}

}

?>
