<?php
/**
 * Display/save mythweb default settings
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
    // One lonely setting.
        $_SESSION['prefer_channum'] = setting('WebPrefer_Channum', $_POST['prefer_channum'] ? 1 : 0);

    // Skin change requires a redirect because certain constants have already been defined.
        if ($redirect)
            redirect_browser(root.module.'/session');
    }

// Load the class for this page
    require_once tmpl_dir.'mythweb.php';

// Exit
    exit;

