<?php
/***                                                                        ***\
    recording_schedules.php                 Last Updated: 2005.03.09 (xris)

    This file defines a theme class for the all recordings section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

class Theme_recording_schedules extends Theme {

    function print_page(&$the_schedules) {
    // Load this page's custom stylesheet
        $this->headers[] = '<link rel="stylesheet" type="text/css" href="'.theme_dir.'recording_schedules.css" />';
    // Print the main page header
        parent::print_header('MythWeb - Recording Schedules');
    // No schedules defined?
        if (!is_array($the_schedules) || !count($the_schedules)) {
?>
<div id="no_schedules" class="command command_border_l command_border_t command_border_b command_border_r">
<?php       echo t('No recording schedules have been defined.') ?>
</div>
<?php
            return;
        }
    // Print the page contents
        $group_field = $_GET['sortby'];
        if ($group_field == 'title' || !in_array($group_field, array('title', 'channum', 'type', 'profile', 'recgroup')))
            $group_field = '';
?>

<table id="listings" width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
    <?php if ($group_field != '') echo "<td class=\"list\">&nbsp;</td>\n"; ?>
    <td><?php echo get_sort_link('title',    t('title'))    ?></td>
    <td><?php echo get_sort_link(prefer_channum ? 'channum' : 'callsign',  t('channel')) ?></td>
    <td><?php echo get_sort_link('profile',  t('profile'))  ?></td>
    <td><?php echo get_sort_link('recgroup', t('recgroup')) ?></td>
    <td><?php echo get_sort_link('type',     t('type'))     ?></td>
</tr><?php
        $prev_group = '';
        $cur_group  = '';
        foreach ($the_schedules as $schedule) {
        // Reset the command variable to a default URL
            $urlstr = 'recordid='.$schedule->recordid;

            $class = ($schedule->type == rectype_dontrec ? 'deactivated' : 'scheduled');
        // If this is an 'always on any channel' or 'find one' recording w/o a channel, set the channel name to 'Any'
            if ($schedule->type == rectype_always || ($schedule->type == rectype_findone && !preg_match('/\\S/', $schedule->channel->channum)))
                $schedule->channel->name = '[ '.t('Any').' ]';
        // A program id counter for popup info
            if (show_popup_info) {
                static $program_id_counter = 0;
                $program_id_counter++;
            }

        // Print a dividing row if grouping changes
            if ($group_field == 'type')
                $cur_group = $schedule->texttype;
            elseif ($group_field == 'channum')
                $cur_group = ($schedule->channel->channum ? $schedule->channel->channum.' - ' : '').$schedule->channel->name;
            elseif ($group_field == 'profile')
                $cur_group = $schedule->profile;
            elseif ($group_field == 'recgroup')
                $cur_group = $schedule->recgroup;
        // "none"?
            $cur_group or $cur_group = t('None');

            $style_class = $schedule->class;
            if ($schedule->type == rectype_override)
                $style_class .= ' record_override_record';
            elseif ($schedule->type == rectype_dontrec)
                $style_class .= ' record_override_suppress';

            if ( $cur_group != $prev_group && $group_field != '' ) {
?><tr class="list_separator">
    <td colspan="6" class="list_separator"><?php echo $cur_group?></td>
</tr><?php
            }
        // Print the content
    ?><tr class="<?php echo $class?>">
        <?php if ($group_field != '') echo "<td class=\"list\">&nbsp;</td>\n"; ?>
    <td class="<?php echo $style_class?>"><?php
        // Window status text, for the mouseover
            $wstatus = "Details for $schedule->title";
        // Print a link to the program detail for this schedule
            echo '<a';
            if (show_popup_info)
                echo show_popup("program_$program_id_counter", $schedule->details_list(), NULL, 'popup', $wstatus);
            else
                echo " onmouseover=\"wstatus('".str_replace('\'', '\\\'', $wstatus)."');return true\" onmouseout=\"wstatus('');return true\"";
            echo ' href="';
        // Link to different places for different kinds of schedules
            if ($schedule->search) {
                if ($schedule->search == searchtype_manual)
                    echo 'schedule_manually';
                else
                    echo 'unsupport_search_schedule!!!';
            }
            else
                echo 'program_detail';
        // Finish off the link
            echo '.php?recordid='.$schedule->recordid.'"'
                 .'>'.$schedule->title;
            if (in_array($schedule->type, array(rectype_once, rectype_override, rectype_dontrec)) && preg_match('/\\w/', $schedule->subtitle))
                echo ":  $schedule->subtitle";
            echo '</a>';
        ?></td>
    <td><?php
            if (prefer_channum) {
                if ($schedule->channel->channum)
                    echo $schedule->channel->channum.' - ';
            }
            else {
                if ($schedule->channel->callsign)
                    echo $schedule->channel->callsign.' - ';
            }
            echo $schedule->channel->name;
        ?></td>
    <td nowrap><?php echo _or($schedule->profile,  '&nbsp;') ?></td>
    <td nowrap><?php echo _or($schedule->recgroup, '&nbsp;') ?></td>
    <td nowrap><?php echo $schedule->texttype ?></td>
</tr><?php
            $prev_group = $cur_group;
        }
?>

</table>
<?php

    // Print the main page footer
        parent::print_footer();
    }

}

?>
