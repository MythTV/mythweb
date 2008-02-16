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

// Load the sorting routines
    require_once 'includes/sorting.php';

// Load the recordings
    global $Schedules;

// Parse the recording list
    $the_schedules = array();
    foreach ($Schedules as $key => $schedule) {
    // Ignore overrides
    #    if ($schedule->type == rectype_override)
    #        continue;
    #    if ($schedule->type == rectype_dontrec)
    #        continue;
    // Ignore manual schedules
    #    if ($schedule->category == 'Manual recording')
    #        continue;
    // Couple of modifications
        if ($schedule->type == rectype_dontrec) {
            $Schedules[$key]->profile  = '';
            $Schedules[$key]->recgroup = '';
        }
    // Add this show
        $the_schedules[] =& $Schedules[$key];
    }

// Sort the recordings
    if (count($the_schedules))
        sort_programs($the_schedules, 'schedules_sortby');

// Load the class for this page
    require_once tmpl_dir.'schedules.php';

// Exit
    exit;

