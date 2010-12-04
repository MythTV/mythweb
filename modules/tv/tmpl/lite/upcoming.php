<?php
/**
 * Show all upcoming recordings.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Upcoming Recordings');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_upcoming.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

/** @todo FIXME:  pull this out of the theme page! */
// Which field are we grouping by?
    $group_field = $_GET['sortby'];
    if (empty($group_field)) {
        $group_field = "airdate";
    }
    elseif (!in_array($group_field, array('title', 'channum', 'airdate'))) {
        $group_field = '';
    }

?>

<div id="display_options" class="command command_border_l command_border_t command_border_b command_border_r">

    <form id="change_display" action="<?php echo root_url ?>tv/upcoming" method="post">
    <input type="hidden" name="change_display" value="1">

    <?php echo t('Display') ?>:

    <input type="checkbox" id="disp_scheduled" name="disp_scheduled" class="radio" onclick="submit_form('','','change_display')"<?php
        if ($_SESSION['scheduled_recordings']['disp_scheduled']) echo ' CHECKED' ?>>
    <a onclick="toggle_checkbox('disp_scheduled');submit_form('','','change_display')"><?php echo t('Scheduled') ?></a>
    |
    <input type="checkbox" id="disp_duplicates" name="disp_duplicates" class="radio" onclick="submit_form('','','change_display')" <?php
        if ($_SESSION['scheduled_recordings']['disp_duplicates']) echo ' CHECKED' ?>>
    <a onclick="toggle_checkbox('disp_duplicates');submit_form('','','change_display')"><?php echo t('Duplicates/Ignored') ?></a>
    |
    <input type="checkbox" id="disp_deactivated" name="disp_deactivated" class="radio" onclick="submit_form('','','change_display')" <?php
        if ($_SESSION['scheduled_recordings']['disp_deactivated']) echo ' CHECKED' ?>>
    <a onclick="toggle_checkbox('disp_deactivated');submit_form('','','change_display')"><?php echo t('Deactivated') ?></a>
    |
    <input type="checkbox" id="disp_conflicts" name="disp_conflicts" class="radio" onclick="$('change_display').submit()" <?php
        if ($_SESSION['scheduled_recordings']['disp_conflicts']) echo ' CHECKED' ?>>
    <a onclick="toggle_checkbox('disp_conflicts');submit_form('','','change_display')"><?php echo t('Conflicts') ?></a>

    <input type="submit" value="<?php echo t('Update') ?>">
    </form>
</div>

<table id="listings" width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
    <?php if ($group_field != '') echo "<td class=\"list\">&nbsp;</td>\n" ?>
    <td><?php echo get_sort_link('title',   t('title')) ?></td>
    <td><?php echo get_sort_link('channum', t('channum')) ?></td>
    <td><?php echo get_sort_link('airdate', t('airdate')) ?></td>
    <td><?php echo get_sort_link('length',  t('length')) ?></td>
    <td align="center" colspan="2"><?php echo t('Commands') ?></a></td>
