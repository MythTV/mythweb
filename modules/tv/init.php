<?php
/**
 * Initialization routines for the MythWeb TV module.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

    $Settings['tv'] = array('name'    => t('TV'),
                            'choices' => array('session'    => t('My Session'),
                                               'channels'   => t('Channel Info'),
                                               'playgroup'  => t('Playback Groups'),
                                               'screens'    => t('Customize Screens'),
                                              ),
                            'default' => 'session',
                           );

// The TV module is always enabled.
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
