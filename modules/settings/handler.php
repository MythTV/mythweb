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

// Load the handler for whatever section was requested so that we can do any
// necessary pre-processing.
    require_once modules_path."/$Path[1]/set_$Path[2].php";

// Print the settings header page
    require_once tmpl_dir.'header.php';

// And the content that goes along with this section
    require_once 'modules/'.$Path[1].'/tmpl/'.tmpl."/set_$Path[2].php";

// And lastly, the footer
    require_once tmpl_dir.'footer.php';

