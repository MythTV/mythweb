<?php
/**
 * Welcome page description of the TV module.
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
    echo '<div id="info_tv">',
         '<img src="', skin_url, '/img/tv.png" class="module_icon" />',

// Print a basic overview of what this module does
         t("See what's on tv, schedule recordings and manage shows that you've "
          ."already recorded.  Please see the following choices:"),

// Next, print a list of possible subsectons
         '<ul>',
         '    <li>', t('Program Listing'),     "</li>\n",
         '    <li>', t('Upcoming Recordings'), "</li>\n",
         '    <li>', t('Recording Schedules'), "</li>\n",
         '    <li>', t('Recorded Programs'),   "</li>\n",
         '</ul>',

// Close the div
         "</div>\n";