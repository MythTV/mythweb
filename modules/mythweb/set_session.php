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
    // Save the template
        if (isset($_POST['tmpl']))
            setcookie('mythweb_tmpl', $_POST['tmpl'], 2147483647, root);

        if (isset($_POST['tmpl_default']))
            $_SESSION['tmpl'] = $_POST['tmpl_default'];

    // Save the skin
        if (isset($_POST['skin']))
            setcookie('mythweb_skin', $_POST['skin'], 2147483647, root);

        if (isset($_POST['skin_default']))
            $_SESSION['skin'] = $_POST['skin_default'];

    // Change language?  Make sure we load the new translation file, too.
        if ($_POST['language'] && $_POST['language'] != $_SESSION['language']){
            $_SESSION['language'] = $_POST['language'];
        // Force the session to regenerate the date formats on language changes
            unset($_SESSION['date_statusbar']);
            unset($_SESSION['date_scheduled']);
            unset($_SESSION['date_scheduled_popup']);
            unset($_SESSION['date_recorded']);
            unset($_SESSION['date_search']);
            unset($_SESSION['date_listing_key']);
            unset($_SESSION['date_listing_jump']);
            unset($_SESSION['date_channel_jump']);
            unset($_SESSION['date_job_status']);
        }

        redirect_browser(root.module.'/'.$Path[1].'/'.$Path[2]);
    }

/**
 * Displays a <select> of the available templates
/**/
    function template_select($name = 'tmpl', $selected = null) {
        echo '<select name="'.$name.'">';
        foreach (array('default', 'lite', 'iPod') as $tmpl) {
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
        echo '<select name="'.$name.'">';
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
        foreach ($GLOBALS['Languages'] as $lang => $details) {
        // Print the option
            echo '<option value="'.html_entities($lang).'"';
            if ($_SESSION['language'] == $lang)
                echo ' SELECTED';
            echo '>'.$details[0].'</option>';
        }
        echo '</select>';
    }
