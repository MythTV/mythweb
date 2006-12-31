<?php
/**
 * Configure MythWeb Session info
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

<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
    <td class="command_border_b" align="right"><?php echo t('MythWeb Template') ?>:</td>
    <td class="command_border_b"><?php template_select() ?></td>
</tr><tr>
    <td class="command_border_b" align="right"><?php echo t('MythWeb Skin') ?>:</td>
    <td class="command_border_b"><?php skin_select() ?></td>
</tr><tr>
    <td class="command_border_b" align="right"><?php echo t('Language') ?>:</td>
    <td class="command_border_b"><?php language_select() ?></td>
</tr><tr>
    <td align="center"><input type="reset"  class="submit" value="<?php echo t('Reset') ?>"></td>
    <td align="center"><input type="submit" class="submit" name="save" value="<?php echo t('Save') ?>"></td>
</tr>
</table>

</form>

