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

<table border="0" cellspacing="0" cellpadding="0">
<tr>
    <th><?php echo t('prefer_channum') ?>:</th>
    <td><input class="radio" type="checkbox" name="prefer_channum"
         title="<?php echo t('prefer_channum') ?>"
         <?php if ($_SESSION['prefer_channum']) echo ' CHECKED'; ?>></td>
</tr>
<tr>
    <th><?php echo t('show_popup_info'); ?>:</th>
    <td><input class=radio" type="checkbox" name="show_popup_info"
               title="<?php echo t('show_popup_info'); ?>"
               <?php if ($_SESSION['show_popup_info']) echo ' CHECKED'; ?>></td>
</tr>
<tr>
    <th><?php echo t('show_channel_icons'); ?>:</th>
    <td><input class=radio" type="checkbox" name="show_channel_icons"
               title="<?php echo t('show_channel_icons'); ?>"
               <?php if ($_SESSION['show_channel_icons']) echo ' CHECKED'; ?>></td>
</tr>
<tr>
    <th><?php echo t('sortby_channum'); ?>:</th>
    <td><input class=radio" type="checkbox" name="sortby_channum"
               title="<?php echo t('sortby_channum'); ?>"
               <?php if ($_SESSION['sortby_channum']) echo ' CHECKED'; ?>></td>
</tr>
<tr>
    <th><?php echo t('genre_colors'); ?>:</th>
    <td><input class=radio" type="checkbox" name="genre_colors"
               title="<?php echo t('genre_colors'); ?>"
               <?php if ($_SESSION['genre_colors']) echo ' CHECKED'; ?>></td>
</tr>
<tr>
    <th><?php echo t('show_video_covers'); ?>:</th>
    <td><input class=radio" type="checkbox" name="show_video_covers"
               title="<?php echo t('show_video_covers'); ?>"
               <?php if ($_SESSION['show_video_covers']) echo ' CHECKED'; ?>></td>
</tr>
<!--
<tr>
    <th><?php echo t('cache_engine'); ?>:</th>
    <td><select name="cache_engine" id="cache_engine">
            <?php
                foreach(Cache::$Engines as $engine) {
                    eval("\$enabled = $engine::isEnabled();");
                    if ($enabled) {
                        ?>
                        <option value="<?php echo $engine;?>" <?php if ($_SESSION['cache_engine'] == $engine) echo 'SELECTED'; ?>><?php echo t($engine); ?>
                        <?php
                    }
                }
            ?>
        </select>
    </td>
</tr>
-->
<tr>
    <td>
        <input type="submit" class="submit" name="set_current_session_as_default" value="<?php echo t('Store the current session as the default') ?>">
        <input type="submit" class="submit" name="clear_current_default_session"  value="<?php echo t('Clear the current default session') ?>">
    </td>
    <td></td>
</tr>
<tr>
    <td align="right"><input type="reset"  class="submit" value="<?php echo t('Reset') ?>"></td>
    <td align="center"><input type="submit" class="submit" name="save" value="<?php echo t('Save') ?>"></td>
</tr>
</table>

</form>
