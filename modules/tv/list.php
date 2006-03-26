<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See README and LICENSE for details.
 *
 * This is the default viewing mode, and shows the current program listings.
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

// Were we passed a timestamp?  This is going to be the most common occurrence
    if ($_GET['time'])
        $list_starttime = intVal($_GET['time']);
    elseif(isset($_GET['daytime']))
        $list_starttime = unixtime(sprintf('%08d%04d00', $_GET['date'], $_GET['daytime']));
// Did we get passed a date (and probably an hour, too)?
    elseif(isset($_GET['date']))
        $list_starttime = unixtime(sprintf('%08d%02d0000', $_GET['date'], $_GET['hour']));
// Default value - just use the current time
    else
        $list_starttime = time();

// Round *back* to the nearest timeslot size
    $list_starttime -= $list_starttime % (timeslot_size * timeslot_blocks);

// Setup the time slots
    $list_endtime = $list_starttime;
    $Timeslots = array();
    for ($i = 0; $i < num_time_slots; $i++) {
        $Timeslots[]  = $list_endtime;
        $list_endtime += timeslot_size; // skip to the next timeslot
    }

// Set a session variable so other sections know how to get back to this particular page
    $_SESSION['list_time'] = $list_starttime;

// Populate the $Channels array
    load_all_channels();

// Load all relevant program information for all channels
    load_all_program_data($list_starttime, $list_endtime);

// Load the class for this page
    require_once tmpl_dir.'list.php';

