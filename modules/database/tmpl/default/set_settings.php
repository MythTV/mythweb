<?php
/**
 *
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/modules/mythtv/tmpl/default/set_settings.php $
 * @date        $Date: 2006-12-31 02:41:16 -0800 (Sun, 31 Dec 2006) $
 * @version     $Revision: 12359 $
 * @author      $Author: xris $
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
