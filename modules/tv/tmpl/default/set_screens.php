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

<table border="0" cellspacing="0" cellpadding="0">
<tr>
    <fieldset>
        <legend><?php echo t('Upcoming Recordings'); ?></legend>
        <?php
            foreach (array('title', 'channel', 'airdate', 'record date', 'length') as $option) {
                echo '<input type="checkbox" name="upcoming['.$option.']" id="upcoming['.$option.']" ';
                if ($_SESSION['tv']['settings']['screens']['upcoming'][$option] == 'on')
                    echo 'checked';
                echo '> <label for="upcoming['.$option.']">'.t(ucwords($option)).'</label><br />';
            }
            ?>
    </fieldset>
</tr>
<tr>
    <td align="center"><input type="reset" value="<?php echo t('Reset') ?>"></td>
    <td align="center"><input type="submit" name="save" value="<?php echo t('Save') ?>"></td>
</tr>
</table>

</form>
