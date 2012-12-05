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
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_schedule.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Create the help Popups
    global $Categories;
//    Search Type Help
    if (!empty($Categories)) {

        $SearchTypeTitle = t('Search Type Help');
        $TitleSearchTitle = t('Title Search:');
        $TitleSearch = t('Search all program titles containing the Title text below');
        $KeywordSearchTitle = t('Keyword Search:');
        $KeywordSearch = t('Search all program keywords for a match against search phrase below');
        $PeopleSearchTitle = t('People Search:');
        $PeopleSearch = t('Search for all actors contained in a recording for a match against search phrase below');
        $PowerSearchTitle = t('Power Search:');
        $PowerSearch = t('Search will perform complex SQL queries against the database as per the search phrase below');

        $SearchTypeHelp = <<<EOF
<table width=\"400\" style=\"background-color: #003060;\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
<tr>
    <td><table width=\"400\" style=\"background-color: #003060;\" class=\"small\" cellpadding=\"5\" cellspacing=\"5\">
        <tr>
            <h3>$SearchTypeTitle</h3>
            <b>$TitleSearchTitle</b> <br>$TitleSearch<br>
            <b>$KeywordSearchTitle</b> <br>$KeywordSearch<br>
            <b>$PeopleSearchTitle</b> <br>$PeopleSearch<br>
            <b>$PowerSearchTitle</b> <br>$PowerSearch
        </tr>
    </td>
</tr>
</table>
EOF;
}

//    Recording Options Help

    if (!empty($Categories)) {

        $RecordingOptionsTitle = t('Recording Options Help');
        $TitleSearchTitle = t('Title:');
        $TitleSearch = t('Searches will be performed against the title of all TV shows');
        $SearchPhraseTitle = t('Search Phrase:');
        $SearchPhrase = t('Depending on the Search type this is where you enter actual main search commands');
        $AdditionalTablesTitle = t('Additional tables:');
        $AdditionalTables = t('Allows you to search through other database tables when using a power search');
        $CommandsTitle = t('Commands:');
        $Commands1 = t('Allows you to match any string of any length (including zero length)');
        $Commands2 = t('Allows you to match on a single character');

        $MoreInfo = t('For more information on the Power Search please go to:');

        $RecordingOptionsHelp = <<<EOF
<table width="400" style="background-color: #003060;" border="1" cellpadding="0" cellspacing="0">
<tr>
    <td><table width="400" style="background-color: #003060;" class="small" cellpadding="5" cellspacing="5">
        <tr>
            <h3>$RecordingOptionsTitle</h3>
            <b>$TitleSearchTitle</b> <br>$TitleSearch<br>
            <b>$SearchPhraseTitle</b> <br>$SearchPhrase<br>
            <b>$AdditionalTablesTitle</b> <br>$AdditionalTables<br>
            <b>$CommandsTitle</b>
            <ul>
                <li><b>%: </b>$Commands1</li>
                <li><b>_: </b>$Commands2</li>
            </ul>

            $MoreInfo
            http://www.mythtv.org/wiki/Custom_Recording
        </tr>
    </td>
</tr>
</table>
EOF;
}

// Print the page contents
?>

<script type="text/javascript">
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

    <div id="schedule">

        <form name="custom_schedule" method="post" action="<?php echo root_url ?>tv/schedules/custom<?php if ($schedule->recordid) echo '/'.urlencode($schedule->recordid) ?>">

        <div class="x-options">
            <h3><?php echo t('Schedule Options') ?>:</h3>

            <ul>
