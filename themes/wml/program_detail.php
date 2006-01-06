<?php
/***                                                                        ***\
    program_detail.php                       Last Updated: 2004.10.25 (jbuckshin)

    This file defines a theme class for the program details section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_program_detail extends Theme {

    function print_page(&$program, &$schedule, &$channel) {

        parent::print_header("Prog Detail");
        parent::print_menu_content();
        // Print the page contents
?>
<p>
<br />
<a href="channel_detail.php?chanid=<?php echo $channel->chanid ?>" ><?php echo $channel->channum." ".$channel->callsign ?></a><br />
<b><?php echo htmlspecialchars($program->title) ?></b><br />
<a href="#cardmodify" ><?php echo t('Recording Options') ?></a><br />
<?php echo strftime(t('generic_date'), $program->starttime) ?><br />
<?php echo t('$1 to $2', strftime('%r', $program->starttime), strftime('%r', $program->endtime)).' ('.tn('$1 min', '$1 mins', (int)($program->length/60)).')' ?> <br />
<?php
        if ($program->previouslyshown) {
            echo t('Repeat').' ';
        }
        if (strlen($program->subtitle)) {
?>
<?php echo t('Subtitle') ?>: <b><?php echo htmlspecialchars($program->subtitle) ?></b><br />
<?php }
        if (strlen($program->description)) { ?>
<?php echo t('Description') ?>: <?php echo htmlspecialchars(str_replace('$', '', $program->description)) ?><br />
<?php         }
         if (strlen($program->category)) {
            echo t('Category') ?>: <?php echo $program->category ?><br />
<?php         }
        if (strlen($program->airdate)) {
            echo t('Original Airdate') ?>: <?php echo $program->airdate ?><br />
<?php         }
        if (strlen($program->rating)) { ?>
<?php echo strlen($program->rater) > 0 ? "$program->rater " : '' ?><?php echo t('Rating') ?>: <?php echo $program->rating ?><br />
<?php
                ?><br />
<?php     }
?>
</p>
</card>
<card id="cardmodify" title="<?php echo t('Update Recording Settings') ?>">
<?php
    $HREFUrl = "";
    if ($_GET['recordid']) {
        $HREFUrl = 'program_detail.php?recordid='.urlencode($_GET['recordid']);
    } else {
        $HREFUrl = 'program_detail.php?chanid='.urlencode($_GET['chanid']).'&amp;starttime='.urlencode($_GET['starttime']);
    }
?>
<do type="accept">
<go href="<?php echo $HREFUrl ?>" method="post">
<postfield name="save" value="submit"/>
<postfield name="record" value="$(record)"/>
<postfield name="profile" value="$(profile)"/>
<postfield name="recpriority" value="$(recpriority)"/>
<postfield name="maxepisodes" value="$(maxepisodes)"/>
<postfield name="startoffset" value="$(startoffset)"/>
<postfield name="endoffset" value="$(endoffset)"/>
<postfield name="dupmethod" value="$(dupmethod)"/>
<postfield name="autoexpire" value="$(autoexpire)"/>
<postfield name="maxnewest" value="$(maxnewest)"/>
</go>
</do>
<p>
<?php echo t('Recording Options') ?>:
<select name="record" value="<?php echo $schedule->type ?>">
<option value="<?php echo rectype_dontrec ?>" id="<?php echo rectype_dontrec ?>"><?php if (!$schedule->recordid) echo "(*)" ?><?php echo t('rectype: dontrec') ?></option>
<option value="<?php echo rectype_once ?>" id="<?php echo rectype_once ?>"><?php if ($schedule->type == rectype_once) echo "(*)" ?><?php echo t('rectype: once') ?></option>
<option value="<?php echo rectype_daily ?>" id="<?php echo rectype_daily ?>"><?php if ($schedule->type == retype_daily) echo "(*)" ?>Record <?php echo t('rectype: daily') ?></option>
<option value="<?php echo rectype_weekly ?>" id="<?php echo rectype_weekly ?>"><?php if ($schedule->type ==rectype_weekly) echo "(*)" ?>Record <?php echo t('rectype: weekly') ?></option>
<option value="<?php echo rectype_channel ?>" id="<?php echo rectype_channel ?>"><?php if ($schedule->type == rectype_channel) echo "(*)" ?><?php echo t('rectype: channel') ?></option>
<option value="<?php echo rectype_always ?>" id="<?php echo rectype_always ?>"><?php if ($schedule->type == rectype_always) echo "(*)" ?><?php echo t('rectype: always') ?></option>
<option value="<?php echo rectype_findone ?>" id="<?php echo rectype_findone ?>"><?php if ($schedule->type == rectype_findone) echo "(*)" ?><?php echo t('rectype: findone') ?></option>
<option value="<?php echo rectype_finddaily ?>" id="<?php echo rectype_finddaily ?>"><?php if ($schedule->type == rectype_finddaily) echo "(*)" ?><?php echo t('rectype-long: finddaily') ?></option>
<option value="<?php echo rectype_findweekly ?>" id="<?php echo rectype_findweekly ?>"><?php if ($schedule->type == rectype_findweekly) echo "(*)" ?><?php echo t('rectype-long: findweekly') ?></option>
<option value="<?php echo rectype_override ?>" id="<?php echo rectype_override ?>"><?php if ($schedule->type == rectype_override) echo "(*)" ?><?php echo t('rectype: override') ?></option>
</select>
<?php echo t('Recording Profile') ?>:
<select name="profile" value="<?php echo $program->profile ?>">
<?php

    foreach(array('Default', 'Live TV', 'High Quality', 'Low Quality') as $profile) {
        echo '<option value="'.htmlentities($profile).'">';
        echo htmlentities($profile).'</option>';
    }
?>
</select>
<?php echo t('Recording Priority') ?>: <input name="recpriority" type="text" value="<?php echo $program->recpriority ?>" format="N*" size="2"/>
<br />
<?php echo t('No. of recordings to keep') ?>:<input type="text" name="maxepisodes" emptyok="true" size="1" format="N" value="<?php echo htmlentities($program->maxepisodes) ?>"/>
<br />
<?php echo t('Start Early') ?>:<input type="text" name="startoffset" emptyok="true" size="2" format="NN" value="<?php echo htmlentities($program->startoffset) ?>"/>
<br />
<?php echo t('End Late') ?>:<input type="text" name="endoffset" emptyok="true" size="2" format="NN" value="<?php echo htmlentities($program->endoffset) ?>"/>
<br />
<?php echo t('Duplicate Check method') ?>
<?php
if ($program->dupmethod == 0 || $program->dupmethod == 6)
    $local_dupmethod = 6;
else
    $local_dupmethod = $program->dupmethod;
?>
<select name="dupmethod" value="<?php $local_dupmethod ?>">
<option value="1"><?php echo t('None') ?></option>
<option value="2"><?php echo t('Subtitle') ?></option>
<option value="4"><?php echo t('Description') ?></option>
<option value="6"><?php echo t('Subtitle and Description') ?></option>
</select>
<select name="autoexpire" multiple="true" value="<?php if ($program->autoexpire) echo "checked" ?>">
<option value="checked" id="o2"><?php echo t('Auto-expire recordings') ?></option>
</select>
<select name="maxnewest" multiple="true" value="<?php if ($program->maxnewest) echo "checked" ?>">
<option value="checked"><?php echo t('Record new and expire old') ?></option>
</select>
</p></card>
<?php
    // Print the main page footer
    parent::print_footer();
    }
}

