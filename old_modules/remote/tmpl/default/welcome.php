<?php
/**
 * Welcome page description of the Remote Control module.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Remote
 *
/**/

// Open with a div and an image
    echo '<div id="info_remote" class="hidden">',
         '<img src="', skin_url, 'img/tv.png" class="module_icon" alt="">',

// Print a basic overview of what this module does
         t('welcome: remote'),

// Next, print a list of possible frontends
         '<ul>';
    foreach (Modules::getModuleProperty('remote', 'links') as $link => $name) {
        echo '    <li><a href="', Modules::getModuleProperty('remote', 'path'), '/', $link, '">', html_entities($name), "</a></li>\n";
    }
    echo '</ul>',

// Close the div
         "</div>\n";
