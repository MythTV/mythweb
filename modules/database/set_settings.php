<?php
/**
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/

    $tables = $db->query('SHOW TABLES');
    while ($table = $tables->fetch_col()) {
        if ($_REQUEST['action'] == t('Optimize Tables')) {
            $db->query("OPTIMIZE TABLE $table");
            $db->query("ANALYZE TABLE $table");
        }

        if ($_REQUEST['action'] == t('Repair Tables'))
            $db->query("REPAIR TABLE $table");

        if ($_REQUEST['action'] != t('Extended Check'))
            $Tables[$table]['check']  = $db->query_assoc("CHECK TABLE $table");
        else
            $Tables[$table]['check']  = $db->query_assoc("CHECK TABLE $table EXTENDED");
    }


