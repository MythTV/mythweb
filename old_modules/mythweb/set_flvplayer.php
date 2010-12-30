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
    // Validaton
        if ($_POST['width'] < 1)
            $_POST['width'] = 320;
        elseif ($_POST['width'] < 160)
            $_POST['width'] = 160;
    // Turn on/off
        setting('WebFLV_on', null, $_POST['flvplayer'] ? 1 : 0);
    // Dimensions...
        setting('WebFLV_w',  null, $_POST['width']);
    // Bitrates
        setting('WebFLV_vb', null, $_POST['vbitrate'] > 0 ? $_POST['vbitrate'] : 256);
        setting('WebFLV_ab', null, $_POST['abitrate'] > 0 ? $_POST['abitrate'] : 64);

    }

// These settings are limited to MythWeb itself
    $Settings_Hosts = 'MythWeb';

