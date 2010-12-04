<?php
/**
 * Initialization routines for the MythWeb settings module
 *
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
                                );
