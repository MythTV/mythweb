<?php
/***                                                                        ***\
    recorded_programs.php                    Last Updated: 2004.11.30 (xris)

    This file defines a theme class for the recorded programs section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_recorded_programs extends Theme {

    function print_page() {
    // Print the main page header
        parent::print_header("MythWeb - Recorded Programs");
    // Print the page contents
        global $All_Shows, $Total_Time;
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
        if (confirm("<?php echo t('Are you sure you want to delete the following show?') ?>\n\n     "+files[id][0]))
            location.href = "recorded_programs.php?delete=yes&file="+files[id][1];
    }

// -->
</script>

<p>
<form class="form" id="program_titles" action="recorded_programs.php" method="get">
<table class="command command_border_l command_border_t command_border_b command_border_r" border="0" cellspacing="0" cellpadding="4" align="center">
<tr>
    <td><?php echo t('Show recordings') ?>:</td>
    <td><select name="title" onchange="get_element('program_titles').submit()">
        <option value=""><?php echo t('All recordings') ?></option><?php
        global $Program_Titles;
        foreach($Program_Titles as $title => $count) {
            echo '<option value="'.htmlspecialchars($title).'"';
            if ($_GET['title'] == $title)
                echo ' SELECTED';
            echo '>'.htmlentities($title, ENT_COMPAT, 'UTF-8')
                .($count > 1 ? ' ('.tn('$1 episode', '$1 episodes', $count).')' : "")
                .'</option>';
        }
        ?>
    </select></td>
    <td><?php echo t('Show group') ?>:</td>
    <td><select name="recgroup" onchange="get_element('program_titles').submit()">
        <option value=""><?php echo t('All recordings')?></option><?php
        global $Groups;
        foreach($Groups as $recgroup => $count) {
            echo '<option value="'.htmlspecialchars($recgroup).'"';
            if ($_GET['recgroup'] == $recgroup)
                echo ' SELECTED';
            echo '>'.htmlentities($recgroup, ENT_COMPAT, 'UTF-8')
                .' ('.tn('$1 recording', '$1 recordings', $count)
                .')</option>';
        }
        ?>
    </select></td>
    <td><noscript><input type="submit" value="<?php echo t('Go') ?>"></noscript></td>
</tr>
</table>
</form>
</p>

<?
// Setup for grouping by various sort orders
$group_field = $_GET['sortby'];
if ($group_field == "") {
    $group_field = "airdate";
} elseif ( ! (($group_field == "title") || ($group_field == "channum") || ($group_field == "airdate") || ($group_field == "recgroup")) ) {
    $group_field = "";
}

?>

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
<?php
    if ($group_field != "")
        echo "\t<td class=\"list\">&nbsp;</td>\n";
    if (show_recorded_pixmaps)
        echo "\t<td>".t('preview')."</td>\n";
?>
    <td><?php echo get_sort_link('title',    t('title'))    ?></td>
    <td><?php echo get_sort_link('subtitle', t('subtitle')) ?></td>
<?php
    if (!$_SESSION['recorded_descunder'])
        echo "\t<td>".get_sort_link('description', t('description'))."</td>\n";
?>
    <td><?php echo get_sort_link('channum',   t('channum'))  ?></td>
    <td><?php echo get_sort_link('recgroup',  t('recgroup'))  ?></td>
    <td><?php echo get_sort_link('airdate',   t('airdate'))  ?></td>
    <td><?php echo get_sort_link('length',    t('length'))   ?></td>
    <td><?php echo get_sort_link('file_size', t('file size')) ?></td>
</tr><?php
    $row = 0;

    $prev_group="";
    $cur_group="";

    foreach ($All_Shows as $show) {

    // Print a dividing row if grouping changes
    if ($group_field == "airdate")
        $cur_group = strftime($_SESSION['date_listing_jump'], $show->starttime);
    elseif ($group_field == "recgroup")
        $cur_group = $show->recgroup;
    elseif ($group_field == "channum")
        $cur_group = $show->channel->name;
    elseif ($group_field == "title")
        $cur_group = $show->title;

    if ( $cur_group != $prev_group && $group_field != '' ) {
?><tr class="list_separator">
    <td colspan="10" class="list_separator"><?php echo $cur_group ?></td>
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
            echo '<a href="'.video_url().'/'.basename($show->filename).'">'
                .'<img id="'.$show->filename."\" src=\"".image_cache.'/'.basename($show->filename).'.png" width="'.pixmap_width.'" height="'.pixmap_height.'" border="0">'
                .'</a>';
        }
        else
            echo '&nbsp;';
        echo "</td>\n";
    }
    ?>
    <td><?php echo '<a href="'.video_url().'/'.basename($show->filename).'">'.$show->title.'</a>'    ?></td>
    <td><?php echo '<a href="'.video_url().'/'.basename($show->filename).'">'.$show->subtitle.'</a>' ?></td>
<?php
    if (!$_SESSION['recorded_descunder'])
        echo "\t<td>".$show->description."</td>\n";
?>
    <td><?php echo $show->channel->channum, ' - <nobr>', $show->channel->name ?></nobr></td>
    <td nowrap align="center"><?php echo $show->recgroup?></td>
    <td nowrap align="center"><?php echo strftime($_SESSION['date_recorded'], $show->starttime)?></td>
    <td nowrap><?php echo nice_length($show->length)?></td>
    <td nowrap><?php echo nice_filesize($show->filesize)?></td>
<?php   if ($show->endtime > time()) { ?>
    <td width="5%">currently recording</td>
<?php   } else { ?>
    <td width="5%" rowspan="<?php echo $_SESSION['recorded_descunder'] ? 3 : 2 ?>" class="command command_border_l command_border_t command_border_b command_border_r" align="center">
        <a id="delete_<?php echo $row?>" href="recorded_programs.php?delete=yes&file=<?php echo urlencode($show->filename)?>"><?php echo t('Delete') ?></a></td>
<?php   }

        if ($_SESSION['recorded_descunder'])
            echo("</tr><tr class=\"recorded\">\n\t<td colspan=\"7\">".$show->description."</td>\n");
        $prev_group = $cur_group;
        $row++;
?>
</tr><tr class="recorded">
    <td nowrap colspan="<?php echo $_SESSION['recorded_descunder'] ? 7 : 8 ?>" align="center">
        <span style="padding-right: 25px"><?php echo t('has commflag') ?>:&nbsp;
            <b><?php echo $show->has_commflag ? t('Yes') : t('No') ?></b></span>
        <span style="padding-right: 25px"><?php echo t('has cutlist')?>:&nbsp;
            <b><?php echo $show->has_cutlist ? t('Yes') : t('No') ?></b></span>
        <span style="padding-right: 25px"><?php echo t('is editing') ?>:&nbsp;
            <b><?php echo $show->is_editing ? t('Yes') : t('No') ?></b></span>
        <span style="padding-right: 25px"><?php echo t('auto-expire') ?>:&nbsp;
            <b><?php echo $show->auto_expire ? t('Yes') : t('No') ?></b></span>
        <?php echo t('has bookmark') ?>:&nbsp;
            <b><?php echo $show->bookmark ? t('Yes') : t('No') ?></b>
        </td>
<?php
    }
?>
</table>
<?php
    echo '<p align="right" style="padding-right: 75px">'
        .t('$1 programs, using $2 ($3) out of $4.', t($GLOBALS['Total_Programs']),
                                                    nice_filesize(disk_used),
                                                    nice_length($Total_Time),
                                                    nice_filesize(disk_size))
        .'</p>';

    // Print the main page footer
        parent::print_footer();
    }

}

?>
