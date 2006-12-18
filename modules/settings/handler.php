<?php
/**
 * Handler for all MythWeb Settings routines
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

// Make sure we at least have the mythweb settings defined
    if (empty($Settings['mythweb'])) {
        custom_error('modules/mythweb/init.php is missing, please verify your install.');
    }

// Empty or unknown module?
    if (empty($Path[1]) || empty($Settings[$Path[1]])) {
        $Path[1] = 'mythweb';
    }

// Empty or unknown subsection?
    if (empty($Path[2]) || empty($Settings[$Path[1]]['choices'][$Path[2]])) {
        $Path[2] = $Settings[$Path[1]]['default'];
    }

// Define a constant for settings pages to use as their form action="" target
    define('form_action', root.'settings/'.$Path[1]
                          .($Path[2] == $Settings[$Path[1]]['default']
                                ? ''
                                : '/'.$Path[2]));

/**
 * @global  mixed   $GLOBALS['Settings_Hosts']
 * @name    $Settings_Hosts
/**/
    global $Settings_Hosts;
    $Settings_Hosts = t('My Session');

// Make sure the settings host is up to date
    if (isset($_REQUEST['settings_host'])) {
        $_SESSION['settings']['host'] = $_REQUEST['settings_host'];
    }

// Load the handler for whatever section was requested so that we can do any
// necessary pre-processing.
    require_once modules_path."/$Path[1]/set_$Path[2].php";

// Print the settings header page
    require_once tmpl_dir.'header.php';

// And the content that goes along with this section
    require_once 'modules/'.$Path[1].'/tmpl/'.tmpl."/set_$Path[2].php";

// And lastly, the footer
    require_once tmpl_dir.'footer.php';

// Exit cleanly
    exit;

/* ****************************************************************************/

/**
 * Prints out the host choices for this section.
/**/
    function host_choices() {
        global $Settings_Hosts;
        if (is_array($Settings_Hosts)) {
            $s = '<form id="host_form" name="host_form" action="'.form_action.'" method="post">'
                .'<select name="settings_host" onchange="$(\'host_form\').submit()">';
            foreach ($Settings_Hosts as $host => $name) {
                $s .= '<option value="'.html_entities($host).'"';
                if ($host == $_SESSION['settings']['host'])
                    $s .= ' SELECTED';
                $s .= '>'.html_entities($name).'</option>';
            }
            $s .= '<noscript><input type="submit" value="'.t('Set Host').'"></noscript>';
            return $s . '</form>';
        }
        else
            return $Settings_Hosts;
    }
