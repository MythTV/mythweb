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

<table border="0" cellspacing="0" cellpadding="0">
<tr class="-sep">
    <th><?php echo t('Locale') ?>:</th>
    <td><?php locale_select() ?></td>
</tr><tr class="-sep">
    <th><?php echo t('SI Units') ?>:</th>
    <td><?php unit_select() ?></td>
</tr><tr>
    <td align="center"><input type="reset" class="submit" value="<?php echo t('Reset') ?>"></td>
    <td align="center"><input type="submit" class="submit" name="save" value="<?php echo t('Save') ?>"></td>
</tr>
</table>

</form>
