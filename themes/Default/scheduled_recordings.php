<?php
/***                                                                        ***\
    scheduled_recordings.php                 Last Updated: 2005.02.08 (xris)

    This file defines a theme class for the scheduled recordings section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_scheduled_recordings extends Theme {

    function print_page(&$shows) {
    // Load this page's custom stylesheet
        $this->headers[] = '<link rel="stylesheet" type="text/css" href="'.theme_dir.'scheduled_recordings.css" />';
    // Print the main page header
        parent::print_header('MythWeb - Scheduled Recordings');
    // Which field are we grouping by?
        $group_field = $_GET['sortby'];
        if (empty($group_field)) {
            $group_field = "airdate";
        }
        elseif (!in_array($group_field, 'title', 'channum', 'airdate')) {
            $group_field = '';
        }
    // Print the page contents
?>

<div id="display_options" class="command command_border_l command_border_t command_border_b command_border_r">

    <form id="change_display" action="scheduled_recordings.php" method="post">
    <input type="hidden" name="change_display" value="1">

    <?php echo t('Display') ?>:

    <input type="checkbox" id="disp_scheduled" name="disp_scheduled" class="radio" onclick="submit_form('','','change_display')"<?php
        if ($_SESSION['scheduled_recordings']['disp_scheduled']) echo ' CHECKED' ?>>
    <a onclick="toggle_checkbox('disp_scheduled');submit_form('','','change_display')"><?php echo t('Scheduled') ?></a>
    |
    <input type="checkbox" id="disp_duplicates" name="disp_duplicates" class="radio" onclick="submit_form('','','change_display')" <?php
        if ($_SESSION['scheduled_recordings']['disp_duplicates']) echo ' CHECKED' ?>>
    <a onclick="toggle_checkbox('disp_duplicates');submit_form('','','change_display')"><?php echo t('Duplicates') ?></a>
    |
    <input type="checkbox" id="disp_deactivated" name="disp_deactivated" class="radio" onclick="submit_form('','','change_display')" <?php
        if ($_SESSION['scheduled_recordings']['disp_deactivated']) echo ' CHECKED' ?>>
    <a onclick="toggle_checkbox('disp_deactivated');submit_form('','','change_display')"><?php echo t('Deactivated') ?></a>
    |
    <input type="checkbox" id="disp_conflicts" name="disp_conflicts" class="radio" onclick="get_element('change_display').submit()" <?php
        if ($_SESSION['scheduled_recordings']['disp_conflicts']) echo ' CHECKED' ?>>
    <a onclick="toggle_checkbox('disp_conflicts');submit_form('','','change_display')"><?php echo t('Conflicts') ?></a>

    <noscript><input type="submit" value="<?php echo t('Update') ?>"></noscript>
    </form>
</div>

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
    foreach ($shows as $show) {
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
            $commands[] = '<a href="scheduled_recordings.php?dontrec=yes&'.$urlstr.'">'.t('Don\'t Record').'</a>';
        }
        elseif ($show->recstatus == 'WillRecord') {
            $class   = 'scheduled';
            $commands[] = '<a href="scheduled_recordings.php?dontrec=yes&'.$urlstr.'">'.t('Don\'t Record').'</a>';
        // Offer to suppress any recordings that have enough info to do so.
            if (preg_match('/\\S/', $show->title) && preg_match('/\\S/', $show->subtitle) && preg_match('/\\S/', $show->description))
                $commands[] = '<a href="scheduled_recordings.php?never_record=yes&'.$urlstr.'">'.t('Never Record').'</a>';
        }
        elseif ($show->recstatus == 'ForceRecord') {
            $class = 'scheduled';
            $commands[] = '<a href="scheduled_recordings.php?dontrec=yes&'.$urlstr.'">'.t('Don\'t Record').'</a>';
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
            $commands[] = '<a href="scheduled_recordings.php?dontrec=yes&'.$urlstr.'">'.t('Don\'t Record').'</a>';
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
            echo show_popup("program_$program_id_counter", $show->details_list(), NULL, 'popup', $wstatus);
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
