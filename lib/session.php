<?php
/**
 * This file handles all of the basic session-related information.
 *
 * It also uses the global variable $db, so it must be called from init.php
 * *after* the database connection has been established.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
 * @uses        $db
 *
/**/

// Start the session
    session_name('mythweb_id');
    session_set_cookie_params(60 * 60 * 24 * 365, '/');     // 1 year timeout on cookies
    ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);   // 30 day timeout on sessions
    session_set_save_handler('sess_do_nothing', 'sess_do_nothing', 'sess_read', 'sess_write', 'sess_destroy', 'sess_gc');
    session_start();

// Register a destruction handler for the db object, since the guys who write
// PHP are smoking something and think objects should be destroyed before the
// sessions get written:  http://us2.php.net/session_set_save_handler
    global $db;
    $db->register_destruct_handler('session_write_close');

/*
 *  The functions defined below are referenced above in session_set_save_handler()
/*/

/**
 * We don't actually have to do anything for open and close, since we connected to the database in init.php
/**/
    function sess_do_nothing() {
        return true;
    }

/**
 * Read the session data from the database
/**/
    function sess_read($id) {
        global $db;
        if (!empty($_SERVER['REMOTE_USER']))
            $id = 'user:'.$_SERVER['REMOTE_USER'];
        $data = $db->query_col('SELECT data
                                  FROM mythweb_sessions
                                 WHERE id = ?
                                    OR id = "default"
                              ORDER BY id = "default" ASC
                                 LIMIT 1',
                               $id
                               );
        if ($data)
            return $data;

        return '';
    }

/**
 * Write the session data to the database
/**/
    function sess_write($id, $data) {
        global $db;
        if (empty($db))
            return;
        if (!empty($_SERVER['REMOTE_USER']))
            $id = 'user:'.$_SERVER['REMOTE_USER'];
        $db->query('REPLACE INTO mythweb_sessions (id, modified, data) VALUES (?,NULL,?)',
                   $id, $data);
        if (!$db->affected_rows())
            return false;
    // Return true
        return true;
    }

/**
 * Destroy the session
/**/
    function sess_destroy($id) {
        global $db;
        if (!empty($_SERVER['REMOTE_USER']))
            $id = 'user:'.$_SERVER['REMOTE_USER'];
        $db->query('DELETE FROM mythweb_sessions WHERE id=?', $id);
        if (!$db->affected_rows())
            return true;
        return false;
    }

/**
 * Clear out any old sessions (we override $maxlifetime with our own variable)
/**/
    function sess_gc($maxlifetime) {
        global $db;
        $db->query('DELETE FROM mythweb_sessions WHERE NOW() > DATE_ADD(modified, INTERVAL ? SECOND) AND id != "default"',
                   $maxlifetime);
        return true;
    }
