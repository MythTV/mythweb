<?php
/***                                                                        ***\
    program_detail.php                       Last Updated: 2004.05.04 (xris)

    This file defines a theme class for the program details section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_program_detail extends Theme {

    function print_page() {
        global $this_channel, $this_program;
    // Print the main page header
        parent::print_header("MythWeb - Program Detail:  $this_program->title");
    // Print the page contents
?>
<table align="center" border="0" cellspacing="0" cellpadding="15">
<tr>
    <td valign="top"><table border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td width="<?php echo prefer_channum ? '80' : '120'?>px" class="menu menu_border_t menu_border_b menu_border_l menu_border_r" width="60" align="center" nowrap><?php
                if (show_channel_icons === true) {
                    ?><table class="small" width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                        <td width="50%" align="center" nowrap><a href="channel_detail.php?chanid=<?php echo $this_channel->chanid?>&time=<?php echo $this_program->starttime?>" class="huge"
                                                        onmouseover="window.status='Details for: <?php echo $this_channel->channum?> <?php echo $this_channel->callsign?>';return true"
                                                        onmouseout="window.status='';return true"><?php echo prefer_channum ? $this_channel->channum : $this_channel->callsign?></a>&nbsp;</td>
                        <td width="50%" align="right"><?php
                            if (is_file($this_channel->icon)) {
                                ?><a href="channel_detail.php?chanid=<?php echo $this_channel->chanid?>&time=<?php echo $this_program->starttime?>"
                                    onmouseover="window.status='Details for: <?php echo $this_channel->channum?> <?php echo $this_channel->callsign?>';return true"
                                    onmouseout="window.status='';return true"><img src="<?php echo $this_channel->icon?>" height="30" width="30"></a><?php
                            } else {
                                echo '&nbsp;';
                            }?></td>
                    </tr><tr>
                        <td colspan="2" align="center" nowrap><a href="channel_detail.php?chanid=<?php echo $this_channel->chanid?>&time=<?php echo $this_program->starttime?>"
                                                        onmouseover="window.status='Details for: <?php echo $this_channel->channum?> <?php echo $this_channel->callsign?>';return true"
                                                        onmouseout="window.status='';return true"><?php echo prefer_channum ? $this_channel->callsign : $this_channel->channum?></a></td>
                    </tr>
                    </table><?php
                } else {
                    ?><a href="channel_detail.php?chanid=<?php echo $this_channel->chanid?>" class="huge"
                        onmouseover="window.status='Details for: <?php echo $this_channel->channum?> <?php echo $this_channel->callsign?>';return true"
                        onmouseout="window.status='';return true"><?php echo prefer_channum ? $this_channel->channum : $this_channel->callsign ?><BR>
                    <?php echo prefer_channum ? $this_channel->callsign : $this_channel->channum?></a><?php
                }
                    ?></td>
            <td width="24px">&nbsp;</td>
            <td><span class="huge"><a href="search.php?searchstr=<?php echo urlencode($this_program->title)?>&search_title=yes">"<?php echo $this_program->title?>"</a>
                <?php if (strlen($this_program->starstring) > 0) echo ", $this_program->starstring";?>
                </span><BR>
                <span class="small">
                <?php
                if ($_GET['recordid'])
                    echo "<em>";
                echo strftime('%a, %b %e', $this_program->starttime);
                if ($this_program->previouslyshown)
                    echo ' ('._LANG_RERUN.')';
                echo '<br />'
                    .strftime('%r', $this_program->starttime) . ' ' . _LANG_TO . ' ' . strftime('%r', $this_program->endtime);
                if (!isset($_GET['recordid']))
                    echo ' (' . (int)($this_program->length/60) . ' ' . _LANG_MINUTES .')';
                if ($_GET['recordid'])
                    echo "</em>";
                echo "<br />\n\t\t\t";
                echo '('._LANG_SEARCH.': &nbsp;'
                    .' <a href="http://www.imdb.com/Find?select=Titles&for='.urlencode($this_program->title).'">'._LANG_IMDB.'</a>'
                    .' &nbsp;-&nbsp; '
                    .' <a href="http://www.tvtome.com/tvtome/servlet/Search?searchType=show&searchString='.urlencode($this_program->title).'">'._LANG_TVTOME . '</a>'
                    .' &nbsp;-&nbsp; '
                    .' <a href="http://www.google.com/search?q='.urlencode($this_program->title).'">'._LANG_GOOGLE.'</a>'
                    .')';
                ?></span></td>
        </tr><tr>
            <td colspan="3">&nbsp;</td>
        </tr><?php
                if (strlen($this_program->subtitle)) {
        ?><tr>
            <td colspan="2" align="right"><?php
                if ($_GET['recordid'])
                    echo "<em>";
                echo 'Episode:&nbsp;';
                if ($_GET['recordid'])
                    echo "</em>";
                ?></td>
            <td><?php
                if ($_GET['recordid'])
                    echo "<em>";
                echo $this_program->subtitle;
                if ($_GET['recordid'])
                    echo "</em>";
                ?></td>
        </tr><?php
                }
                if (strlen($this_program->description)) {
        ?><tr>
            <td colspan="2" align="right" valign="top"><?php
                if ($_GET['recordid'])
                    echo "<em>";
                echo 'Description:&nbsp;';
                if ($_GET['recordid'])
                    echo "</em>";
                ?></td>
            <td><?php
                if ($_GET['recordid'])
                    echo "<em>";
                echo wordwrap($this_program->description, 45, "<BR>\n");
                if ($_GET['recordid'])
                    echo "</em>";
                ?></td>
        </tr><?php
                }
        ?><tr>
            <td colspan="3">&nbsp;</td>
        </tr><?php
            if (strlen($this_program->category)) {
        ?><tr>
            <td colspan="2" align="right"><? echo _LANG_CATEGORY?>:&nbsp;</td>
            <td><?php echo $this_program->category?></td>
        </tr><?php
            }
            if (strlen($this_program->airdate)) {
        ?><tr>
            <td nowrap colspan="2" align="right"><? echo _LANG_ORIG_AIRDATE?>:&nbsp;</td>
            <td><?php echo $this_program->airdate?></td>
        </tr><?php
            }
            if (strlen($this_program->rating)) {
        ?><tr>
            <td colspan="2" align="right"><?php echo strlen($this_program->rater) > 0 ? "$this_program->rater " : ''?>Rating:&nbsp;</td>
            <td><?php echo $this_program->rating?></td>
        </tr><?php
            }
        ?>

        </table>

    <td valign="top" align="right" rowspan="2">

        <form name="program_detail" method="post" action="program_detail.php?<?php
            if ($_GET['recordid'])
                echo 'recordid='.urlencode($_GET['recordid']);
            else
                echo 'chanid='.urlencode($_GET['chanid']).'&starttime='.urlencode($_GET['starttime'])
            ?>">

        <table class="command command_border_l command_border_t command_border_b command_border_r" align="center" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td><p align="center"><?php echo _LANG_RECORDING_OPTIONS?>:</p></td></tr>
        <tr>
            <td><input type="radio" class="radio" name="record" value="never" id="record_never"<?php echo
                $this_program->will_record ? '' : ' CHECKED'?>></input>
                <a onclick="get_element('record_never').checked=true;"><?php
                    if ($this_program->will_record)
                        echo _LANG_CANCEL_THIS_SCHEDULE;
                    else
                        echo _LANG_DONT_RECORD_THIS_PROGRAM;
                    ?></a>
                <br/>
<?php       if (($this_program->type == 1) || ($this_program->starttime > time())) { ?>
                <input type="radio" class="radio" name="record" value="once" id="record_once"<?php
                    echo $this_program->record_once ? ' CHECKED' : ''?>></input>
                <a onclick="get_element('record_once').checked=true;"><?php echo _LANG_RECTYPE_LONG_ONCE?></a>
                <br/>
<?php       } ?>
                <input type="radio" class="radio" name="record" value="daily" id="record_daily"<?php echo
                $this_program->record_daily ? ' CHECKED' : ''?>></input>
                <a onclick="get_element('record_daily').checked=true;"><? echo _LANG_RECTYPE_LONG_DAILY?></a>
                <br/>
                <input type="radio" class="radio" name="record" value="weekly" id="record_weekly"<?php echo
                $this_program->record_weekly ? ' CHECKED' : ''?>></input>
                <a onclick="get_element('record_weekly').checked=true;"><? echo _LANG_RECTYPE_LONG_WEEKLY?></a>
                <br/>
                <input type="radio" class="radio" name="record" value="channel" id="record_channel"<?php echo
                $this_program->record_channel ? ' CHECKED' : ''?>></input>
                <a onclick="get_element('record_channel').checked=true;"><? echo _LANG_RECTYPE_LONG_CHANNEL?> <?php echo prefer_channum ? $this_channel->channum : $this_channel->callsign ?>.</a>
                <br/>
                <input type="radio" class="radio" name="record" value="always" id="record_always"<?php echo
                $this_program->record_always ? ' CHECKED' : ''?>></input>
                <a onclick="get_element('record_always').checked=true;"><?php echo _LANG_RECTYPE_LONG_ALWAYS?></a>
                <br/>
                <input type="radio" class="radio" name="record" value="findone" id="record_findone"<?php echo
                $this_program->record_findone ? ' CHECKED' : ''?>></input>
                <a onclick="get_element('record_findone').checked=true;"><?php echo _LANG_RECTYPE_LONG_FINDONE?></a>
                </td>
        </tr><tr>
            <td><p>
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td nowrap align="right"><?php echo _LANG_RECORDING_PROFILE ?>:&nbsp;</td>
                    <td><select align=right name="profile"><?php
                        global $Profiles;
                        foreach($Profiles as $profile) {
                            echo '<option value="'.htmlentities($profile).'"';
                            if ($this_program->profile == $profile)
                                echo ' SELECTED';
                            echo '>'.htmlentities($profile).'</option>';
                        }
                        ?></select></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo _LANG_RECPRIORITY?>:&nbsp;</td>
                    <td><select align=right name="recpriority"><?php
                        for($recprioritycount=99;$recprioritycount>=-99;--$recprioritycount) {
                            echo '<option value="'.$recprioritycount.'"';
                            if ($this_program->recpriority == $recprioritycount)
                                echo ' SELECTED';
                            echo ">$recprioritycount</option>";
                        }
                        ?></select></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo _LANG_CHECK_FOR_DUPLICATES_IN?>:&nbsp;</td>
                    <td><select align=right name="dupin"><?php
                            echo '<option value="1"';
                            if ($this_program->dupin == 1)
                                echo ' SELECTED';
                            echo '>' . _LANG_CURRENT_RECORDINGS . '</option>';
                            echo '<option value="2"';
                            if ($this_program->dupin == 2)
                                echo ' SELECTED';
                            echo '>' . _LANG_PREVIOUS_RECORDINGS . '</option>';
                            echo '<option value="15"';
                            if (($this_program->dupin == 15) ||
                                ($this_program->dupin == 0))
                                echo ' SELECTED';
                            echo '>' . _LANG_ALL_RECORDINGS . '</option>';
                       ?></select></td>
                </tr><tr>
                    <td nowrap align="right"><? echo _LANG_DUPLICATE_CHECK_METHOD?>:&nbsp;</td>
                    <td><select align=right name="dupmethod"><?php
                            echo '<option value="1"';
                            if ($this_program->dupmethod == 1)
                                echo ' SELECTED';
                            echo '>' . _LANG_NONE . '</option>';
                            echo '<option value="2"';
                            if ($this_program->dupmethod == 2)
                                echo ' SELECTED';
                            echo '>' . _LANG_SUBTITLE . '</option>';
                            echo '<option value="4"';
                            if ($this_program->dupmethod == 4)
                                echo ' SELECTED';
                            echo '>' . _LANG_DESCRIPTION . '</option>';
                            echo '<option value="6"';
                            if (($this_program->dupmethod == 6) ||
                                ($this_program->dupmethod == 0))
                                echo ' SELECTED';
                            echo '>'._LANG_SUBTITLE_AND_DESCRIPTION.'</option>';
                       ?></select></td>
                </tr><tr>
                    <td nowrap align="right"><? echo _LANG_AUTO_EXPIRE_RECORDINGS?>&nbsp;</td>
                    <td><input type="checkbox" class="radio" name="autoexpire" <?php if ($this_program->autoexpire) echo "CHECKED" ?>></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo _LANG_NO_OF_RECORDINGS_TO_KEEP?>&nbsp;</td>
                    <td><input type="input" name="maxepisodes" size="1" value="<?php echo htmlentities($this_program->maxepisodes) ?>"></td>
                </tr><tr>
                    <td nowrap align="right"><? echo _LANG_RECORD_NEW_AND_EXPIRE_OLD?>&nbsp;</td>
                    <td><input type="checkbox" class="radio" name="maxnewest" <?php if ($this_program->maxnewest) echo "CHECKED" ?>></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo _LANG_START_EARLY?>:&nbsp;</td>
                    <td><input type="input" name="startoffset" size="1" value="<?php echo htmlentities($this_program->startoffset) ?>"></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo _LANG_END_LATE?>:&nbsp;</td>
                    <td><input type="input" name="endoffset" size="1" value="<?php echo htmlentities($this_program->endoffset) ?>"></td>
                </tr>
                </table>
                </p>

                <p align="center"><input type="submit" class="submit" name="save" value="<?php echo _LANG_UPDATE_RECORDING_SETTINGS?>"></p></td>

        </tr>
        </table>

        </form>
    </td>
</tr>
<tr>
    <td height="100%" align="center" valign="bottom">
<?php if ($_GET['recordid']) { ?>
        <a href="recording_schedules.php"><?php echo _LANG_BACK_TO_RECORDING_SCHEDULES?></a></td>
<?php } else { ?>
        <a href="program_listing.php?time=<?php echo $this_program->starttime?>"><?php echo _LANG_WHAT_ELSE_IS_ON_AT_THIS_TIME?></a>
        <p>
        <a href="search.php?searchstr=<?php echo $this_program->title?>&search_title=1"><?php echo _LANG_FIND_OTHER_SHOWING_OF_THIS_PROGRAM?></a>
        <p>
        <a href="program_listing.php?time=<?php echo $_SESSION['list_time']?>"><?php echo _LANG_BACK_TO_THE_PROGRAM_LISTING?></a></td>
<?php } ?>
</tr>
</table>
<?php
    // Print the main page footer
        parent::print_footer();
    }

}

?>
