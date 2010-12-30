<?php
/**
 * Initialization routines for the MythWeb Status module
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Status
 *
/**/

// The TV module is always enabled.
    $Modules['status'] = array('path'        => 'status',
                               'sort'        => 500,
                               'name'        => t('Status'),
                          );

