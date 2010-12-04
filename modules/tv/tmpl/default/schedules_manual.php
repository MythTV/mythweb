<?php
/**
 * Schedule a custom recording by manually specifying starttime and length
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Schedule Manually');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_schedule.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Print the page contents
?>

    <div id="schedule">

        <form name="schedule_manually" method="post" action="<?php echo root_url ?>tv/schedules/manual<?php if ($schedule->recordid) echo '/'.urlencode($schedule->recordid) ?>">

<?php   if ($schedule->type != rectype_override && $schedule->type != rectype_dontrec) { ?>
        <div class="x-options">
            <h3><?php echo t('Schedule Options') ?>:</h3>

            <ul>
<?php       if ($schedule->recordid) { ?>
                <li><input type="radio" class="radio" name="record" value="0" id="record_never">
                    <label for="record_never"><?php echo t('Cancel this schedule.') ?></label></li>
<?php       } ?>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_once ?>" id="record_once"<?php
                        echo $schedule->type == rectype_once ? ' CHECKED' : '' ?>>
                    <label for="record_once"><?php echo t('rectype-long: once') ?></label></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_daily ?>" id="record_daily"<?php
                        echo $schedule->type == rectype_daily ? ' CHECKED' : '' ?>>
                    <label for="record_daily"><?php echo t('rectype-long: daily') ?></label></li>

                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_weekly ?>" id="record_weekly"<?php
                        echo $schedule->type == rectype_weekly ? ' CHECKED' : '' ?>>
                    <label for="record_weekly"><?php echo t('rectype-long: weekly') ?></label></li>
            </ul>
        </div>
<?php
        }
        if ($schedule->recordid) {
?>
        <div class="x-options">
            <h3><?php echo t('Schedule Override') ?>:</h3>

            <ul>
<?php       if ($schedule->type == rectype_override || $schedule->type == rectype_dontrec) { ?>
                <li><input type="radio" class="radio" name="record" value="0" id="schedule_default"<?php
                        if ($schedule->type != rectype_override && $schedule->type != rectype_dontrec) echo ' CHECKED' ?>>
                    <label for="schedule_default"><?php echo t('Schedule normally.') ?></label></li>
<?php       } ?>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_override ?>" id="record_override"<?php
                        if ($schedule->type == rectype_override) echo ' CHECKED' ?>>
                    <label for="record_override"><?php echo t('rectype-long: override') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_dontrec ?>" id="record_dontrec"<?php
                        if ($schedule->type == rectype_dontrec) echo ' CHECKED' ?>>
                    <label for="record_dontrec"><?php echo t('rectype-long: dontrec') ?></label></li>
            </ul>
        </div>
<?php      } ?>

        <div class="x-options">
            <h3><?php echo t('Recording Options') ?>:</h3>

            <dl>
                <dt><?php echo t('Channel') ?>:&nbsp;</dt>
                <dd><?php channel_select($schedule->chanid) ?></dd>
                <dt><?php echo t('Start Date') ?>:&nbsp;</dt>
                <dd><input type="text" name="startdate" size="10" maxlength="10" value="<?php echo date("Y-m-d", $schedule->starttime) ?>"><br /><?php echo t('For daily recordings, 5 weekdays if a weekday, or 7 days per week if a weekend day.') ?></dd>
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

        <div class="x-options">
<?php    require_once tmpl_dir.'_advanced_options.php' ?>
        </div>

        <div id="schedule_submit">
            <input type="submit" class="submit" name="save" value="<?php echo $schedule->recordid ? t('Save Schedule') : t('Create Schedule') ?>">
        </div>

        </form>

    </div>

<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
