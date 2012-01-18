<?php
/**
 * View the logs
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Logs
 *
/**/

// Where to start searching from
    $_GET['start'] = intVal($_GET['start']);
    if ($_GET['start'] < 1)
        $_GET['start'] = 0;

// How many entries to show?
    $_GET['show'] = intVal($_GET['show']);
    if ($_GET['show'] < 1)
        $_GET['show'] = 100;

// Load the logs (remember that start and show are already safe for non-escaped usage)
    $Logs = array();
    $sh   = $db->query('SELECT * FROM logging ORDER BY id DESC LIMIT '.$_GET['start'].','.$_GET['show']);
    while ($row = $sh->fetch_assoc()) {
        $Logs[] = $row;
    }
    $sh->finish();

// Print the status page template
    require_once tmpl_dir.'backend_log.php';

// Yup, that really is it.
    exit;
