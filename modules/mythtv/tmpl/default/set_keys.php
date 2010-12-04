<?php
/**
 * Configure MythTV Key Bindings
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/
?>
<div class="error" style="padding: 5px">
<?php echo t('info:jumppoints') ?>
</div>

<form class="form" method="post" action="<?php echo form_action ?>">
<input type="hidden" name="host" value="<?php echo html_entities($_SESSION['settings']['host']) ?>" />

<table border="0" cellpadding="4" cellspacing="2" class="list small" align="center">
<tr class="menu large" align="center">
    <td colspan="3"><?php echo t('JumpPoints Editor') ?></td>
</tr><tr class="menu" align="center">
    <td width="33%"><?php echo t('Destination') ?></td>
    <td width="33%"><?php echo t('Description') ?></td>
    <td width="33%"><?php echo t('Key bindings') ?></td>
</tr><?php
    foreach ($Jumps as $jumppoint) {
?><tr class="settings" align="center">
    <td><?php echo html_entities($jumppoint['destination']) ?></td>
    <td><?php echo html_entities($jumppoint['description']) ?></td>
    <td><input type="text" size="35"
               name="jump[<?php echo html_entities($jumppoint['destination']) ?>]"
               value="<?php echo html_entities($jumppoint['keylist']) ?>"></td>
</tr><?php
    }
?>
</table>

<p></p>

<table border="0" cellpadding="4" cellspacing="2" class="list small" align="center">
<tr class="menu large" align="center">
        <td colspan="4"><?php echo t('Keybindings Editor') ?></td>
</tr><tr class="menu" align="center">
        <td width="15%"><?php echo t('Context')      ?></td>
        <td width="25%"><?php echo t('Action')       ?></td>
        <td width="40%"><?php echo t('Description')  ?></td>
        <td width="20%"><?php echo t('Key bindings') ?></td>
</tr><?php
    foreach ($Keys as $key) {
?><tr class="settings" align="center">
        <td><?php echo html_entities($key['context'])     ?></td>
        <td><?php echo html_entities($key['action'])      ?></td>
        <td><?php echo html_entities($key['description']) ?></td>
        <td><input type="text" size="25"
                   name="key[<?php echo html_entities($key['context']), '][', html_entities($key['action']) ?>]"
                   value="<?php echo html_entities($key['keylist']) ?>"></td>
</tr>
<?php
    }
?>
</table>

<p align="center">
<input type="submit" class="submit" name="save" value="<?php echo t('Save') ?>">
</p>

</form>

