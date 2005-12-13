<?php
/**
 * Handler for all MythWeb Settings routines
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/

// Unknown section?
    if (empty($Modules['settings']['links'][$Path[1]]))
        $Path[1] = NULL;

// Show the requested section
    require_once 'modules/settings/'.$Path[1].'.php';