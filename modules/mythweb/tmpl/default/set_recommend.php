<?php
/**
 * Configure MythWeb Recommendation settings
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/
?>

<form class="form" method="post" action="<?php echo form_action ?>">

<table border="0" cellspacing="0" cellpadding="0">

<tr>
    <th><?php echo t('Enable') ?>:</th>
    <td>
		<input class="radio"
			   type="checkbox"
			   name="recommend_enabled"
			   title="<?php echo t('Enable') ?>"
			   <?php if (setting('recommend_enabled')) echo ' CHECKED'; ?>>
	</td>
</tr>

<tr>
    <th><?php echo t('API Server') ?>:</th>
    <td>
		<input type="text"
			   name="recommend_server"
			   title="<?php echo t('API Server') ?>"
			   value="<?php echo html_entities(setting('recommend_server')) ?>" />
	</td>
</tr>

<tr>
    <th><?php echo t('API Key') ?>:</th>
    <td>
		<input type="text"
			   name="recommend_key"
			   title="<?php echo t('API Server') ?>"
			   value="<?php echo html_entities(setting('recommend_key')) ?>" />
	</td>
</tr>

<tr>
    <td align="right"><input type="reset"  class="submit" value="<?php echo t('Reset') ?>"></td>
    <td align="center"><input type="submit" class="submit" name="save" value="<?php echo t('Save') ?>"></td>
</tr>

</table>

</form>
