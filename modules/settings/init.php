<?php
/**
 * Initialization routines for the MythWeb settings module
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/

// The settings module is always enabled.
    $Modules['settings'] = array('path'        => 'settings',
                                 'sort'        => 999,
                                 'name'        => t('Settings'),
                                 'description' => t('settings'),
                                 'links'       => array('session'   => t('MythWeb session settings'),
                                                        'mythweb'   => t('MythTV global defaults'),
                                                        'channels'  => t('MythTV channel info'),
                                                        'keys'      => t('MythTV key bindings'),
                                                        'settings'  => t('MythTV settings table'),
                                                       ),
                                );
