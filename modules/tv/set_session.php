<?php
/**
 * Display/save MythWeb session settings
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/

// Save?
    if ($_POST['save']) {
    // Save the date formats
        if (isset($_POST['date_statusbar']))       $_SESSION['date_statusbar']       = $_POST['date_statusbar'];
        if (isset($_POST['date_scheduled']))       $_SESSION['date_scheduled']       = $_POST['date_scheduled'];
        if (isset($_POST['date_scheduled_popup'])) $_SESSION['date_scheduled_popup'] = $_POST['date_scheduled_popup'];
        if (isset($_POST['date_recorded']))        $_SESSION['date_recorded']        = $_POST['date_recorded'];
        if (isset($_POST['date_search']))          $_SESSION['date_search']          = $_POST['date_search'];
        if (isset($_POST['date_listing_key']))     $_SESSION['date_listing_key']     = $_POST['date_listing_key'];
        if (isset($_POST['date_listing_jump']))    $_SESSION['date_listing_jump']    = $_POST['date_listing_jump'];
        if (isset($_POST['date_channel_jump']))    $_SESSION['date_channel_jump']    = $_POST['date_channel_jump'];
        if (isset($_POST['time_format']))          $_SESSION['time_format']          = $_POST['time_format'];
    // Recorded Programs (can't use isset() here because un-checked checkboxes don't show up in the request)
        $_SESSION['recorded_pixmaps']   = $_POST['recorded_pixmaps']   ? true : false;
        if (isset($_POST['file_url_override']))  $_SESSION['file_url_override']  = trim(preg_replace('#^file://#', '', $_POST['file_url_override']));
    // Guide Settings
        $_SESSION['guide_favonly']    = $_POST['guide_favonly'] ? true : false;
        $_SESSION['timeslot_size']    = max(5, intVal($_POST['timeslot_size'])) * 60;
        $_SESSION['num_time_slots']   = max(3, intVal($_POST['num_time_slots']));
        $_SESSION['timeslot_blocks']  = max(1, intVal($_POST['timeslot_blocks']));
        $_SESSION['timeslotbar_skip'] = max(1, intVal($_POST['timeslotbar_skip']));
        $_SESSION['max_stars']        = max(3, intVal($_POST['max_stars']));
        $_SESSION['star_character']   = $_POST['star_character'];
        $_SESSION['recorded_paging']  = $_POST['recorded_paging'];
    }
