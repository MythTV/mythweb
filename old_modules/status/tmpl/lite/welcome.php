<?php
/**
 * Welcome page description of the status module.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Open with a div and an image
    echo '<div id="info_status">',
         '<p>',
         '<a href="', root_url, Modules::getModuleProperty('status', 'path'), '">',
         '<img src="', skin_url, '/img/status.png" class="module_icon" border="0" />',
         '<h2>', Modules::getModuleProperty('status', 'name'), '</h2></a>',
         '</p>',

// Print a basic overview of what this module does
         t('welcome: status'),

// Close the div
         "</div>\n";
