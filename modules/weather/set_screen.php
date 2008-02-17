<?php
/**
 * Weather Screen settings
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Weather
 *
/**/

// Load all of the known mythtv frontend hosts
    $Settings_Hosts = array();
    $sh = $db->query('SELECT DISTINCT hostname
                      FROM weathersourcesettings
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

// Initialize Screens
    rebuild_active_screens();
    rebuild_inactive_screens();

// Add to Active Screens
    if (isset($_POST['add']) && isset($_POST['host'])) {
            if (isset($_POST['inactive_screen'])) {
                $screen = new WeatherScreen(null);
                $screen->initNew($_POST['inactive_screen'], $_POST['host']);

                rebuild_active_screens();
            }
        $_SESSION['settings']['host'] = $_POST['host'];
    }

// Delete from Active Screens
    else if (isset($_POST['delete']) && isset($_POST['host'])) {
        if (isset($_POST['active_screen'])) {
            $screen = new WeatherScreen($_POST['active_screen']);
            $screen->deleteScreen();

            rebuild_active_screens();
        }
        $_SESSION['settings']['host'] = $_POST['host'];
    }

// Move screen
    else if ((isset($_POST['move_u']) || isset($_POST['move_d'])) && isset($_POST['host'])) {
        if (isset($_POST['active_screen'])) {
            $screen = new WeatherScreen($_POST['active_screen']);
            if (isset($_POST['move_u'])) $screen->move('up');
            if (isset($_POST['move_d'])) $screen->move('down');

            rebuild_active_screens();
        }
    }

// Edit Active Screen
    else if (isset($_POST['edit']) && isset($_POST['host'])) {
        // Cancel editting
        if (isset($_POST['cancel_edit']))  {
            unset($_SESSION['weather']['edit']);
            unset($_SESSION['weather']['search']);
        }
        // Edit screen
        if (isset($_POST['active_screen'])) {
            $_SESSION['weather']['edit'] = $_POST['active_screen'];
        }
        // Search locations
        if (isset($_POST['edit_search']) && (strlen($_POST['weather_search'])>0)) {
            $_SESSION['weather']['search'] = $_POST['weather_search'];
        }
        // Save changes
        if (isset($_POST['save_edit'])) {
            $screen = new WeatherScreen($_POST['edit']);
            // Save location changes 
            if (isset($_POST['weather_location']) && isset($_POST['weather_use_results'])) {
                $matches = array();
                if (preg_match('/\(\((\d*)\)\)(.*)/', $_POST['weather_location'], $matches)) {
                    $screen->updateLocation($matches[1], $matches[2]);
                }
            }
            // Save unit changes
            if (isset($_POST['weather_units']))
                $screen->updateUnits($_POST['weather_units']);

            // Save clears out search and edit functions
            unset($_SESSION['weather']['edit']);
            unset($_SESSION['weather']['search']);
        }

        $_SESSION['settings']['host'] = $_POST['host'];
    }

/**
 * refreshes the active screens array
/**/
    function rebuild_active_screens() {
        global $db;
        $_SESSION['weather']['active'] = array();

        $sh = $db->query('SELECT screen_id, draworder
                          FROM weatherscreens 
                          WHERE hostname=?
                          ORDER BY draworder', $_SESSION['settings']['host']);

        // Populate active screens
        while(list($screen_id, $draworder) = $sh->fetch_row())
            $_SESSION['weather']['active'][$draworder] = $screen_id;

        $sh->finish();
    }

/**
 * refreshes the inactive screens array
/**/
    function rebuild_inactive_screens() {
        global $db;

        // Clear old inactive list
        unset($_SESSION['weather']['inactive']);
        if (!isset($_SESSION['weather']['inactive']))
            $_SESSION['weather']['inactive'] = array();

        $sh = $db->query('SELECT types 
                          FROM weathersourcesettings 
                          WHERE hostname=?', $_SESSION['settings']['host']);

        // Populate inactive screens
        //
        // TODO Hardcoding these variables is probably a no-no.  But all of this
        //      stuff is coded into the XML theme (weather-ui.xml).  Having the
        //      module parse that seems overkill.
        while(list($types) = $sh->fetch_row()) {
            $scratch = explode(',', $types);
            foreach ($scratch as $item) {
                if ($item == 'cclocation')   $type_list[$item] = 'Current Conditions';
                if ($item == '3dlocation')   $type_list[$item] = 'Three Day Forecast';
                if ($item == '6dlocation')   $type_list[$item] = 'Six Day Forecast';
                if ($item == 'smdesc')       $type_list[$item] = 'Static Map';
                if ($item == 'amdesc')       $type_list[$item] = 'Animated Map';
                if ($item == 'swlocation')   $type_list[$item] = 'Severe Weather Alerts';
                if ($item == '18hrlocation') $type_list[$item] = '18 Hour Forecast';
            }
        }
        $sh->finish();

        // Return if no types are found
        if (!isset($type_list)) { return; }

        foreach ($type_list as $key => $value) 
            array_push($_SESSION['weather']['inactive'], $type_list[$key]);

        sort($_SESSION['weather']['inactive']);
    }

/**
 * displays a list of inactive screens as a <select> list
/**/
    function display_inactive_screens() {
        if (!isset($_SESSION['weather']['inactive'])) return;
       
        if (count($_SESSION['weather']['inactive']) <= 0)
            echo '<p><b>Warning!!</b> No types were found in weathersourcesettings for hostname ('. $_SESSION['settings']['host'] .')</p>';

        else { 
            echo '<select name="inactive_screen">' ."\n";
            foreach ($_SESSION['weather']['inactive'] as $screen) 
                if (! $screen->active) 
                    echo '    <option>'. $screen ."</option>\n";
            echo '</select>' ."\n";
        }
    }
    

/**
 * displays a list of active screens as a <select> list
/**/
    function display_active_screens() {
        if (!isset($_SESSION['weather']['active'])) return;
       
        echo "<ol>\n"; 
        foreach ($_SESSION['weather']['active'] as $screen_id) {
            $screen = new WeatherScreen($screen_id);
            $screen->getData();

            echo '<li><input type="radio" name="active_screen" value="'. $screen->screen_id .'" id="active-screen-'. $screen->screen_id .'">';
            echo '<label for="active-screen-'. $screen->screen_id .'">'. $screen->container ."</label></li>\n";
            echo "<ul>\n";
            echo '<li>Location: ';

            foreach($screen->data as $key => $value) {
                if (preg_match('/location/', $key)) { echo $value; break; }
                if (preg_match('/desc/', $key))     { echo $value; break; }
            }

            echo "</li>\n";
            echo '<li>Source: '. $screen->getSource() ."</li>\n";
            echo "</ul>\n";
        }
        echo "</ol>";
    }
