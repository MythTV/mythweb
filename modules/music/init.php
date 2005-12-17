<?php
/**
 * Initialization routines for the MythWeb Music module
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Music
 *
/**/

// First, we should check to see that MythMusic is configured.
    $has_music = $db->query_col('SELECT COUNT(*) FROM musicmetadata');

// If music is enabled, add it to the list.
    if ($has_music)
        $Modules['music'] = array('path'        => 'music',
                                  'name'        => t('Music'),
                                  'description' => t('')
                                 );

