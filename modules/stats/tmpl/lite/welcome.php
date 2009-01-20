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
 * @subpackage  Stats
 *
/**/

// Open with a div and an image
    echo '<div id="info_stats">',
         '<p>',
         '<a href="', root, Modules::getModuleProperity('stats', 'path'), '">',
         '<img src="', skin_url, '/img/stats.png" class="module_icon" border="0" />',
         '<h2>', Modules::getModuleProperity('stats', 'name'), '</h2></a>',
         '</p>',

// Print a basic overview of what this module does
         t('welcome: stats'),

// Close the div
         "</div>\n";
