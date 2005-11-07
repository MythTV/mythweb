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

// First, we should check to see that MythVideo is configured.
    $has_video = true;


// If video is enabled, add it to the list.
    if ($has_video)
        $Modules['movietimes'] = array('path'        => 'movietimes',
                                       'name'        => t('Movie Times'),
                                       'description' => t('')
                                      );

