<?php
/**
 * Initialization routines for the MythWeb TV module
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

// First, we should check to see that MythWeather is configured.
    $has_weather = true;


// If weather is enabled, add it to the list.
    if ($has_weather)
        $Modules['weather'] = array('path'        => 'weather',
                                    'name'        => t('Weather'),
                                    'description' => t('')
                                   );

