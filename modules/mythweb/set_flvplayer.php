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
        setting('WebFLV_on', null, $_POST['flvplayer'] ? 1 : 0);
    // Dimensions
        setting('WebFLV_w',  null, $_POST['width']  > 0 ? $_POST['width']  : 320);
        setting('WebFLV_h',  null, $_POST['height'] > 0 ? $_POST['height'] : 240);
    // Bitrates
        setting('WebFLV_vb', null, $_POST['vbitrate'] > 0 ? $_POST['vbitrate'] : 256);
        setting('WebFLV_ab', null, $_POST['abitrate'] > 0 ? $_POST['abitrate'] : 64);

    }

// These settings are limited to MythWeb itself
    $Settings_Hosts = 'MythWeb';

