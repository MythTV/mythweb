<?php
/***                                                                        ***\
    program_detail.php                       Last Updated: 2004.11.29 (xris)

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
                <?php if (strlen($this_program->starstring) > 0) echo " $this_program->starstring";?>
                </span><BR>
                <span class="small">
                <?php
                if ($_GET['recordid'])
                    echo "<em>";
                echo strftime('%a, %b %e', $this_program->starttime);
                if ($this_program->previouslyshown)
                    echo ' ('.t('Rerun').')';
                echo '<br />'
                    .t('$1 to $2', strftime('%r', $this_program->starttime), strftime('%r', $this_program->endtime));
                if (!isset($_GET['recordid']))
                    echo ' ('.tn('$1 min', '$1 mins', (int)($this_program->length/60)).')';
                if ($_GET['recordid'])
                    echo "</em>";
                echo "<br />\n\t\t\t";
                echo '('.t('Search').': &nbsp;'
                    .' <a href="http://www.imdb.com/Find?select=Titles&for='.urlencode($this_program->title).'">'.t('IMDB').'</a>'
                    .' &nbsp;-&nbsp; '
                    .' <a href="http://www.tvtome.com/tvtome/servlet/Search?searchType=show&searchString='.urlencode($this_program->title).'">'.t('TVTome').'</a>'                    .' &nbsp;-&nbsp; '
                    .' <a href="http://www.google.com/search?q='.urlencode($this_program->title).'">'.t('Google').'</a>'
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
            <td colspan="2" align="right"><? echo t('Category') ?>:&nbsp;</td>
            <td><?php echo $this_program->category?></td>
        </tr><?php
            }
            if (strlen($this_program->airdate)) {
        ?><tr>
            <td nowrap colspan="2" align="right"><? echo t('Original Airdate') ?>:&nbsp;</td>
            <td><?php echo $this_program->airdate?></td>
        </tr><?php
            }
            if (strlen($this_program->rating)) {
        ?><tr>
            <td colspan="2" align="right"><?php echo strlen($this_program->rater) > 0 ? "$this_program->rater " : ''?>Rating:&nbsp;</td>
            <td><?php echo $this_program->rating?></td>
        </tr><?php
            }
            $list = getCredits($this_program->chanid,$this_program->starttime,'host');
            if (strlen($list)) {
        ?><tr valign="top">
            <td colspan="2" align="right">Hosted by:&nbsp;</td>
            <td><?php echo $list?></td>
        </tr><?php
            }
            $list = getCredits($this_program->chanid,$this_program->starttime,'presenter');
            if (strlen($list)) {
        ?><tr valign="top">
            <td colspan="2" align="right">Presented by:&nbsp;</td>
            <td><?php echo $list?></td>
        </tr><?php
            }
            $list = getCredits($this_program->chanid,$this_program->starttime,'actor');
            if (strlen($list)) {
        ?><tr valign="top">
            <td colspan="2" align="right">Cast:&nbsp;</td>
            <td><?php echo $list?></td>
        </tr><?php
            }
            $list = getCredits($this_program->chanid,$this_program->starttime,'guest_star');
            if (strlen($list)) {
        ?><tr valign="top">
            <td colspan="2" align="right">Guest Starring:&nbsp;</td>
            <td><?php echo $list?></td>
        </tr><?php
            }
            $list = getCredits($this_program->chanid,$this_program->starttime,'director');
            if (strlen($list)) {
        ?><tr valign="top">
            <td colspan="2" align="right">Directed by:&nbsp;</td>
            <td><?php echo $list?></td>
        </tr><?php
            }
            $list = getCredits($this_program->chanid,$this_program->starttime,'producer');
            if (strlen($list)) {
        ?><tr valign="top">
            <td colspan="2" align="right">Produced by:&nbsp;</td>
            <td><?php echo $list?></td>
        </tr><?php
            }
            $list = getCredits($this_program->chanid,$this_program->starttime,'executive_producer');
            if (strlen($list)) {
        ?><tr valign="top">
            <td colspan="2" align="right">Exec.&nbsp;Producer<?php echo strchr($list,',')?'s':'' ?>:&nbsp;</td>
            <td><?php echo $list?></td>
        </tr><?php
            }
            $list = getCredits($this_program->chanid,$this_program->starttime,'writer');
            if (strlen($list)) {
        ?><tr valign="top">
            <td colspan="2" align="right">Written by:&nbsp;</td>
            <td><?php echo $list?></td>
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
            <td><p align="center"><?php echo t('Recording Options') ?>:</p></td></tr>
        <tr>
            <td><input type="radio" class="radio" name="record" value="never" id="record_never"<?php echo
                $this_program->will_record ? '' : ' CHECKED'?>></input>
                <a onclick="get_element('record_never').checked=true;"><?php
                    if ($this_program->will_record)
                        echo t('Cancel this schedule');
                    else
                        echo t('Don\'t record this program');
                    ?></a>
                <br/>
                <input type="radio" class="radio" name="record" value="once" id="record_once"<?php
                    echo $this_program->record_once ? ' CHECKED' : ''?>></input>
                <a onclick="get_element('record_once').checked=true;"><?php echo t('rectype-long: once') ?></a>
                <br/>
                <input type="radio" class="radio" name="record" value="daily" id="record_daily"<?php echo
                $this_program->record_daily ? ' CHECKED' : ''?>></input>
                <a onclick="get_element('record_daily').checked=true;"><? echo t('rectype-long: daily') ?></a>
                <br/>
                <input type="radio" class="radio" name="record" value="weekly" id="record_weekly"<?php echo
                $this_program->record_weekly ? ' CHECKED' : ''?>></input>
                <a onclick="get_element('record_weekly').checked=true;"><? echo t('rectype-long: weekly') ?></a>
                <br/>
                <input type="radio" class="radio" name="record" value="channel" id="record_channel"<?php echo
                $this_program->record_channel ? ' CHECKED' : ''?>></input>
                <a onclick="get_element('record_channel').checked=true;"><? echo t('rectype-long: channel') ?> <?php echo prefer_channum ? $this_channel->channum : $this_channel->callsign ?>.</a>
                <br/>
                <input type="radio" class="radio" name="record" value="always" id="record_always"<?php echo
                $this_program->record_always ? ' CHECKED' : ''?>></input>
                <a onclick="get_element('record_always').checked=true;"><?php echo t('rectype-long: always') ?></a>
                <br/>
                <input type="radio" class="radio" name="record" value="findone" id="record_findone"<?php echo
                $this_program->record_findone ? ' CHECKED' : ''?>></input>
                <a onclick="get_element('record_findone').checked=true;"><?php echo t('rectype-long: findone') ?></a>
                </td>
        </tr><tr>
            <td><p>
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td nowrap align="right"><?php echo t('Recording Profile') ?>:&nbsp;</td>
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
                    <td nowrap align="right"><?php echo t('Recording Group') ?>:&nbsp;</td>
                    <td><select align=right name="recgroup"><?php
                        global $Groups;
                        foreach($Groups as $group) {
                            echo '<option value="'.htmlentities($group).'"';
                            if ($this_program->recgroup == $group)
                                echo ' SELECTED';
                            echo '>'.htmlentities($group).'</option>';
                        }
                        ?></select></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo t('Recording Priority') ?>:&nbsp;</td>
                    <td><select align=right name="recpriority"><?php
                        for($recprioritycount=99;$recprioritycount>=-99;--$recprioritycount) {
                            echo '<option value="'.$recprioritycount.'"';
                            if ($this_program->recpriority == $recprioritycount)
                                echo ' SELECTED';
                            echo ">$recprioritycount</option>";
                        }
                        ?></select></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo t('Check for duplicates in') ?>:&nbsp;</td>
                    <td><select align=right name="dupin"><?php
                            echo '<option value="1"';
                            if ($this_program->dupin == 1)
                                echo ' SELECTED';
                            echo '>' . t('Current recordings') . '</option>';
                            echo '<option value="2"';
                            if ($this_program->dupin == 2)
                                echo ' SELECTED';
                            echo '>' . t('Previous recordings') . '</option>';
                            echo '<option value="4"';
                            if ($this_program->dupin == 4)
                                echo ' SELECTED';
                            echo '>' . t('Only New Episodes') . '</option>';
                            echo '<option value="15"';
                            if (($this_program->dupin == 15) ||
                                ($this_program->dupin == 0))
                                echo ' SELECTED';
                            echo '>' . t('All recordings') . '</option>';
                       ?></select></td>
                </tr><tr>
                    <td nowrap align="right"><? echo t('Duplicate Check method') ?>:&nbsp;</td>
                    <td><select align=right name="dupmethod"><?php
                            echo '<option value="1"';
                            if ($this_program->dupmethod == 1)
                                echo ' SELECTED';
                            echo '>' . t('None') . '</option>';
                            echo '<option value="2"';
                            if ($this_program->dupmethod == 2)
                                echo ' SELECTED';
                            echo '>' . t('Subtitle') . '</option>';
                            echo '<option value="4"';
                            if ($this_program->dupmethod == 4)
                                echo ' SELECTED';
                            echo '>' . t('Description') . '</option>';
                            echo '<option value="6"';
                            if (($this_program->dupmethod == 6) ||
                                ($this_program->dupmethod == 0))
                                echo ' SELECTED';
                            echo '>'.t('Subtitle and Description').'</option>';
                       ?></select></td>
                </tr><tr>
                    <td nowrap align="right"><? echo t('Auto-expire recordings') ?>&nbsp;</td>
                    <td><input type="checkbox" class="radio" name="autoexpire" <?php if ($this_program->autoexpire) echo "CHECKED" ?>></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo t('No. of recordings to keep') ?>&nbsp;</td>
                    <td><input type="input" name="maxepisodes" size="1" value="<?php echo htmlentities($this_program->maxepisodes) ?>"></td>
                </tr><tr>
                    <td nowrap align="right"><? echo t('Record new and expire old') ?>&nbsp;</td>
                    <td><input type="checkbox" class="radio" name="maxnewest" <?php if ($this_program->maxnewest) echo "CHECKED" ?>></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo t('Start Early') ?>:&nbsp;</td>
                    <td><input type="input" name="startoffset" size="1" value="<?php echo htmlentities($this_program->startoffset) ?>"></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo t('End Late') ?>:&nbsp;</td>
                    <td><input type="input" name="endoffset" size="1" value="<?php echo htmlentities($this_program->endoffset) ?>"></td>
                </tr>
                </table>
                </p>

                <p align="center"><input type="submit" class="submit" name="save" value="<?php echo t('Update Recording Settings') ?>"></p></td>

        </tr>
        </table>

        </form>
    </td>
</tr>
<tr>
    <td height="100%" align="center" valign="bottom">
<?php if ($_GET['recordid']) { ?>
        <a href="recording_schedules.php"><?php echo t('Back to the recording schedules') ?></a></td>
<?php } else { ?>
        <a href="program_listing.php?time=<?php echo $this_program->starttime?>"><?php echo t('What else is on at this time?') ?></a>
        <p>
        <a href="search.php?searchstr=<?php echo $this_program->title?>&search_title=1"><?php echo t('Find other showings of this program') ?></a>
        <p>
        <a href="program_listing.php?time=<?php echo $_SESSION['list_time']?>"><?php echo t('Back to the program listing') ?></a></td>
<?php } ?>
</tr>
</table>
<?php
    // Print the main page footer
        parent::print_footer();
    }

}

?>
