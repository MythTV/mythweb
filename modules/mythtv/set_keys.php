<?php
/**
 * Configure MythTV Key Bindings
 *
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
#        MythBackend::find()->rescheduleRecording();
#    }


// Load all of the known mythtv frontend hosts
    $Settings_Hosts = array();
    $sh = $db->query('SELECT DISTINCT hostname FROM jumppoints ORDER BY hostname');
    while (list($host) = $sh->fetch_row()) {
        if (empty($host))
            continue;
        $Settings_Hosts[$host] = $host;
    }
    $sh->finish();

// Make sure we have a valid host selected
    if (!isset($Settings_Hosts[$_SESSION['settings']['host']]))
        $_SESSION['settings']['host'] = reset(array_keys($Settings_Hosts));
// Save?
    elseif ($_POST['save'] && $_POST['host']) {
        foreach ($_POST['jump'] as $dest => $key_list) {
            $db->query('UPDATE jumppoints
                           SET keylist=?
                         WHERE destination=? AND hostname=?',
                       $key_list,
                       $dest,
                       $_POST['host']
                      );
        }
        foreach ($_POST['key'] as $context => $data) {
            foreach ($data as $action => $key_list) {
                $db->query('UPDATE keybindings
                               SET keylist=?
                             WHERE context=? AND action=? AND hostname=?',
                           $key_list,
                           $context,
                           $action,
                           $_POST['host']
                          );
            }
        }
    // Make sure the session host gets updated to the posted one.
        $_SESSION['settings']['host'] = $_POST['host'];
    }

// Load all of the jump points from the database
    $Jumps = array();
    $sh = $db->query('SELECT * FROM jumppoints WHERE hostname=?',
                     $_SESSION['settings']['host']);
    while ($row = $sh->fetch_assoc()) {
        $Jumps[] = $row;
    }
    $sh->finish();

// Load all of the keys from the database (sort Global context keys to the top)
    $Keys = array();
    $sh = $db->query('SELECT *
                        FROM keybindings
                       WHERE hostname = ?
                    ORDER BY (context = "Global") DESC, context, action',
                     $_SESSION['settings']['host']);
    while ($row = $sh->fetch_assoc()) {
        $Keys[] = $row;
    }
    $sh->finish();
