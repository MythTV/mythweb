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
    // Some global mythweb settings
        $_SESSION['prefer_channum'] = setting('WebPrefer_Channum', $_POST['prefer_channum'] ? 1 : 0);
    // Video URL needs some special checking
        $_POST['video_url'] = trim($_POST['video_url']);
        if (empty($_POST['video_url']) || preg_match('#^\w+://#', $_POST['video_url']))
            setting('WebVideo_URL', $_POST['video_url']);
        else
            add_warning('Video URL needs a URI indicator like myth:// or file://');
    // Skin change requires a redirect because certain constants have already been defined.
        if ($redirect)
            redirect_browser(root.module.'/session');
    }

// Load the class for this page
    require_once tmpl_dir.'mythweb.php';

// Exit
    exit;

