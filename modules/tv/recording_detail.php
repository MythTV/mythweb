<?php
/**
 * view and manipulate recorded programs.
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

// Use the new directory structure?
    if (!$_GET['chanid'] && !$_GET['starttime']) {
        $_GET['chanid']    = $Path[2];
        $_GET['starttime'] = $Path[3];
    }

// Just in case
    $_GET['chanid']    = intVal($_GET['chanid']);
    $_GET['starttime'] = intVal($_GET['starttime']);

// Pull only this program
    $record = get_backend_rows('QUERY_RECORDING TIMESLOT '.$_GET['chanid'].' '.unix2mythtime($_GET['starttime']), 1);
    if (is_array($record[0]) && $_GET['chanid'] == $record[0][4] && $_GET['starttime'] == $record[0][26])
        $program =& new Program($record[0]);
// No program found -- back to the recordings list
    else
        redirect_browser(root.'tv/recorded');

// Load the class for this page
    require_once tmpl_dir.'recording_detail.php';

// Exit
    exit;
