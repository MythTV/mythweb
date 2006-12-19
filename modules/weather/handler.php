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

// Load the weather classes
    require_once 'includes/objects/WeatherSite.php';
    require_once 'includes/objects/Forecast.php';

// Default unit preference is not metric
    if (empty($_SESSION['weather']['siunits'])) {
        $_SESSION['weather']['siunits'] = 'NO';
    }

/**
 * @global  array   $GLOBALS['Weather_Types']
 * @name    $Weather_Types
/**/
    global $Weather_Types;
    $Weather_Types = array();

// Load the weather data
    foreach (file(modules_path.'/'.module.'/weathertypes.dat') as $line) {
        list($id, $name, $img) = explode(',', $line);
        $Weather_Types[$id] = array($img, $name);
    }

/**
 * @global  array   $GLOBALS['WeatherSites']
 * @name    $WeatherSites
/**/
    global $WeatherSites;
    $WeatherSites = array();

// Build a list of the known weather sites, starting with the session prefs
    if ($_SESSION['weather']['locale'])
        $WeatherSites[$_SESSION['weather']['locale']] = new WeatherSite($_SESSION['weather']['locale'],
                                                                        t('MythWeb Session'),
                                                                        $_SESSION['weather']['siunits']);
// Pull from the database next
    $sh = $db->query('SELECT data, hostname FROM settings WHERE value="locale"');
    while (list($locale, $host) = $sh->fetch_row()) {
    // New data site
        if (empty($WeatherSites[$locale])) {
            $siunits = $db->query_col('SELECT data
                                         FROM settings
                                        WHERE value="SIUnits" AND hostname=?',
                                      $host);
            $WeatherSites[$locale] = new WeatherSite($locale, $host, $siunits);
        }
    // Add the hostname to sites we've already seen
        else {
            $WeatherSites[$locale]->hosts[] = $host;
        }

    }
    $sh->finish();

// Print the weather page template
    require_once tmpl_dir.'weather.php';

// Exit
    exit;

