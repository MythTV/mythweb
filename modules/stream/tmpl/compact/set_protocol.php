<?php
/**
 * Configure MythWeb Music protocol preference
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

<div class="error" style="padding: 5px">
<?php echo t('settings/stream: protocol') ?>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
    <td class="command_border_b" align="right"><label for="force_http"><?php echo t('Force HTTP for streams') ?>:</label></td>
    <td class="command_border_b"><input type="checkbox" id="force_http" name="force_http" value="1"<?php if ($_SESSION['stream']['force_http']) echo ' CHECKED' ?>></td>
</tr><tr>
    <td align="center"><input type="reset" class="submit" value="<?php echo t('Reset') ?>"></td>
    <td align="center"><input type="submit" class="submit" name="save" value="<?php echo t('Save') ?>"></td>
</tr>
</table>

</form>