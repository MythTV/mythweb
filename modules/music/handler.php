<?php
/**
 * MythMusic browser
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Music
 *
/**/

// Compact theme uses the old music module
    if (tmpl == "compact") {
        require_once("modules/music/music_handler.php");
    }
    else {
        if (in_array($Path[1], array('mp3act_js.js.php', 'mp3act_fat.js', 'mp3act_hidden.php'))) {
            require_once 'modules/music/'.$Path[1];
            exit;
        }
        if (strstr($Path[1],"mp3act_playstream.php") != false) {
            require_once 'modules/music/mp3act_playstream.php';
            exit;
        }
        require_once 'modules/music/mp3act_main.php';
    }
