<?php
/**
 * Display/save MythWeb session settings
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/

    $Screens = array('upcoming recordings'  => array('title', 'original airdate', 'episode number', 'channel', 'recording group', 'airdate', 'record date', 'length'),
                    );

// Save?
    if ($_POST['save']) {
        foreach(array_keys($Screens) as $key)
            $_SESSION['settings']['screens']['tv'][$key] = $_POST[str_replace(' ', '_', $key)];
    }
