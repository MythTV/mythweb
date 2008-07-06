<?php
/**
 * Show all upcoming recordings.
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
    $page_title = 'MythWeb - '.t('Upcoming Recordings');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_upcoming.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

/** @todo FIXME:  pull this out of the theme page! */
// Which field are we grouping by?
    $group_field = $_SESSION['scheduled_sortby'][0]['field'];
    if (empty($group_field))
        $group_field = 'recdate';
    elseif (!in_array($group_field, array('title', 'channum', 'airdate', 'recdate')))
        $group_field = '';

?>

<script type="text/javascript">
    function load_tool_tip(element_id, channel_id, start_time) {
        var element = $(element_id);
        if (Tips.hasTip(element) == false) {
            ajax_add_request();
            new Ajax.Request('<?php echo root; ?>tv/get_show_details',
                             {
                                parameters: {
                                                chanid:             channel_id,
                                                starttime:          start_time,
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

<form id="change_display" action="<?php echo root ?>tv/upcoming" method="post">
<div><input type="hidden" name="change_display" value="1"></div>

<table id="display_options" class="commandbox commands" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td class="x-title"><?php echo t('Display') ?>:</td>
    <td class="x-check">
        <label for="disp_scheduled">
        <input type="checkbox" id="disp_scheduled" name="disp_scheduled" class="radio" onclick="$('change_display').submit()"<?php
            if ($_SESSION['scheduled_recordings']['disp_scheduled']) echo ' CHECKED' ?>>
        <?php echo t('Scheduled') ?></label>
        </td>
    <td class="x-check">
        <label for="disp_duplicates">
        <input type="checkbox" id="disp_duplicates" name="disp_duplicates" class="radio" onclick="$('change_display').submit()" <?php
            if ($_SESSION['scheduled_recordings']['disp_duplicates']) echo ' CHECKED' ?>>
        <?php echo t('Duplicates') ?></label>
        </td>
    <td class="x-check">
        <label for="disp_deactivated">
        <input type="checkbox" id="disp_deactivated" name="disp_deactivated" class="radio" onclick="$('change_display').submit()" <?php
            if ($_SESSION['scheduled_recordings']['disp_deactivated']) echo ' CHECKED' ?>>
        <?php echo t('Deactivated') ?></label>
        </td>
    <td class="x-check">
        <label for="disp_conflicts">
        <input type="checkbox" id="disp_conflicts" name="disp_conflicts" class="radio" onclick="$('change_display').submit()" <?php
            if ($_SESSION['scheduled_recordings']['disp_conflicts']) echo ' CHECKED' ?>>
        <?php echo t('Conflicts') ?></label>
        </td>
</tr>
</table>

</form>

<table id="listings" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
    <?php if ($group_field != '') echo "<td class=\"list\">&nbsp;</td>\n" ?>
        <th class="x-status"><?php  echo t('Status') ?></th>
    <?php if ($_SESSION['settings']['screens']['tv']['upcoming recordings']['title'] == 'on') { ?>
        <th class="x-title"><?php   echo get_sort_link('title',   t('Title'))   ?></th>
    <?php } if ($_SESSION['settings']['screens']['tv']['upcoming recordings']['channel'] == 'on') { ?>
        <th class="x-channum"><?php echo get_sort_link('channum', t('Channel')) ?></th>
    <?php } if ($_SESSION['settings']['screens']['tv']['upcoming recordings']['airdate'] == 'on') { ?>
        <th class="x-airdate"><?php echo get_sort_link('airdate', t('Airdate')) ?></th>
    <?php } if ($_SESSION['settings']['screens']['tv']['upcoming recordings']['record date'] == 'on') { ?>
        <th class="x-recdate"><?php  echo get_sort_link('recdate',  t('Record Date'))  ?></th>
    <?php } if ($_SESSION['settings']['screens']['tv']['upcoming recordings']['length'] == 'on') { ?>
        <th class="x-length" nowrap><?php  echo get_sort_link('length',  t('Record Length'))  ?></th>
    <?php } ?>
</tr><?php
    $row = 0;

    $prev_group = '';
    $cur_group  = '';
    foreach ($all_shows as $show) {

    // Set the class to be used to display the recording status character
        $rec_class = implode(' ', array(recstatus_class($show), $show->recstatus));
    // Reset the command variable to a default URL
        $commands = array();
        $urlstr = $show->chanid.'/'.$show->starttime;
        if ($Schedules[$show->recordid]->search == searchtype_manual)
            $urlstr .= '/'.$show->recordid;
    // Set the recording status character, class and any applicable commands for each show
        switch ($show->recstatus) {
            case 'Recording':
                $rec_char   = $show->inputname;
                $css_class  = 'scheduled';
                break;
            case 'WillRecord':
                $rec_char   = $show->inputname;
                $css_class  = 'scheduled';
                $commands[] = 'dontrec';
            // Offer to suppress any recordings that have enough info to do so.
                if (preg_match('/\\S/', $show->title)
                        && (preg_match('/\\S/', $show->programid.$show->subtitle.$show->description))) {
                    $commands[] = 'never_record';
                }
                break;
            case 'PreviousRecording':
                $rec_char   = t('Duplicate');
                $css_class  = 'duplicate';
                $commands[] = 'record';
                $commands[] = 'forget_old';
                break;
            case 'CurrentRecording':
                $rec_char   = t('Recorded');
                $css_class  = 'duplicate';
                $commands[] = 'record';
                $commands[] = 'forget_old';
                break;
            case 'Repeat':
                $rec_char   = 'Rerun';
                $css_class  = 'duplicate';
                $commands[] = 'record';
                break;
            case 'EarlierShowing':
                $rec_char   = t('Earlier');
                $css_class  = 'deactivated';
                $commands[] = 'activate';
                $commands[] = 'default';
                break;
            case 'TooManyRecordings':
                $rec_char   = t('Too Many');
                $css_class  = 'deactivated';
                break;
            case 'NeverRecord':
                $rec_char   = t('Never Record');
                $css_class  = 'deactivated';
                $commands[] = 'activate';
                $commands[] = 'forget_old';
                break;
            case 'Cancelled':
                $rec_char   = t('Cancelled');
                $css_class  = 'deactivated';
                $commands[] = 'activate';
                $commands[] = 'default';
                break;
            case 'DontRecord':
                $rec_char   = t('Don\'t Record');
                $css_class  = 'deactivated';
                $commands[] = 'activate';
                $commands[] = 'default';
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
                $commands[] = 'record';
                $commands[] = 'never_record';
                break;
            case 'LaterShowing':
                $rec_char   = t('Later');
                $css_class  = 'deactivated';
                $commands[] = 'activate';
                $commands[] = 'default';
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
                $commands[] = 'record';
                $commands[] = 'dontrec';
                break;
            case 'ManualOverride':
                $rec_char   = t('Override');
                $css_class  = 'deactivated';
                $commands[] = 'activate';
                $commands[] = 'default';
                break;
            case 'ForceRecord':
                $rec_char   = $show->inputname ? $show->inputname : t('Forced');
                $css_class  = 'scheduled';
                $commands[] = 'dontrec';
                $commands[] = 'default';
                break;
            default:
                $rec_char   = '&nbsp;';
                #$rec_char   = $show->recstatus;
                $rec_class  = '';
                $css_class  = 'deactivated';
                $commands[] = 'activate';
                $commands[] = 'dontrec';
                break;
        }
    // Now do the necessary replacements for each command
        foreach ($commands as $key => $val) {
            switch ($val) {
                case 'dontrec':
                    $commands[$key] = '<a href="'.root.'tv/upcoming/'.$urlstr.'?dontrec=yes"'
                                     .' title="'.html_entities(t('info: dont record')).'">'
                                     .t('Don\'t Record').'</a>';
                    break;
                case 'never_record':
                    $commands[$key] = '<a href="'.root.'tv/upcoming/'.$urlstr.'?never_record=yes"'
                                     .' title="'.html_entities(t('info:never record')).'">'
                                     .t('Never Record').'</a>';
                    break;
                case 'record':
                    $commands[$key] = '<a href="'.root.'tv/upcoming/'.$urlstr.'?record=yes"'
                                     .' title="'.html_entities(t('info: record this')).'">'
                                     .t('Record This').'</a>';
                    break;
                case 'forget_old':
                    $commands[$key] = '<a href="'.root.'tv/upcoming/'.$urlstr.'?forget_old=yes"'
                                     .' title="'.html_entities(t('info:forget old')).'">'
                                     .t('Forget Old').'</a>';
                    break;
                case 'activate':
                    $commands[$key] = '<a href="'.root.'tv/upcoming/'.$urlstr.'?activate=yes"'
                                     .' title="'.html_entities(t('info: activate recording')).'">'
                                     .t('Activate').'</a>';
                    break;
                case 'default':
                    $commands[$key] = '<a href="'.root.'tv/upcoming/'.$urlstr.'?default=yes"'
                             .' title="'.html_entities(t('info: default recording')).'">'
                             .t('Default').'</a>';
                    break;
            }
        }

    // A program id counter for popup info
        if ($_SESSION["show_popup_info"]) {
            static $program_id_counter = 0;
            $program_id_counter++;
        }

    // Print a dividing row if grouping changes
        if ($group_field == "airdate")
            $cur_group = strftime($_SESSION['date_listing_jump'], $show->starttime);
        elseif ($group_field == "recdate")
            $cur_group = strftime($_SESSION['date_listing_jump'], $show->recstartts);
        elseif ($group_field == "channum")
            $cur_group = $show->channel->channum.' - '.$show->channel->name;
        elseif ($group_field == "title")
            $cur_group = $show->title;

        if ( $cur_group != $prev_group && $group_field != '' ) {
?><tr class="list_separator">
    <td colspan="10" class="list_separator"><?php echo $cur_group ?></td>
</tr><?php
        }

    // Print the content
?><tr class="<?php echo $css_class ?>">
<?php if (!empty($group_field)) echo "    <td class=\"list\">&nbsp;</td>\n" ?>
    <td class="x-status rec_class <?php echo $rec_class ?>"><?php echo $rec_char ?></td>
    <?php
        if ($_SESSION['settings']['screens']['tv']['upcoming recordings']['title'] == 'on') {
            ?>
                <td class="x-title <?php echo $show->css_class ?>"><?php
                // Print the link to edit this scheduled recording
                    echo '<a id="program-'.$show->chanid.'-'.$show->starttime.'"';
                    if ($_SESSION["show_popup_info"]) {
                        echo ' onmouseover = "currently_hovered_id = this.id; details_delay_timer_id = setTimeout(function () {load_tool_tip(\'program-'.$show->chanid.'-'.$show->starttime.'\',\''.$show->chanid.'\',\''.$show->starttime.'\');}, 250);"';
                        echo ' onmouseout  = "currently_hovered_id = null; clearTimeout( details_delay_timer_id ); details_delay_timer_id = null;"';
                    }
                    else
                        echo ' title="',html_entities(strftime($_SESSION['time_format'], $show->starttime)
                                     .' - '.strftime($_SESSION['time_format'], $show->endtime)
                                     .' -- '
                                     .$show->title
                                     .($show->subtitle
                                         ? ':  '.$show->subtitle
                                         : '')), '"';
                    echo ' href="', root, 'tv/detail/', $urlstr, '">',
                         $show->title,
                         ($show->subtitle
                            ? ':  '.$show->subtitle
                            : ''),
                         '</a>';
                    ?>
                </td>
            <?php
        }
        if ($_SESSION['settings']['screens']['tv']['upcoming recordings']['channel'] == 'on') {
            ?>
                <td class="x-channum"><?php echo $show->channel->channum, ' - ', $show->channel->name ?></td>
            <?php
        }
        if ($_SESSION['settings']['screens']['tv']['upcoming recordings']['airdate'] == 'on') {
            ?>
                <td class="x-airdate" nowrap><?php echo strftime($_SESSION['date_scheduled'], $show->starttime) ?></td>
            <?php
        }
        if ($_SESSION['settings']['screens']['tv']['upcoming recordings']['record date'] == 'on') {
            ?>
                <td class="x-recdate" nowrap><?php echo strftime($_SESSION['date_scheduled'], $show->recstartts) ?></td>
            <?php
        }
        if ($_SESSION['settings']['screens']['tv']['upcoming recordings']['length'] == 'on') {
            ?>
                <td class="x-length"><?php  echo nice_length($show->length) ?></td>
            <?php
        }
        if ($show->recstatus == 'Recording') {
            echo '    <td class="x-commands commands x-recording" colspan="2">',
                 '<a href="', root, 'tv/detail/', $show->chanid, '/', $show->starttime, '">',
                 t('Currently Recording:  Edit'),"</a></td>\n";
        }
        else {
            foreach ($commands as $command) {
                echo '    <td class="x-commands commands">',$command,"</td>\n";
            }
        }
?>
</tr><?php
        $prev_group = $cur_group;
        $row++;
    }
?>

</table>
<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
