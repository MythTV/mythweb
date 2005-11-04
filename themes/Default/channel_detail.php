<?php
/***                                                                        ***\
    channel_detail.php                        Last Updated: 2005.02.28 (xris)

    This file defines a theme class for the channel detail section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

class Theme_channel_detail extends Theme {

    function print_page(&$this_channel) {
    // Print the main page header
        parent::print_header('MythWeb - Channel Detail');
    // Print out some header info about this channel and time
?>
<p>
<table align="center" width="90%" cellspacing="2" cellpadding="2">
<tr>
<?php   if (show_channel_icons && is_file($this_channel->icon)) { ?>
    <td align="right"><img src="<?php echo $this_channel->icon ?>" height="30" width="30"></td>
<?php      } ?>
    <td width="66%" valign="center" class="huge">
        Channel <?php echo $this_channel->channum ?>:  <?php echo $this_channel->callsign ?> on <?php echo strftime('%B %e, %Y', $_SESSION['list_time']) ?></td>
    <td class="command command_border_l command_border_t command_border_b command_border_r" align="center">
        <form method="get" id="form" action="channel_detail.php">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td nowrap align="center"><?php echo t('Jump to') ?>:&nbsp;&nbsp;</td>
            <td><?php channel_select() ?></td>
            <td align="right"><?php echo t('Date') ?>:&nbsp;</td>
            <td><?php date_select() ?></td>
            <td align="center"><noscript><input type="submit" class="submit" value="<?php echo t('Jump') ?>"></noscript></td>
        </tr>
        </table>
        </form>
        </td>
</tr>
</table>
</p>
<?php
    // Print the shows for today
        $this->print_shows($this_channel);
    // Print the main page footer
        parent::print_footer();
    }

    function print_shows(&$this_channel) {
    // No search was performed, just return
        if (!is_array($this_channel->programs))
            return;
    // Display the results
?><table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
    <td><a href="scheduled_recordings.php?sortby=airdate"><?php echo t('Time') ?></a></td>
    <td><a href="scheduled_recordings.php?sortby=title"><?php echo t('Show') ?></a></td>
    <td><?php echo t('Episode') ?></td>
    <td><?php t('Description') ?></td>
    <td><a href="scheduled_recordings.php?sortby=length"><?php echo t('Length') ?></a></td>
</tr><?php

        $row = 0;
        foreach ($this_channel->programs as $show) {

        // Print some additional information for movies
        $additional = '';
        if ($show->category_type == 'movie'
                || $show->category_type == 'Film') {
            if ($show->airdate > 0)
                    $additional = sprintf('%4d', $show->airdate);
            if (strlen($show->rating) > 0) {
                if ($additional)
                    $additional .= ", ";
                $additional .= "<i>$show->rating</i>";
            }
            if (strlen($show->starstring) > 0) {
                if ($additional)
                    $additional .= ", ";
                $additional .= $show->starstring;
            }
            if ($additional)
                $additional = ' (' . $additional . ')';
        }

    // Print the content
    ?><tr class="<?php echo $show->class ?>">
    <td nowrap align="center"><a href="program_listing.php?time=<?php echo $show->starttime ?>"><?php echo strftime($_SESSION['time_format'], $show->starttime) ?> - <?php echo strftime($_SESSION['time_format'], $show->endtime) ?></a></td>
    <td class="<?php echo $show->class ?>"><?php
        if ($show->hdtv)
               echo '<span class="hdtv_icon">HD</span>';
        echo '<a href="program_detail.php?chanid='.$show->chanid.'&starttime='.$show->starttime.'">'
             .$show->title.$additional.'</a>';
        ?></td>
    <td><?php echo $show->subtitle ?></td>
    <td><?php echo $show->description ?></td>
    <td nowrap><?php echo nice_length($show->length) ?></td>
</tr><?php
            $row++;
        }
?>

</table>
<?php
    }

}

