<?php
/**
 * Print the program list data only
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// UTF-8 content
    @header("Content-Type: text/html; charset=utf-8");
?>

<div id="list_head" class="clearfix">
    <form class="form" id="program_listing" action="<?php echo root ?>tv/list" method="get">
    <div id="x_current_time"><?php
        echo t('Currently Browsing:  $1', strftime($_SESSION['date_statusbar'], $list_starttime))
    ?></div>
    <table id="x-jumpto" class="commandbox commands" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="x-jumpto"><?php echo t('Jump To') ?>:</td>
        <td class="x-hour"><?php hour_select('id="hour_select" onchange="list_update($(\'hour_select\')[$(\'hour_select\').selectedIndex].value);"') ?></td>
        <td class="x-day">
            <a class="link" onclick="list_update(<?php echo $list_starttime - (24 * 60 * 60); ?>);">
                <img src="<?php echo skin_url ?>img/left.gif" alt="<?php echo t('left'); ?>">
            </a>
            <?php date_select('id="date_select" onchange="list_update($(\'date_select\')[$(\'date_select\').selectedIndex].value);"') ?>
            <a class="link" onclick="list_update(<?php echo $list_starttime + (24 * 60 * 60); ?>);">
                <img src="<?php echo skin_url ?>img/right.gif" alt="<?php echo t('right'); ?>">
            </a>
        </td>
    </tr>
    </table>
    </form>
</div>

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<?php

        $timeslot_anchor    = 0;
        $channel_count      = 0;
        $displayed_channels = array();

    // Go through each channel and load/print its info - use references to avoid "copy" overhead
        foreach ($Callsigns as $chanid) {
            $channel = $Channels[$chanid];
        // Ignore channels with no number
            if (strlen($channel->channum) < 1)
                continue;
        // Ignore invisible channels
            if ($channel->visible == 0)
                continue;
        // Skip already-displayed channels
            if ($displayed_channels[$channel->channum][$channel->callsign])
                continue;
            $displayed_channels[$channel->channum][$channel->callsign] = 1;
        // Display the timeslot bar?
            if ($channel_count % timeslotbar_skip == 0) {
            // Update the timeslot anchor
                $timeslot_anchor++;
?><tr>
    <td class="menu" align="right"><a class="link" onclick="list_update(<?php echo $list_starttime - (timeslot_size * num_time_slots); ?>);" name="anchor<?php echo $timeslot_anchor ?>"><img src="<?php echo skin_url ?>img/left.gif" alt="left"></a></td>
<?php
                $block_count = 0;
                foreach ($Timeslots as $time) {
                    if ($block_count++ % timeslot_blocks)
                        continue;
?>
    <td class="menu nowrap" colspan="<?php echo timeslot_blocks ?>" style="width: <?php echo intVal(timeslot_blocks * 94 / num_time_slots) ?>%" align="center"><a class="link" onclick="list_update(<?php echo $time; ?>);"><?php echo strftime($_SESSION['time_format'], $time) ?></a></td>
<?php
                }
?>
    <td class="menu nowrap"><a class="link" onclick="list_update(<?php echo $list_starttime + (timeslot_size * num_time_slots); ?>);"><img src="<?php echo skin_url ?>img/right.gif" alt="right"></a></td>
</tr><?php
            }
        // Count this channel
            $channel_count++;
        // Print the data
?><tr>
    <td class="x-channel">
        <a href="<?php echo root ?>tv/channel/<?php echo $channel->chanid, '/', $list_starttime ?>"
                title="<?php
                    echo t('Details for: $1',
                           html_entities($channel->name))
                ?>">
<?php       if ($_SESSION["show_channel_icons"] == true && !empty($channel->icon)) { ?>
        <img src="<?php echo $channel->icon ?>" height="30" width="30">
<?php       } ?>
        <span class="x-preferred"><?php echo ($_SESSION["prefer_channum"] ? $channel->channum : $channel->callsign) ?></span><br>
            <?php echo ($_SESSION["prefer_channum"] ? $channel->callsign : $channel->channum), "\n" ?>
        </a>
        </td>
<?php
// Let the channel object figure out how to display its programs
    $channel->display_programs($list_starttime, $list_endtime);
?>
    <td>&nbsp;</td>
</tr><?php
        }
?>
</table>
