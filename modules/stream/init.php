<?php
/**
 * Initialization routines for the MythWeb streaming module.
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
    $Modules['stream'] = array('path'        => 'stream',
                               'hidden'      => true,
                               'name'        => t('Streaming'),
                              );

