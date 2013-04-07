<?php
/**
 * Display/save recommendation settings
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/

// Save?
    if ($_POST['save']) {
		setting('recommend_enabled', null, (bool)$_POST['recommend_enabled']);
		setting('recommend_server', null, $_POST['recommend_server']);
		setting('recommend_key', null, $_POST['recommend_key']);
    }

// These settings are limited to MythWeb itself
    $Settings_Hosts = 'MythWeb';
