<?php
/***                                                                        ***\
    program_detail.php                       Last Updated: 2005.02.20 (xris)

    This file defines a theme class for the program details section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

class Theme_program_detail extends Theme {

    function print_page(&$program, &$schedule, &$channel) {
    // Load this page's custom stylesheet
        $this->headers[] = '<link rel="stylesheet" type="text/css" href="'.theme_dir.'program_detail.css" />';
    // Print the main page header
        parent::print_header("MythWeb - ".t('Program Detail').":  $program->title");
    /* Print the page contents:
     * I really hate tables, but this layout just doesn't work right with pure-css.
     * In its defense, it *is* somewhat tabular.
     */
?>
<table id="program_content" border="0" cellspacing="0" cellpadding="0">
<tr>

    <td>

    <div id="program_info" class="clearfix">
        <div id="program_header">
<?php if ($channel) { ?>
            <div id="channel_info" class="menu menu_border_t menu_border_b menu_border_l menu_border_r">
                <a href="channel_detail.php?chanid=<?php echo $channel->chanid?>&time=<?php echo $program->starttime?>"
                        onmouseover="return wstatus('<? echo t('Details for')?>: <?php echo $channel->channum.' '.$channel->callsign?>')"
                        onmouseout="return wstatus('')">
<?php       if (show_channel_icons === true && is_file($channel->icon)) { ?>
                    <img src="<?php echo $channel->icon?>" height="30" width="30"></a>
<?php       } ?>
                    <span class="preferred"><?php echo _or(prefer_channum ? $channel->channum : $channel->callsign, '&nbsp') ?></span><br />
                    <?php echo (prefer_channum ? $channel->callsign : $channel->channum)."\n" ?>
                </a>
            </div>
<?php } ?>
            <div id="program_title">
                <h1>
                    <a href="search.php?searchstr=<?php echo urlencode($program->title)?>&search_title=yes">"<?php echo $schedule->title?>"</a>
<?php       if (strlen($program->starstring) > 0)
                echo "                    $program->starstring\n";
?>
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
<?php           } ?>
            </dl>
        </div>
<?php   } ?>

        <div id="local_links">
<?php       if ($_GET['recordid']) { ?>
            <a href="recording_schedules.php"><?php
                echo t('Back to the recording schedules')
            ?></a>
<?php       } else { ?>
            <a href="program_listing.php?time=<?php echo $program->starttime ?>"><?php
                echo t('What else is on at this time?')
            ?></a>
<?php       } ?>
            <a href="search.php?searchstr=<?php echo urlencode($schedule->title) ?>&search_title=1"><?php
                if ($_GET['recordid'])
                    echo t('Find showings of this program');
                else
                    echo t('Find other showings of this program');
            ?></a>
            <a href="program_listing.php?time=<?php echo $_SESSION['list_time'] ?>"><?php
                echo t('Back to the program listing')
            ?></a>
        </div>

    </div>

    </td>
    <td>

    <div id="recording_info" class="command command_border_l command_border_t command_border_b command_border_r clearfix">

        <form name="program_detail" method="post" action="program_detail.php?<?php
            if ($_GET['recordid'])
                echo 'recordid='.urlencode($_GET['recordid']);
            else
                echo 'chanid='.urlencode($_GET['chanid']).'&starttime='.urlencode($_GET['starttime'])
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
                        echo $schedule->type == rectype_once ? ' CHECKED' : ''?> />
                    <a onclick="get_element('record_once').checked=true;"><?php echo t('rectype-long: once') ?></a></li>

<?php       if ($schedule->description != 'Manually scheduled') { ?>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_daily ?>" id="record_daily"<?php
                        echo $schedule->type == rectype_daily ? ' CHECKED' : ''?> />
                    <a onclick="get_element('record_daily').checked=true;"><? echo t('rectype-long: daily') ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_weekly ?>" id="record_weekly"<?php
                        echo $schedule->type == rectype_weekly ? ' CHECKED' : ''?> />
                    <a onclick="get_element('record_weekly').checked=true;"><? echo t('rectype-long: weekly') ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_findone ?>" id="record_findone"<?php
                        echo $schedule->type == rectype_findone ? ' CHECKED' : ''?> />
                    <a onclick="get_element('record_findone').checked=true;"><? echo t('rectype-long: findone') ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_finddaily ?>" id="record_finddaily"<?php
                        echo $schedule->type == rectype_finddaily ? ' CHECKED' : ''?> />
                    <a onclick="get_element('record_finddaily').checked=true;"><? echo t('rectype-long: finddaily') ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_findweekly ?>" id="record_findweekly"<?php
                        echo $schedule->type == rectype_findweekly ? ' CHECKED' : ''?> />
                    <a onclick="get_element('record_findweekly').checked=true;"><? echo t('rectype-long: findweekly') ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_channel ?>" id="record_channel"<?php
                        echo $schedule->type == rectype_channel ? ' CHECKED' : ''?> />
                    <a onclick="get_element('record_channel').checked=true;"><? echo t('rectype-long: channel', prefer_channum ? $channel->channum : $channel->callsign) ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_always ?>" id="record_always"<?php
                        echo $schedule->type == rectype_always ? ' CHECKED' : ''?> />
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
<?      } ?>

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
                <dt><? echo t('Duplicate Check method') ?>:</dt>
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
                <dt><? echo t('Auto-flag commercials') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="autocommflag"<?php if ($schedule->autocommflag) echo ' CHECKED' ?> value="1" /></dd>
                <dt><? echo t('Auto-transcode') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="autotranscode"<?php if ($schedule->autotranscode) echo ' CHECKED' ?> value="1" /></dd>
                <dt><? echo t('Auto-expire recordings') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="autoexpire"<?php if ($schedule->autoexpire) echo ' CHECKED' ?> value="1" /></dd>
                <dt><? echo t('Record new and expire old') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="maxnewest"<?php if ($schedule->maxnewest) echo ' CHECKED' ?> value="1" /></dd>
                <dt><? echo t('Inactive') ?>:</dt>
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
    // Print the main page footer
        parent::print_footer();
    }

}

?>
