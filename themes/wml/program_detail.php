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
<a href="channel_detail.php?chanid=<?php echo $this_channel->chanid?>" ><?php echo $this_channel->channum." ".$this_channel->callsign; ?></a><br/>
<?php echo htmlspecialchars($this_program->title)?><br/>
<a href="#cardmodify" ><?php echo _LANG_RECORDING_OPTIONS; ?></a><br/>
<?php echo strftime(generic_date, $this_program->starttime)?><br/>
<?php echo strftime($_SESSION['time_format'], $this_program->starttime)?> <?php echo _LANG_TO;?> <?php echo strftime($_SESSION['time_format'], $this_program->endtime)?> (<?php echo (int)($this_program->length/60)?> <?php echo _LANG_MINUTES; ?>)<br/>
<?php
        if ($this_program->previouslyshown) {
            echo _LANG_RERUN.' ';
        }
        if (strlen($this_program->subtitle)) { 
?>
<?php echo _LANG_SUBTITLE; ?>: <b><?php echo htmlspecialchars($this_program->subtitle)?></b><br/>
<?php }
        if (strlen($this_program->description)) {?>
<?php echo _LANG_DESCRIPTION; ?>: <?php echo htmlspecialchars(str_replace('$', '', $this_program->description))?><br/>
<?php         }
         if (strlen($this_program->category)) {
            echo _LANG_CATEGORY; ?>: <?php echo $this_program->category?><br/>
<?php         }
        if (strlen($this_program->airdate)) {
            echo _LANG_ORIG_AIRDATE; ?>: <?php echo $this_program->airdate?><br/>
<?php         }
        if (strlen($this_program->rating)) {?>
<?php echo strlen($this_program->rater) > 0 ? "$this_program->rater " : ''?><?php echo _LANG_RATING; ?>: <?php echo $this_program->rating?><br/>
<?php
                ?><br/>
<?php     } 
?>
</p>
</card>
<card id="cardmodify" title="<?php echo _LANG_SETTINGS; ?>">
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
<postfield name="recorddups" value="$(recorddups)"/>
<postfield name="autoexpire" value="$(autoexpire)"/>
<postfield name="maxnewest" value="$(maxnewest)"/>
</go>
</do>
<p>
<?php echo _LANG_RECORDING_OPTIONS; ?>:
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
<option value="never" id="record_never"><?php if ($record_opt=="never") echo "(*)"; ?><?php echo _LANG_RECTYPE_DONTREC; ?></option>
<option value="once" id="record_once"><?php if ($record_opt=="once") echo "(*)"; ?><?php echo _LANG_RECTYPE_LONG_ONCE; ?></option>
<option value="daily" id="record_daily"><?php if ($record_opt=="daily") echo "(*)"; ?>Record <?php echo _LANG_RECTYPE_LONG_DAILY; ?></option>
<option value="weekly" id="record_weekly"><?php if ($record_opt=="weekly") echo "(*)"; ?>Record <?php echo _LANG_RECTYPE_LONG_WEEKLY?></option>
<option value="channel" id="record_channel"><?php if ($record_opt=="channel") echo "(*)"; ?><?php echo _LANG_RECTYPE_LONG_CHANNEL; ?></option>
<option value="always" id="record_always"><?php if ($record_opt=="always") echo "(*)"; ?><?php echo _LANG_RECTYPE_LONG_ALWAYS; ?></option>
<option value="findone" id="record_findone"><?php if ($record_opt=="findone") echo "(*)"; ?><?php echo _LANG_RECTYPE_LONG_FINDONE; ?></option>
</select>
</p>
<p>
<select name="profile" value="<?php echo $this_program->profile ?>">
<optgroup title="<?php echo _LANG_RECORDING_PROFILE; ?>">
<?php

    global $Profiles;
    foreach($Profiles as $profile) {
        echo '<option value="'.htmlentities($profile).'">';
        echo htmlentities($profile).'</option>';
    }
?>
</optgroup></select>
<?php echo _LANG_RECPRIORITY; ?>: <input name="recpriority" type="text" value="<?php echo $this_program->recpriority ?>" format="N*" size="2"/>
<br/>
<?php echo _LANG_NO_OF_RECORDINGS_TO_KEEP; ?>:<input type="text" name="maxepisodes" emptyok="true" size="1" format="N" value="<?php echo htmlentities($this_program->maxepisodes) ?>"/>
<br/>
<?php echo _LANG_START_EARLY; ?>:<input type="text" name="startoffset" emptyok="true" size="2" format="NN" value="<?php echo htmlentities($this_program->startoffset) ?>"/>
<br/>
<?php echo _LANG_END_LATE; ?>:<input type="text" name="endoffset" emptyok="true" size="2" format="NN" value="<?php echo htmlentities($this_program->endoffset) ?>"/>
<br/>
<select name="recorddups" multiple="true" value="<?php if ($this_program->recorddups) echo 'checked' ?>">
<option value="checked" id="o1"><?php echo _LANG_DUPLICATES; ?>?</option>
</select>
<select name="autoexpire" multiple="true" value="<?php if ($this_program->autoexpire) echo "checked" ?>">
<option value="checked" id="o2"><?php echo _LANG_AUTO_EXPIRE_RECORDINGS; ?></option>
</select>
<select name="maxnewest" multiple="true" value="<?php if ($this_program->maxnewest) echo "checked" ?>">
<option value="checked"><?php echo _LANG_RECORD_NEW_AND_EXPIRE_OLD; ?></option>
</select>
</p></card>
<?php
    // Print the main page footer
    parent::print_footer();
    }
}
?>
