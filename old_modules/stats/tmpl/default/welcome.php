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
    echo '<div id="info_stats" class="hidden">',
         '<img src="', skin_url, '/img/stats.png" class="module_icon" alt="">',

// Print a basic overview of what this module does
         t('welcome: stats'),

// Close the div
         "</div>\n";
