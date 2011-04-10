<?php
/**
 * Initialization routines for the MythWeb Stats module
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Stats
 *
/**/

    $enabled = $db->query_col('SELECT COUNT(*) FROM oldrecorded WHERE future = 0');

    if($enabled) {
        $Modules['stats'] = array('path' => 'stats',
                                  'sort' => 501,
                                  'name' => t('Statistics'),
                                 );
    }
