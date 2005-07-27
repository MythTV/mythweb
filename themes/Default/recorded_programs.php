<?php
/***                                                                        ***\
    recorded_programs.php                    Last Updated: 2005.04.02 (xris)

    This file defines a theme class for the recorded programs section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_recorded_programs extends Theme {

    function print_page() {
    // Print the main page header
        parent::print_header("MythWeb - Recorded Programs");
    // Print the page contents
        global $All_Shows, $Total_Time, $Total_Used;
?>

<script language="JavaScript" type="text/javascript">
<!--

// Load the known shows
    var files = new Array();
<?php   foreach ($All_Shows as $show) { ?>
    files.push([<?php echo escape($show->title) ?>,
                <?php echo escape($show->subtitle) ?>,
                <?php echo escape(urlencode($show->group)) ?>,
                <?php echo escape(urlencode($show->recendts-$show->recstartts)) ?>,
                <?php echo escape(urlencode($show->filesize)) ?>,
                <?php echo escape(urlencode($show->filename)) ?>]);
<?php   } ?>

    function confirm_delete(id, forget_old) {
        var title      = files[id][0];
        var subtitle   = files[id][1];
        var group      = files[id][2];
        var filelength = files[id][3];
        var filesize   = files[id][4];
        var filename   = files[id][5]
        if (confirm("<?php echo t('Are you sure you want to delete the following show?') ?>\n\n     "+title+": "+subtitle)) {
        // Hide the row from view
            toggle_vis('inforow_' + id,   'display');
            toggle_vis('statusrow_' + id, 'display');
        // decrement the number of rows in a section
            rowcount[section]--;
            var section   = rowsection[id];
            var row_count = rowcount[section];
        // Decrement the number of episodes for this title
            titles[title]--;
            var episode_count = titles[title]
        // If we just hid the only row in a section, then hide the section break above it as well
            if (row_count == 0) {
                toggle_vis('breakrow_' + section, 'display');
            }
        // Change the recordings dropdown menu on the fly
            if (episode_count == 0) {
                toggle_vis('Title ' + title, 'display');
            }
            else {
                var count_text;
                count_text = (episode_count > 1) ? ' (' + episode_count + ' episodes)' : '';
                get_element('Title ' + title).innerHTML = title + count_text;
            }
        // TODO: test changing the groups dropdown on the fly
            //I can't test it because I haven't set up any recording groups, and probably never will
            if (group) {
            // Decrement the number of episodes for this group
                groups[group]--;
                var group_count = titles[title]
            // Change the groups dropdown menu on the fly
                if (group_count == 0) {
                    toggle_vis('Group ' + group, 'display');
                }
                else {
                    var count_text;
                    group_text = (group_count >1) ? ' (' + group_count + ' episodes)' : '';
                    get_element('Group ' + group).innerHTML = group + group_text;
                }
            }
        // Do the actual deletion
            if (rowsection < 1)
                location.href = "recorded_programs.php?delete=yes&file="+filename;
            else
                submit_url("recorded_programs.php?delete=yes&file="+filename , updateResults);
        // Debug statements - uncomment to verify that the right file is being deleted
            //alert('row number ' + id + ' belonged to section ' + section + ' which now has ' + rowcount[section] + ' elements');
            //alert('just deleted an episode of "' + title + '" which now has ' + episode_count + ' episodes left');
        // Decrement the total number of shows and update the page
            programcount--;
            get_element('programcount').innerHTML = programcount;
        // Decrease the total amount of time by the amount of the show
            totaltime -= filelength;
            get_element('totaltime').innerHTML = nice_length(totaltime, <?php
                                                        echo escape(t('$1 hr')) .', '
                                                            .escape(t('$1 hrs')).', '
                                                            .escape(t('$1 min')).', '
                                                            .escape(t('$1 mins'));
                                                        ?>);
        // Decrease the disk usage indicator by the amount of the show
            diskused -= filesize;
            get_element('diskused').innerHTML = nice_filesize(diskused);
        // Adjust the freespace shown
            get_element('diskfree').innerHTML = nice_filesize(<?php echo disk_size ?> - diskused);
        }
    }

    function updateResults() {
        alert('The file was deleted successfully');
    }

// -->
</script>

<p>
<form id="program_titles" action="recorded_programs.php" method="get">
<table class="command command_border_l command_border_t command_border_b command_border_r" border="0" cellspacing="0" cellpadding="4" align="center">
<tr>
    <td><?php echo t('Show recordings') ?>:</td>
    <td width="250" align="center"><select name="title" onchange="get_element('program_titles').submit()">
        <option id="All recordings" value=""><?php echo t('All recordings') ?></option><?php
        global $Program_Titles;
        foreach($Program_Titles as $title => $count) {
            echo '<option id="Title '.htmlspecialchars($title).'" value="'.htmlspecialchars($title).'"';
            if ($_GET['title'] == $title)
                echo ' SELECTED';
            echo '>'.htmlentities($title, ENT_COMPAT, 'UTF-8')
                .($count > 1 ? ' ('.tn('$1 episode', '$1 episodes', $count).')' : "")
                .'</option>';
        }
        ?>
    </select></td>
<?php
global $Groups;
if (count($Groups) > 1) { ?>
    <td><?php echo t('Show group') ?>:</td>
    <td><select name="recgroup" onchange="get_element('program_titles').submit()">
        <option value=""><?php echo t('All recordings') ?></option><?php
        foreach($Groups as $recgroup => $count) {
            echo '<option id="Group '.htmlspecialchars($recgroup).'" value="'.htmlspecialchars($recgroup).'"';
            if ($_GET['recgroup'] == $recgroup)
                echo ' SELECTED';
            echo '>'.htmlentities($recgroup, ENT_COMPAT, 'UTF-8')
                .' ('.tn('$1 recording', '$1 recordings', $count)
                .')</option>';
        }
        ?>
    </select></td>
<?php } ?>
    <td><noscript><input type="submit" value="<?php echo t('Go') ?>"></noscript></td>
</tr>
</table>
</form>
</p>

<?php
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
    <td><?php echo get_sort_link('title',    t('title')) ?></td>
    <td><?php echo get_sort_link('subtitle', t('subtitle')) ?></td>
<?php
    if (!$_SESSION['recorded_descunder'])
        echo "\t<td>".get_sort_link('description', t('description'))."</td>\n";
?>
    <td><?php echo get_sort_link('channum',   t('channum')) ?></td>
    <td><?php echo get_sort_link('recgroup',  t('recgroup')) ?></td>
    <td><?php echo get_sort_link('airdate',   t('airdate')) ?></td>
    <td><?php echo get_sort_link('length',    t('length')) ?></td>
    <td><?php echo get_sort_link('file_size', t('file size')) ?></td>
</tr><?php
    $row     = 0;
    $section = -1;

    $prev_group = '';
    $cur_group  = '';

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
        $section++;
?><tr id="breakrow_<?php echo $section ?>" class="list_separator">
    <td colspan="10" class="list_separator"><?php echo $cur_group ?></td>
</tr><?php
    }
?><tr id="inforow_<?php echo $row ?>" class="recorded">
<?php
    if ($group_field != "")
        echo "\t<td class=\"list\" rowspan=\"".($_SESSION['recorded_descunder'] ? 3 : 2)."\">&nbsp;</td>\n";
    if (show_recorded_pixmaps) {
        echo "\t<td rowspan=\"".($_SESSION['recorded_descunder'] ? 3 : 2).'">';
        if (file_exists(image_cache.'/'.basename($show->filename).'.png')) {
            echo '<a href="'.video_url().'/'.basename($show->filename)."\" name=\"$row\">"
                .'<img id="'.$show->filename."\" src=\"".image_cache.'/'.basename($show->filename).'.png" width="'.pixmap_width.'" height="'.pixmap_height.'" border="0">'
                .'</a>';
        }
        else
            echo "<a name=\"$row\">&nbsp;</a>";
        echo "</td>\n";
    }
    ?>
    <td><?php echo '<a href="'.video_url().'/'.basename($show->filename).'"'
                    .(show_recorded_pixmaps ? '' : " name=\"$row\"")
                    .'>'.$show->title.'</a>' ?></td>
    <td><?php echo '<a href="'.video_url().'/'.basename($show->filename).'">'
                    .$show->subtitle.'</a>' ?></td>
<?php
    if (!$_SESSION['recorded_descunder'])
        echo "\t<td>".$show->description."</td>\n";
?>
    <td><?php echo $show->channel->channum, ' - <nobr>', $show->channel->name ?></nobr></td>
    <td nowrap align="center"><?php echo $show->recgroup ?></td>
    <td nowrap align="center"><?php echo strftime($_SESSION['date_recorded'], $show->starttime) ?></td>
    <td nowrap><?php echo nice_length($show->length) ?></td>
    <td nowrap><?php echo nice_filesize($show->filesize) ?></td>
<?php   if ($show->endtime > time()) { ?>
    <td width="5%">currently recording</td>
<?php   } else { ?>
    <td width="5%" rowspan="<?php echo $_SESSION['recorded_descunder'] ? 2 : 1 ?>" class="command command_border_l command_border_t command_border_b command_border_r" align="center">
        <a id="delete_<?php echo $row ?>"
            href="recorded_programs.php?delete=yes&file=<?php echo urlencode($show->filename) ?>"
            js_href="javascript:confirm_delete(<?php echo $row ?>, false)";
            title="<?php echo htmlentities(t('Delete $1', preg_replace('/: $/', '', $show->title.': '.$show->subtitle))) ?>"
            ><?php echo t('Delete') ?></a>
    </td>
<?php   }

        if ($_SESSION['recorded_descunder'])
            echo("</tr><tr class=\"recorded\">\n\t<td colspan=\"7\">".$show->description."</td>\n");
?>
</tr><tr id="statusrow_<?php echo $row ?>" class="recorded">
    <td nowrap colspan="<?php echo $_SESSION['recorded_descunder'] ? 7 : 8 ?>" align="center">
        <span style="padding-right: 25px"><?php echo t('has commflag') ?>:&nbsp;
            <b><?php echo $show->has_commflag ? t('Yes') : t('No') ?></b></span>
        <span style="padding-right: 25px"><?php echo t('has cutlist') ?>:&nbsp;
            <b><?php echo $show->has_cutlist ? t('Yes') : t('No') ?></b></span>
        <span style="padding-right: 25px"><?php echo t('is editing') ?>:&nbsp;
            <b><?php echo $show->is_editing ? t('Yes') : t('No') ?></b></span>
        <span style="padding-right: 25px"><?php echo t('auto-expire') ?>:&nbsp;
            <b><?php echo $show->auto_expire ? t('Yes') : t('No') ?></b></span>
        <?php echo t('has bookmark') ?>:&nbsp;
            <b><?php echo $show->bookmark ? t('Yes') : t('No') ?></b>
        </td>
    <td width="5%" class="command command_border_l command_border_t command_border_b command_border_r" align="center">
        <a id="delete_rerecord_<?php echo $row ?>"
            href="recorded_programs.php?delete=yes&file=<?php echo urlencode($show->filename) ?>&forget_old"
            js_href="javascript:confirm_delete(<?php echo $row ?>, true)";
            title="<?php echo htmlentities(t('Delete and rerecord $1', preg_replace('/: $/', '', $show->title.': '.$show->subtitle))) ?>"
            ><?php echo t('Delete + Rerecord') ?></a></td>
    </td>
</tr><?php
        $prev_group = $cur_group;
    // Keep track of how many shows are visible in each section
        $row_count[$section]++;
    // Keep track of which shows are in which section
        $row_section[$row] = $section;
    // Increment row last
        $row++;
    }
?>

</table>

<script language="JavaScript" type="text/javascript">
/* FIXME -- move this code to the top of the page */
    var rowcount     = new Array();
    var rowsection   = new Array();
    var titles       = new Object;
    var groups       = new Object;
    var programcount = <?php echo $GLOBALS['Total_Programs'] ?>;
    var diskused     = <?php echo disk_used ?>;
    var totaltime    = <?php echo $Total_Time ?>;
<?php
    foreach ($row_count as $count) {
        echo 'rowcount.push(['.escape($count).']);';
    }
    foreach ($row_section as $section) {
        echo 'rowsection.push(['.escape($section).']);';
    }
    foreach($Program_Titles as $title => $count) {
        echo 'titles['.escape($title).'] = '.escape($count).';';
    }
    foreach($Groups as $recgroup => $count) {
        echo 'groups['.escape($recgroup).'] = '.escape($count).';';
    }
?>
</script>

<?php
    echo '<p align="right" style="padding-right: 75px">'
        .t('$1 programs, using $2 ($3) out of $4 ($5 free).',
           '<span id="programcount">'.t($GLOBALS['Total_Programs']).'</span>',
           '<span id="diskused">'.nice_filesize($Total_Used).'</span>',
           '<span id="totaltime">'.nice_length($Total_Time).'</span>',
           '<span id="disksize">'.nice_filesize(disk_size).'</span>',
           '<span id="diskfree">'.nice_filesize(disk_size - disk_used).'</span>'
          )
        .'</p>';

    // Print the main page footer
        parent::print_footer();
    }

}

?>
