<?php
/**
 * Welcome page description of the Settings module.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/

// Open with a div and an image
    echo '<div id="info_settings" class="hidden">',
         '<img src="', skin_url, '/img/settings.png" class="module_icon" alt="">',

// Print a basic overview of what this module does
         t('welcome: settings'),

// Next, print a list of possible subsectons
         '<ul>';
    foreach ($Settings as $module => $set) {
        echo '    <li><a href="', root_url, Modules::getModuleProperty('settings', 'path'), '/', $module, '">', $set['name'], "</a>\n";
        if (count($set['choices']) > 1) {
            echo "        <ul>\n";
            foreach ($set['choices'] as $section => $name) {
                echo '            <li><a href="', root_url, Modules::getModuleProperty('settings', 'path'), '/', $module, '/', $section, '">', $name, "</a></li>\n";
            }
            echo "        </ul>\n";
        }
        echo "</li>\n";
    }
    echo '</ul>',

// Close the div
         "</div>\n";
