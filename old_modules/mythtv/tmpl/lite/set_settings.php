<?php
/**
 * Configure MythTV Settings table
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/
?>
<form class="form" method="post" action="<?php echo form_action ?>">
<input type="hidden" name="host" value="<?php echo html_entities($_SESSION['settings']['host']) ?>" />

<table border="0" cellpadding="4" cellspacing="2" class="list small" align="center">
<tr class="menu" align="center">
    <td><?php echo t('Value') ?></td>
    <td><?php echo t('Data') ?></td>
    <td><?php echo t('Delete') ?></td>
</tr><?php
    foreach ($MythSettings as $value => $data) {
?><tr class="settings">
    <td align="right"><?php echo html_entities($value) ?></td>
    <td><input type="text" size="64" name="settings[<?php echo html_entities($value) ?>]" value="<?php echo html_entities($data) ?>"></td>
    <td><input type="checkbox" name="delete[<?php echo html_entities($value) ?>]" value="1"></td>
</tr><?php
    }
?>
</table>

<p align="center">
<input type="submit" name="save" value="<?php echo t('Save') ?>">
</p>

</form>

