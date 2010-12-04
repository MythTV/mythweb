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

// Set the desired page title
    $page_title = 'MythWeb - '.t('MythWeb Global Defaults');

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

?>

<form class="form" method="post" action="<?php echo root_url ?>settings/mythweb">

<table class="command command_border_l command_border_t command_border_b command_border_r" border="0" cellspacing="0" cellpadding="5" style="margin: 1em auto">
<tr>
    <td align="right"><?php echo t('Prefer Channum') ?>:</td>
    <td><input class="radio" type="checkbox" title="Prefer channel number over callsign." name="prefer_channum"<?php if ($_SESSION['prefer_channum']) echo ' CHECKED' ?>></td>
</tr><tr>
    <td align="right"><?php echo t('MythVideo Dir') ?>:</td>
    <td><input type="text" size="36" name="mythvideo_dir" value="<?php echo html_entities(setting('VideoStartupDir', hostname))?>"><br />
</tr><tr>
    <td align="right"><?php echo t('MythVideo Artwork Dir') ?>:</td>
    <td><input type="text" size="36" name="video_artwork_dir" value="<?php echo html_entities(setting('VideoArtworkDir', hostname))?>"><br />
</td>
</tr><tr>
    <td class="command_border_t" align="center"><input type="reset" value="<?php echo t('Reset') ?>"></td>
    <td class="command_border_t" align="center"><input type="submit" name="save" value="<?php echo t('Save') ?>"></td>
</tr>
</table>

</form>

<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';

