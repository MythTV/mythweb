<?php
/***                                                                        ***\
    settings_mythweb.php                     Last Updated: 2004.07.06 (xris)

    main configuration index
\***                                                                        ***/

// Load the parent class for all settings pages
    require_once theme_dir.'settings.php';

class Theme_settings_mythweb extends Theme_settings {

    function print_page() {
        $this->print_header();
?>

<form class="form" method="post" action="settings_mythweb.php">

<table class="command command_border_l command_border_t command_border_b command_border_r" border="0" cellspacing="0" cellpadding="5" style="float: left;margin-left: 20px">
<tr>
    <td class="command_border_b" align="right">MythWeb <? echo _LANG_THEME?>:</td>
    <td class="command_border_b"><?php theme_select() ?></td>
</tr><tr>
    <td class="command_border_b" align="right"><?php echo _LANG_LANGUAGE?>:</td>
    <td class="command_border_b"><?php language_select() ?></td>
</tr><tr>
    <td colspan="2"><?php echo _LANG_RECORDED_PROGRAMS?>:</td>
</tr><tr>
    <td class="command_border_b" align="right"><?php echo _LANG_SHOW_DESCRIPTIONS_ON_NEW_LINE?>:</td>
    <td class="command_border_b"><input class="radio" type="checkbox" title="Nice for very long descriptions on the recorded screen." name="recorded_descunder"<?php if ($_SESSION['recorded_descunder']) echo ' CHECKED' ?>></td>
</tr><tr>
    <td><?php echo _LANG_DATEFORMATS?>:</td>
    <td><div class="small" style="float:right"><a href="http://php.net/manual/en/function.strftime.php" target="_blank"><?php echo _LANG_FORMAT_HELP?></a></div></td>
</tr><tr>
    <td align="right"><?php echo _LANG_STATUS_BAR?>:&nbsp;</td>
    <td><input type="text" size="24" name="date_statusbar" value="<?php    echo htmlentities($_SESSION['date_statusbar']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo _LANG_SCHEDULED_RECORDINGS?>:&nbsp;</td>
    <td><input type="text" size="24" name="date_scheduled" value="<?php    echo htmlentities($_SESSION['date_scheduled']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo _LANG_SCHEDULED_POPUP?>:&nbsp;</td>
    <td><input type="text" size="24" name="date_scheduled_popup" value="<?php echo htmlentities($_SESSION['date_scheduled_popup']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo _LANG_RECORDED_PROGRAMS?>:&nbsp;</td>
    <td><input type="text" size="24" name="date_recorded" value="<?php     echo htmlentities($_SESSION['date_recorded']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo _LANG_SEARCH_RESULTS?>:&nbsp;</td>
    <td><input type="text" size="24" name="date_search" value="<?php       echo htmlentities($_SESSION['date_search']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo _LANG_LISTING_TIME_KEY?>:&nbsp;</td>
    <td><input type="text" size="24" name="date_listing_key" value="<?php  echo htmlentities($_SESSION['date_listing_key']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo _LANG_LISTING_JUMP_TO?>&nbsp;</td>
    <td><input type="text" size="24" name="date_listing_jump" value="<?php echo htmlentities($_SESSION['date_listing_jump']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo _LANG_CHANNEL_JUMP_TO?>&nbsp;</td>
    <td><input type="text" size="24" name="date_channel_jump" value="<?php echo htmlentities($_SESSION['date_channel_jump']) ?>"></td>
</tr><tr>
    <td align="right"><? echo _LANG_HOUR_FORMAT?>&nbsp;</td>
    <td><select name="time_format" style="text-align: center"><?php
        foreach (array('%I:%M %p', '%H:%M') as $code) {
            echo "<option value=\"$code\"";
            if ($_SESSION['time_format'] == $code)
                echo ' SELECTED';
            echo '>'.strftime($code, strtotime('9:00 AM')).' / '.strftime($code, strtotime('9:00 PM')).'</option>';
        }
        ?></select></td>
</tr><tr>
    <td class="command_border_t" align="center"><input type="reset" value="<?php echo _LANG_RESET?>"></td>
    <td class="command_border_t" align="center"><input type="submit" name="save" value="<?php echo _LANG_SAVE?>"></td>
</tr>
</table>

</form>

<?php

        $this->print_footer();
    }

    function print_header() {
        parent::print_header("MythWeb - Configure Mythweb");
    }

    function print_footer() {
        parent::print_footer();
    }

}
?>
