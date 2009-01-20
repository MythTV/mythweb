<?php
/**
 * This is pretty much a dummy module to hold the settings sections that
 * pertain specifically to MythWeb.  It allows us to have a prettier URL when
 * editing, which integrating these into the settings module wouldn't.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
/**/

    $Settings['mythweb'] = array('name'    => t('MythWeb'),
                                 'choices' => array('session'   => t('My Session'),
                                                    'defaults'  => t('MythWeb Defaults'),
                                                    'flvplayer' => t('Video Playback'),
                                                   ),
                                 'default' => 'session',
                                );
