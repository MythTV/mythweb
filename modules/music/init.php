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

// First, we should check to see that MythMusic is configured.
    $has_music = true;


// If music is enabled, add it to the list.
    if ($has_music)
        $Modules['music'] = array('path'        => 'music',
                                  'name'        => t('Music'),
                                  'description' => t('')
                                 );

