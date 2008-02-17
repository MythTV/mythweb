<?php
/**
 * Connection routines for the new socket interface to mythfrontend.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythTV
 *
/**/

/**
 * @global  array $GLOBALS['Frontends']
 * @name    $Frontends
/**/
    global $Frontends;
    $Frontends = array();

// Load the frontends into an array
    $sh = $db->query('SELECT s1.hostname, s2.data
                        FROM settings AS s1, settings AS s2
                       WHERE s1.hostname = s2.hostname
                             AND s1.value = "NetworkControlEnabled" AND s1.data=1
                             AND s2.value = "NetworkControlPort"
                    ORDER BY s1.hostname'
                    );
    while (list($host, $port) = $sh->fetch_row()) {
    // Remove some characters that should never be here, anyway, and might
    // confuse javascript/html
        $host = preg_replace('/["\']+/', '', $host);
    // Add to the list
        $Frontends[$host] = new MythFrontend($host, $port);
    }
    $sh->finish();


