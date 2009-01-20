<?php
/**
 * Welcome page description of the status module.
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
    echo '<div id="info_status">',
         '<p>',
         '<a href="', root, Modules::getModuleProperity('status', 'path'), '">',
         '<img src="', skin_url, '/img/status.png" class="module_icon" border="0" />',
         '<h2>', Modules::getModuleProperity('status', 'name'), '</h2></a>',
         '</p>',

// Print a basic overview of what this module does
         t('welcome: status'),

// Close the div
         "</div>\n";
