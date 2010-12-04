<?php
/**
 * Initialization routines for the MythWeb Music module
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Music
 *
/**/

// First, we should check to see that MythMusic is configured.
// Make sure to turn off fatal errors in case the table isn't there.
    $db->disable_fatal_errors();
    $has_music = $db->query_col('SELECT COUNT(*) FROM music_songs');
    $db->enable_fatal_errors();
    $db->error(false);

// If music is enabled, add it to the list.
    if ($has_music && tmpl == 'default') {
        $Modules['music'] = array('path'        => 'music',
                                  'sort'        => 2,
                                  'name'        => t('Music'),
                                  'description' => t('')
                                 );
    }

