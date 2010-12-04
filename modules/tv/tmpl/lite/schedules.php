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
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_schedules.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';


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
    <?php if ($group_field != '') echo "<td class=\"list\">&nbsp;</td>\n" ?>
    <td><?php echo get_sort_link('title',    t('title')) ?></td>
    <td><?php echo get_sort_link('recpriority', t('recpriority')) ?></td>
    <td><?php echo get_sort_link($_SESSION["prefer_channum"] ? 'channum' : 'callsign',  t('channel')) ?></td>
    <td><?php echo get_sort_link('profile',  t('profile')) ?></td>
    <td><?php echo get_sort_link('transcoder',  t('transcoder')) ?></td>
    <td><?php echo get_sort_link('recgroup', t('recgroup')) ?></td>
    <td><?php echo get_sort_link('type',     t('type')) ?></td>
</tr><?php
        $prev_group = '';
        $cur_group  = '';
        foreach ($the_schedules as $schedule) {
        // Reset the command variable to a default URL
            $urlstr = 'recordid='.$schedule->recordid;

            $css_class = ($schedule->type == rectype_dontrec ? 'deactivated' : 'scheduled');
        // If this is an 'always on any channel' or 'find one' recording w/o a channel, set the channel name to 'Any'
            if ($schedule->type == rectype_always || ($schedule->type == rectype_findone && !preg_match('/\\S/', $schedule->channel->channum)))
                $schedule->channel->name = '[ '.t('Any').' ]';

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
    <td class="<?php echo $style_class ?>"><?php
        // Window status text, for the mouseover
            $wstatus = "Details for $schedule->title";
        // Print a link to the program detail for this schedule
            echo '<a href="'.root_url.'tv/';
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
    <td><?php
            echo $schedule->recpriority
        ?></td>
    <td><?php
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
    <td nowrap><?php echo _or($schedule->profile,  '&nbsp;') ?></td>
    <td nowrap>
        <?php
        global $Transcoders;
        echo _or($Transcoders[$schedule->transcoder],  '&nbsp;')
        ?>
    </td>
    <td nowrap><?php echo _or($schedule->recgroup, '&nbsp;') ?></td>
    <td nowrap><?php echo $schedule->texttype ?></td>
</tr><?php
            $prev_group = $cur_group;
        }
?>

</table>
<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';

