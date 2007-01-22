<?php
/**
 * Schedule a custom recording by manually specifying various search options
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
    $page_title = 'MythWeb - '.t('Custom Schedule');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_schedule.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Print the page contents
?>

<script language="JavaScript" type="text/javascript">
<!--

// Swaps visibility of the standard/power options lists
    function toggle_options() {
        if (get_element('searchtype_power').checked) {
            get_element('standard_options').style.visibility = 'hidden';
            get_element('standard_options').style.display    = 'none';
            get_element('power_options').style.visibility    = 'visible';
            get_element('power_options').style.display       = 'block';
        }
        else {
            get_element('power_options').style.visibility    = 'hidden';
            get_element('power_options').style.display       = 'none';
            get_element('standard_options').style.visibility = 'visible';
            get_element('standard_options').style.display    = 'block';
        }
    // Get the search type
        if (get_element('searchtype_title').checked)
            get_element('search_type').innerHTML = '<?php echo str_replace("'", "\\'", t('$1 Search', t('Title'))) ?>';
        else if (get_element('searchtype_keyword').checked)
            get_element('search_type').innerHTML = '<?php echo str_replace("'", "\\'", t('$1 Search', t('Keyword'))) ?>';
        else if (get_element('searchtype_people').checked)
            get_element('search_type').innerHTML = '<?php echo str_replace("'", "\\'", t('$1 Search', t('People'))) ?>';
        else if (get_element('searchtype_power').checked)
            get_element('search_type').innerHTML = '<?php echo str_replace("'", "\\'", t('$1 Search', t('Power'))) ?>';
    }

// -->
</script>

    <div id="schedule">

        <form name="custom_schedule" method="post" action="<?php echo root ?>tv/schedules/custom<?php if ($schedule->recordid) echo '/'.urlencode($schedule->recordid) ?>">

        <div class="_options">
            <h3><?php echo t('Schedule Options') ?>:</h3>

            <ul>
<?php       if ($schedule->recordid) { ?>
                <li><input type="radio" class="radio" name="record" value="0" id="record_never" />
                    <label for="record_never"><?php echo t('Cancel this schedule.') ?></label></li>
<?php       } ?>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_always ?>" id="record_always"<?php
                        if ($schedule->type == rectype_always) echo ' CHECKED' ?> />
                    <label for="record_always"><?php echo t('rectype-long: always') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_finddaily ?>" id="rectype_finddaily"<?php
                        if ($schedule->type == rectype_finddaily) echo ' CHECKED' ?> />
                    <label for="rectype_finddaily"><?php echo t('rectype-long: finddaily') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_findweekly ?>" id="rectype_findweekly"<?php
                        if($schedule->type == rectype_findweekly) echo ' CHECKED' ?> />
                    <label for="rectype_findweekly"><?php echo t('rectype-long: findweekly') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_findone ?>" id="rectype_findone"<?php
                        if ($schedule->type == rectype_findone) echo ' CHECKED' ?> />
                    <label for="rectype_findone"><?php echo t('rectype-long: findone') ?></label></li>
            </ul>
        </div>

        <div class="_options">
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

        <div class="_options">
            <h3><?php echo t('Recording Options') ?>:</h3>

            <dl id="title_options" class="_long">
                <dt><?php echo t('Title') ?>:&nbsp;</dt>
                <dd><input type="text" name="title" value="<?php echo html_entities($schedule->edit_title) ?>" size="24">
                    (<span id="search_type"><?php echo t('$1 Search', $schedule->search_type) ?></span>)</dd>
            </dl>
            <dl id="standard_options" class="_long<?php if ($schedule->search == searchtype_power) echo ' hidden' ?>">
                <dt><?php echo t('Search Phrase') ?>:&nbsp;</dt>
                <dd><input type="text" name="search_phrase" value="<?php echo html_entities($schedule->description) ?>" size="30"></dd>
            </dl>
            <dl id="power_options" class="_long<?php if ($schedule->search != searchtype_power) echo ' hidden' ?>">
                <dt><?php echo t('Additional Tables') ?>:&nbsp;</dt>
                <dd><input type="text" name="additional_tables" value="<?php echo html_entities($schedule->subtitle) ?>" size="30"></dd>
                <dt><?php echo t('Search Phrase') ?>:&nbsp;</dt>
                <dd><textarea name="search_sql" autorows="10" cols="48"><?php echo html_entities($schedule->description) ?></textarea>
                    <?php /** @todo would be cool to have sample stuff just like the frontend does */ ?>
                    </dd>
            </dl>

        </div>

        <div class="_options">
            <h3><?php echo t('Find Date & Time Options') ?>:</h3>
            <dl class="clearfix">
               <dt><?php echo t('Find Day') ?>:</dt>
               <dd><?php day_select($schedule->findday) ?></dd>
               <dt><?php echo t('Find Time') ?>:</dt>
               <dd><input type="text" name="findtime" value="<?php echo htmlentities($schedule->findtime) ?>" /></dd>
            </dl>
        </div>

        <div class="_options">
<?php    require_once tmpl_dir.'_advanced_options.php' ?>
        </div>

        <div id="_schedule_submit">
            <input type="submit" class="submit" name="save" value="<?php echo $schedule->recordid ? t('Save Schedule') : t('Create Schedule') ?>">
        </div>

        </form>

    </div>

<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';

