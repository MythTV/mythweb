<?php
/**
 * Configure MythTV playback groups
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/
?>

<form id="chg_grp_form" class="form" method="post" action="<?php echo form_action ?>">

<table border="0" cellspacing="0" cellpadding="0">
<tr class="x-sep">
    <th><?php echo t('Edit existing group') ?>:</th>
    <td><?php playgroup_select($group['name'], 'playgroup', NULL, NULL, '$(\'chg_grp_form\').submit()') ?>
        <noscript><input type="submit" class="submit" value="<?php echo t('Edit') ?>"></noscript></td>
    <td><input type="submit" class="submit" name="new_group" value="<?php echo t('New Group') ?>"></td>
</tr>
</table>

</form>

<form id="save_grp_form" class="form" method="post" action="<?php echo form_action ?>">
    <input type="hidden" name="old_name" value="<?php echo html_entities($group['name']) ?>" />

<table border="0" cellspacing="0" cellpadding="0">
<tr>
    <th><?php echo t('Name') ?>:</th>
    <td colspan="2"><?php
        if ($group['name'] == 'Default')
            echo '<b>Default</b>';
        else
            echo '<input type="text" name="name" value="', html_entities($group['name']), '" maxlength="32" />';
        ?></td>
</tr><tr>
    <th><?php echo t('Title Match') ?>:</th>
    <td colspan="2"><input type="text" name="titlematch"  value="<?php echo html_entities($group['titlematch'])  ?>" /></td>
</tr><tr>
    <th><?php echo t('Skip Ahead') ?>:</th>
    <td colspan="2"><input type="text" name="skipahead"   class="quantity" value="<?php echo html_entities($group['skipahead'])   ?>" /></td>
</tr><tr>
    <th><?php echo t('Skip Back') ?>:</th>
    <td colspan="2"><input type="text" name="skipback"    class="quantity" value="<?php echo html_entities($group['skipback'])    ?>" /></td>
</tr><tr>
    <th><?php echo t('Time Stretch') ?>:</th>
    <td colspan="2"><input type="text" name="timestretch" class="quantity" value="<?php echo html_entities($group['timestretch']) ?>" /></td>
</tr><tr class="x-sep">
    <th><?php echo t('Jump') ?>:</th>
    <td colspan="2"><input type="text" name="jump"        class="quantity" value="<?php echo html_entities($group['jump'])        ?>" /></td>
</tr><tr align="center">
    <td><input type="reset"  class="submit" value="<?php echo t('Reset') ?>"></td>
    <td><input type="submit" class="submit" name="save" value="<?php echo t('Save') ?>"></td>
    <td><input type="submit" class="submit" name="delete" value="<?php echo t('Delete') ?>"></td>
</tr>
</table>

</form>

