<?php
/**
 * Initialization routines for the MythWeb TV module.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

    $db->disable_fatal_errors();
    $has_tv = $db->query_col('SELECT COUNT(*) FROM channel WHERE visible=1');
    $db->enable_fatal_errors();
    $db->error(false);

// If TV is enabled, add it to the list.
    if ($has_tv) {

        $Settings['tv'] = array('name'    => t('TV'),
                                'choices' => array('session'    => t('My Session'),
                                                   'channels'   => t('Channel Info'),
                                                   'playgroup'  => t('Playback Groups'),
                                                   'screens'    => t('Customize Screens'),
                                                  ),
                                'default' => 'session',
                               );

        $Modules['tv'] = array('path'        => 'tv',
                               'sort'        => 1,
                               'name'        => t('TV'),
                               'links'       => array('list'             => t('Program Listing'),
                                                      'searches'         => t('Special Searches'),
                                                      'upcoming'         => t('Upcoming Recordings'),
                                                      'schedules'        => t('Recording Schedules'),
                                                      'schedules/manual' => t('Schedule Manually'),
                                                      'schedules/custom' => t('Custom Schedule'),
                                                      'recorded'         => t('Recorded Programs'),
                                                     ),
                              );

    }
