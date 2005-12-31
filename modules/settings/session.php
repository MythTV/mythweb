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
    // Save the date formats
        if ($_POST['date_statusbar'])       $_SESSION['date_statusbar']       = $_POST['date_statusbar'];
        if ($_POST['date_scheduled'])       $_SESSION['date_scheduled']       = $_POST['date_scheduled'];
        if ($_POST['date_scheduled_popup']) $_SESSION['date_scheduled_popup'] = $_POST['date_scheduled_popup'];
        if ($_POST['date_recorded'])        $_SESSION['date_recorded']        = $_POST['date_recorded'];
        if ($_POST['date_search'])          $_SESSION['date_search']          = $_POST['date_search'];
        if ($_POST['date_listing_key'])     $_SESSION['date_listing_key']     = $_POST['date_listing_key'];
        if ($_POST['date_listing_jump'])    $_SESSION['date_listing_jump']    = $_POST['date_listing_jump'];
        if ($_POST['date_channel_jump'])    $_SESSION['date_channel_jump']    = $_POST['date_channel_jump'];
        if ($_POST['time_format'])          $_SESSION['time_format']          = $_POST['time_format'];
    // Save the theme
        if ($_POST['theme'])                $_SESSION['Theme']                = $_POST['theme'];
    // Use SI units?
        if ($_POST['siunits'])              $_SESSION['siunits']              = $_POST['siunits'];
    // Save the weather icon set
        if ($_POST['weathericonset'])       $_SESSION['weathericonset']       = $_POST['weathericonset'];
    // Recorded Programs
        $_SESSION['recorded_descunder'] = $_POST['recorded_descunder'] ? true : false;
    // Guide Settings
        $_SESSION['guide_favonly'] = $_POST['guide_favonly'] ? true : false;
    // Change language?  Make sure we load the new translation file, too.
        if ($_POST['language'] && $_POST['language'] != $_SESSION['language']) {
            $_SESSION['language'] = $_POST['language'];
            require_once 'languages/'.$_SESSION['language'].'.php';
        }

    }

// Load the class for this page
    require_once theme_dir.'settings/session.php';

// Exit
    exit;


/**
 * displays a <select> of the available themes
/**/
    function theme_select() {
        echo '<select name="theme">';
        foreach (get_sorted_files("themes/") as $theme) {
        // Skip the CVS directory and the non-browser themes
            if (in_array($theme, array('CVS', 'wap', 'wml', 'vxml'))) continue;
        // Ignore non-directories
            if (!is_dir("themes/$theme")) continue;
        // Print the option
            echo '<option value="'.htmlentities($theme).'"';
            if ($_SESSION['Theme'] == $theme)
                echo ' SELECTED';
            $theme = ereg_replace('_', ' ', $theme);
            echo '>'.htmlentities($theme).'</option>';
        }
        echo '</select>';
    }

/**
 * displays a <select> of available weather icon sets
/**/
    function weathericonset_select() {
        echo '<select name="weathericonset">';
        foreach (get_sorted_files("images/weather/") as $theme) {
        // Skip the CVS directory and the non-browser themes
            if (in_array($theme, array('CVS', '.svn'))) continue;
        // Ignore non-directories
            if (!is_dir("images/weather/$theme")) continue;
        // Print the option
            echo '<option value="'.htmlentities($theme).'"';
            if ($_SESSION['weathericonset'] == $theme)
                echo ' SELECTED';
            $theme = str_replace('_', ' ', $theme);
            echo '>'.htmlentities($theme).'</option>';
        }
        echo '</select>';
    }

/**
 * displays a <select> of the available languages
/**/
    function language_select() {
        echo '<select name="language">';
        foreach ($GLOBALS['Languages'] as $lang => $details) {
        // Print the option
            echo '<option value="'.htmlentities($lang).'"';
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

