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

// Parse the program list
    $program = null;
    foreach (get_backend_rows('QUERY_RECORDINGS Delete') as $key => $record) {
    // Skip the offset
        if ($key === 'offset')  // WHY IN THE WORLD DOES 0 == 'offset'?!?!?  so we use ===
            continue;
    // Skip unwanted shows
        if ($_GET['chanid'] != $record[4] || $_GET['starttime'] != $record[26])
            continue;
    // Load our program
        $program =& new Program($record);
    // Did the best we could to find some programs; let's move on.
        break;
    }

// No program found -- back to the recordings list
    if (empty($program))
        redirect_browser(root.'tv/recorded');

// Load the class for this page
    require_once tmpl_dir.'recording_detail.php';

// Exit
    exit;
