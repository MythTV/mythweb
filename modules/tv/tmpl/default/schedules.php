<?php
/**
 * This file defines a theme class for the all recordings section.
 * It must define one method.   documentation will be added someday.
 *
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Recording Schedules');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_schedules.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// No schedules defined?
    if (!is_array($the_schedules) || !count($the_schedules)) {
        echo '<div id="no_schedules">',
             t('No recording schedules have been defined.').
             '</div>';
        return;
    }

// Print the page contents
    $group_field = $_GET['sortby'];
    if ($group_field == 'title' || !in_array($group_field, array('title', 'channum', 'type', 'profile', 'recgroup')))
        $group_field = '';
?>

<script type="text/javascript">
    function load_tool_tip(element_id, recordid) {
        var element = $(element_id);
        if (Tips.hasTip(element) == false) {
            ajax_add_request();
            new Ajax.Request('<?php echo root_url; ?>tv/get_schedule_details',
                             {
                                parameters: {
                                                recordid:           recordid,
                                                ajax:               true
                                            },
                                onSuccess: add_tool_tip,
                                method:    'get'
                             });
        }
    }

    function add_tool_tip(content) {
        ajax_remove_request();
        var info = content.responseJSON;
        if (Tips.hasTip($(info['id'])) == false) {
            new Tip(info['id'], info['info'], { className: 'popup' });
            attempt_to_show_tip(info['id']);
        }
    }

    var currently_hovered_id = null;
    var details_delay_timer_id = null;

    function attempt_to_show_tip(element) {
        if (element == currently_hovered_id)
            Tips.showTip(element);
    }
</script>

<table id="listings" border="0" cellpadding="4" cellspacing="2" class="list small" sortable="true">
<thead>
<tr class="menu">
    <?php if ($group_field != '') echo "<th class=\"list\">&nbsp;</th>\n"; ?>
    <th class="x-title"><?php      echo t('Title' );              ?></th>
    <th class="x-priority"><?php   echo t('Recording Priority' ); ?></th>
    <th class="x-channel" sort_hint="sortMythwebChannel"><?php    echo t('Channel' );            ?></th>
    <th class="x-profile"><?php    echo t('Profile' );            ?></th>
    <th class="x-transcoder"><?php echo t('Transcoder');          ?></th>
    <th class="x-group"><?php      echo t('Recording Group');     ?></th>
    <th class="x-type"><?php       echo t('Type');                ?></th>
    <th class="x-sgroup"><?php     echo t('Storage Group');       ?></th>
    <th class="x-startoffset"><?php echo t('Start Early');        ?></th>
    <th class="x-endoffset"><?php  echo t('End Late');            ?></th>
    <th class="x-lastrec"><?php    echo t('Last Recorded');       ?></th>
</tr>
</thead>
<?php
        $prev_group = '';
        $cur_group  = '';
        foreach ($the_schedules as $schedule) {
        // Ignore templates until full support can be added
            if ($schedule->type == rectype_template)
                continue;
        // Reset the command variable to a default URL
            $urlstr = 'recordid='.$schedule->recordid;

            $css_class = ($schedule->type == rectype_dontrec ? 'deactivated' : 'scheduled');
        // If this is an 'always on any channel' or 'find one' recording w/o a channel, set the channel name to 'Any'
            if ($schedule->type == rectype_always || ($schedule->type == rectype_findone && !preg_match('/\\S/', $schedule->channel->channum)))
                $schedule->channel->name = '[ '.t('Any').' ]';
        // A program id counter for popup info
            if ($_SESSION["show_popup_info"]) {
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
            elseif ($group_field == 'storagegroup')
                $cur_group = $schedule->storagegroup;
        // "none"?
            $cur_group or $cur_group = t('None');

            $style_class = $schedule->css_class;
            if ($schedule->type == rectype_override)
                $style_class .= ' record_override_record';
            elseif ($schedule->type == rectype_dontrec)
                $style_class .= ' record_override_suppress';

            if ( $cur_group != $prev_group && $group_field != '' ) {
?><tr class="list_separator">
    <td colspan="6" class="list_separator"><?php echo $cur_group ?></td>
</tr><?php
            }
        // Print the content
    ?><tr class="<?php echo $css_class ?>">
        <?php if ($group_field != '') echo "<td class=\"list\">&nbsp;</td>\n" ?>
    <td class="x-title <?php echo $style_class ?>"><?php
        // Window status text, for the mouseover
            $wstatus = "Details for $schedule->title";
        // Print a link to the program detail for this schedule
            echo '<a id="schedule-'.$schedule->recordid.'"';
            if ($_SESSION["show_popup_info"]) {
                echo ' onmouseover = "currently_hovered_id = this.id; details_delay_timer_id = setTimeout(function () {load_tool_tip(\'schedule-'.$schedule->recordid.'\',\''.$schedule->recordid.'\');}, 250);"';
                echo ' onmouseout  = "currently_hovered_id = null; clearTimeout( details_delay_timer_id ); details_delay_timer_id = null;"';
            }
            echo ' href="'.root_url.'tv/';
        // Link to different places for different kinds of schedules
            if ($schedule->search) {
                echo 'schedules/',
                     ($schedule->search == searchtype_manual) ? 'manual'
                                                              : 'custom',
                     '/', $schedule->recordid;
            }
            else
                echo 'detail?recordid='.$schedule->recordid;
        // Finish off the link
            echo '">'.$schedule->title;
            if (in_array($schedule->type, array(rectype_once, rectype_override, rectype_dontrec)) && preg_match('/\\w/', $schedule->subtitle))
                echo ":  $schedule->subtitle";
            echo '</a>';
        ?></td>
    <td class="x-priority"><?php
            echo $schedule->recpriority
        ?></td>
    <td class="x-channel"><?php
            if ($_SESSION["prefer_channum"]) {
                if ($schedule->channel->channum)
                    echo $schedule->channel->channum.' - ';
            }
            else {
                if ($schedule->channel->callsign)
                    echo $schedule->channel->callsign.' - ';
            }
            echo $schedule->channel->name;
        ?></td>
    <td class="x-profile"><?php echo _or($schedule->profile,  '&nbsp;') ?></td>
    <td class="x-transcoder"><?php
        global $Transcoders;
        echo _or($Transcoders[$schedule->transcoder],  '&nbsp;')
        ?></td>
    <td class="x-group"><?php echo _or($schedule->recgroup, '&nbsp;') ?></td>
    <td class="x-type"><?php  echo $schedule->texttype ?></td>
    <td class="x-sgroup"><?php echo _or($schedule->storagegroup, '&nbsp;') ?></td>
    <td class="x-startoffset"><?php echo _or($schedule->startoffset, '&nbsp;') ?></td>
    <td class="x-endoffset"><?php echo _or($schedule->endoffset, '&nbsp;') ?></td>
    <td class="x-lastrec"><?php echo _or($schedule->last_record, '&nbsp;') ?></td>
</tr><?php
            $prev_group = $cur_group;
        }
?>

</table>
<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
