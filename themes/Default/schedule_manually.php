<?php
/***                                                                        ***\
    schedule_manually.php                       Last Updated: 2004.09.05 (dka)

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
            <td><p align="center"><?php echo _LANG_RECORDING_OPTIONS?>:</p></td></tr>
        <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td nowrap align="right">Channel:&nbsp;</td>
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
                    <td nowrap align="right">Start Date:&nbsp;</td>
                    <td><input type="text" name="startdate" size="10" maxlength="10" value="<?php echo date("Y-m-d") ?>"></td>
                </tr><tr>
                    <td nowrap align="right">Start Time:&nbsp;</td>
                    <td><input type="text" name="starttime" size="10" maxlength="8" value="<?php echo date("H:i:00") ?>"></td>
                </tr><tr>
                    <td nowrap align="right">Length (min):&nbsp;</td>
                    <td><input type="text" name="length" value="120" size="10" maxlength="4"></td>
                </tr> <tr>
                    <td nowrap align="right">Title:&nbsp;</td>
                    <td><input type="text" name="title" value="use callsign" size="30"></td>
                </tr><tr>
                    <td nowrap align="right">Subtitle:&nbsp;</td>
                    <td><input type="text" name="subtitle" value="use datetime" size="30"></td>
                </tr>
                </table>
            </td>
        </tr><tr>
            <td><input type="radio" class="radio" name="record" value="once" id="record_once" checked></input>
                <a onclick="get_element('record_once').checked=true;"><?php echo _LANG_RECTYPE_LONG_ONCE?></a>
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
                    <td><input type="checkbox" class="radio" name="autoexpire"></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo _LANG_NO_OF_RECORDINGS_TO_KEEP?>&nbsp;</td>
                    <td><input type="input" name="maxepisodes" size="1"></td>
                </tr><tr>
                    <td nowrap align="right"><? echo _LANG_RECORD_NEW_AND_EXPIRE_OLD?>&nbsp;</td>
                    <td><input type="checkbox" class="radio" name="maxnewest"></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo _LANG_START_EARLY?>:&nbsp;</td>
                    <td><input type="input" name="startoffset" size="1" value="0"></td>
                </tr><tr>
                    <td nowrap align="right"><?php echo _LANG_END_LATE?>:&nbsp;</td>
                    <td><input type="input" name="endoffset" size="1" value="0"></td>
                </tr>
                </table>
                </p>

                <p align="center"><input type="submit" class="submit" name="save" value="<?php echo _LANG_UPDATE_RECORDING_SETTINGS?>"></p></td>

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
