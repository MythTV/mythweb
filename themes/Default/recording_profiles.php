<?php
/***                                                                        ***\
    recording_profiles.php                   Last Updated: 2003.08.22 (xris)

    Configure recording profiles
\***                                                                        ***/

// Make sure we have the parent class defined
require_once theme_dir.'settings.php';

class Theme_recording_profiles extends Theme_settings {

    function print_page() {
        $this->print_header();
        global $Profiles, $Groups;
?>
<p>
<form id="profile_group" action="recording_profiles.php" method="get">
<table class="command command_border_l command_border_t command_border_b command_border_r" border="0" cellspacing="0" cellpadding="4" align="center">
<tr>
    <td><?php echo t('Profile Groups') ?>:</td>
    <td><?php group_select() ?></td>
    <td><noscript><input type="submit" value="<?php echo t('Go') ?>"></noscript></td>
</tr>
</table>
</form>
</p>

<p>
<table border="0" cellpadding="4" cellspacing="2" class="list small" align="center">
<tr class="menu" align="center">
    <td colspan="5"><?php echo t('Recording profiles').': '.$Groups[$_GET['group']]['name'] ?></td>
</tr><?php
    foreach ($Profiles as $id => $profile) {
?><tr class="settings">
    <th rowspan="4"><?php echo $profile['name'] ?></td>
    <td rowspan="2" align="center"><p class="bold">video</p>
        <table class="small" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td align="right">width:</td>
            <td><?php echo $profile['params']['width'] ?></td>
        </tr><tr>
            <td align="right">height:</td>
            <td><?php echo $profile['params']['height'] ?></td>
        </tr>
        </table></td>
    <td><input type="radio" class="radio" name="vid_type_<?php echo $id ?>"<?php if ($profile['videocodec'] == 'MPEG-4') echo ' CHECKED' ?>>mpeg4</td>
    <td align="center"><table class="small" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td align="right">mpeg4bitrate:</td>
            <td><?php echo $profile['params']['mpeg4bitrate'] ?></td>
            <td align="right">mpeg4maxquality:</td>
            <td><?php echo $profile['params']['mpeg4maxquality'] ?></td>
            <td align="right">mpeg4minquality:</td>
            <td><?php echo $profile['params']['mpeg4minquality'] ?></td>
        </tr><tr>
            <td align="right">mpeg4option4mv:</td>
            <td><?php echo $profile['params']['mpeg4option4mv'] ?></td>
            <td align="right">mpeg4optionidct:</td>
            <td><?php echo $profile['params']['mpeg4optionidct'] ?></td>
            <td align="right">mpeg4optionime:</td>
            <td><?php echo $profile['params']['mpeg4optionime'] ?></td>
        </tr><tr>
            <td align="right">mpeg4optionvhq:</td>
            <td><?php echo $profile['params']['mpeg4optionvhq'] ?></td>
            <td align="right">mpeg4qualdiff:</td>
            <td><?php echo $profile['params']['mpeg4qualdiff'] ?></td>
            <td align="right">mpeg4scalebitrate:</td>
            <td><?php echo $profile['params']['mpeg4scalebitrate'] ?></td>
        </tr>
        </table></td>
</tr><tr class="settings">
    <td><input type="radio" class="radio" name="vid_type_<?php echo $id ?>"<?php if ($profile['videocodec'] == 'RTjpeg') echo ' CHECKED' ?>>rtjpeg</td>
    <td align="center"><table class="small" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td align="right">quality:</td>
            <td><?php echo $profile['params']['rtjpegquality'] ?></td>
        </tr><tr>
            <td align="right">chroma filter:</td>
            <td><?php echo $profile['params']['rtjpegchromafilter'] ?></td>
        </tr><tr>
            <td align="right">luma filter:</td>
            <td><?php echo $profile['params']['rtjpeglumafilter'] ?></td>
        </tr>
        </table></td>
</tr><tr class="settings">
    <td rowspan="2" align="center"><p class="bold">audio</p>
        <table class="small" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td align="right">sample rate:</td>
            <td><?php echo $profile['params']['samplerate'] ?></td>
        </tr><tr>
            <td align="right">volume:</td>
            <td><?php echo $profile['params']['volume'] ?></td>
        </tr>
        </table></td>
    <td><input type="radio" class="radio" name="aud_type_<?php echo $id ?>"<?php if ($profile['audiocodec'] == 'MP3') echo ' CHECKED' ?>>mp3</td>
    <td align="center"><table class="small" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td align="right">quality:</td>
            <td><?php echo $profile['params']['mp3quality'] ?></td>
        </tr>
        </table></td>
</tr><tr class="settings">
    <td><input type="radio" class="radio" name="aud_type_<?php echo $id ?>"<?php if ($profile['audiocodec'] != 'MP3') echo ' CHECKED' ?>>uncompressed</td>
</tr><?php
    }
?>
</table>
</p>

<?php
        debug($Groups);

        $this->print_footer();
    }

}

