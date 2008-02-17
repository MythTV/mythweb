<?php
/**
 * Handler for the Weather module.
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

    $WeatherScreens = array();

// Get configured WeatherScreens from the database
    $sh = $db->query('SELECT screen_id, draworder 
                      FROM weatherscreens
                      WHERE hostname=?',
                      $_SESSION['settings']['host']);

    while(list($screen_id, $draworder) = $sh->fetch_row()) {
        $WeatherScreens[$draworder] = new WeatherScreen($screen_id);
        $WeatherScreens[$draworder]->getData();
    }

    ksort($WeatherScreens);
    $sh->finish();

// Print the weather page template
    require_once tmpl_dir.'weather.php';

// Exit
    exit;

