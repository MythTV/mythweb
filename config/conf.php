<?php
/**
 * Global configuration for MythWeb.
 *
 * All end-user customizations (should?) happen here
 * Most of this should really by in a MySQL table with
 * a php interface to change it (someday...)
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

/*
 *  You probably don't need to edit anything below here, but the variables are
 *  provided for your convenience.
/*/

// Path to the mythvideo "covers" directory
    define('video_img_path', 'data/video_covers');

// video_url is normally determined automatically (a local link to data/recordings
//   for Linux/MacOS, and a myth:// URL for windows machines), but you can override
//   it here to something else if you really need to.
#   define('video_url', 'data/recordings');
#   define('video_url', 'file://machine_name/path_to_videos');
#   define('video_url', 'myth://slave_backend_ip:6543');

