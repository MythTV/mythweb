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

// The TV module is always enabled.
    $Modules['tv'] = array('path'        => 'tv',
                           'name'        => t('TV'),
                           'links'       => array('listing'   => t('Program Listing'),
                                                  'searches'  => t('Special Searches'),
                                                  'upcoming'  => t('Upcoming Recordings'),
                                                  'schedules' => t('Recording Schedules'),
                                                  'recorded'  => t('Recorded Programs'),
                                                 ),
                          );

