<?php
/***                                                                        ***\
    schedule_manually.php                       Last Updated: 2004.11.29 (xris)

    This file defines a theme class for the schedule manually section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

class Theme_schedule_manually extends Theme {

    function print_page(&$Channels) {
        global $this_channel, $this_program;
    // Print the main page header
        parent::print_header("MythWeb - Schedule Manually");
    // Print the page contents
?>
<table align="center" border="0" cellspacing="0" cellpadding="15">
<tr>
    <td valign="top" align="center">

        <form name="schedule_manually" method="post" action="schedule_manually.php">

        <table class="command command_border_l command_border_t command_border_b command_border_r" align="center" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td><p align="center"><?php echo t('Recording Options') ?>:</p></td></tr>
        <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td nowrap align="right"><?php echo t('Channel') ?>:&nbsp;</td>
                    <td><select name="channel">

                        <?php
                        foreach (array_keys($Channels) as $key) {
                            // Ignore channels with no number
                            if (strlen($Channels[$key]->channum) < 1)
                                continue;

                            // Ignore invisible channels
                            if ($Channels[$key]->visible == 0)
                                continue;

                            echo "<option value=\"" . $Channels[$key]->chanid . "\">" . $Channels[$key]->channum . " " . $Channels[$key]->callsign . "</option>";
                        }
                        ?>
                        </select>
                    </td>
                </tr><tr>
                    <td nowrap align="right"><?php echo t('Start Date') ?>:&nbsp;</td>
                    <td><input type="text" name="startdate" size="10" maxlength="10" value="<?php echo date("Y-m-d") ?>"></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo t('Start Time') ?>:&nbsp;</td>
                    <td><input type="text" name="starttime" size="10" maxlength="8" value="<?php echo date("H:i:00") ?>"></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo t('Length (min)') ?>:&nbsp;</td>
                    <td><input type="text" name="length" value="120" size="10" maxlength="4"></td>
                </tr> <tr>
                    <td nowrap align="right"><?php echo t('Title') ?>:&nbsp;</td>
                    <td><input type="text" name="title" value="use callsign" size="30"></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo t('Subtitle') ?>:&nbsp;</td>
                    <td><input type="text" name="subtitle" value="use datetime" size="30"></td>
                </tr>
                </table>
            </td>
        </tr><tr>
            <td><input type="radio" class="radio" name="record" value="once" id="record_once" checked></input>
                <a onclick="get_element('record_once').checked=true;"><?php echo t('rectype-long: once') ?></a>
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
                    <td><input type="checkbox" class="radio" name="autoexpire"></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo t('No. of recordings to keep') ?>&nbsp;</td>
                    <td><input type="input" name="maxepisodes" size="1"></td>
                </tr><tr>
                    <td nowrap align="right"><? echo t('Record new and expire old') ?>&nbsp;</td>
                    <td><input type="checkbox" class="radio" name="maxnewest"></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo t('Start Early') ?>:&nbsp;</td>
                    <td><input type="input" name="startoffset" size="1" value="0"></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo t('End Late') ?>:&nbsp;</td>
                    <td><input type="input" name="endoffset" size="1" value="0"></td>
                </tr>
                </table>
                </p>

                <p align="center"><input type="submit" class="submit" name="save" value="<?php echo t('Update Recording Settings') ?>"></p></td>

        </tr>
        </table>

        </form>
    </td>
</tr>
</table>
<?php
    // Print the main page footer
        parent::print_footer();
    }

}

?>
