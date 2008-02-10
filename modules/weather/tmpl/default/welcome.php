<?php
/**
 * Welcome page description of the Weather module.
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

// Open with a div and an image
    echo '<div id="info_weather" class="hidden">',
         '<img src="', skin_url, '/img/weather.png" class="module_icon" />',

// Print a basic overview of what this module does
         t('welcome: weather'),

// Next, print a list of possible subsectons
    ####

// Close the div
         "</div>\n";
