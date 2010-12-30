<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See README and LICENSE for details.
 *
 * This is the default viewing mode, and shows the current program listings.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Were we passed a timestamp?  This is going to be the most common occurrence
    if ($_REQUEST['time'])
        $list_starttime = intVal($_REQUEST['time']);
    elseif(isset($_REQUEST['daytime']))
        $list_starttime = unixtime(sprintf('%08d%04d00', $_REQUEST['date'], $_REQUEST['daytime']));
// Did we get passed a date (and probably an hour, too)?
    elseif(isset($_REQUEST['date']))
        $list_starttime = unixtime(sprintf('%08d%02d0000', $_REQUEST['date'], $_REQUEST['hour']));
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

// Are we an ajax request?
    if ($_REQUEST['ajax'])
        require_once tmpl_dir.'list_data.php';
    else
        require_once tmpl_dir.'list.php';

/**
 * Prints a <select> of the available hour range
/**/
    function hour_select($params = '') {
        global $list_starttime;
        echo "<select name=\"hour\" $params>";
        for ($h=0;$h<24;$h++) {
            echo '<option value="'.mktime($h,0,0, date('m', $list_starttime), date('d', $list_starttime), date('Y', $list_starttime)).'"';
            if ($h == date('H', $list_starttime))
                echo ' SELECTED';
            echo '>'.strftime($_SESSION['time_format'], strtotime("$h:00")).'</option>';
        }
        echo '</select>';
    }

/**
 * Prints a <select> of the available date range
/**/
    function date_select($params = '') {
        global $db;
        global $list_starttime;
    // Get the available date range
        $min_days = max(-7, $db->query_col('SELECT TO_DAYS(min(starttime)) - TO_DAYS(NOW()) FROM program'));
        $max_days = min(30, $db->query_col('SELECT TO_DAYS(max(starttime)) - TO_DAYS(NOW()) FROM program'));
    // Print out the list
        echo "<select name=\"date\" $params>";
        for ($i=$min_days; $i<=$max_days; $i++) {
            $time = mktime(date('G', $list_starttime),0,0, date('m'), date('d') + $i, date('Y'));
            echo "<option value=\"$time\"";
            if ( date('Ymd', $time) == date('Ymd', $list_starttime))
                echo ' SELECTED';
            echo '>'.strftime($_SESSION['date_listing_jump'] , $time).'</option>';
        }
        echo '</select>';
    }
