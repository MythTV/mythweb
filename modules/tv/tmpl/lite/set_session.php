<?php
/**
 * Configure MythWeb Session info
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/
?>

<form class="form" method="post" action="<?php echo form_action ?>">

<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
    <td colspan="2"><?php echo t('Recorded Programs') ?>:</td>
</tr><tr>
    <td align="right"><label for="recorded_pixmaps"><?php echo t('Show pixmaps') ?></label>:</td>
    <td><input class="radio" type="checkbox" title="Show recording thumbnails." id="recorded_pixmaps" name="recorded_pixmaps"<?php if ($_SESSION['recorded_pixmaps']) echo ' CHECKED' ?>></td>
</tr><tr>
    <td align="right"><?php echo t('Download URL override') ?></label>:</td>
    <td>file://<input type="text" id="file_url_override" name="file_url_override" value="<?php echo html_entities(trim($_SESSION['file_url_override'])) ?>" title="Instead of streaming downloaded recordings, load from a local file:// path instead."></td>
</tr><tr>
    <td colspan="2"><?php echo t('Guide Settings') ?>:</td>
</tr><tr>
    <td align="right"><?php echo t('Only display favorite channels') ?>:</td>
    <td ><input class="radio" type="checkbox" title="In the program listing, only show channels marked as favorite channels" name="guide_favonly"<?php if ($_SESSION['guide_favonly']) echo ' CHECKED' ?>></td>
</tr><tr>
    <td align="right"><?php echo t('Max star rating for movies') ?>:</td>
    <td><input type="text" size="5" name="max_stars" value="<?php echo intVal($_SESSION['max_stars']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo t('Star character') ?>:</td>
    <td><input type="text" size="5" name="star_character" value="<?php echo html_entities($_SESSION['star_character']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo t('Timeslot size') ?>:</td>
    <td><input type="text" size="5" name="timeslot_size" value="<?php echo intVal($_SESSION['timeslot_size'] / 60) ?>"> <?php echo t('minutes') ?></td>
</tr><tr>
    <td align="right"><?php echo t('Number of timeslots') ?>:</td>
    <td><input type="text" size="5" name="num_time_slots" value="<?php echo intVal($_SESSION['num_time_slots']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo t('Group timeslots every') ?>:</td>
    <td><input type="text" size="5" name="timeslot_blocks" value="<?php echo intVal($_SESSION['timeslot_blocks']) ?>"></td>
</tr><tr>
    <td class="command_border_b" align="right"><?php echo t('Rows to show between timeslot info') ?>:</td>
    <td class="command_border_b"><input type="text" size="5" name="timeslotbar_skip" value="<?php echo intVal($_SESSION['timeslotbar_skip']) ?>"></td>
</tr><tr>
    <td><?php echo t('Date Formats') ?>:</td>
    <td><div class="small" style="float:right"><a href="http://php.net/manual/en/function.strftime.php" target="_blank"><?php echo t('format help') ?></a></div></td>
</tr><tr>
    <td align="right"><?php echo t('Status Bar') ?>:&nbsp;</td>
    <td><input type="text" size="24" name="date_statusbar" value="<?php    echo html_entities($_SESSION['date_statusbar']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo t('Upcoming Recordings') ?>:&nbsp;</td>
    <td><input type="text" size="24" name="date_scheduled" value="<?php    echo html_entities($_SESSION['date_scheduled']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo t('Scheduled Popup') ?>:&nbsp;</td>
    <td><input type="text" size="24" name="date_scheduled_popup" value="<?php echo html_entities($_SESSION['date_scheduled_popup']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo t('Recorded Programs') ?>:&nbsp;</td>
    <td><input type="text" size="24" name="date_recorded" value="<?php     echo html_entities($_SESSION['date_recorded']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo t('Search Results') ?>:&nbsp;</td>
    <td><input type="text" size="24" name="date_search" value="<?php       echo html_entities($_SESSION['date_search']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo t('Listing Time Key') ?>:&nbsp;</td>
    <td><input type="text" size="24" name="date_listing_key" value="<?php  echo html_entities($_SESSION['date_listing_key']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo t('Listing &quot;Jump to&quot;') ?>&nbsp;</td>
    <td><input type="text" size="24" name="date_listing_jump" value="<?php echo html_entities($_SESSION['date_listing_jump']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo t('Channel &quot;Jump to&quot;') ?>&nbsp;</td>
    <td><input type="text" size="24" name="date_channel_jump" value="<?php echo html_entities($_SESSION['date_channel_jump']) ?>"></td>
</tr><tr>
    <td align="right"><?php echo t('Hour Format') ?>&nbsp;</td>
    <td><select name="time_format" style="text-align: center"><?php
        foreach (array('%I:%M %p', '%H:%M') as $code) {
            echo "<option value=\"$code\"";
            if ($_SESSION['time_format'] == $code)
                echo ' SELECTED';
            echo '>'.strftime($code, strtotime('9:00 AM')).' / '.strftime($code, strtotime('9:00 PM')).'</option>';
        }
        ?></select></td>
</tr><tr>
    <td class="command_border_t" align="center"><input type="reset" value="<?php echo t('Reset') ?>"></td>
    <td class="command_border_t" align="center"><input type="submit" name="save" value="<?php echo t('Save') ?>"></td>
</tr>
</table>

</form>

