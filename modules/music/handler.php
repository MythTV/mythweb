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

// Make sure the music directory exists
    if (file_exists('data/music')) {
    // File is not a directory or a symlink
        if (!is_dir('data/music') && !is_link('data/music')) {
            custom_error('An invalid file exists at data/music.  Please remove it in'
                        .' order to use the music portions of MythWeb.');
        }
    }
// Create the symlink, if possible.
//
// NOTE:  Errors have been disabled because if I turn them on, people hosting
//        MythWeb on Windows machines will have issues.  I will turn the errors
//        back on when I find a clean way to do so.
//
    else {
        $dir = $db->query_col('SELECT data
                                 FROM settings
                                WHERE value="MusicLocation" AND hostname=?',
                              hostname
                             );
        if ($dir) {
            $ret = @symlink($dir, 'data/music');
            if (!$ret) {
                #custom_error("Could not create a symlink to $dir, the local MythMusic directory"
                #            .' for this hostname ('.hostname.').  Please create a symlink to your'
                #            .' MythMusic directory at data/music in order to use the music'
                #            .' portions of MythWeb.');
            }
        }
        else {
            #custom_error('Could not find a value in the database for the MythMusic directory'
            #            .' for this hostname ('.hostname.').  Please create a symlink to your'
            #            .' MythMusic directory at data/music in order to use the music'
            #            .' portions of MythWeb.');
        }
    }

// Load the modules we'll need
    if (in_array($Path[1], array('mp3act_js.js.php', 'mp3act_fat.js', 'mp3act_hidden.php'))) {
        require_once 'modules/music/'.$Path[1];
        exit;
    }
    if (strstr($Path[1],'mp3act_playstream.php') != false) {
        require_once 'modules/music/mp3act_playstream.php';
        exit;
    }
// Too many messy headers/cookies errors in the main script -- wrapper it
// to avoid them.
    ob_start();
// Load the main module
    require_once 'modules/music/mp3act_main.php';

