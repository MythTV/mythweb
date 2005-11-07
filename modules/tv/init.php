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

// The TV module is always enabled.
    $Modules['tv'] = array('path'        => 'tv',
                           'name'        => t('TV'),
                           'description' => t('See what\'s on tv, schedule recordings and manage shows that you\'ve already recorded.')
                          );

