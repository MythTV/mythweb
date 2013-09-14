<?php
/**
 * Display/save mythweb session settings
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/

// Save?
    if ($_POST['save']) {
    // Save the template
        if (isset($_POST['tmpl']))
            $_SESSION['tmpl'] = $_POST['tmpl'];

    // Save the skin
        if (isset($_POST['skin']))
            $_SESSION['skin'] = $_POST['skin'];

    // Change language?  Make sure we load the new translation file, too.
        if ($_POST['language'] && $_POST['language'] != $_SESSION['language']){
            $_SESSION['language'] = $_POST['language'];
	    // Unset the date/time formats in session so translation can fill in the 
	    // language specific defaults
            unset($_SESSION['date_statusbar']);
            unset($_SESSION['date_scheduled']);
            unset($_SESSION['date_scheduled_popup']);
            unset($_SESSION['date_recorded']);
            unset($_SESSION['date_search']);
            unset($_SESSION['date_listing_key']);
            unset($_SESSION['date_listing_jump']);
            unset($_SESSION['date_channel_jump']);
            unset($_SESSION['date_job_status']);
            unset($_SESSION['time_format']);
            Translate::find()->load_translation();
        }

        redirect_browser(module.'/'.$Path[1].'/'.$Path[2]);
    }

/**
 * Displays a <select> of the available templates
/**/
    function template_select($name = 'tmpl', $selected = null) {
        echo '<select name="'.$name.'">';
        foreach (array('default', 'lite') as $tmpl) {
        // Print the option
            echo '<option value="'.html_entities($tmpl).'"';
            if ($selected == $tmpl)
                echo ' SELECTED';
            echo '>'.html_entities(str_replace('_', ' ', $tmpl)).'</option>';
        }
        echo '</select>';
    }

/**
 * Displays a <select> of the available skins
/**/
    function skin_select($name = 'skin', $selected = null) {
        echo '<select id="'.$name.'" name="'.$name.'">';
        foreach (get_sorted_files("skins/") as $skin) {
        // Skip the svn directory
            if (in_array($skin, array('.svn')))
                continue;
        // Ignore non-directories
            if (!is_dir("skins/$skin"))
                continue;
        // Print the option
            echo '<option value="'.html_entities($skin).'"';
            if ($selected == $skin)
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
        foreach (Translate::$Languages as $lang => $details) {
        // Print the option
            echo '<option value="'.html_entities($lang).'"';
            if ($_SESSION['language'] == $lang)
                echo ' SELECTED';
            echo '>'.$details[0].'</option>';
        }
        echo '</select>';
    }
