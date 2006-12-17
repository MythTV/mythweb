<?php
/**
 * Configure MythTV Key Bindings
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/

// Reset keybindings?   (still need a way to get the backend to repopulate these)
#    if ($_GET['RESET_KEYS']) {
#        $result = mysql_query('DELETE FROM keybindings')
#            or trigger_error('SQL Error: '.mysql_error().' [#'.mysql_errno().']', FATAL);
#        backend_notify_changes();
#    }

// Save?
    $use_host = "";
    if ($_POST['save']) {
        foreach ($_POST as $key => $key_list) {
            if (preg_match('/^jump:([\\w_\/]+):(\\w+)$/', $key, $matches)) {
                list($match, $dest, $use_host) = $matches;
                $db->query('UPDATE jumppoints
                               SET keylist=?
                             WHERE destination=? AND hostname=?',
                           $key_list,
                           str_replace('_', ' ', $dest),
                           $use_host
                          );
            }
            elseif (preg_match('/^key:([\\w_\/]+):(\\w+):(\\w+)$/', $key, $matches)) {
                list($match, $context, $action, $use_host) = $matches;
                $db->query('UPDATE keybindings
                               SET keylist=?
                             WHERE context=? AND action=? AND hostname=?',
                           $key_list,
                           str_replace('_', ' ', $context),
                           $action,
                           $use_host
                          );
            }
        }
    }

    if ($_GET['host'])
        $use_host = $_GET['host'];

// Load all of the known mythtv hosts
    $Hosts = array();
    $sh = $db->query('SELECT hostname FROM jumppoints GROUP BY hostname ORDER BY hostname');
    while ($row = $sh->fetch_assoc()) {
        if (empty($row['hostname']))
            continue;
        $Hosts[] = $row;
        if (empty($use_host))
            $use_host = $row['hostname'];
    }
    $sh->finish();

// Load all of the jump points from the database
    $Jumps = array();
    $sh = $db->query('SELECT * FROM jumppoints WHERE hostname=?',
                     $use_host);
    while ($row = $sh->fetch_assoc()) {
        $Jumps[] = $row;
    }
    $sh->finish();

// Load all of the keys from the database (sort Global context keys to the top)
    $Keys = array();
    $sh = $db->query('SELECT *
                        FROM keybindings
                       WHERE hostname = ?
                    ORDER BY (context = "Global") DESC, context',
                     $use_host);
    while ($row = $sh->fetch_assoc()) {
        $Keys[] = $row;
    }
    $sh->finish();

