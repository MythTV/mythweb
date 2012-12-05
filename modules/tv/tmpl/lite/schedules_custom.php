<?php
/**
 * Schedule a custom recording by manually specifying various search options
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Custom Schedule');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_schedules_custom.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Print the page contents
?>

<script language="JavaScript" type="text/javascript">
<!--

// Swaps visibility of the standard/power options lists
    function toggle_options() {
        if ($('searchtype_power').checked) {
            $('standard_options').hide();
            $('power_options').show();
        }
        else {
            $('power_options').hide();
            $('standard_options').show();
        }
    // Get the search type
        if ($('searchtype_title').checked)
            $('search_type').innerHTML = '<?php echo str_replace("'", "\\'", t('$1 Search', t('Title'))) ?>';
        else if ($('searchtype_keyword').checked)
            $('search_type').innerHTML = '<?php echo str_replace("'", "\\'", t('$1 Search', t('Keyword'))) ?>';
        else if ($('searchtype_people').checked)
            $('search_type').innerHTML = '<?php echo str_replace("'", "\\'", t('$1 Search', t('People'))) ?>';
        else if ($('searchtype_power').checked)
            $('search_type').innerHTML = '<?php echo str_replace("'", "\\'", t('$1 Search', t('Power'))) ?>';
    }

// -->
</script>

    <div id="recording_info" class="command command_border_l command_border_t command_border_b command_border_r clearfix">

        <form name="custom_schedule" method="post" action="<?php echo root_url ?>tv/schedules/custom<?php if ($schedule->recordid) echo '/'.urlencode($schedule->recordid) ?>">

        <div id="schedule_options">
            <h3><?php echo t('Schedule Options') ?>:</h3>

            <ul>
<?php       if ($schedule->recordid) { ?>
                <li><input type="radio" class="radio" name="record" value="0" id="record_never" />
                    <label for="record_never"><?php echo t('Cancel this schedule.') ?></label></li>
<?php       } ?>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_always ?>" id="record_always"<?php
                        if ($schedule->type == rectype_always) echo ' CHECKED' ?> />
                    <label for="record_always"><?php echo t('rectype-long: always') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_daily ?>" id="rectype_daily"<?php
                        if ($schedule->type == rectype_daily) echo ' CHECKED' ?> />
                    <label for="rectype_daily"><?php echo t('rectype-long: finddaily') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_weekly ?>" id="rectype_weekly"<?php
                        if($schedule->type == rectype_weekly) echo ' CHECKED' ?> />
                    <label for="rectype_weekly"><?php echo t('rectype-long: findweekly') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_findone ?>" id="rectype_findone"<?php
                        if ($schedule->type == rectype_findone) echo ' CHECKED' ?> />
                    <label for="rectype_findone"><?php echo t('rectype-long: findone') ?></label></li>
            </ul>
        </div>

        <div id="searchtype_options">
            <h3><?php echo t('Search Type') ?>:</h3>

            <ul>
                <li><input type="radio" class="radio" name="searchtype" value="<?php echo searchtype_title ?>" id="searchtype_title"<?php
                        if (empty($schedule->search) || $schedule->search == searchtype_title) echo ' CHECKED'
                        ?> onclick="toggle_options()" />
                    <label for="searchtype_title"><?php echo t('Title Search') ?></label></li>
                <li><input type="radio" class="radio" name="searchtype" value="<?php echo searchtype_keyword ?>" id="searchtype_keyword"<?php
                        if ($schedule->search == searchtype_keyword) echo ' CHECKED'
                        ?> onclick="toggle_options()" />
                    <label for="searchtype_keyword"><?php echo t('Keyword Search') ?></label></li>
                <li><input type="radio" class="radio" name="searchtype" value="<?php echo searchtype_people ?>" id="searchtype_people"<?php
                        if ($schedule->search == searchtype_people) echo ' CHECKED'
                        ?> onclick="toggle_options()" />
                    <label for="searchtype_people"><?php echo t('People Search') ?></label></li>
                <li><input type="radio" class="radio" name="searchtype" value="<?php echo searchtype_power ?>" id="searchtype_power"<?php
                        if ($schedule->search == searchtype_power) echo ' CHECKED'
                        ?> onclick="toggle_options()" />
                    <label for="searchtype_power"><?php echo t('Power Search') ?></label></li>
            </ul>

        </div>

        <div id="recording_options">
            <h3><?php echo t('Recording Options') ?>:</h3>

            <dl id="title_options">
                <dt><?php echo t('Title') ?>:&nbsp;</dt>
                <dd><input type="text" name="title" value="<?php echo html_entities($schedule->edit_title) ?>" size="24">
                    (<span id="search_type"><?php echo t('$1 Search', $schedule->search_type) ?></span>)</dd>
            </dl>
            <dl id="standard_options"<?php if ($schedule->search == searchtype_power) echo ' class="hidden"' ?>>
                <dt><?php echo t('Search Phrase') ?>:&nbsp;</dt>
                <dd><input type="text" name="search_phrase" value="<?php echo html_entities($schedule->description) ?>" size="30"></dd>
            </dl>

            <dl id="power_options"<?php if ($schedule->search != searchtype_power) echo ' class="hidden"' ?>>
                <dt><?php echo t('Additional Tables') ?>:&nbsp;</dt>
                <dd><input type="text" name="additional_tables" value="<?php echo html_entities($schedule->subtitle) ?>" size="30"></dd>
                <dt><?php echo t('Search Phrase') ?>:&nbsp;</dt>
                <dd><textarea name="search_sql" rows="10" cols="48"><?php echo html_entities($schedule->description) ?></textarea>
                    <?php /** @todo would be cool to have sample stuff just like the frontend does */ ?>
                    </dd>
            </dl>

        </div>

        <div id="find_date_options">
            <h3><?php echo t('Find Date & Time Options') ?>:</h3>
            <dl class="clearfix">
               <dt><?php echo t('Find Day') ?>:</dt>
               <dd><?php day_select($schedule->findday) ?></dd>
               <dt><?php echo t('Find Time') ?>:</dt>
               <dd><input type="text" name="findtime" value="<?php echo html_entities($schedule->findtime) ?>" /></dd>
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
                <dt><?php echo t('Look up Metadata') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="autometadata"<?php if ($schedule->autometadata) echo ' CHECKED' ?> value="1" /></dd>
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
                <dt><?php echo t('Inactive') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="inactive"<?php if ($schedule->inactive) echo ' CHECKED' ?> value="1" /></dd>
                <dt><?php echo t('Auto-expire recordings') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="autoexpire"<?php if ($schedule->autoexpire) echo ' CHECKED' ?> value="1" /></dd>
                <dt><?php echo t('Record new and expire old') ?>:</dt>
                <dd><input type="checkbox" class="radio" name="maxnewest"<?php if ($schedule->maxnewest) echo ' CHECKED' ?> value="1" /></dd>
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
                <input type="submit" class="submit" name="save" value="<?php echo $schedule->recordid ? t('Save Schedule') : t('Create Schedule') ?>">
            </p>

        </div>

        </form>

    </div>

<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
