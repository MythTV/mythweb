<?php
/**
 * Enable or Disable the included FLV player
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
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
        <?php
            $ffmpeg = '';
            foreach (split (':', getenv ('PATH').':/usr/local/bin:/usr/bin') as $path) {
                if (file_exists ($path."/ffmpeg")) {
                    $ffmpeg = $path."/ffmpeg";
                    break;
                }
                elseif (php_uname ('s') == 'Darwin' && file_exists ($path."/ffmpeg.app")) {
                    $ffmpeg = $path."/ffmpeg".app;
                    break;
                }
            }
            $ffmpeg_output = shell_exec ("$ffmpeg --help 2>&1");
            $has_mp3_support = strpos ($ffmpeg_output, "mp3");
            if (!$has_mp3_support)
                echo ' DISABLED';
            if (setting('WebFLV_on'))
                echo ' CHECKED';
            echo '>';
            if (!$has_mp3_support)
                echo ' ffmpeg with MP3 support not detected';
            ?></td>
</tr><tr>
    <th valign="top"><?php echo t('Width') ?>:</th>
    <td><input type="text" name="width"
         size="5" title="FLV Width"
         value="<?php echo intVal(_or(setting('WebFLV_w'), 320)) ?>" />
         <br>
         (height is calculated automatically from the recording aspect ratio)
         </td>
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
