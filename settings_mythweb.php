<?php
/***                                                                        ***\
    settings_mythweb.php                     Last Updated: 2005.02.11 (xris)

    mythweb settings
\***                                                                        ***/

// Which section are we in?
    define('section', 'settings');

// Initialize the script, database, etc.
    require_once "includes/init.php";

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

    // Recorded Programs
        $_SESSION['recorded_descunder'] = $_POST['recorded_descunder'] ? true : false;
    // Guide Settings
        $_SESSION['guide_favonly'] = $_POST['guide_favonly'] ? true : false;
    }

// Load the class for this page
    require_once theme_dir.'settings_mythweb.php';

// Create an instance of this page from its theme object
    $Page = new Theme_settings_mythweb();

// Display the page
    $Page->print_page();

// Exit
    exit;


/*
    theme_select:
    displays a <select> of the available themes
*/
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

/*
    language_select:
    displays a <select> of the available languages
*/
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

    /*
    unit_select:
    displays a <select> for the unit type
    */
    function unit_select() {
        echo '<select name="siunits">';
        if(!$_SESSION['siunits'])
        {
            $result = mysql_query('SELECT * FROM settings WHERE value="SIUnits"')
            or trigger_error('SQL Error: '.mysql_error(), FATAL);

            $row = mysql_fetch_assoc($result);
            $si = $row["data"];
            $_SESSION['siunits'] = $si;

            mysql_free_result($result);
        }
        else
        {
            $si = $_SESSION['siunits'];
        }

        echo "<option value='YES'".($si=='YES'?' SELECTED':'').">".t('Yes')."</option>\n";
        echo "<option value='NO'".($si=='YES'?'':' SELECTED').">".t('No')."</option>\n";
        echo '</select>';
    }

    /*
    unit_select:
    displays a <select> for the unit type
    */
    function unit_select() {
        echo '<select name="siunits">';
        if(!$_SESSION['siunits'])
        {
            $result = mysql_query('SELECT * FROM settings WHERE value="SIUnits"')
            or trigger_error('SQL Error: '.mysql_error(), FATAL);

            $row = mysql_fetch_assoc($result);
            $si = $row["data"];
            $_SESSION['siunits'] = $si;

            mysql_free_result($result);
        }
        else
        {
            $si = $_SESSION['siunits'];
        }

        echo "<option value='YES'".($si=='YES'?' SELECTED':'').">".t('Yes')."</option>\n";
        echo "<option value='NO'".($si=='YES'?'':' SELECTED').">".t('No')."</option>\n";
        echo '</select>';
    }
?>
