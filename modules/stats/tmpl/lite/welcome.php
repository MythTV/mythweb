<?php
/**
 * Welcome page description of the status module.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Stats
 *
/**/

// Open with a div and an image
    echo '<div id="info_stats">',
         '<p>',
         '<a href="', Modules::getModuleProperty('stats', 'path'), '">',
         '<img src="', skin_url, '/img/stats.png" class="module_icon" border="0" />',
         '<h2>', Modules::getModuleProperty('stats', 'name'), '</h2></a>',
         '</p>',

// Print a basic overview of what this module does
         t('welcome: stats'),

// Close the div
         "</div>\n";
