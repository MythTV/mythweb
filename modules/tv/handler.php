<?php
/**
 * Handler for all MythWeb TV routines
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

// Load the tv-related libraries
    require_once "includes/channels.php";
    require_once "includes/programs.php";
    require_once "includes/recording_schedules.php";

// Unknown section?  Use the default
    if (!in_array($Path[1], array('detail', 'channel'))
            && empty($Modules['tv']['links'][$Path[1]]))
        $Path[1] = 'list';

// Show the requested section
    require_once 'modules/tv/'.$Path[1].'.php';