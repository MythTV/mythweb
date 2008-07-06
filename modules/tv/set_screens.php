<?php
/**
 * Display/save MythWeb session settings
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

    $Screens = array('upcoming recordings'  => array('title', 'channel', 'airdate', 'record date', 'length'),
                    );

// Save?
    if ($_POST['save']) {
        foreach(array_keys($Screens) as $key)
            $_SESSION['settings']['screens']['tv'][$key] = $_POST[str_replace(' ', '_', $key)];
    }
