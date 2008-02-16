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

// The stats module is always enabled.
    $Modules['stats'] = array('path' => 'stats',
                              'sort' => 501,
                              'name' => t('Statistics'),
                             );

