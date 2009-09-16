<?php
/**
 * View all recording schedules
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

// Scheduling a manual recording gets its own page
    if ($Path[2] == 'manual' || $Path[2] == 'custom') {
        require_once 'modules/tv/schedules_'.$Path[2].'.php';
        exit;
    }

    $the_schedules = Schedule::findAll();

// Load the class for this page
    require_once tmpl_dir.'schedules.php';

// Exit
    exit;
