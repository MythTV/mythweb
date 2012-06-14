<?php
/**
 * View all recording schedules
 *
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


// Parse the recording list
    $the_schedules = array();
    foreach (Schedule::findAll() as $key) {
        $schedule = &Schedule::find($key);
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
            $schedule->profile  = '';
            $schedule->recgroup = '';
        }
    // Add a blank channel, to suppress warnings
        if (!$schedule->channel) {
            $schedule->channel = Channel::find(null);
        }
    // Add this show
        $the_schedules[] = &$schedule;
    }

// Remove the reference. This prevents duplicate entries showing up in the list
    unset($schedule);

// Sort the recordings
    if (count($the_schedules))
        sort_programs($the_schedules, 'schedules_sortby');

// Load the class for this page
    require_once tmpl_dir.'schedules.php';

// Exit
    exit;
