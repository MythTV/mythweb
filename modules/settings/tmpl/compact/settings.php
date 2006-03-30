<?php
/**
 * Configure MythTV Key Bindings
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


// Set the desired page title
    $page_title = 'MythWeb - '.t('Settings Table');

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

?>
<table align="center" width="40%" cellspacing="2" cellpadding="2">
<tr>
    <td width="50%" class="command command_border_l command_border_t command_border_b command_border_r" align="center">
        <form class="form" method="get" action="<?php echo root ?>settings/settings">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td nowrap align="center"><?php echo t('Edit settings for') ?>:&nbsp;&nbsp;</td>
                <td><select name="host"><?php
                    echo '<option value=""';
                    if (empty($_GET['host']))
                        echo ' SELECTED';
                    echo '> - '.t('Global').' - </option>';
                    foreach ($Hosts as $host) {
                        echo '<option value='.$host;
                        if ($host == $_GET['host'])
                            echo ' SELECTED';
                        echo '>'.$host.'</option>';
                    }
                    ?></select>
                    </td>
            <td align="center"><input type="submit" class="submit" value="<?php echo t('Set Host') ?>"></td>
        </tr>
        </table>
        </form>
        </td>
</tr>
</table>

<p class="error" style="width: 32em; margin: 1em auto; padding: 5px; text-align: center">
    This settings page has very little error checking yet. You can easily<br />
    screw things up if you're not careful, and short of restoring the<br />
    database from a backup, there is <b>no</b> way to undo your changes.
</p>

<form class="form" method="post" action="<?php echo root ?>settings/settings?host=<?php echo rawurlencode($_GET['host']) ?>">

<table border="0" cellpadding="4" cellspacing="2" class="list small" align="center">
<tr class="menu large" align="center">
    <td colspan="3"><?php echo t('Settings Table Editor') ?></td>
</tr><tr class="menu" align="center">
    <td><?php echo t('Value') ?></td>
    <td><?php echo t('Data') ?></td>
    <td><?php echo t('Delete') ?></td>
</tr><?php
    foreach ($Settings as $value => $data) {
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
<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';

