<?php
/**
 * Make sure the database is at the most recent version
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// What *should* the database version be?
    define('WebDBSchemaVer', 2);

// What version does the database think it is?
    $db_vers = setting('WebDBSchemaVer');

// The database is too new
    if ($db_vers > WebDBSchemaVer)
        trigger_error("Current database version of $db_vers is newer than"
                      ." the code base version ".WebDBSchemaVer,
                      FATAL);

// Older database that needs to be upgraded
    if ($db_vers < WebDBSchemaVer) {
        switch ($db_vers) {
        // No version, no database
            case 0:
                $db->query('CREATE TABLE mythweb_sessions (
                                id              VARCHAR(128) PRIMARY KEY NOT NULL DEFAULT "",
                                modified        TIMESTAMP,
                                data            BLOB NOT NULL DEFAULT "",
                                INDEX (modified)
                            )');
                setting('WebDBSchemaVer', null, ++$db_vers);
        // Moving settings into the database
            case 1:
                setting('WebPrefer_Channum', null, 1);
                setting('WebDBSchemaVer',    null, ++$db_vers);
        // All other numbers should run their changes sequentially
            #case 2:
            #    # do something to upgrade the database here
            #    $db_vers++;
        }
    }
