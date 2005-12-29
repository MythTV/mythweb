<?php
/**
 * This displays details about a program, as well as provides recording
 * commands.
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
    $page_title = 'MythWeb - '.t('Program Detail').":  $program->title";

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_detail.css" />';

// Print the page header
    require_once theme_dir.'/header.php';

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
<?php if ($channel) { ?>
            <div id="channel_info" class="menu menu_border_t menu_border_b menu_border_l menu_border_r">
                <a href="<?php echo root ?>tv/channel/<?php echo $channel->chanid, '/', $program->starttime ?>"
                        onmouseover="return wstatus('<?php echo t('Details for') ?>: <?php echo $channel->channum.' '.$channel->callsign ?>')"
                        onmouseout="return wstatus('')">
<?php       if (show_channel_icons === true && is_file($channel->icon)) { ?>
                    <img src="<?php echo $channel->icon ?>" height="30" width="30"></a>
<?php       } ?>
                    <span class="preferred"><?php echo _or(prefer_channum ? $channel->channum : $channel->callsign, '&nbsp') ?></span><br />
                    <?php echo (prefer_channum ? $channel->callsign : $channel->channum)."\n" ?>
                </a>
            </div>
<?php } ?>
            <div id="program_title">
                <h1>
                    <a href="<?php echo root ?>tv/search/<?php echo urlencode($program->title) ?>&search_title=yes"><?php echo $schedule->title ?></a>
                </h1>
                <div id="program_time">
<?php
            if ($_GET['recordid'])
                echo '<span class="bold">';
            echo strftime('%a, %b %e', $schedule->starttime);
            if ($program && $program->previouslyshown)
                echo ' ('.t('Rerun').')';
            echo '<br />'
                .t('$1 to $2', strftime('%r', $schedule->starttime), strftime('%r', $schedule->endtime));
            if ($program)
                echo ' ('.tn('$1 min', '$1 mins', intval($program->length/60)).')';
            if ($_GET['recordid'])
                echo "</span>";
            echo "<br />\n";
?>
                </div>
                <div id="external_searches">
                    (<?php echo t('Search') ?>: &nbsp;
                    <a href="http://www.imdb.com/Find?select=Titles&for=<?php echo urlencode($schedule->title) ?>"><?php echo t('IMDB') ?></a>
                    &nbsp;-&nbsp;
                    <a href="http://www.tv.com/search.php?type=11&stype=all&qs=<?php echo urlencode($schedule->title) ?>"><?php echo t('TV.com') ?></a>
                    &nbsp;-&nbsp;
                    <a href="http://www.google.com/search?q=<?php echo urlencode($schedule->title) ?>"><?php echo t('Google') ?></a>
                    )
                </div>
            </div>
        </div>
<?php       if (strlen($schedule->subtitle) || strlen($schedule->description) || !empty($program->recstatus)) { ?>
        <div id="program_details">
            <dl>
<?php           if (strlen($schedule->subtitle)) { ?>
                <dt<?php if ($_GET['recordid']) echo ' class="bold"' ?>><?php echo t('Episode') ?>:&nbsp;</dt>
                <dd<?php if ($_GET['recordid']) echo ' class="bold"' ?>><?php
                    echo $schedule->subtitle;
                    ?></dd>
<?php           }
                if (strlen($schedule->description)) {
?>
                <dt<?php if ($_GET['recordid']) echo ' class="bold"' ?>><?php echo t('Description') ?>:&nbsp;</dt>
                <dd<?php if ($_GET['recordid']) echo ' class="bold"' ?>><?php
                    echo nl2br($schedule->description);
                    ?></dd>
<?php           }
                if (!empty($program->recstatus)) {
?>
                <dt><?php echo t('Notes') ?>:&nbsp;</dt>
                <dd><?php
                    echo $GLOBALS['RecStatus_Reasons'][$program->recstatus];
                    ?></dd>
<?php           } ?>
            </dl>
        </div>
<?php       }
            if ($program) {
?>
        <div id="program_extra_details">
            <dl>
<?php           if (strlen($program->category)) { ?>
                <dt><?php echo t('Category') ?>:&nbsp;</dt>
                <dd><?php echo $program->category ?></dd>
<?php           }
               if (strlen($program->airdate)) {
?>
                <dt><?php echo t('Original Airdate') ?>:&nbsp;</dt>
                <dd><?php echo $program->airdate ?></dd>
<?php           }
                if (strlen($program->rating)) {
?>
                <dt><?php
                    if (strlen($program->rater))
                        echo t('$1 Rating', $program->rater);
                    else
                        echo t('Rating');
                    ?>:&nbsp;</dt>
                <dd><?php echo $program->rating ?></dd>
<?php           }
                if ($program->get_credits('host')) {
?>
                <dt><?php echo t('Hosted by') ?>:&nbsp;</dt>
                <dd><?php echo $program->get_credits('host') ?></dd>
<?php           }
                if ($program->get_credits('presenter')) {
?>
                <dt><?php echo t('Presented by') ?>:&nbsp;</dt>
                <dd><?php echo $program->get_credits('presenter') ?></dd>
<?php           }
                if ($program->get_credits('actor')) {
?>
                <dt><?php echo t('Cast') ?>:&nbsp;</dt>
                <dd><?php echo $program->get_credits('actor') ?></dd>
<?php           }
                if ($program->get_credits('guest_star')) {
?>
                <dt><?php echo t('Guest Starring') ?>:&nbsp;</dt>
                <dd><?php echo $program->get_credits('guest_star') ?></dd>
<?php           }
                if ($program->get_credits('director')) {
?>
                <dt><?php echo t('Directed by') ?>:&nbsp;</dt>
                <dd><?php echo $program->get_credits('director') ?></dd>
<?php           }
                if ($program->get_credits('producer')) {
?>
                <dt><?php echo t('Produced by') ?>:&nbsp;</dt>
                <dd><?php echo $program->get_credits('producer') ?></dd>
<?php           }
                if ($program->get_credits('executive_producer')) {
?>
                <dt><?php echo t('Exec. Producer') ?>:&nbsp;</dt>
                <dd><?php echo $program->get_credits('executive_producer') ?></dd>
<?php           }
                if ($program->get_credits('writer')) {
?>
                <dt><?php echo t('Written by') ?>:&nbsp;</dt>
                <dd><?php echo $program->get_credits('writer') ?></dd>
<?php           }
		if (strlen($program->starstring) > 0) {
?>
		   <dt><?php echo t('Guide rating') ?>:&nbsp;</dt>
		   <dd><?php echo $program->starstring ?></dd>
<?php           } ?>
            </dl>
        </div>
<?php   } ?>

        <div id="local_links">
<?php       if ($_GET['recordid']) { ?>
            <a href="<?php echo root ?>tv/schedules"><?php
                echo t('Back to the recording schedules')
            ?></a>
<?php       } else { ?>
            <a href="<?php echo root ?>tv/list?time=<?php echo $program->starttime ?>"><?php
                echo t('What else is on at this time?')
            ?></a>
<?php       } ?>
            <a href="<?php echo root ?>tv/search/<?php echo urlencode($schedule->title) ?>&search_title=1"><?php
                if ($_GET['recordid'])
                    echo t('Find showings of this program');
                else
                    echo t('Find other showings of this program');
            ?></a>
            <a href="<?php echo root ?>tv/list?time=<?php echo $_SESSION['list_time'] ?>"><?php
                echo t('Back to the program listing')
            ?></a>
        </div>

    </div>

    </td>
    <td>

    <div id="recording_info" class="command command_border_l command_border_t command_border_b command_border_r clearfix">

        <form name="program_detail" method="post" action="<?php echo root ?>tv/detail<?php
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
                        if (!$schedule->recordid) echo ' CHECKED' ?> />
                    <a onclick="get_element('record_never').checked=true;"><?php
                        if ($schedule->recordid)
                            echo t('Cancel this schedule.');
                        else
                            echo t('Don\'t record this program.');
                        ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_once ?>" id="record_once"<?php
                        echo $schedule->type == rectype_once ? ' CHECKED' : '' ?> />
                    <a onclick="get_element('record_once').checked=true;"><?php echo t('rectype-long: once') ?></a></li>

<?php       if ($schedule->description != 'Manually scheduled') { ?>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_daily ?>" id="record_daily"<?php
                        echo $schedule->type == rectype_daily ? ' CHECKED' : '' ?> />
                    <a onclick="get_element('record_daily').checked=true;"><?php echo t('rectype-long: daily') ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_weekly ?>" id="record_weekly"<?php
                        echo $schedule->type == rectype_weekly ? ' CHECKED' : '' ?> />
                    <a onclick="get_element('record_weekly').checked=true;"><?php echo t('rectype-long: weekly') ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_findone ?>" id="record_findone"<?php
                        echo $schedule->type == rectype_findone ? ' CHECKED' : '' ?> />
                    <a onclick="get_element('record_findone').checked=true;"><?php echo t('rectype-long: findone') ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_finddaily ?>" id="record_finddaily"<?php
                        echo $schedule->type == rectype_finddaily ? ' CHECKED' : '' ?> />
                    <a onclick="get_element('record_finddaily').checked=true;"><?php echo t('rectype-long: finddaily') ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_findweekly ?>" id="record_findweekly"<?php
                        echo $schedule->type == rectype_findweekly ? ' CHECKED' : '' ?> />
                    <a onclick="get_element('record_findweekly').checked=true;"><?php echo t('rectype-long: findweekly') ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_channel ?>" id="record_channel"<?php
                        echo $schedule->type == rectype_channel ? ' CHECKED' : '' ?> />
                    <a onclick="get_element('record_channel').checked=true;"><?php echo t('rectype-long: channel', prefer_channum ? $channel->channum : $channel->callsign) ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_always ?>" id="record_always"<?php
                        echo $schedule->type == rectype_always ? ' CHECKED' : '' ?> />
                    <a onclick="get_element('record_always').checked=true;"><?php echo t('rectype-long: always') ?></a></li>
<?php       } ?>
            </ul>
        </div>
<?php
        }
        if ($schedule && $schedule->type) {
?>
        <div id="schedule_override">
            <h3><?php echo t('Schedule Override') ?>:</h3>

            <ul>
<?php       if ($schedule->type == rectype_override || $schedule->type == rectype_dontrec) { ?>
                <li><input type="radio" class="radio" name="record" value="0" id="schedule_default"<?php
                        if ($schedule->type != rectype_override && $schedule->type != rectype_dontrec) echo ' CHECKED' ?> />
                    <a onclick="get_element('schedule_default').checked=true;"><?php
                        echo t('Schedule normally.') ?></a></li>
<?php       } ?>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_override ?>" id="record_override"<?php
                        if ($schedule->type == rectype_override) echo ' CHECKED' ?> />
                    <a onclick="get_element('record_override').checked=true;"><?php
                        echo t('rectype-long: override') ?></a></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_dontrec ?>" id="record_dontrec"<?php
                        if ($schedule->type == rectype_dontrec) echo ' CHECKED' ?> />
                    <a onclick="get_element('record_dontrec').checked=true;"><?php
                        echo t('rectype-long: dontrec') ?></a></li>

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
                <dt><?php echo t('Recording Priority') ?>:</dt>
                <dd><select name="recpriority"><?php
                    for ($i=99; $i>=-99; --$i) {
                        echo "<option value=\"$i\"";
                        if ($schedule->recpriority == $i)
                            echo ' SELECTED';
                        echo ">$i</option>";
                    }
                    ?></select></dd>
                <dt><?php echo t('Time Stretch Default') ?>:</dt>
                <dd>
                    <select name="timestretch">
                <?php
                    $tsstep = 0.05;
                    for ($tscount = 0.5; $tscount < 2.01; $tscount += $tsstep) {
                        $matches = fequals($schedule->tsdefault, $tscount);

                        if (!$matches &&
                                $schedule->tsdefault < $tscount &&
                                $schedule->tsdefault > $tscount - $tsstep) {
                            printf('<option value="%01.2f" selected>%01.2f' .
                                    "</option>\n", $schedule->tsdefault,
                                    $schedule->tsdefault);
                        }

                        printf('<option value="%01.2f"', $tscount);
                        if ($matches) {
                            echo ' selected';
                        }
                        printf(">%01.2f</option>\n", $tscount);
                    }
                ?>
                    </select>
                </dd>
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
                   ?></select></dd>
                <dt><?php echo t('Auto-flag commercials') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="autocommflag"<?php if ($schedule->autocommflag) echo ' CHECKED' ?> value="1" /></dd>
                <dt><?php echo t('Auto-transcode') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="autotranscode"<?php if ($schedule->autotranscode) echo ' CHECKED' ?> value="1" /></dd>
                <dt><?php echo get_backend_setting('UserJobDesc1') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="autouserjob1"<?php if ($schedule->autouserjob1) echo ' CHECKED' ?> value="1" /></dd>
                <dt><?php echo get_backend_setting('UserJobDesc2') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="autouserjob2"<?php if ($schedule->autouserjob2) echo ' CHECKED' ?> value="1" /></dd>
                <dt><?php echo get_backend_setting('UserJobDesc3') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="autouserjob3"<?php if ($schedule->autouserjob3) echo ' CHECKED' ?> value="1" /></dd>
                <dt><?php echo get_backend_setting('UserJobDesc4') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="autouserjob4"<?php if ($schedule->autouserjob4) echo ' CHECKED' ?> value="1" /></dd>
                <dt><?php echo t('Auto-expire recordings') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="autoexpire"<?php if ($schedule->autoexpire) echo ' CHECKED' ?> value="1" /></dd>
                <dt><?php echo t('Record new and expire old') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="maxnewest"<?php if ($schedule->maxnewest) echo ' CHECKED' ?> value="1" /></dd>
                <dt><?php echo t('Inactive') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="inactive"<?php if ($schedule->inactive) echo ' CHECKED' ?> value="1" /></dd>
                <dt><?php echo t('No. of recordings to keep') ?>:</dt>
                <dd><input type="input" class="quantity" name="maxepisodes" value="<?php echo htmlentities($schedule->maxepisodes) ?>" /></dd>
                <dt><?php echo t('Start Early') ?>:</dt>
                <dd><input type="input" class="quantity" name="startoffset" value="<?php echo htmlentities($schedule->startoffset) ?>" />
                    <?php echo t('minutes') ?></dd>
                <dt><?php echo t('End Late') ?>:</dt>
                <dd><input type="input" class="quantity" name="endoffset" value="<?php echo htmlentities($schedule->endoffset) ?>" />
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
    require_once theme_dir.'/footer.php';