</tr><?php
    $row = 0;

    $prev_group = '';
    $cur_group  = '';
    foreach ($all_shows as $show) {
    // Set the class to be used to display the recording status character
        $rec_class = implode(' ', array(recstatus_class($show), $show->recstatus));
    // Reset the command variable to a default URL
        $commands = array();
        $urlstr = 'chanid='.$show->chanid.'&starttime='.$show->starttime;
    // Set the recording status character, class and any applicable commands for each show
        switch ($show->recstatus) {
            case 'Recording':
            case 'WillRecord':
                $rec_char   = $show->inputname;
                $css_class  = 'scheduled';
                $commands[] = '<a href="'.root_url.'tv/upcoming?dontrec=yes&'
                              .$urlstr.'">'.t('Don\'t Record').'</a>';
            // Offer to suppress any recordings that have enough info to do so.
                if (preg_match('/\\S/', $show->title)
                        && (preg_match('/\\S/', $show->programid.$show->subtitle.$show->description))) {
                    $commands[] = '<a href="'.root_url.'tv/upcoming?'
                                  .'never_record=yes&'.$urlstr.'">'
                                  .t('Never Record').'</a>';
                }
                break;
            case 'PreviousRecording':
                $rec_char   = t('Duplicate');
                $css_class  = 'duplicate';
                $commands[] = '<a href="'.root_url.'tv/upcoming?record=yes&'
                              .$urlstr.'">'.t('Record This').'</a>';
                $commands[] = '<a href="'.root_url.'tv/upcoming?'
                              .'forget_old=yes&'.$urlstr.'">'
                              .t('Forget Old').'</a>';
                break;
            case 'CurrentRecording':
                $rec_char   = t('Recorded');
                $css_class  = 'duplicate';
                $commands[] = '<a href="'.root_url.'tv/upcoming?record=yes&'
                              .$urlstr.'">'.t('Record This').'</a>';
                $commands[] = '<a href="'.root_url.'tv/upcoming?'
                              .'forget_old=yes&'.$urlstr.'">'
                              .t('Forget Old').'</a>';
                break;
            case 'Repeat':
                $rec_char = 'Rerun';
                $css_class= 'duplicate';
                break;
            case 'EarlierShowing':
                $rec_char = t('Earlier');
                $css_class= 'deactivated';
                $commands[] = '<a href="'.root_url.'tv/upcoming?record=yes&'
                              .$urlstr.'">'.t('Activate').'</a>';
                $commands[] = '<a href="'.root_url.'tv/upcoming?default=yes&'
                              .$urlstr.'">'.t('Default').'</a>';
                break;
            case 'TooManyRecordings':
                $rec_char = t('Too Many');
                $css_class= 'deactivated';
                break;
            case 'Cancelled':
                $rec_char   = t('Cancelled');
                $css_class  = 'deactivated';
                $commands[] = '<a href="'.root_url.'tv/upcoming?record=yes&'
                              .$urlstr.'">'.t('Activate').'</a>';
                $commands[] = '<a href="'.root_url.'tv/upcoming?default=yes&'
                              .$urlstr.'">'.t('Default').'</a>';
                break;
            case 'Conflict':
                $rec_char = t('Conflict');
            // We normally use the recstatus value as the name of the class
            //  used when displaying the recording status character.
            // However, there is already a class named 'conflict' so we
            //  need to modify this specific recstatus to avoid a conflict.
                $rec_class = implode(' ', array(recstatus_class($show),
                                     'conflicting'));
                $css_class  = 'conflict';
                $commands[] = '<a href="'.root_url.'tv/upcoming?record=yes&'
                              .$urlstr.'">'.t('Record This').'</a>';
                $commands[] = '<a href="'.root_url.'tv/upcoming?dontrec=yes&'
                              .$urlstr.'">'.t('Don\'t Record').'</a>';
                break;
            case 'LaterShowing':
                $rec_char = t('Later');
                $css_class= 'deactivated';
                $commands[] = '<a href="'.root_url.'tv/upcoming?record=yes&'
                              .$urlstr.'">'.t('Activate').'</a>';
                $commands[] = '<a href="'.root_url.'tv/upcoming?default=yes&'
                              .$urlstr.'">'.t('Default').'</a>';
                break;
            case 'LowDiskSpace':
                $rec_char   = t('Low Space');
                $css_class  = 'deactivated';
                $commands[] = 'Not Enough Disk Space';
                break;
            case 'TunerBusy':
                $rec_char   = t('Tuner Busy');
                $css_class  = 'deactivated';
                $commands[] = 'Tuner is busy';
                break;
            case 'Overlap':
                $rec_char   = t('Override');
                $css_class  = 'conflict';
                $commands[] = '<a href="'.root_url.'tv/upcoming?record=yes&'
                              .$urlstr.'">'.t('Record This').'</a>';
                $commands[] = '<a href="'.root_url.'tv/upcoming?dontrec=yes&'
                              .$urlstr.'">'.t('Don\'t Record').'</a>';
                break;
            case 'ManualOverride':
                $rec_char   = t('Override');
                $css_class  = 'deactivated';
                $commands[] = '<a href="'.root_url.'tv/upcoming?record=yes&'
                              .$urlstr.'">'.t('Activate').'</a>';
                $commands[] = '<a href="'.root_url.'tv/upcoming?default=yes&'
                              .$urlstr.'">'.t('Default').'</a>';
                break;
            case 'ForceRecord':
                $rec_char   = $show->inputname ? $show->inputname : t('Forced');
                $css_class  = 'scheduled';
                $commands[] = '<a href="'.root_url.'tv/upcoming?dontrec=yes&'
                              .$urlstr.'">'.t('Don\'t Record').'</a>';
                $commands[] = '<a href="'.root_url.'tv/upcoming?default=yes&'
                              .$urlstr.'">'.t('Default').'</a>';
                break;
            default:
                $rec_char   = '&nbsp;';
                $rec_class  = '';
                $css_class  = 'deactivated';
                $commands[] = '<a href="'.root_url.'tv/upcoming?record=yes&'
                              .$urlstr.'">'.t('Activate').'</a>';
                $commands[] = '<a href="'.root_url.'tv/upcoming?dontrec=yes&'
                              .$urlstr.'">'.t('Don\'t Record').'</a>';
                break;
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
    <td colspan="5" class="list_separator"><?php echo $cur_group ?></td>
</tr><?php
        }

    // Print the content
?><tr class="<?php echo $css_class ?>">
<?php if (!empty($group_field)) echo "    <td class=\"rec_class $rec_class\">$rec_char</td>\n" ?>
    <td class="<?php echo $show->css_class ?>"><?php
    // Window status text, for the mouseover
        $wstatus = strftime($_SESSION['time_format'], $show->starttime).' - '.strftime($_SESSION['time_format'], $show->endtime).' -- '
                  .str_replace(array("'", '"'),array("\\'", '&quot;'), $show->title)
                  .($show->subtitle ? ':  '.str_replace(array("'", '"'),array("\\'", '&quot;'), $show->subtitle)
                                          : '');
    // Print the link to edit this scheduled recording
        echo '<a href="'.root_url.'tv/detail/'.$show->chanid.'/'.$show->starttime.'">'
            .$show->title
            .(preg_match('/\\w/', $show->subtitle) ? ":  $show->subtitle" : '')
            .'</a>';
        ?></td>
    <td><?php echo $show->channel->channum, ' - ', $show->channel->name ?></td>
    <td nowrap><?php echo strftime($_SESSION['date_scheduled'], $show->starttime) ?></td>
    <td nowrap><?php echo nice_length($show->length) ?></td>
<?php   foreach ($commands as $command) { ?>
    <td nowrap width="5%" class="command command_border_l command_border_t command_border_b command_border_r" align="center"><?php echo $command ?></td>
<?php   } ?>
</tr><?php
        $prev_group = $cur_group;
        $row++;
    }
?>

</table>
<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
