<?php
/**
 * This is pretty much a dummy module to hold the settings sections that
 * pertain to Mythbackend and other things not actually present within MythWeb
 * itself.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
/**/

    $Settings['mythtv'] = array('name'    => t('MythTV'),
                                'choices' => array('settings' => t('Settings Table'),
                                                   'channels' => t('Channel Info'),
                                                   'keys'     => t('Key Bindings'),
                                                  ),
                                'default' => 'settings',
                               );

