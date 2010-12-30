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
    echo '<div id="info_status" class="hidden">',
         '<img src="', skin_url, '/img/status.png" class="module_icon" alt="">',

// Print a basic overview of what this module does
         t('welcome: status'),

// Close the div
         "</div>\n";
