<?php
/**
 * Show the current lineup for a specific channel
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Channel Detail');

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Print out some header info about this channel and time
?>
<p>
<table align="center" width="90%" cellspacing="2" cellpadding="2">
<tr>
<?php   if ($_SESSION["show_channel_icons"] && !empty($this_channel->icon)) { ?>
    <td align="right"><img src="<?php echo $this_channel->icon ?>" height="30" width="30"></td>
<?php      } ?>
    <td width="66%" valign="center" class="huge">
        Channel <?php echo $this_channel->channum ?>:  <?php echo $this_channel->callsign ?> on <?php echo strftime('%B %e, %Y', $_SESSION['list_time']) ?></td>
    <td class="command command_border_l command_border_t command_border_b command_border_r" align="center">
        <form method="get" id="program_listing" action="<?php echo root_url ?>tv/channel">
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

// Only show the programs if there are some to display
    if (is_array($this_channel->programs)) {
?><table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
    <td><?php echo t('Time')        ?></td>
    <td><?php echo t('Title')       ?></td>
    <td><?php echo t('Episode')     ?></td>
    <td><?php echo t('Description') ?></td>
    <td><?php echo t('Length')      ?></td>
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
    ?><tr class="<?php echo $show->css_class ?>">
    <td nowrap align="center"><a href="<?php echo root_url ?>tv/list?time=<?php echo $show->starttime ?>"><?php echo strftime($_SESSION['time_format'], $show->starttime) ?> - <?php echo strftime($_SESSION['time_format'], $show->endtime) ?></a></td>
    <td class="<?php echo $show->css_class ?>"><?php
        if ($show->hdtv)
               echo '<span class="hdtv_icon">HD</span>';
        echo '<a href="'.root_url.'tv/detail/'.$show->chanid.'/'.$show->starttime.'">'
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

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';

