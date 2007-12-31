<?php
/**
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
<form class="form" method="post" action="<?php echo form_action; ?>">

<h3>Actions</h3>

<p align="center">
<input class="submit" type="submit" name="action" value="<?php echo t('Optimize Tables'); ?>">
<input class="submit" type="submit" name="action" value="<?php echo t('Repair Tables'); ?>">
<input class="submit" type="submit" name="action" value="<?php echo t('Extended Check'); ?>">
</p>

<h3>Status</h3>

<table border="0" cellpadding="4" cellspacing="2" class="list small" align="center">
<tr class="menu" align="center">
    <td><?php echo t('Name'); ?></td>
    <td><?php echo t('Status'); ?></td>
</tr><?php
    foreach ($Tables as $table_name => $table ) {
?><tr class="settings">
    <td><?php echo $table_name; ?></td>
    <td><?php echo $table['check']['Msg_text']; ?></td>
</tr><?php
    }
?>
</table>

</form>
