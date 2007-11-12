<?php
/**
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/modules/mythtv/set_settings.php $
 * @date        $Date: 2006-12-19 00:17:33 -0800 (Tue, 19 Dec 2006) $
 * @version     $Revision: 12295 $
 * @author      $Author: xris $
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


