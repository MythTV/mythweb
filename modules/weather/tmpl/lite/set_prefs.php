<?php
/**
 * Display/save MythWeather settings
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Weather
 *
/**/
?>

<form class="form" method="post" action="<?php echo form_action ?>">
<input type="hidden" name="host" value="<?php echo html_entities($_SESSION['settings']['host']) ?>" />

<table border="0" cellspacing="0" cellpadding="5">
<tr>
    <td class="command_border_b" align="right"><?php echo t('Locale') ?>:</td>
    <td class="command_border_b"><?php locale_select() ?></td>
</tr><tr>
    <td class="command_border_b" align="right"><?php echo t('SI Units') ?>:</td>
    <td class="command_border_b"><?php unit_select() ?></td>
</tr><tr>
    <td align="center"><input type="reset" value="<?php echo t('Reset') ?>"></td>
    <td align="center"><input type="submit" name="save" value="<?php echo t('Save') ?>"></td>
</tr>
</table>

</form>
