<?php
/**
 * Make sure the database is at the most recent version
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// What *should* the database version be?
    define('WebDBSchemaVer', 4);

// What version does the database think it is?
    $db_vers = intval(setting('WebDBSchemaVer'));

    if ($db_vers < 0)
        $db_vers = 0;

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
                $db->query('DROP TABLE IF EXISTS mythweb_sessions');
                $db->query('CREATE TABLE mythweb_sessions (
                                id              VARCHAR(128) PRIMARY KEY NOT NULL DEFAULT "",
                                modified        TIMESTAMP,
                                data            BLOB NOT NULL,
                                INDEX (modified)
                            )');
                setting('WebDBSchemaVer', null, ++$db_vers, false);
				
        // Moving settings into the database
            case 1:
                setting('WebPrefer_Channum', null, 1, false);
                setting('WebDBSchemaVer',    null, ++$db_vers, false);
				
        // Add default width for recording details if they have not been set yet
            case 2:
                $width = intval(setting('WebFLV_w'));
                if ($width < 1) {
                    setting('WebFLV_w', null, 320, false);
                } elseif ($width < 160) {
                    setting('WebFLV_w', null, 160, false);
                }
                setting('WebDBSchemaVer',    null, ++$db_vers, false);
				
			case 3:
				setting('recommend_enabled', null, false);
				setting('recommend_server', null, 'http://myth-recommendations.aws.af.cm/');
				setting('recommend_key', null, 'REQUIRED');
				
                setting('WebDBSchemaVer',    null, ++$db_vers, false);
				
        // All other numbers should run their changes sequentially
            #case N:
            #    # do something to upgrade the database here
            #    $db_vers++;
        }
    }
