<?php
/**
 * Display/save MythWeather Screen settings
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

<?php

// Edit screen ------------------------------------------------------------
if (isset($_SESSION['weather']['edit'])) {
    $screen = new WeatherScreen($_SESSION['weather']['edit']);
    $screen->getData();

    if (isset($_SESSION['weather']['search']))
        $screen->runSearch($_SESSION['weather']['search']);
?>

<form class="form" method="post" action="<?php echo form_action ?>">
<input type="hidden" name="host" value="<?php echo html_entities($_SESSION['settings']['host']) ?>">
<input type="hidden" name="edit" value="<?php echo $screen->screen_id ?>" />

<table border="0" cellspacing="0" cellpadding="0">
<tr>
    <td colspan="2"><?php echo t('Edit Screen') ?></td>
</tr>
<tr>
    <th>Screen Name</th>
    <td><?php echo $screen->container ?></td>
</tr>
<tr>
    <th>Location</th>
    <td><?php
            foreach($screen->data as $key => $value) {
                if (preg_match('/location/', $key)) { echo $value; break; }
                if (preg_match('/desc/', $key)) { echo $value; break; }
            }

        ?></td>
</tr>

<?php if (isset($_SESSION['weather']['search'])) { ?>
<tr>
    <th>Search Results</th>
    <?php if (count($screen->search)) { ?>
    <td><select name="weather_location" size="1"><?php
        foreach($screen->search as $key => $value) {
            foreach ($value as $location => $description) {
                echo '<option value="(('. $key .'))'. $location .'">('. $screen->getSource($key) .") ". htmlentities($description) ."</option>\n";
            }
        }
        ?></select>
    </td>
</tr>
<tr>
    <th><input type="checkbox" name="weather_use_results" id="use_results"></th>
    <td><label for="use_results">Use selected location</label></td>
</tr>
    <?php } else { ?>
    <td>Nothing found for &quot;<i><?php echo $_SESSION['weather']['search'] ?></i>&quot;</td>
    <?php } } ?>
</tr>
<tr>
    <th>Change Location</th>
    <td><input type="text" name="weather_search" size="15" value="<?php echo $_SESSION['weather']['search'] ?>"> <input type="submit" class="submit" name="edit_search" value="<?php echo t('Search') ?>"></td>
</tr>
<tr>
    <th>Units</th>
    <td><select name="weather_units">
            <option value="0" <?php echo $screen->units == 0 ? 'SELECTED' : '' ?>>SI</option>
            <option value="1" <?php echo $screen->units == 1 ? 'SELECTED' : '' ?>>English</option>
        </select>
    </td>
</tr>
<tr>
    <th></th>
    <td>
        <input type="submit" class="submit" name="save_edit" value="<?php echo t('Save') ?>">
        <input type="submit" class="submit" name="cancel_edit" value="<?php echo t('Cancel') ?>">
    </td>
</tr>
</table>

</form>

<?php // Define screens ----------------------------------------------------------
} else {
?>

<form class="form" method="post" action="<?php echo form_action ?>">
<input type="hidden" name="host" value="<?php echo html_entities($_SESSION['settings']['host']) ?>" />

<table border="0" cellspacing="0" cellpadding="0">
<tr>
    <td colspan="2"><?php echo t('Inactive Screens') ?></td>
</tr>
<tr class="x-sep">
    <td> <?php display_inactive_screens() ?> </td>
    <?php if (count($_SESSION['weather']['inactive']) > 0) { ?>
    <td><input type="submit" class="submit" name="add" value="<?php echo t('Add To Active Screens') ?>"></td>
    <?php } ?>
</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0">
<tr>
    <td colspan="2"><?php echo t('Active Screens') ?></td>
</tr>
<tr>
    <td><?php display_active_screens() ?></th>
    <td>
        <table border="0" cellspacing="0" cellpadding="0">
            <tr><td><input type="submit" class="submit" name="move_u" value="<?php echo t('Up') ?>"></td></tr>
            <tr><td><input type="submit" class="submit" name="move_d" value="<?php echo t('Down') ?>"></td></tr>
            <tr><td><input type="submit" class="submit" name="edit" value="<?php echo t('Edit') ?>"></td></tr>
            <tr><td><input type="submit" class="submit" name="delete" value="<?php echo t('Delete') ?>"></td></tr>
        </table>
    </td>
</tr>
</table>

</form>
<?php }