<?php       if ($schedule->recordid) { ?>
                <li><input type="radio" class="radio" name="record" value="0" id="record_never">
                    <label for="record_never"><?php echo t('Cancel this schedule.') ?></label></li>
<?php       } ?>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_always ?>" id="record_always"<?php
                        if ($schedule->type == rectype_always) echo ' CHECKED' ?>>
                    <label for="record_always"><?php echo t('rectype-long: always') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_daily ?>" id="rectype_daily"<?php
                        if ($schedule->type == rectype_daily) echo ' CHECKED' ?>>
                    <label for="rectype_daily"><?php echo t('rectype-long: finddaily') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_weekly ?>" id="rectype_weekly"<?php
                        if($schedule->type == rectype_weekly) echo ' CHECKED' ?>>
                    <label for="rectype_weekly"><?php echo t('rectype-long: findweekly') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_findone ?>" id="rectype_findone"<?php
                        if ($schedule->type == rectype_findone) echo ' CHECKED' ?>>
                    <label for="rectype_findone"><?php echo t('rectype-long: findone') ?></label></li>
            </ul>
        </div>

        <div class="x-options">
            <h3><a <?php echo show_popup('SearchTypeHelp',$SearchTypeHelp) ?>><?php echo t('Search Type') ?>:</a></h3>

            <ul>
                <li><input type="radio" class="radio" name="searchtype" value="<?php echo searchtype_title ?>" id="searchtype_title"<?php
                        if (empty($schedule->search) || $schedule->search == searchtype_title) echo ' CHECKED'
                        ?> onclick="toggle_options()">
                    <label for="searchtype_title"><?php echo t('Title Search') ?></label></li>
                <li><input type="radio" class="radio" name="searchtype" value="<?php echo searchtype_keyword ?>" id="searchtype_keyword"<?php
                        if ($schedule->search == searchtype_keyword) echo ' CHECKED'
                        ?> onclick="toggle_options()">
                    <label for="searchtype_keyword"><?php echo t('Keyword Search') ?></label></li>
                <li><input type="radio" class="radio" name="searchtype" value="<?php echo searchtype_people ?>" id="searchtype_people"<?php
                        if ($schedule->search == searchtype_people) echo ' CHECKED'
                        ?> onclick="toggle_options()">
                    <label for="searchtype_people"><?php echo t('People Search') ?></label></li>
                <li><input type="radio" class="radio" name="searchtype" value="<?php echo searchtype_power ?>" id="searchtype_power"<?php
                        if ($schedule->search == searchtype_power) echo ' CHECKED'
                        ?> onclick="toggle_options()">
                    <label for="searchtype_power"><?php echo t('Power Search') ?></label></li>
            </ul>

        </div>

        <div class="x-options">
            <h3><a <?php echo show_popup('RecordingOptionsHelp',$RecordingOptionsHelp) ?>><?php echo t('Recording Options') ?>:</a></h3>

            <dl id="title_options" class="x-long">
                <dt><?php echo t('Title') ?>:&nbsp;</dt>
                <dd><input type="text" name="title" value="<?php echo html_entities($schedule->edit_title) ?>" size="24">
                    (<span id="search_type"><?php echo t('$1 Search', $schedule->search_type) ?></span>)</dd>
            </dl>
            <dl id="standard_options" class="x-long<?php if ($schedule->search == searchtype_power) echo ' hidden' ?>">
                <dt><?php echo t('Search Phrase') ?>:&nbsp;</dt>
                <dd><input type="text" name="search_phrase" value="<?php echo html_entities($schedule->description) ?>" size="30"></dd>
            </dl>
            <dl id="power_options" class="x-long" <?php if ($schedule->search != searchtype_power) echo ' style="display: none;"'; ?>>
                <dt><?php echo t('Additional Tables') ?>:&nbsp;</dt>
                <dd><input type="text" name="additional_tables" value="<?php echo html_entities($schedule->subtitle) ?>" size="30"></dd>


                <dt><?php echo t('Search Phrase') ?>:&nbsp;</dt>
                <dd><textarea name="search_sql" rows="10" cols="48"><?php echo html_entities($schedule->description) ?></textarea></dd>

                <dd>
                <SELECT style="width: 335px;"name="sqlcommands">
                    <OPTION value="cardinput.cardinputid = 1"><?php echo t('Modify priority for an input (Input priority)') ?>
                    <OPTION value="cardinput.cardid = 2"><?php echo t('Modify priority for all inputs on a card') ?>
                    <OPTION value="capturecard.hostname = 'mythbox'"><?php echo t('Modify priority for every card on a host') ?>
                    <OPTION value="channel.chanid = '1003'"><?php echo t('Only one specific channel ID (Channel priority)') ?>
                    <OPTION value="channel.channum = '3'"><?php echo t('Only a certain channel number') ?>
                    <OPTION value="channel.callsign = 'ESPN'"><?php echo t('Only channels that carry a specific station') ?>
                    <OPTION value="channel.callsign LIKE 'HBO%'"><?php echo t('Match related callsigns') ?>
                    <OPTION value="channel.commmethod = %1"><?php echo t('Only channels marked as commercial free') ?>
                    <OPTION value="channel.callsign = 'ESPN' AND cardinput.cardinputid = 2"><?php echo t('Modify priority for a station on an input') ?>
                    <OPTION value="program.title LIKE 'CSI: %'"><?php echo t('Priority for all matching titles') ?>
                    <OPTION SELECTED value="program.hdtv > 0"><?php echo t('Only shows marked as HDTV') ?>
                    <OPTION value="program.closecaptioned > 0"><?php echo t('Close Captioned priority') ?>
                    <OPTION value="program.previouslyshown = 0"><?php echo t('New episodes only') ?>
                    <OPTION value="program.generic = 0"><?php echo t('Modify unidentified episodes') ?>
                    <OPTION value="program.first > 0"><?php echo t('First showing of each episode') ?>
                    <OPTION value="program.last > 0"><?php echo t('Last showing of each episode') ?>
                    <OPTION value="RECTABLE.endoffset > 0"><?php echo t('Priority for any show with End Late time') ?>
                    <OPTION value="program.category = 'Reality'"><?php echo t('Priority for a category') ?>
                    <OPTION value="program.category_type = 'sports'"><?php echo t('Priority for a category type') ?>
                    <OPTION value="program.stars >= 0.75"><?php echo t('Modify priority by star rating (0.0 to 1.0 for movies only)') ?>
                    <OPTION value="program.first > 0 AND program.last > 0"><?php echo t('Priority when shown once') ?>
                    <OPTION value="RECTABLE.storagegroup = 'Archive' AND capturecard.hostname = 'mythbox'"><?php echo t('Prefer a host for a storage group') ?>
                    <OPTION value="program.hdtv > 0 AND program.starttime > DATE_SUB(program.endtime, INTERVAL 2 HOUR)"><?php echo t('Priority for HD shows under two hours') ?>
                    <OPTION value="program.category_type = 'movie' AND program.airdate >= 2006"><?php echo t('Priority for movies by the year of release') ?>
                    <OPTION value="program.category_type = 'movie' AND HOUR(program.starttime) < 6"><?php echo t('Prefer movies when shown at night') ?>
                    <OPTION value="RECTABLE.endoffset > 0 AND program.category = 'Sports event' AND capturecard.hostname = 'mythbox'"><?php echo t('Prefer a host for live sports with overtime') ?>
                    <OPTION value="cardinput.cardinputid = 1 AND channel.channum IN (3, 5, 39, 66)"><?php echo t('Avoid poor signal quality') ?>
                </SELECT>

                <script language="Javascript">
                <!--
                function checkName(displayObj) {
                    if ( displayObj.value.length < 1 ) {
                        SQLquery = document.custom_schedule.sqlcommands.options[document.custom_schedule.sqlcommands.selectedIndex].value;
                        displayObj.value= SQLquery;
                        document.custom_schedule.sqlcommands.options.remove[document.custom_schedule.sqlcommands.selectedIndex]
                    }
                    else {
                        SQLquery = document.custom_schedule.sqlcommands.options[document.custom_schedule.sqlcommands.selectedIndex].value;
                        displayObj.value= displayObj.value + " AND " + SQLquery; 
                    }
                }

                // -->
                </script>
                <input type="button" style="width: 50px;"size="5" value="<?php echo t('Add') ?>" OnClick="checkName(search_sql);">
                </dd>
            </dl>

        </div>

        <div class="x-options">
            <h3><?php echo t('Find Date & Time Options') ?>:</h3>
            <dl class="clearfix">
               <dt><?php echo t('Find Day') ?>:</dt>
               <dd><?php day_select($schedule->findday) ?></dd>
               <dt><?php echo t('Find Time') ?>:</dt>
               <dd><input type="text" name="findtime" value="<?php echo html_entities($schedule->findtime) ?>" /></dd>
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
