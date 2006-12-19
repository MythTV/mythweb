<?php
/**
 * Weather settings
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Weather
/**/

// Load all of the known mythtv frontend hosts
    $Settings_Hosts = array('' => t('MythWeb Session'));
    $sh = $db->query('SELECT DISTINCT hostname
                        FROM settings
                       WHERE value="locale"
                    ORDER BY hostname');
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
    // Changing settings for this MythWeb session
        if (empty($_POST['host'])) {
            $_SESSION['weather']['siunits'] = $_POST['siunits'];
            $_SESSION['weather']['locale']  = $_POST['locale'];
        }
    // Changing settings for a specific host?
        else {
            $db->query('UPDATE settings
                           SET data = ?
                         WHERE value="SIUnits" AND hostname=?',
                       $_POST['siunits'],
                       $_POST['host']);
            $db->query('UPDATE settings
                           SET data = ?
                         WHERE value="locale" AND hostname=?',
                       $_POST['locale'],
                       $_POST['host']);
        }
    // Make sure the session host gets updated to the posted one.
        $_SESSION['settings']['host'] = $_POST['host'];
    }

/**
 * displays a <select> for the unit type
/**/
    function unit_select() {
        global $db;
        if (empty($_SESSION['settings']['host'])) {
            $siunits = _or($_SESSION['weather']['siunits'], 'NO');
        }
        else {
            $siunits = $db->query_col('SELECT data
                                         FROM settings
                                        WHERE value="SIUnits" AND hostname=?',
                                      $_SESSION['settings']['host']);
        }
        echo '<select name="siunits">',
             '<option value="YES"'.($siunits == 'YES' ? ' SELECTED' : ''), '>'.t('&deg;C'), "</option>\n",
             '<option value="NO"' .($siunits == 'YES' ? '' : ' SELECTED'), '>'.t('&deg;F'),  "</option>\n",
             '</select>';
    }

/**
 * displays a <select> for the locale choices
/**/
    function locale_select() {
        global $db, $Path;
    // Current value?
        if (empty($_SESSION['settings']['host'])) {
            $locale = $_SESSION['weather']['locale'];
            if (empty($locale)) {
                $locale = $db->query_col('SELECT data
                                            FROM settings
                                           WHERE value="locale"');
            }
        }
        else {
            $locale = $db->query_col('SELECT data
                                        FROM settings
                                       WHERE value="locale" AND hostname=?',
                                     $_SESSION['settings']['host']);
        }
    // Load the locale file and print the results
        echo '<select name="locale">';
        foreach (file(modules_path.'/'.$Path[1].'/accid.dat') as $line) {
            list($ignore, $code, $name) = explode('::', $line);
            if (empty($code))
                continue;
            echo '<option value="', html_entities($code), '"';
            if ($locale == $code)
                echo ' SELECTED';
            echo '>', html_entities($name), '</option>';
        }
        echo '</select>';
    }

