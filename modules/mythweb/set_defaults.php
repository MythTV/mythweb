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
    // Video artwork directory
        $_POST['video_artwork_dir'] = trim($_POST['video_artwork_dir']);
        if (!empty($_POST['video_artwork_dir'])) {
            if (!file_exists($_POST['video_artwork_dir']))
                add_error('Video artwork directory "'.$_POST['video_artwork_dir'].'" doesn\'t exist.');
            elseif (!is_dir($_POST['video_artwork_dir']) && !is_link($_POST['video_artwork_dir']))
                add_error('Video artwork directory "'.$_POST['video_artwork_dir'].'" exists but is not a directory.');
            else {
                setting('VideoArtworkDir', hostname, $_POST['video_artwork_dir']);
            }
        }
    // MythVideo directory
        $_POST['mythvideo_dir'] = trim($_POST['mythvideo_dir']);
        if (!empty($_POST['mythvideo_dir'])) {
            if (!file_exists($_POST['mythvideo_dir']))
                add_error('MythVideo directory "'.$_POST['mythvideo_dir'].'" doesn\'t exist.');
            elseif (!is_dir($_POST['mythvideo_dir']) && !is_link($_POST['mythvideo_dir']))
                add_error('MythVideo directory "'.$_POST['mythvideo_dir'].'" exists but is not a directory.');
            else {
                setting('VideoStartupDir', hostname, $_POST['mythvideo_dir']);
            }
        }
    }

// These settings are limited to MythWeb itself
    $Settings_Hosts = 'MythWeb';

