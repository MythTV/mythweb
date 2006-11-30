<?php
/**
 * Welcome page description of the Music module.
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
    echo '<div id="info_music">',
         '<p>',
         '<a href="', root, $Modules['music']['path'], '">',
         '<img src="', skin_url, '/img/music.png" class="module_icon" border="0" />',
         '<h2>', $Modules['music']['name'], '</h2></a>',
         '</p>',

// Print a basic overview of what this module does
         t('welcome: music'),

// Next, print a list of possible subsectons
    ####

// Close the div
         "</div>\n";