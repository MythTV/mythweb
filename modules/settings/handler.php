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
    if ($Path[1])
        require_once 'modules/settings/'.$Path[1].'.php';

// Otherwise, just show the settings index page
    require_once tmpl_dir.'overview.php';
