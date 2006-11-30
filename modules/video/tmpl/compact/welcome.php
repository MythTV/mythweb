<?php
/**
 * Welcome page description of the Video module.
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
    echo '<div id="info_video">',
         '<p>',
         '<a href="', root, $Modules['video']['path'], '">',
         '<img src="', skin_url, '/img/video.png" class="module_icon" border="0" />',
         '<h2>', $Modules['video']['name'], '</h2></a>',
         '</p>',

// Print a basic overview of what this module does
         t('welcome: video'),

// Next, print a list of possible subsectons
    ####

// Close the div
         "</div>\n";