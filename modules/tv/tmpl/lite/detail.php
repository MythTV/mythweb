<?php
/**
 * This displays details about a program, as well as provides recording
 * commands.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Program Detail').":  $program->title";

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_detail.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

/*
 * Print the page contents:
 * I really hate tables, but this layout just doesn't work right with pure-css.
 * In its defense, it *is* somewhat tabular.
/*/
?>
<table id="program_content" border="0" cellspacing="0" cellpadding="0">
<tr>

    <td>

    <div id="program_info" class="clearfix">
        <div id="program_header">
<?php   if ($channel) { ?>
            <div id="channel_info" class="menu menu_border_t menu_border_b menu_border_l menu_border_r">
                <a href="<?php echo root_url; ?>tv/channel/<?php echo $channel->chanid, '/', $program->starttime; ?>">
<?php       if ($_SESSION["show_channel_icons"] == true && !empty($channel->icon)) { ?>
                    <img src="<?php echo $channel->icon ?>" height="30" width="30"></a>
<?php       } ?>
                    <span class="preferred"><?php echo _or($_SESSION["prefer_channum"] ? $channel->channum : $channel->callsign, '&nbsp') ?></span><br />
                    <?php echo ($_SESSION["prefer_channum"] ? $channel->callsign : $channel->channum)."\n" ?>
                </a>
            </div>
<?php   } ?>
            <div id="program_title">
                <h1>
                    <a href="<?php echo root_url ?>tv/search/<?php echo str_replace('%2F', '/', rawurlencode($schedule->title)) ?>?search_title=1"><?php echo $schedule->title ?></a>
                </h1>
                <div id="program_time">
<?php
        if ($_GET['recordid'])
            echo '<span class="bold">';
        echo strftime('%a, %b %e', $schedule->starttime);
        if ($program && $program->previouslyshown)
            echo ' ('.t('Repeat').')';
        echo '<br />'
            .t('$1 to $2', strftime($_SESSION['time_format'], $schedule->starttime), strftime($_SESSION['time_format'], $schedule->endtime));
        if ($program)
            echo ' ('.tn('$1 min', '$1 mins', intval($program->length/60)).')';
        if ($_GET['recordid'])
            echo "</span>";
        echo "<br />\n";
?>
                </div>
                <div id="external_searches">
                    (<?php echo t('Search') ?>: &nbsp;
                    <a href="http://www.themoviedb.org/search/movie?query=<?php echo urlencode($schedule->title) ?>"><?php echo t('themoviedb') ?></a>
                    &nbsp;-&nbsp;
                    <a href="http://www.imdb.com/search/title?title=<?php echo urlencode($schedule->title) ?>"><?php echo t('IMDB') ?></a>
                    &nbsp;-&nbsp;
                    <a href="http://www.thetvdb.com/?string=<?php echo urlencode($schedule->title) ?>&searchseriesid=&tab=listseries&function=Search"><?php echo t('TheTVDB') ?></a>
                    &nbsp;-&nbsp;
                    <a href="http://www.tv.com/search.php?type=11&stype=all&qs=<?php echo urlencode($schedule->title) ?>"><?php echo t('TV.com') ?></a>
                    &nbsp;-&nbsp;
                    <a href="http://www.google.com/search?q=<?php echo urlencode($schedule->title) ?>"><?php echo t('Google') ?></a>
                    )
                </div>
            </div>
        </div>
