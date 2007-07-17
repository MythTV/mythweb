<?php
/**
 * Show the current lineup for a specific channel
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
    $page_title = 'MythWeb - '.t('Channel Detail');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_channel.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Print out some header info about this channel and time
?>

<div id="list_head" class="clearfix">
    <form method="get" id="program_listing" action="<?php echo root ?>tv/channel">
    <div id="_current_time">
<?php   if (show_channel_icons && !empty($this_channel->icon)) { ?>
        <img src="<?php echo $this_channel->icon ?>" height="30" width="30">
<?php   } ?>
        Channel <?php echo $this_channel->channum ?>:  <?php echo $this_channel->callsign ?> on <?php echo strftime('%B %e, %Y', $_SESSION['list_time']) ?>
    </div>
    <table id="-jumpto" class="commandbox commands" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="-jumpto"><?php echo t('Jump To') ?>:</td>
        <td class="-hour"><?php channel_select('onchange="$(\'program_listing\').submit()"') ?></td>
        <td class="-day"><a href="<?php echo root ?>tv/channel/<?php echo $this_channel->chanid, '/', $_SESSION['list_time'] - (24 * 60 * 60) ?>"
                ><img src="<?php echo skin_url ?>img/left.gif" border="0"></a>
            <?php date_select('onchange="$(\'program_listing\').submit()"') ?>
            <a href="<?php echo root ?>tv/channel/<?php echo $this_channel->chanid, '/', $_SESSION['list_time'] + (24 * 60 * 60) ?>"
                    ><img src="<?php echo skin_url ?>img/right.gif" border="0"></a>
            </td>
    </tr>
    </table>
    </form>
</div>

<?php

// Only show the programs if there are some to display
    if (is_array($this_channel->programs)) {
?><table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
    <td><?php echo t('Time')        ?></td>
    <td><?php echo t('Show')        ?></td>
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
    <td nowrap align="center"><a href="<?php echo root ?>tv/list?time=<?php echo $show->starttime ?>"><?php echo strftime($_SESSION['time_format'], $show->starttime) ?> - <?php echo strftime($_SESSION['time_format'], $show->endtime) ?></a></td>
    <td class="<?php echo $show->css_class ?>"><?php
        if ($show->videoproperties & 0x01)
               echo '<span class="hdtv_icon">HD</span>';
        echo '<a href="'.root.'tv/detail/'.$show->chanid.'/'.$show->starttime.'">'
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

