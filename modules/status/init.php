<?php
/**
 * Initialization routines for the MythWeb Status module
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Status
 *
/**/

// The TV module is always enabled.
    $Modules['status'] = array('path'        => 'status',
                               'name'        => t('Status'),
                          );