<?php    if (strlen($schedule->subtitle) || strlen($schedule->fancy_description) || !empty($program->recstatus)) { ?>
        <div id="program_details">
            <dl>
<?php       if (strlen($schedule->subtitle)) { ?>
                <dt<?php if ($_GET['recordid']) echo ' class="bold"' ?>><?php echo t('Episode') ?>:&nbsp;</dt>
                <dd<?php if ($_GET['recordid']) echo ' class="bold"' ?>><?php
                echo $schedule->subtitle;
                    ?></dd>
<?php       }
            if (strlen($schedule->fancy_description)) {
?>
                <dt<?php if ($_GET['recordid']) echo ' class="bold"' ?>><?php echo t('Description') ?>:&nbsp;</dt>
                <dd<?php if ($_GET['recordid']) echo ' class="bold"' ?>><?php
                    echo nl2br($schedule->fancy_description);
                    ?></dd>
<?php       }
            if (!empty($program->recstatus)) {
?>
                <dt><?php echo t('MythTV Status') ?>:&nbsp;</dt>
                <dd><?php
                    echo $GLOBALS['RecStatus_Reasons'][$program->recstatus];
                    ?></dd>
<?php       } ?>
            </dl>
        </div>
<?php   }
        if ($program) {
?>
        <div id="program_extra_details">
            <dl>
<?php       if (strlen($program->category)) { ?>
                <dt><?php echo t('Category') ?>:&nbsp;</dt>
                <dd><?php echo $program->category ?></dd>
<?php       }
            if (strlen($program->category_type)) { ?>
                <dt><?php echo t('Type') ?>:&nbsp;</dt>
                <dd><?php echo $program->showtype, ' (', $program->seriesid, ')' ?></dd>
<?php       }
            if (strlen($program->syndicatedepisodenumber) > 0) {
?>
               <dt><?php echo t('Episode Number') ?>:&nbsp;</dt>
               <dd><?php echo $program->syndicatedepisodenumber ?></dd>
<?php       }
            if (strlen($program->airdate)) {
?>
                <dt><?php echo t('Original Airdate') ?>:&nbsp;</dt>
                <dd><?php echo $program->airdate ?></dd>
<?php       }
            if (strlen($program->programid) > 0) {
?>
               <dt><?php echo t('Program ID') ?>:&nbsp;</dt>
               <dd><?php echo $program->programid ?></dd>
<?php       }
            if ($program->get_credits('host')) {
?>
                    <dt><?php echo t('Hosted by') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('host') ?></dd>
<?php       }
            if ($program->get_credits('presenter')) {
?>
                    <dt><?php echo t('Presented by') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('presenter') ?></dd>
<?php       }
            if ($program->get_credits('actor')) {
?>
                    <dt><?php echo t('Cast') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('actor') ?></dd>
<?php       }
            if ($program->get_credits('guest_star')) {
?>
                    <dt><?php echo t('Guest Starring') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('guest_star') ?></dd>
<?php       }
            if ($program->get_credits('director')) {
?>
                    <dt><?php echo t('Directed by') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('director') ?></dd>
<?php       }
            if ($program->get_credits('producer')) {
?>
                    <dt><?php echo t('Produced by') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('producer') ?></dd>
<?php       }
            if ($program->get_credits('executive_producer')) {
?>
                    <dt><?php echo t('Exec. Producer') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('executive_producer') ?></dd>
<?php       }
            if ($program->get_credits('writer')) {
?>
                    <dt><?php echo t('Written by') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('writer') ?></dd>
<?php       }
            if (strlen($program->starstring) > 0) {
?>
                    <dt><?php echo t('Guide rating') ?>:&nbsp;</dt>
                    <dd><?php echo $program->starstring ?></dd>
<?php       } ?>
            </dl>
        </div>
<?php
        }
        if (count($conflicting_shows)) {
            echo "    <div id=\"conflicting_shows\" class=\"clearfix\">\n        ",
                 t('Possible conflicts with this show'),
                 ":\n        <table>\n        ";
        // A program id counter for popup info
            $program_id_counter = 0;
            foreach ($conflicting_shows as $show) {
            // Set the class to be used to display the recording status character
                $rec_class = implode(' ', array(recstatus_class($show), $show->recstatus));
            // Set the recording status character, class and any applicable commands for each show
                switch ($show->recstatus) {
                    case 'Recording':
                    case 'WillRecord':
                    case 'ForceRecord':
                        $css_class = 'scheduled';
                        break;
                    case 'PreviousRecording':
                    case 'CurrentRecording':
                    case 'Repeat':
                    case 'Recorded':
                        $css_class = 'duplicate';
                        break;
                    case 'Conflict':
                    case 'Overlap':
                        $css_class = 'conflict';
                        break;
                    case 'EarlierShowing':
                    case 'TooManyRecordings':
                    case 'Cancelled':
                    case 'LaterShowing':
                    case 'LowDiskSpace':
                    case 'TunerBusy':
                    case 'ManualOverride':
                    default:
                        $css_class = 'deactivated';
                        break;
                }

            // Print the content
        ?><tr class="<?php echo $css_class ?>">
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
                <td><a href="<?php echo root_url ?>tv/channel/<?php echo $show->channel->chanid, '/', $show->starttime ?>"><?php echo $show->channel->channum, ' - ', $show->channel->name ?></a></td>
        </tr><?php
                $program_id_counter++;
            }
            echo "\n        </table>\n    </div>";
        }
?>

        <div id="local_links">
