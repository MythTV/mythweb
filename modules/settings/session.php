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
 * @subpackage  Settings
 *
/**/

// Save?
    if ($_POST['save']) {
        $redirect = false;
    // Save the date formats
        if (isset($_POST['date_statusbar']))       $_SESSION['date_statusbar']       = $_POST['date_statusbar'];
        if (isset($_POST['date_scheduled']))       $_SESSION['date_scheduled']       = $_POST['date_scheduled'];
        if (isset($_POST['date_scheduled_popup'])) $_SESSION['date_scheduled_popup'] = $_POST['date_scheduled_popup'];
        if (isset($_POST['date_recorded']))        $_SESSION['date_recorded']        = $_POST['date_recorded'];
        if (isset($_POST['date_search']))          $_SESSION['date_search']          = $_POST['date_search'];
        if (isset($_POST['date_listing_key']))     $_SESSION['date_listing_key']     = $_POST['date_listing_key'];
        if (isset($_POST['date_listing_jump']))    $_SESSION['date_listing_jump']    = $_POST['date_listing_jump'];
        if (isset($_POST['date_channel_jump']))    $_SESSION['date_channel_jump']    = $_POST['date_channel_jump'];
        if (isset($_POST['time_format']))          $_SESSION['time_format']          = $_POST['time_format'];
    // Save the template
        if (isset($_POST['tmpl']))                 $_SESSION['tmpl']                 = $_POST['tmpl'];
    // Save the skin
        if (isset($_POST['skin']) && $_POST['skin'] != $_SESSION['skin']) {
            $_SESSION['skin'] = $_POST['skin'];
            $redirect = true;
        }
    // Use SI units?
        if (isset($_POST['siunits']))              $_SESSION['siunits']              = $_POST['siunits'];
    // Recorded Programs (can't use isset() here because un-checked checkboxes don't show up in the request)
        $_SESSION['recorded_descunder'] = $_POST['recorded_descunder'] ? true : false;
        $_SESSION['recorded_pixmaps']   = $_POST['recorded_pixmaps']   ? true : false;
        $_SESSION['use_myth_uri']       = $_POST['use_myth_uri']       ? true : false;
        if (isset($_POST['file_url_override']))  $_SESSION['file_url_override']  = trim(preg_replace('#^file://#', '', $_POST['file_url_override']));
    // Guide Settings
        $_SESSION['guide_favonly']    = $_POST['guide_favonly'] ? true : false;
        $_SESSION['timeslot_size']    = max(5, intVal($_POST['timeslot_size'])) * 60;
        $_SESSION['num_time_slots']   = max(3, intVal($_POST['num_time_slots']));
        $_SESSION['timeslot_blocks']  = max(1, intVal($_POST['timeslot_blocks']));
        $_SESSION['timeslotbar_skip'] = max(1, intVal($_POST['timeslotbar_skip']));
        $_SESSION['max_stars']        = max(3, intVal($_POST['max_stars']));
        $_SESSION['star_character']   = $_POST['star_character'];
    // Change language?  Make sure we load the new translation file, too.
        if ($_POST['language'] && $_POST['language'] != $_SESSION['language']) {
            $_SESSION['language'] = $_POST['language'];
            $redirect = true;
        }

    // Skin change requires a redirect because certain constants have already been defined.
        if ($redirect)
            redirect_browser(root.module.'/session');
    }

// Load the class for this page
    require_once tmpl_dir.'session.php';

// Exit
    exit;

/**
 * Displays a <select> of the available templates
/**/
    function template_select() {
        echo '<select name="tmpl">';
        foreach (array('default', 'compact') as $tmpl) {
        // Print the option
            echo '<option value="'.html_entities($tmpl).'"';
            if ($_SESSION['tmpl'] == $tmpl)
                echo ' SELECTED';
            echo '>'.html_entities(str_replace('_', ' ', $tmpl)).'</option>';
        }
        echo '</select>';
    }

/**
 * Displays a <select> of the available skins
/**/
    function skin_select() {
        echo '<select name="skin">';
        foreach (get_sorted_files("skins/") as $skin) {
        // Skip the svn directory and the non-browser themes
            if (in_array($skin, array('.svn', 'wap', 'wml', 'vxml'))) continue;
        // Ignore non-directories
            if (!is_dir("skins/$skin")) continue;
        // Print the option
            echo '<option value="'.html_entities($skin).'"';
            if ($_SESSION['skin'] == $skin)
                echo ' SELECTED';
            echo '>'.html_entities(str_replace('_', ' ', $skin)).'</option>';
        }
        echo '</select>';
    }

/**
 * Displays a <select> of the available languages
/**/
    function language_select() {
        echo '<select name="language">';
        foreach ($GLOBALS['Languages'] as $lang => $details) {
        // Print the option
            echo '<option value="'.html_entities($lang).'"';
            if ($_SESSION['language'] == $lang)
                echo ' SELECTED';
            echo '>'.$details[0].'</option>';
        }
        echo '</select>';
    }

/**
 * displays a <select> for the unit type
/**/
    function unit_select() {
        global $db;
        echo '<select name="siunits">';
        if (empty($_SESSION['siunits'])) {
            $_SESSION['siunits'] = $db->query_col('SELECT data FROM settings WHERE value="SIUnits"');
        }
        echo '<option value="YES"'.($_SESSION['siunits'] == 'YES' ? ' SELECTED' : '').'>'.t('Yes')."</option>\n";
        echo '<option value="NO"' .($_SESSION['siunits'] == 'YES' ? '' : ' SELECTED').'>'.t('No') ."</option>\n";
        echo '</select>';
    }

