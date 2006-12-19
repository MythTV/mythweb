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
    // Save the template
        if (isset($_POST['tmpl']))                 $_SESSION['tmpl']                 = $_POST['tmpl'];
    // Save the skin
        if (isset($_POST['skin']) && $_POST['skin'] != $_SESSION['skin']) {
            $_SESSION['skin'] = $_POST['skin'];
            $redirect = true;
        }
    // Change language?  Make sure we load the new translation file, too.
        if ($_POST['language'] && $_POST['language'] != $_SESSION['language']) {
            $_SESSION['language'] = $_POST['language'];
            $redirect = true;
        }

    // Skin change requires a redirect because certain constants have already been defined.
        if ($redirect)
            redirect_browser(root.module.'/'.$Path[1].'/'.$Path[2]);
    }

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

