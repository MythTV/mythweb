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
        $_SESSION['prefer_channum'] = setting('WebPrefer_Channum', null, $_POST['prefer_channum'] ? 1 : 0);
    }

// These settings are limited to MythWeb itself
    $Settings_Hosts = 'MythWeb';

