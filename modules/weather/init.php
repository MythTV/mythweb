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

// Settings options
    $Settings['weather'] = array('name'    => t('Weather'),
                                 'choices' => array('prefs'  => t('Preferences'),
                                                   ),
                                 'default' => 'prefs',
                                );

// First, we should check to see that MythWeather is configured.
    $has_weather = $_SESSION['locale']
                    ? true
                    : $db->query_col('SELECT COUNT(data)
                                        FROM settings
                                       WHERE value="locale"');



// If weather is enabled, add it to the list.
    if ($has_weather) {
        $Modules['weather'] = array('path'        => 'weather',
                                    'sort'        => 4,
                                    'name'        => t('Weather'),
                                    'description' => t('Local weather forecast')
                                   );
    }
