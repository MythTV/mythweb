<?php
/**
 * Initialization routines for the MythWeb Backend Logs module
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Logs
 *
/**/

    global $db;

// Check to see if database logging has been enabled
    $enabled = $db->query_col('SELECT SUM(data) FROM settings WHERE value="LogEnabled"');

// The TV module is always enabled.
    if ($enabled > 0)
        $Modules['backend_log'] = array('path'        => 'backend_log',
                                        'sort'        => 550,
                                        'name'        => t('Logs'),
                                       );
