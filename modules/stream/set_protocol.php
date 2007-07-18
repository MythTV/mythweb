<?php
/**
 * Display/save mythweb session settings
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Music
 *
/**/

// Save?
    if ($_POST['save']) {
    // Save the protocol choice
        $_SESSION['stream']['force_http']       = $_REQUEST['force_http'] ? true : false;
        $_SESSION['stream']['force_http_port']  = intVal($_REQUEST['force_http_port']);
        if ($_SESSION['stream']['force_http_port'] < 1)
            $_SESSION['stream']['force_http_port'] = '';
    }
