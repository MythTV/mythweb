<?php
/**
 * Configure MythTV playback groups
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/

// We're now outside of the tv module directory, so we need to re-add it as a
// search path.
    ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.'modules/tv');

// We need the list of available playgroups
    require_once 'modules/tv/classes/Schedule.php';

// Save changes
    if ($_REQUEST['save'] && $_REQUEST['old_name']) {
        if ($_REQUEST['old_name'] == 'Default')
            $_REQUEST['name'] = 'Default';
        else
            $_REQUEST['name'] = trim($_REQUEST['name']);
    // Check for name collision
        if ($_REQUEST['name'] != $_REQUEST['old_name']) {
            $test = $db->query_col('SELECT name FROM playgroup WHERE name = ?',
                                   $_REQUEST['name']);
            if ($test) {
                add_error(t('error: playgroup $1 exists', $_REQUEST['name']));
            }
        }
    // Save if there are no errors
        if (!errors()) {
            if ($_REQUEST['name'] != $_REQUEST['old_name']) {
                $db->query('DELETE FROM playgroup WHERE name = ?',
                           $_REQUEST['old_name']);
            }
            $db->query('REPLACE INTO playgroup
                                     (name, titlematch, skipahead, skipback, timestretch, jump)
                              VALUES (?, ?, ?, ?, ?, ?)',
                       $_REQUEST['name'],
                       $_REQUEST['titlematch'],
                       $_REQUEST['skipahead'],
                       $_REQUEST['skipback'],
                       $_REQUEST['timestretch'],
                       $_REQUEST['jump']
                      );
            $_REQUEST['playgroup'] = $_REQUEST['name'];
        }
    }
// Delete group
    elseif ($_REQUEST['delete']) {
        if ($_REQUEST['old_name'] != 'Default') {
            $db->query('DELETE FROM playgroup WHERE name = ?',
                       $_REQUEST['old_name']);
        }
    }

// Load a playgroup to edit
    if ($_REQUEST['new_group']) {
        $group = $db->query_assoc('SELECT * FROM playgroup WHERE name = "Default"');
        $group['name'] = 'NEW GROUP';
    }
    else {
        $group = $db->query_assoc('SELECT * FROM playgroup WHERE name = ?',
                                  $_REQUEST['playgroup']);
        if (empty($group)) {
            $_REQUEST['playgroup'] = 'Default';
            $group = $db->query_assoc('SELECT * FROM playgroup WHERE name = ?',
                                      $_REQUEST['playgroup']);
        }
    }

// These settings affect all of mythtv
    $Settings_Hosts = t('All Hosts');
