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

// Check to see if database logging has been enabled
    $enabled = $db->query_col('SELECT SUM(data) FROM settings WHERE value="LogEnabled"');

// The TV module is always enabled.
    if ($enabled > 0)
        $Modules['backend_log'] = array('path'        => 'backend_log',
                                        'name'        => t('Backend Logs'),
                                       );