<?php       if ($_GET['recordid']) { ?>
            <a href="<?php echo root_url ?>tv/schedules"><?php
                echo t('Back to the recording schedules')
            ?></a>
<?php       } else { ?>
            <a href="<?php echo root_url ?>tv/list?time=<?php echo $program->starttime ?>"><?php
                echo t('What else is on at this time?')
            ?></a>
<?php       } ?>
            <a href="<?php echo root_url ?>tv/search/<?php echo str_replace('%2F', '/', rawurlencode($schedule->title)) ?>?search_title=1"><?php
                if ($_GET['recordid'])
                    echo t('Find showings of this program');
                else
                    echo t('Find other showings of this program');
            ?></a>
            <a href="<?php echo root_url ?>tv/list?time=<?php echo $_SESSION['list_time'] ?>"><?php
                echo t('Back to the program listing')
            ?></a>
        </div>

    </div>

    </td>
    <td>

    <div id="recording_info" class="command command_border_l command_border_t command_border_b command_border_r clearfix">

        <form name="program_detail" method="post" action="<?php echo root_url ?>tv/detail<?php
            if ($_GET['recordid'])
                echo '?recordid='.urlencode($_GET['recordid']);
            else
                echo '/'.urlencode($_GET['chanid']).'/'.urlencode($_GET['starttime'])
            ?>">

