<?php
/**
 * Initialization routines for the MythWeb Weather module
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Weather
 *
/**/

// First, we should check to see that MythWeather is configured.
    $has_weather = $db->query_col('SELECT COUNT(data) FROM settings WHERE value="locale"');

// If weather is enabled, add it to the list.
    if ($has_weather) {
        # This isn't quite ready yet
        #$Settings['weather'] = array('name'    => t('Weather'),
        #                             'choices' => array('prefs' => t('Preferences'),
        #                                               ),
        #                             'default' => 'prefs',
        #                            );
        $Modules['weather'] = array('path'        => 'weather',
                                    'sort'        => 4,
                                    'name'        => t('Weather'),
                                    'description' => t('Local weather forecast')
                                   );
    }
