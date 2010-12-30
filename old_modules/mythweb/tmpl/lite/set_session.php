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
    <td class="command_border_b" align="right"><?php echo t('Default MythWeb Template') ?>:</td>
    <td class="command_border_b"><?php template_select('tmpl_default', $_SESSION['tmpl']) ?></td>
</tr><tr>
    <td class="command_border_b" align="right"><?php echo t('Current MythWeb Template') ?>:</td>
    <td class="command_border_b"><?php template_select('tmpl', tmpl) ?></td>
</tr><tr>
    <td class="command_border_b" align="right"><?php echo t('MythWeb Skin') ?>:</td>
    <td class="command_border_b"><?php skin_select() ?></td>
</tr><tr>
    <td class="command_border_b" align="right"><?php echo t('Language') ?>:</td>
    <td class="command_border_b"><?php language_select() ?></td>
</tr><tr>
    <td align="center"><input type="reset" value="<?php echo t('Reset') ?>"></td>
    <td align="center"><input type="submit" name="save" value="<?php echo t('Save') ?>"></td>
</tr>
</table>

</form>