<?php   if (!$schedule || $schedule->type != rectype_override && $schedule->type != rectype_dontrec) { ?>
        <div id="schedule_options">
            <h3><?php echo t('Schedule Options') ?>:</h3>

            <ul>
                <li><input type="radio" class="radio" name="record" value="0" id="record_never"<?php
                        if (!$schedule->recordid || $schedule->search) echo ' CHECKED' ?> />
                    <label for="record_never"><?php
                        if ($schedule->search) {
                            echo t('Schedule via $1.',
                                   '<a href='.root_url.'tv/schedules/'
                                   .($schedule->search == searchtype_manual
                                        ? 'manual'
                                        : 'custom'
                                    )
                                   .'/'.$schedule->recordid.'>'
                                   .$schedule->search_title.'</a>');
                        }
                        elseif ($schedule->recordid)
                            echo t('Cancel this schedule.');
                        else
                            echo t('Don\'t record this program.');
                        ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_once ?>" id="record_once"<?php
                        echo $schedule->type == rectype_once ? ' CHECKED' : '' ?> />
                    <label for="record_once"><?php echo t('rectype-long: once') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_findone ?>" id="record_findone"<?php
                        echo $schedule->type == rectype_findone ? ' CHECKED' : '' ?> />
                    <label for="record_findone"><?php echo t('rectype-long: findone') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_always ?>" id="record_always"<?php
                        echo $schedule->type == rectype_always ? ' CHECKED' : '' ?> />
                    <label for="record_always"><?php echo t('rectype-long: always') ?></label></li>
            </ul>
        </div>
<?php
        }
        if ($schedule && $schedule->type != rectype_once && ($schedule->search || $schedule->type)) {
?>
        <div id="schedule_override">
            <h3><?php echo t('Schedule Override') ?>:</h3>

            <ul>
<?php       if ($schedule->type == rectype_override || $schedule->type == rectype_dontrec) { ?>
                <li><input type="radio" class="radio" name="record" value="0" id="schedule_default"<?php
                        if ($schedule->type != rectype_override && $schedule->type != rectype_dontrec) echo ' CHECKED' ?> />
                    <label for="schedule_default"><?php
                        echo t('Schedule normally.') ?></label></li>
<?php       } ?>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_override ?>" id="record_override"<?php
                        if ($schedule->type == rectype_override) echo ' CHECKED' ?> />
                    <label for="record_override"><?php
                        echo t('rectype-long: override') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_dontrec ?>" id="record_dontrec"<?php
                        if ($schedule->type == rectype_dontrec) echo ' CHECKED' ?> />
                    <label for="record_dontrec"><?php
                        echo t('rectype-long: dontrec') ?></label></li>

            </ul>
        </div>
<?php      } ?>

        <div id="advanced_options">
            <h3><?php echo t('Advanced Options') ?>:</h3>

            <dl class="clearfix">
                <dt><?php echo t('Recording Profile') ?>:</dt>
                <dd><?php profile_select($schedule->profile) ?></dd>
                <dt><?php echo t('Transcoder') ?>:</dt>
                <dd><?php transcoder_select($schedule->transcoder) ?></dd>
                <dt><?php echo t('Recording Group') ?>:</dt>
                <dd><?php recgroup_select($schedule->recgroup) ?></dd>
                <dt><?php echo t('Storage Group') ?>:</dt>
                <dd><?php storagegroup_select($schedule->storagegroup) ?></dd>
                <dt><?php echo t('Recording Priority') ?>:</dt>
                <dd><select name="recpriority"><?php
                    for ($i=99; $i>=-99; --$i) {
                        echo "<option value=\"$i\"";
                        if ($schedule->recpriority == $i)
                            echo ' SELECTED';
                        echo ">$i</option>";
                    }
                    ?></select></dd>
                <dt><?php echo t('Check for duplicates in') ?>:</dt>
                <dd><select name="dupin"><?php
                        echo '<option value="1"';
                        if ($schedule->dupin == 1)
                            echo ' SELECTED';
                        echo '>' . t('Current recordings') . '</option>';
                        echo '<option value="2"';
                        if ($schedule->dupin == 2)
                            echo ' SELECTED';
                        echo '>' . t('Previous recordings') . '</option>';
                        echo '<option value="4"';
                        if ($schedule->dupin == 4)
                            echo ' SELECTED';
                        echo '>' . t('Only New Episodes') . '</option>';
                        echo '<option value="15"';
                        if ($schedule->dupin == 15 || $schedule->dupin == 0)
                            echo ' SELECTED';
                        echo '>' . t('All recordings') . '</option>';
                   ?></select></dd>
                <dt><?php echo t('Duplicate Check method') ?>:</dt>
                <dd><select name="dupmethod"><?php
                        echo '<option value="1"';
                        if ($schedule->dupmethod == 1)
                            echo ' SELECTED';
                        echo '>' . t('None') . '</option>';
                        echo '<option value="2"';
                        if ($schedule->dupmethod == 2)
                            echo ' SELECTED';
                        echo '>' . t('Subtitle') . '</option>';
                        echo '<option value="4"';
                        if ($schedule->dupmethod == 4)
                            echo ' SELECTED';
                        echo '>' . t('Description') . '</option>';
                        echo '<option value="6"';
                        if ($schedule->dupmethod == 6 || $schedule->dupmethod == 0)
                            echo ' SELECTED';
                        echo '>'.t('Subtitle and Description').'</option>';
                        echo '<option value="8"';
                        if ($schedule->dupmethod == 8)
                            echo ' SELECTED';
                        echo '>'.t('Subtitle then Description').'</option>';
                   ?></select></dd>
                <dt><?php echo t('Preferred Input') ?>:</dt>
                <dd><?php input_select($schedule->prefinput, 'prefinput') ?></dd>
                <dt><label for="autometadata"><?php echo t('Look up Metadata') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autometadata" name="autometadata"<?php if ($schedule->autometadata) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="autocommflag"><?php echo t('Auto-flag commercials') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autocommflag" name="autocommflag"<?php if ($schedule->autocommflag) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="autotranscode"><?php echo t('Auto-transcode') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autotranscode" name="autotranscode"<?php if ($schedule->autotranscode) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="autouserjob1"><?php echo get_backend_setting('UserJobDesc1') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autouserjob1" name="autouserjob1"<?php if ($schedule->autouserjob1) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="autouserjob2"><?php echo get_backend_setting('UserJobDesc2') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autouserjob2" name="autouserjob2"<?php if ($schedule->autouserjob2) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="autouserjob3"><?php echo get_backend_setting('UserJobDesc3') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autouserjob3" name="autouserjob3"<?php if ($schedule->autouserjob3) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="autouserjob4"><?php echo get_backend_setting('UserJobDesc4') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autouserjob4" name="autouserjob4"<?php if ($schedule->autouserjob4) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="inactive"><?php echo t('Inactive') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="inactive" name="inactive"<?php if ($schedule->inactive) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="autoexpire"><?php echo t('Auto-expire recordings') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autoexpire" name="autoexpire"<?php if ($schedule->autoexpire) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="maxnewest"><?php echo t('Record new and expire old') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="maxnewest" name="maxnewest"<?php if ($schedule->maxnewest) echo ' CHECKED' ?> value="1" /></dd>
                <dt><?php echo t('No. of recordings to keep') ?>:</dt>
                <dd><input type="input" class="quantity" name="maxepisodes" value="<?php echo html_entities($schedule->maxepisodes) ?>" /></dd>
                <dt><?php echo t('Start Early') ?>:</dt>
                <dd><input type="input" class="quantity" name="startoffset" value="<?php echo html_entities($schedule->startoffset) ?>" />
                    <?php echo t('minutes') ?></dd>
                <dt><?php echo t('End Late') ?>:</dt>
                <dd><input type="input" class="quantity" name="endoffset" value="<?php echo html_entities($schedule->endoffset) ?>" />
                    <?php echo t('minutes') ?></dd>
            </dl>

            <p align="center">
                <input type="submit" class="submit" name="save" value="<?php echo t('Update Recording Settings') ?>">
            </p>

        </div>

        </form>

    </div>

    </td>

</tr>
</table>

<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
