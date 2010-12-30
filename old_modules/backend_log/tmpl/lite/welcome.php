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
    echo '<div id="info_backend_log">',
         '<p>',
         '<a href="', root_url, Modules::getModuleProperty('backend_log', 'path'), '">',
         '<img src="', skin_url, '/img/backend_log.png" class="module_icon" border="0" />',
         '<h2>', Modules::getModuleProperty('backend_log', 'name'), '</h2></a>',
         '</p>',

// Print a basic overview of what this module does
         t('welcome: backend_log'),

// Close the div
         "</div>\n";
