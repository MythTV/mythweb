<?php
/**
 * Welcome page description of the Movie Times module.
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
    echo '<div id="info_movietimes" class="hidden">',
         '<img src="', skin_url, '/img/movietimes.png" class="module_icon" />',

// Print a basic overview of what this module does
         t("Get listings for movies playing at local theatres."),

// Next, print a list of possible subsectons
    ####

// Close the div
         "</div>\n";