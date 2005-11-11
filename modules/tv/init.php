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
 *
/**/

// The TV module is always enabled.
    $Modules['tv'] = array('path'        => 'tv',
                           'name'        => t('TV'),
                           'links'       => array('list'      => t('Program Listing'),
                                                  'search'    => t('Search TV'),
                                                  'searches'  => t('Special Searches'),
                                                  'upcoming'  => t('Upcoming Recordings'),
                                                  'schedules' => t('Recording Schedules'),
                                                  'recorded'  => t('Recorded Programs'),
                                                 ),
                          );

