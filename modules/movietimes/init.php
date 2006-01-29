<?php
/**
 * Initialization routines for the MythWeb Movie Times module
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  MovieTimes
 *
/**/

// First, we should check to see that the movie times plugin is configured.
    $has_movietimes = false;

// If video is enabled, add it to the list.
    if ($has_movietimes)
        $Modules['movietimes'] = array('path'        => 'movietimes',
                                       'name'        => t('Movie Times'),
                                       'description' => t('')
                                      );

