<?php
/**
 * Configure MythTV Settings table
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/

// Load all of the known mythtv hosts
    $Settings_Hosts = array('' => '- '.t('All Hosts').' -');
    $sh = $db->query('SELECT DISTINCT hostname FROM settings ORDER BY hostname');
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
    elseif ($_POST['save'] && isset($_POST['host'])) {
        foreach ($_POST['settings'] as $value => $data) {
            setting($value, _or($_POST['host'], null), $data);
        }
        if (is_array($_POST['delete'])) {
            foreach ($_POST['delete'] as $value => $data) {
                if (!$data)
                    continue;
                if (empty($_POST['host']))
                    $sh = $db->query('DELETE FROM settings
                                       WHERE value=? AND hostname IS NULL',
                                     $value
                                    );
                else
                    $sh = $db->query('DELETE FROM settings
                                       WHERE value=? AND hostname=?',
                                     $value,
                                     $_POST['host']
                                    );
            }
        }
    // Make sure the session host gets updated to the posted one.
        $_SESSION['settings']['host'] = $_POST['host'];
    }

// Load all of the settings for the requested host
    $MythSettings = array();
    if (empty($_SESSION['settings']['host']))
        $sh = $db->query('SELECT value, data
                            FROM settings
                           WHERE hostname IS NULL
                        ORDER BY value');
    else
        $sh = $db->query('SELECT value, data
                            FROM settings
                           WHERE hostname=?
                        ORDER BY value',
                         $_SESSION['settings']['host']);
    while (list($value, $data) = $sh->fetch_row()) {
        $MythSettings[$value] = $data;
    }
    $sh->finish();

