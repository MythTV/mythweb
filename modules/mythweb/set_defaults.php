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
    // Some global mythweb settings
        $_SESSION['prefer_channum']     = setting('WebPrefer_Channum', null, $_POST['prefer_channum'] ? 1 : 0);
        $_SESSION['show_popup_info']    = $_POST['show_popup_info']    ? 1 : 0;
        $_SESSION['show_channel_icons'] = $_POST['show_channel_icons'] ? 1 : 0;
        $_SESSION['sortby_channum']     = $_POST['sortby_channum']     ? 1 : 0;
        $_SESSION['show_video_covers']  = $_POST['show_video_covers']  ? 1 : 0;
    }

// These settings are limited to MythWeb itself
    $Settings_Hosts = 'MythWeb';
