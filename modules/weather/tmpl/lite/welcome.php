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
 *
/**/

// Open with a div and an image
    echo '<div id="info_weather">',
         '<p>',
         '<a href="', root, $Modules['weather']['path'], '">',
         '<img src="', skin_url, '/img/weather.png" class="module_icon" border="0" />',
         '<h2>', $Modules['weather']['name'], '</h2></a>',
         '</p>',

// Print a basic overview of what this module does
         t('welcome: weather'),

// Next, print a list of possible subsectons
    ####

// Close the div
         "</div>\n";