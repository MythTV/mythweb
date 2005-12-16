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
    if ($has_weather)
        $Modules['weather'] = array('path'        => 'weather',
                                    'name'        => t('Weather'),
                                    'description' => t('')
                                   );

