<?php
/**
 * Print the program list
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

// Set the desired page title
    $page_title = 'MythWeb - ' . t('Program Listing') . ': '.strftime($_SESSION['date_statusbar'], $list_starttime);

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_list.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

?>

<div id="list_head" class="clearfix">
    <form class="form" id="program_listing" action="<?php echo root ?>tv/list" method="get">
    <div id="_current_time"><?php
        echo t('Currently Browsing:  $1', strftime($_SESSION['date_statusbar'], $list_starttime))
    ?></div>
    <table id="-jumpto" class="commandbox commands" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="-jumpto"><?php echo t('Jump To') ?>:</td>
        <td class="-hour"><?php hour_select('onchange="$(\'program_listing\').submit()"') ?></td>
        <td class="-day"><a href="<?php echo root ?>tv/list?time=<?php echo $list_starttime - (24 * 60 * 60) ?>"
                ><img src="<?php echo skin_url ?>img/left.gif" border="0"></a>
            <?php date_select('onchange="$(\'program_listing\').submit()"') ?>
            <a href="<?php echo root ?>tv/list?time=<?php echo $list_starttime + (24 * 60 * 60) ?>"
                    ><img src="<?php echo skin_url ?>img/right.gif" border="0"></a>
            </td>
    </tr>
    </table>
    </form>
</div>

<p>
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
    <td class="menu" width="4%" align="right"><a href="<?php echo root ?>tv/list?time=<?php echo $list_starttime - (timeslot_size * num_time_slots) ?>#anchor<?php echo $timeslot_anchor ?>" name="anchor<?php echo $timeslot_anchor ?>"><img src="<?php echo skin_url ?>img/left.gif" border="0" alt="left"></a></td>
<?php
                $block_count = 0;
                foreach ($Timeslots as $time) {
                    if ($block_count++ % timeslot_blocks)
                        continue;
?>
    <td nowrap class="menu" colspan="<?php echo timeslot_blocks ?>" width="<?php echo intVal(timeslot_blocks * 94 / num_time_slots) ?>%" align="center"><a href="<?php echo root ?>tv/list?time=<?php echo $time.'#anchor'.$timeslot_anchor ?>"><?php echo strftime($_SESSION['time_format'], $time) ?></a></td>
<?php
                }
?>
    <td nowrap class="menu" width="2%"><a href="<?php echo root ?>tv/list?time=<?php echo $list_starttime + (timeslot_size * num_time_slots) ?>#anchor<?php echo $timeslot_anchor ?>"><img src="<?php echo skin_url ?>img/right.gif" border="0" alt="right"></a></td>
</tr><?php
            }
        // Count this channel
            $channel_count++;
        // Print the data
?><tr>
    <td class="-channel">
        <a href="<?php echo root ?>tv/channel/<?php echo $channel->chanid, '/', $program->starttime ?>"
                title="<?php
                    echo t('Details for: $1',
                           html_entities($channel->name))
                ?>">
<?php       if (show_channel_icons === true && !empty($channel->icon)) { ?>
        <img src="<?php echo $channel->icon ?>" height="30" width="30">
<?php       } ?>
        <span class="-preferred"><?php echo (prefer_channum ? $channel->channum : $channel->callsign) ?></span><br />
            <?php echo (prefer_channum ? $channel->callsign : $channel->channum), "\n" ?>
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
</p>
<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';

