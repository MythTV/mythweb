<?php
/***                                                                        ***\
    recorded_programs.php                    Last Updated: 2004.07.06 (xris)

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
<?php   foreach ($All_Shows as $show) { ?>
    files.push([<?php echo escape($show->title.': '.$show->subtitle)?>, <?php echo escape(urlencode($show->filename))?>]);
<?php   } ?>

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
            echo '<option value="'.htmlspecialchars($title).'"';
            if ($_GET['title'] == $title)
                echo ' SELECTED';
            echo '>'.htmlentities($title, ENT_COMPAT, 'UTF-8').($count > 1 ? " ($count "._LANG_EPISODES.")" : "").'</option>';
        }
        ?>
    </select></td>
    <td><noscript><input type="submit" value="<?php echo _LANG_GO?>"></noscript></td>
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
    <td><?php echo get_sort_link('title')    ?></td>
    <td><?php echo get_sort_link('subtitle') ?></td>
<?php
    if (!$_SESSION['recorded_descunder'])
        echo "\t<td>".get_sort_link('description')."</td>\n";
?>
    <td><?php echo get_sort_link('channum')   ?></td>
    <td><?php echo get_sort_link('airdate')   ?></td>
    <td><?php echo get_sort_link('length')    ?></td>
    <td><?php echo get_sort_link('file_size') ?></td>
</tr><?php
    $row = 0;

    $prev_group="";
    $cur_group="";

    foreach ($All_Shows as $show) {

    // Print a dividing row if grouping changes
    if ($group_field == "airdate")
        $cur_group = strftime($_SESSION['date_listing_jump'], $show->starttime);
    elseif ($group_field == "channum")
        $cur_group = $show->channel->name;
    elseif ($group_field == "title")
        $cur_group = $show->title;

    if ( $cur_group != $prev_group && $group_field != '' ) {
?><tr class="list_separator">
    <td colspan="9" class="list_separator"><?php echo $cur_group ?></td>
</tr><?
    }
?><tr class="recorded">
<?php
    if ($group_field != "")
        echo "\t<td class=\"list\" rowspan=\"".($_SESSION['recorded_descunder'] ? 3 : 2)."\">&nbsp;</td>\n";
    if (show_recorded_pixmaps) {
        echo "\t<td rowspan=\"".($_SESSION['recorded_descunder'] ? 3 : 2).'">';
        generate_preview_pixmap($show);
        if (file_exists(image_cache.'/'.basename($show->filename).'.png')) {
            echo '<a href="'.video_url.'/'.basename($show->filename).'">'
                .'<img id="'.$show->filename."\" src=\"".image_cache.'/'.basename($show->filename).'.png" width="'.pixmap_width.'" height="'.pixmap_height.'" border="0">'
                .'</a>';
        }
        else
            echo '&nbsp;';
        echo "</td>\n";
    }
    ?>
    <td><?php echo '<a href="'.video_url.'/'.basename($show->filename).'">'.$show->title.'</a>'    ?></td>
    <td><?php echo '<a href="'.video_url.'/'.basename($show->filename).'">'.$show->subtitle.'</a>' ?></td>
<?php
    if (!$_SESSION['recorded_descunder'])
        echo "\t<td>".$show->description."</td>\n";
?>
    <td><?php echo $show->channel->channum, ' - <nobr>', $show->channel->name ?></nobr></td>
    <td nowrap align="center"><?php echo strftime($_SESSION['date_recorded'], $show->starttime)?></td>
    <td nowrap><?php echo nice_length($show->length)?></td>
    <td nowrap><?php echo nice_filesize($show->filesize)?></td>
<?php   if ($show->endtime > time()) { ?>
    <td width="5%">currently recording</td>
<?php   } else { ?>
    <td width="5%" rowspan="<?php echo $_SESSION['recorded_descunder'] ? 3 : 2 ?>" class="command command_border_l command_border_t command_border_b command_border_r" align="center">
        <a id="delete_<?php echo $row?>" href="recorded_programs.php?delete=yes&file=<?php echo urlencode($show->filename)?>"><?php echo _LANG_DELETE?></a></td>
<?php   }

        if ($_SESSION['recorded_descunder'])
            echo("</tr><tr class=\"recorded\">\n\t<td colspan=\"6\">".$show->description."</td>\n");
        $prev_group = $cur_group;
        $row++;
?>
</tr><tr class="recorded">
    <td nowrap colspan="<?php echo $_SESSION['recorded_descunder'] ? 6 : 7 ?>" align="center">
        <span style="padding-right: 25px"><?php echo _LANG_SHOW_HAS_COMMFLAG?>:&nbsp;
            <b><?php echo $show->has_commflag ? _LANG_YES : _LANG_NO ?></b></span>
        <span style="padding-right: 25px"><?php echo _LANG_SHOW_HAS_CUTLIST?>:&nbsp;
            <b><?php echo $show->has_cutlist ? _LANG_YES : _LANG_NO ?></b></span>
        <span style="padding-right: 25px"><?php echo _LANG_SHOW_IS_EDITING?>:&nbsp;
            <b><?php echo $show->is_editing ? _LANG_YES : _LANG_NO ?></b></span>
        <span style="padding-right: 25px"><?php echo _LANG_SHOW_AUTO_EXPIRE?>:&nbsp;
            <b><?php echo $show->auto_expire ? _LANG_YES : _LANG_NO ?></b></span>
        <?php echo _LANG_SHOW_HAS_BOOKMARK?>:&nbsp;
            <b><?php echo $show->bookmark ? _LANG_YES : _LANG_NO ?></b>
        </td>
<?php
    }
?>
</table>
<?php
    echo '<p align="right" style="padding-right: 75px">'.$GLOBALS['Total_Programs'].' '._LANG_PROGRAMS_USING.' '.nice_filesize(disk_used)._LANG_OUT_OF.nice_filesize(disk_size).'</p>';

    // Print the main page footer
        parent::print_footer();
    }

}

?>
