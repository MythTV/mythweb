<?php
/***                                                                        ***\
    scheduled_recordings.php                    Last Updated: 2004.09.08 (xris)

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
    <td><?php echo get_sort_link('title')   ?></td>
    <td><?php echo get_sort_link('channum') ?></td>
    <td><?php echo get_sort_link('airdate') ?></td>
    <td><?php echo get_sort_link('length')  ?></td>
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
    // Build a popup table for the mouseover of the cell, with extra program information?
        if (show_popup_info) {
        // A program id counter
            static $program_id_counter = 0;
            $program_id_counter++;
        // Add a footnote
            global $Footnotes;
            $Footnotes[] = "<div id=\"program_{$program_id_counter}_popup\" class=\"hidden\">
<table class=\"menu small\" border=\"1\" cellpadding=\"5\" cellspacing=\"0\">
<tr>
    <td><table class=\"menu small\" cellpadding=\"2\" cellspacing=\"0\">
        <tr>
            <td align=\"right\">".t('Airtime').":</td>
            <td>".strftime($_SESSION['date_scheduled_popup'].', '.$_SESSION['time_format'], $show->starttime).' to '.strftime($_SESSION['time_format'], $show->endtime)."</td>
        </tr><tr>
            <td align=\"right\">".t('Title').":</td>
            <td>$show->title</td>
        </tr>"
        .(preg_match('/\\S/', $show->subtitle) ? "<tr>
            <td align=\"right\">".t('Subtitle').":</td>
            <td>$show->subtitle</td>
        </tr>" : '')
        .(preg_match('/\\S/', $show->description) ? "<tr>
            <td align=\"right\" valign=\"top\">".t('Description').":</td>
            <td>".nl2br(wordwrap($show->description, 70))."</td>
        </tr>" : '')
        .(preg_match('/\\S/', $show->rating) ? "<tr>
            <td align=\"right\" valign=\"top\">".t('Rating').":</td>
            <td>$show->rating</td>
        </tr>" : '')
        .($show->airdate > 0 ? "<tr>
            <td align=\"right\">".t('Original Airdate').":</td>
            <td>$show->airdate</td>
        </tr>" : '')
        .(preg_match('/\\S/', $show->category) ? "<tr>
            <td align=\"right\">".t('Category').":</td>
            <td>$show->category</td>
        </tr>" : '')
        .($show->previouslyshown ? "<tr>
            <td align=\"right\">".t('Rerun').":</td>
            <td>Yes</td>
        </tr>" : '')
        .($show->will_record ? "<tr>
            <td align=\"right\">".t('Schedule').":</td>
            <td>".($show->record_daily       ? t('rectype-long: daily')
                    : ($show->record_weekly  ? t('rectype-long: weekly')
                    : ($show->record_once    ? t('rectype-long: once')
                    : ($show->record_channel ? t('rectype-long: channel')
                    : ($show->record_findone ? t('rectype-long: findone')
                    : t('rectype-long: always'))))))."</td>
        </tr>" : '')
        .(preg_match('/\\S/', $show->profile) ? "<tr>
            <td align=\"right\">".t('Profile').":</td>
            <td>$show->profile</td>
        </tr>" : '')
        .($show->recstatus ? "<tr>
            <td align=\"right\">".t('Notes').":</td>
            <td>".$GLOBALS['RecStatus_Reasons'][$show->recstatus]."</td>
        </tr>" : '')
        ."</table></td>
</tr>
</table>
</div>";
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
        // Print a link to record this show
        echo '<a id="program_'.$program_id_counter.'" href="program_detail.php?chanid='.$show->chanid.'&starttime='.$show->starttime.'"'
             .(show_popup_info ? ' onmouseover="window.status=\'Details for: '.str_replace('\'', '\\\]', $show->title).'\';show(\'program_'.$program_id_counter.'\');return true"'
                                .' onmouseout="window.status=\'\';hide();return true"'
                               : '')
             .'>'.$show->title
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
