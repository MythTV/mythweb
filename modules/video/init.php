<?php
/**
 * Initialization routines for the MythWeb Video module
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Video
 *
/**/

// First, we should check to see that MythVideo is configured.
// Make sure to turn off fatal errors in case the table isn't there.
    $db->disable_fatal_errors();
    $has_video = $db->query_col('SELECT COUNT(*) FROM videometadata');
    $db->enable_fatal_errors();

// If video is enabled, add it to the list.
    if ($has_video)
        $Modules['video'] = array('path'        => 'video',
                                  'name'        => t('Video'),
                                  'description' => t('')
                                 );

