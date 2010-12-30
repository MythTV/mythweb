<?php
/**
 * Display/save mythweb default settings
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/

// Save?
    if ($_POST['save']) {
    // Some global mythweb settings
        $_SESSION['prefer_channum']      = setting('WebPrefer_Channum', null, $_POST['prefer_channum'] ? 1 : 0);
        $_SESSION['show_popup_info']     = $_POST['show_popup_info']     ? 1 : 0;
        $_SESSION['show_channel_icons']  = $_POST['show_channel_icons']  ? 1 : 0;
        $_SESSION['sortby_channum']      = $_POST['sortby_channum']      ? 1 : 0;
        $_SESSION['genre_colors']        = $_POST['genre_colors']        ? 1 : 0;
        $_SESSION['show_video_covers']   = $_POST['show_video_covers']   ? 1 : 0;
        $_SESSION['cache_engine']        = $_POST['cache_engine'];
    }

    if ($_POST['set_current_session_as_default'])
        sess_write('default', session_encode());
    elseif ($_POST['clear_current_default_session'])
        sess_destroy('default');

// These settings are limited to MythWeb itself
    $Settings_Hosts = 'MythWeb';
