<?php
/***                                                                        ***\
    scheduled_recordings.php                    Last Updated: 2005.01.21 (xris)

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
        var prev_separator_index = 0;

        for (var i=1; i < get_element("listings").rows.length; i++) {
            if (get_element("listings").rows[i].className == "list_separator") {
                if (prev_visible_class == "list_separator")
                    get_element("listings").rows[prev_separator_index].style.display = "none";
                get_element("listings").rows[i].style.display = "";
                prev_visible_class = "list_separator";
                prev_separator_index = i;
            }
            else {
                if (get_element(get_element("listings").rows[i].className).checked) {
                    get_element("listings").rows[i].style.display = "";
                    prev_visible_class = get_element("listings").rows[i].className;
                }
                else
                    get_element("listings").rows[i].style.display = "none";
            }
        }
	if(prev_visible_class == "list_separator")
        	get_element("listings").rows[prev_separator_index].style.display = "none";
    }
// -->
</script>

<table border="0" align="center">
<tr>
    <td><?php echo t('Display') ?>:</td>
    <td><input type="checkbox" id="scheduled" class="radio" onclick="changevisible()" CHECKED></td>
    <td><?php echo t('Scheduled') ?></td>
    <td><input type="checkbox" id="duplicate" class="radio" onclick="changevisible()" CHECKED></td>
    <td><?php echo t('Duplicates') ?></td>
    <td><input type="checkbox" id="deactivated" class="radio" onclick="changevisible()" CHECKED></td>
    <td><?php echo t('Deactivated') ?></td>
    <td><input type="checkbox" id="conflict" class="radio" onclick="changevisible()" CHECKED></td>
    <td><?php echo t('Conflicts') ?></td>
</tr>
</table>

<?php
$group_field = $_GET['sortby'];
if ($group_field == "") {
    $group_field = "airdate";
} elseif ( ! (($group_field == "title") || ($group_field == "channum") || ($group_field == "airdate")) ) {
    $group_field = "";
}
?>

<table id="listings" width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
    <?php if ($group_field != '') echo "<td class=\"list\">&nbsp;</td>\n"; ?>
    <td><?php echo get_sort_link('title',   t('title'))   ?></td>
    <td><?php echo get_sort_link('channum', t('channum')) ?></td>
    <td><?php echo get_sort_link('airdate', t('airdate')) ?></td>
    <td><?php echo get_sort_link('length',  t('length'))  ?></td>
    <td align="center" colspan="2"><?php echo t('Commands') ?></a></td>
</tr><?php
    $row = 0;

    $prev_group="";
    $cur_group="";
    foreach ($All_Shows as $show) {
    // Reset the command variable to a default URL
        $commands = array();
        $urlstr = 'chanid='.$show->chanid.'&starttime='.$show->starttime;
    // Which class does this show fall into?
        if ($show->recstatus == 'LowDiskSpace') {
            $class = 'deactivated';
            $commands[] = 'Not Enough Disk Space';
        }
        elseif ($show->recstatus == 'TunerBusy') {
            $class = 'deactivated';
            $commands[] = 'Tuner is busy';
        }
        if ($show->recstatus == 'PreviousRecording' || $show->recstatus == 'CurrentRecording') {
            $class = 'duplicate';
            $commands[] = '<a href="scheduled_recordings.php?record=yes&'.$urlstr.'">'.t('Record This').'</a>';
            $commands[] = '<a href="scheduled_recordings.php?forget_old=yes&'.$urlstr.'">'.t('Forget Old').'</a>';
        }
        elseif ($show->recstatus == 'Conflict' || $show->recstatus == 'Overlap') {
            $class   = 'conflict';
            $commands[] = '<a href="scheduled_recordings.php?record=yes&'.$urlstr.'">'.t('Record This').'</a>';
            $commands[] = '<a href="scheduled_recordings.php?suppress=yes&'.$urlstr.'">'.t('Don\'t Record').'</a>';
        }
        elseif ($show->recstatus == 'WillRecord') {
            $class   = 'scheduled';
            $commands[] = '<a href="scheduled_recordings.php?suppress=yes&'.$urlstr.'">'.t('Don\'t Record').'</a>';
        // Offer to suppress any recordings that have enough info to do so.
            if (preg_match('/\\S/', $show->title) && preg_match('/\\S/', $show->subtitle) && preg_match('/\\S/', $show->description))
                $commands[] = '<a href="scheduled_recordings.php?never_record=yes&'.$urlstr.'">'.t('Never Record').'</a>';
        }
        elseif ($show->recstatus == 'ForceRecord') {
            $class = 'scheduled';
            $commands[] = '<a href="scheduled_recordings.php?suppress=yes&'.$urlstr.'">'.t('Don\'t Record').'</a>';
            $commands[] = '<a href="scheduled_recordings.php?default=yes&'.$urlstr.'">'.t('Default').'</a>';
        }
        elseif ($show->recstatus == 'ManualOverride' || $show->recstatus == 'Cancelled') {
            $class   = 'deactivated';
            $commands[] = '<a href="scheduled_recordings.php?record=yes&'.$urlstr.'">'.t('Activate').'</a>';
            $commands[] = '<a href="scheduled_recordings.php?default=yes&'.$urlstr.'">'.t('Default').'</a>';
        }
        else {
            $class   = 'deactivated';
            $commands[] = '<a href="scheduled_recordings.php?record=yes&'.$urlstr.'">'.t('Activate').'</a>';
            $commands[] = '<a href="scheduled_recordings.php?suppress=yes&'.$urlstr.'">'.t('Don\'t Record').'</a>';
        }
    // A program id counter for popup info
        if (show_popup_info) {
            static $program_id_counter = 0;
            $program_id_counter++;
        }

    // Print a dividing row if grouping changes
        if ($group_field == "airdate")
            $cur_group = strftime($_SESSION['date_listing_jump'], $show->starttime);
        elseif ($group_field == "channum")
            $cur_group = $show->channel->name;
        elseif ($group_field == "title")
            $cur_group = $show->title;

        if ( $cur_group != $prev_group && $group_field != '' ) {
?><tr class="list_separator">
    <td colspan="5" class="list_separator"><?php echo $cur_group?></td>
</tr><?php
        }

    // Print the content
?><tr class="<?php echo $class?>">
<?php if ($group_field != '') echo "<td class=\"list\">&nbsp;</td>\n"; ?>
    <td class="<?php echo $show->class?>"><?php
    // Window status text, for the mouseover
        $wstatus = strftime($_SESSION['time_format'], $show->starttime).' - '.strftime($_SESSION['time_format'], $show->endtime).' -- '
                  .str_replace(array("'", '"'),array("\\'", '&quot;'), $show->title)
                  .($show->subtitle ? ':  '.str_replace(array("'", '"'),array("\\'", '&quot;'), $show->subtitle)
                                          : '');
    // Print the link to edit this scheduled recording
        echo '<a';
        if (show_popup_info)
            echo show_popup("program_$program_id_counter", $show->details_table(), NULL, 'popup', $wstatus);
        else
            echo " onmouseover=\"wstatus('".str_replace('\'', '\\\'', $wstatus)."');return true\" onmouseout=\"wstatus('');return true\"";
        echo ' href="program_detail.php?chanid='.$show->chanid.'&starttime='.$show->starttime.'">'
            .$show->title
            .(preg_match('/\\w/', $show->subtitle) ? ":  $show->subtitle" : '')
            .'</a>';
        ?></td>
    <td><?php echo $show->channel->channum, ' - ', $show->channel->name?></td>
    <td nowrap><?php echo strftime($_SESSION['date_scheduled'], $show->starttime)?></td>
    <td nowrap><?php echo nice_length($show->length)?></td>
<?php   foreach ($commands as $command) { ?>
    <td nowrap width="5%" class="command command_border_l command_border_t command_border_b command_border_r" align="center"><?php echo $command?></td>
<?php   } ?>
</tr><?php
        $prev_group = $cur_group;
        $row++;
    }
?>

</table>
<?php

    // Print the main page footer
        parent::print_footer();
    }

}

?>
