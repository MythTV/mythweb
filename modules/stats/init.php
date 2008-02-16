<?php
/**
 * Initialization routines for the MythWeb Stats module
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Stats
 *
/**/

    $enabled = $db->query_col('SELECT COUNT(*) FROM oldrecorded');

    if($enabled) {
        $Modules['stats'] = array('path' => 'stats',
                                  'sort' => 501,
                                  'name' => t('Statistics'),
                                 );
    }
