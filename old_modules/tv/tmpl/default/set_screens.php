<?php
/**
 * Configure MythWeb Session info
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/
?>

<form class="form" method="post" action="<?php echo form_action ?>">
    <?php
        foreach ($Screens as $screen => $options) {
            ?>
                <fieldset style="margin: 1em;">
                    <legend><?php echo t(ucwords($screen)); ?></legend>
                    <?php
                        foreach($options as $option) {
                            echo '<input type="checkbox" name="'.$screen.'['.$option.']" id="'.$screen.'['.$option.']" ';
                            if ($_SESSION['settings']['screens']['tv'][$screen][$option] == 'on')
                                echo 'checked';
                            echo '> <label for="'.$screen.'['.$option.']">'.t(ucwords($option)).'</label><br />';
                        }
                    ?>
                </fieldset>
            <?php
        }
    ?>

    <div style="width: 100%; padding-top: 2em; clear: both; text-align: center;">
        <input class="submit" type="reset" value="<?php echo t('Reset') ?>">
        &nbsp;
        <input class="submit" type="submit" name="save" value="<?php echo t('Save') ?>">
    </div>

</form>
