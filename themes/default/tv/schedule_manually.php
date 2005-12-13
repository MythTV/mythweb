<?php
/**
 * Schedule a custom recording by manually specifying starttime and length
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
    $page_title = 'MythWeb - '.t('Schedule Manually');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_schedule_manually.css" />';

// Print the page header
    require_once theme_dir.'/header.php';

// Print the page contents
?>

    <div id="recording_info" class="command command_border_l command_border_t command_border_b command_border_r clearfix">

        <form name="schedule_manually" method="post" action="schedule_manually.php<?php if ($schedule->recordid) echo '?recordid='.urlencode($schedule->recordid) ?>">

<?php   if ($schedule->type != rectype_override && $schedule->type != rectype_dontrec) { ?>
        <div id="schedule_options">
            <h3><?php echo t('Schedule Options') ?>:</h3>

            <ul>
<?php       if ($schedule->recordid) { ?>
                <li><input type="radio" class="radio" name="record" value="0" id="record_never"<?php
                        if (!$schedule->recordid) echo ' CHECKED' ?> />
                    <a onclick="get_element('record_never').checked=true;"><?php
                            echo t('Cancel this schedule.');
                        ?></a></li>

<?php       } ?>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_once ?>" id="record_once"<?php
                        echo $schedule->type == rectype_once ? ' CHECKED' : '' ?> />
                    <a onclick="get_element('record_once').checked=true;"><?php echo t('rectype-long: once') ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_daily ?>" id="record_daily"<?php
                        echo $schedule->type == rectype_daily ? ' CHECKED' : '' ?> />
                    <a onclick="get_element('record_daily').checked=true;"><?php echo t('rectype-long: daily') ?></a></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_weekly ?>" id="record_weekly"<?php
                        echo $schedule->type == rectype_weekly ? ' CHECKED' : '' ?> />
                    <a onclick="get_element('record_weekly').checked=true;"><?php echo t('rectype-long: weekly') ?></a></li>
            </ul>
        </div>
<?php
        }
        if ($schedule->recordid) {
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

        <div id="recording_options">
            <h3><?php echo t('Recording Options') ?>:</h3>

            <dl>
                <dt><?php echo t('Channel') ?>:&nbsp;</dt>
                <dd><?php channel_select($schedule->chanid) ?></dd>
                <dt><?php echo t('Start Date') ?>:&nbsp;</dt>
                <dd><input type="text" name="startdate" size="10" maxlength="10" value="<?php echo date("Y-m-d", $schedule->starttime) ?>"></dd>
                <dt><?php echo t('Start Time') ?>:&nbsp;</dt>
                <dd><input type="text" name="starttime" size="10" maxlength="8" value="<?php echo date("H:i:00", $schedule->starttime) ?>"></dd>
                <dt><?php echo t('Length (min)') ?>:&nbsp;</dt>
                <dd><input type="text" name="length" value="<?php echo $schedule->length ?>" size="10" maxlength="4"></dd>
                <dt><?php echo t('Title') ?>:&nbsp;</dt>
                <dd><input type="text" name="title" value="<?php echo $schedule->title ?>" size="30"></dd>
                <dt><?php echo t('Subtitle') ?>:&nbsp;</dt>
                <dd><input type="text" name="subtitle" value="<?php echo $schedule->subtitle ?>" size="30"></dd>
            </dl>

        </div>

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
                <input type="submit" class="submit" name="save" value="<?php echo $schedule->recordid ? t('Save Schedule') : t('Create Schedule') ?>">
            </p>

        </div>

        </form>

    </div>

<?php

// Print the page footer
    require_once theme_dir.'/footer.php';

