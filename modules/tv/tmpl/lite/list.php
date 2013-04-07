<?php
/**
 * Print the program list
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - ' . t('Program Listing') . ': '.strftime($_SESSION['date_statusbar'], $list_starttime);

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

?>

<p>
<table align="center" width="90%" cellspacing="2" cellpadding="2">
<tr>
    <td width="50%" align="center"><?php echo t('Currently Browsing:  $1', strftime($_SESSION['date_statusbar'], $list_starttime)) ?></td>
    <td class="command command_border_l command_border_t command_border_b command_border_r" align="center">
        <form class="form" id="program_listing" action="<?php echo root_url ?>tv/list" method="get">
        <table border="0" cellspacing="0" cellpadding="2">
        <tr>

            <td nowrap align="center"><span class='link' onclick="list_update($('date_select')[$('date_select').selectedIndex].value);"><?php echo t('Jump To') ?></span>:&nbsp;&nbsp;</td>
            <td align="right"><?php echo t('Hour') ?>:&nbsp;</td>
            <td><select name="hour" style="text-align: right"><?php
                for ($h=0;$h<24;$h++) {
                    echo "<option value=\"$h\"";
                    if ($h == date('H', $list_starttime))
                        echo ' SELECTED';
                    echo '>'.strftime($_SESSION['time_format'], strtotime("$h:00")).'</option>';
                }
                ?></select></td>
            <td align="right"><?php echo t('Date') ?>:&nbsp;</td>
            <tdnowrap><?php date_select() ?></td>
            <td align="center"><input type="submit" class="submit" value="<?php echo t('Jump') ?>"></td>
        </tr>
        </table>
        </form></td>
</tr>
</table>
</p>

<p>
<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<?php

        $timeslot_anchor    = 0;
        $channel_count      = 0;
        $displayed_channels = array();

    // Go through each channel and load/print its info - use references to avoid "copy" overhead
        $channels = Channel::getChannelList();
        foreach ($channels as $chanid) {
            $channel =& Channel::find($chanid);
        // Ignore channels with no number
            if (strlen($channel->channum) < 1)
                continue;
        // Ignore invisible channels
            if ($channel->visible == 0) {
                continue;
            }
        // Skip already-displayed channels
            if ($displayed_channels[$channel->channum])
                continue;
            $displayed_channels[$channel->channum] = 1;
        // Display the timeslot bar?
            if ($channel_count % timeslotbar_skip == 0) {
            // Update the timeslot anchor
                $timeslot_anchor++;
?><tr>
    <td class="menu" width="4%" align="right"><a href="<?php echo root_url ?>tv/list?time=<?php echo $list_starttime - (timeslot_size * num_time_slots) ?>#anchor<?php echo $timeslot_anchor ?>" name="anchor<?php echo $timeslot_anchor ?>"><img src="<?php echo skin_url ?>img/left.gif" border="0" alt="left"></a></td>
<?php
                $block_count = 0;
                foreach ($Timeslots as $time) {
                    if ($block_count++ % timeslot_blocks)
                        continue;
?>
    <td nowrap class="menu" colspan="<?php echo timeslot_blocks ?>" width="<?php echo intVal(timeslot_blocks * 94 / num_time_slots) ?>%" align="center"><a href="<?php echo root_url ?>tv/list?time=<?php echo $time.'#anchor'.$timeslot_anchor ?>"><?php echo strftime($_SESSION['time_format'], $time) ?></a></td>
<?php
                }
?>
    <td nowrap class="menu" width="2%"><a href="<?php echo root_url ?>tv/list?time=<?php echo $list_starttime + (timeslot_size * num_time_slots) ?>#anchor<?php echo $timeslot_anchor ?>"><img src="<?php echo skin_url ?>img/right.gif" border="0" alt="right"></a></td>
</tr><?php
            }
        // Count this channel
            $channel_count++;
        // Print the data
?><tr>
    <td align="center" class="menu" nowrap><?php
            if ($_SESSION["show_channel_icons"] == true) {
        ?><table class="small" width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td width="50%" align="center" nowrap><a href="<?php echo root_url ?>tv/channel/<?php echo $channel->chanid, '/', date('Ymd', $list_starttime) ?>" class="huge"><?php echo $_SESSION["prefer_channum"] ? $channel->channum : $channel->callsign ?></a>&nbsp;</td>
            <td width="50%" align="right"><?php
                if (!empty($channel->icon)) {
                    ?><a href="<?php echo root_url ?>tv/channel/<?php echo $channel->chanid, '/', date('Ymd', $list_starttime) ?>"><img src="<?php echo $channel->icon ?>" height="30" width="30"></a><?php
                } else {
                    echo '&nbsp;';
                } ?></td>
        </tr><tr>
            <td colspan="2" align="center" nowrap><a href="<?php echo root_url ?>tv/channel/<?php echo $channel->chanid, '/', date('Ymd', $list_starttime) ?>"
                                            onmouseover="window.status='Details for: <?php echo preg_replace("/([\"'])/", '\\\$1', $channel->channum.' '. $channel->callsign) ?>';return true"
                                            onmouseout="window.status='';return true"><?php echo $_SESSION["prefer_channum"] ? $channel->callsign : $channel->channum ?></a></td>
        </tr>
        </table><?php
            } else {
        ?><a href="<?php echo root_url ?>tv/channel/<?php echo $channel->chanid ?>" class="huge"
            onmouseover="window.status='Details for: <?php echo $channel->channum ?> <?php echo $channel->callsign ?>';return true"
            onmouseout="window.status='';return true"><?php echo $_SESSION["prefer_channum"] ? $channel->channum : $channel->callsign ?><BR>
        <?php echo $_SESSION["prefer_channum"] ? $channel->callsign : $channel->channum ?></a><?php
            }
        ?></td>
<?php
// Let the channel object figure out how to display its programs
    $channel->display_programs($list_starttime, $list_endtime);
?>
    <td>&nbsp;</td>
</tr><?php
        }
?>
</table>
</p>
<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
