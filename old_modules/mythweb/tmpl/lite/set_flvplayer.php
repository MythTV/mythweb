<?php
/**
 * Enable or Disable the included FLV player
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/
?>

<form class="form" method="post" action="<?php echo form_action ?>">

<div class="x-notice" style="width: 45em; text-align: left">
<?php echo t('info: flvplayer') ?>
</div>

<table border="0" cellspacing="0" cellpadding="0">
<tr>
    <th><?php echo t('Enable Video Playback') ?>:</th>
    <td><input class="radio" type="checkbox" name="flvplayer"
         title="Enable Flash Video player for recordings."
         <?php if (setting('WebFLV_on')) echo ' CHECKED' ?>></td>
</tr><tr>
<? /*  The SWF player can't handle different sizes yet, so don't turn these on
    <th><?php echo t('Width') ?>:</th>
    <td><input type="text" name="width"
         size="5" title="FLV Width"
         value="<?php echo html_entities(_or(setting('WebFLV_w'), 320)) ?>" /></td>
</tr><tr>
    <th><?php echo t('Height') ?>:</th>
    <td><input type="text" name="height"
         size="5" title="FLV Height"
         value="<?php echo html_entities(_or(setting('WebFLV_h'), 240)) ?>" /></td>
*/ ?>
</tr><tr>
    <th><?php echo t('Video Bitrate') ?>:</th>
    <td><input type="text" name="vbitrate"
         size="5" title="Video Bitrate"
         value="<?php echo html_entities(_or(setting('WebFLV_vb'), 256)) ?>" />
         kbps</td>
</tr><tr>
    <th><?php echo t('Audio Bitrate') ?>:</th>
    <td><input type="text" name="abitrate"
         size="5" title="Audio Bitrate"
         value="<?php echo html_entities(_or(setting('WebFLV_ab'), 64)) ?>" />
         kbps</td>
</tr><tr>
    <td align="right"><input type="reset"  class="submit" value="<?php echo t('Reset') ?>"></td>
    <td align="center"><input type="submit" class="submit" name="save" value="<?php echo t('Save') ?>"></td>
</tr>
</table>

</form>

