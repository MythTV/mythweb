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
    <td align="right"><?php echo t('Prefer Channum') ?>:</td>
    <td><input class="radio" type="checkbox" title="Prefer channel number over callsign." name="prefer_channum"<?php if ($_SESSION['prefer_channum']) echo ' CHECKED' ?>></td>
</tr><tr>
    <td class="command_border_t" align="center"><input type="reset" value="<?php echo t('Reset') ?>"></td>
    <td class="command_border_t" align="center"><input type="submit" name="save" value="<?php echo t('Save') ?>"></td>
</tr>
</table>

</form>

