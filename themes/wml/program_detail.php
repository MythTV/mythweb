<?php
/***                                                                        ***\
    program_detail.php                       Last Updated: 2004.10.25 (jbuckshin)

    This file defines a theme class for the program details section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_program_detail extends Theme {

    function print_page() {

        global $this_channel, $this_program;
        // Print the main page header

        parent::print_header("Prog Detail");
        parent::print_menu_content();
        // Print the page contents
?>
<p>
<br/>
<a href="channel_detail.php?chanid=<?php echo $this_channel->chanid?>" ><?php echo $this_channel->channum." ".$this_channel->callsign; ?></a><br/>
<b><?php echo htmlspecialchars($this_program->title)?></b><br/>
<a href="#cardmodify" ><?php echo t('Recording Options') ?></a><br/>
<?php echo strftime(t('generic_date'), $this_program->starttime)?><br/>
<?php echo t('$1 to $2', strftime('%r', $this_program->starttime), strftime('%r', $this_program->endtime)).' ('.tn('$1 min', '$1 mins', (int)($this_program->length/60)).')' ?> <br/>
<?php
        if ($this_program->previouslyshown) {
            echo t('Rerun').' ';
        }
        if (strlen($this_program->subtitle)) { 
?>
<?php echo t('Subtitle') ?>: <b><?php echo htmlspecialchars($this_program->subtitle)?></b><br/>
<?php }
        if (strlen($this_program->description)) {?>
<?php echo t('Description') ?>: <?php echo htmlspecialchars(str_replace('$', '', $this_program->description))?><br/>
<?php         }
         if (strlen($this_program->category)) {
            echo t('Category') ?>: <?php echo $this_program->category?><br/>
<?php         }
        if (strlen($this_program->airdate)) {
            echo t('Original Airdate') ?>: <?php echo $this_program->airdate?><br/>
<?php         }
        if (strlen($this_program->rating)) {?>
<?php echo strlen($this_program->rater) > 0 ? "$this_program->rater " : ''?><?php echo t('Rating') ?>: <?php echo $this_program->rating?><br/>
<?php
                ?><br/>
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
<?php
    $record_opt="";
    if (! $this_program->will_record) $record_opt="never";
    if ($this_program->record_once) $record_opt="once";
    if ($this_program->record_daily) $record_opt="daily";
    if ($this_program->record_weekly) $record_opt="weekly";
    if ($this_program->record_channel) $record_opt="channel";
    if ($this_program->record_always) $record_opt="always";
    if ($this_program->record_findone) $record_opt="findone";

?>
<select name="record" value="<?php echo $record_opt ?>">
<option value="never" id="record_never"><?php if ($record_opt=="never") echo "(*)"; ?><?php echo t('rectype: dontrec') ?></option>
<option value="once" id="record_once"><?php if ($record_opt=="once") echo "(*)"; ?><?php echo t('rectype: once') ?></option>
<option value="daily" id="record_daily"><?php if ($record_opt=="daily") echo "(*)"; ?>Record <?php echo t('rectype: daily') ?></option>
<option value="weekly" id="record_weekly"><?php if ($record_opt=="weekly") echo "(*)"; ?>Record <?php echo t('rectype: weekly') ?></option>
<option value="channel" id="record_channel"><?php if ($record_opt=="channel") echo "(*)"; ?><?php echo t('rectype: channel') ?></option>
<option value="always" id="record_always"><?php if ($record_opt=="always") echo "(*)"; ?><?php echo t('rectype: always') ?></option>
<option value="findone" id="record_findone"><?php if ($record_opt=="findone") echo "(*)"; ?><?php echo t('rectype: findone') ?></option>
</select>
<?php echo t('Recording Profile') ?>:
<select name="profile" value="<?php echo $this_program->profile ?>">
<?php

    global $Profiles;
    foreach($Profiles as $profile) {
        echo '<option value="'.htmlentities($profile).'">';
        echo htmlentities($profile).'</option>';
    }
?>
</select>
<?php echo t('Recording Priority') ?>: <input name="recpriority" type="text" value="<?php echo $this_program->recpriority ?>" format="N*" size="2"/>
<br/>
<?php echo t('No. of recordings to keep') ?>:<input type="text" name="maxepisodes" emptyok="true" size="1" format="N" value="<?php echo htmlentities($this_program->maxepisodes) ?>"/>
<br/>
<?php echo t('Start Early') ?>:<input type="text" name="startoffset" emptyok="true" size="2" format="NN" value="<?php echo htmlentities($this_program->startoffset) ?>"/>
<br/>
<?php echo t('End Late') ?>:<input type="text" name="endoffset" emptyok="true" size="2" format="NN" value="<?php echo htmlentities($this_program->endoffset) ?>"/>
<br/>
<?php echo t('Duplicate Check method') ?>
<?php 
if ($this_program->dupmethod == 0 || $this_program->dupmethod == 6)
    $local_dupmethod = 6;
else
    $local_dupmethod = $this_program->dupmethod;
?>
<select name="dupmethod" value="<?php $local_dupmethod ?>">
<option value="1"><?php echo t('None') ?></option>
<option value="2"><?php echo t('Subtitle') ?></option>
<option value="4"><?php echo t('Description') ?></option>
<option value="6"><?php echo t('Subtitle and Description') ?></option>
</select>
<select name="autoexpire" multiple="true" value="<?php if ($this_program->autoexpire) echo "checked" ?>">
<option value="checked" id="o2"><?php echo t('Auto-expire recordings') ?></option>
</select>
<select name="maxnewest" multiple="true" value="<?php if ($this_program->maxnewest) echo "checked" ?>">
<option value="checked"><?php echo t('Record new and expire old') ?></option>
</select>
</p></card>
<?php
    // Print the main page footer
    parent::print_footer();
    }
}
?>
