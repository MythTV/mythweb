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

// The domain of this webserver, for cookie validation and other things.  This
//  *should* work automatically as-is, but if cookies don't work, you may need
//  to manually set this to the full domain name of this server.
//
//    eg.  define('server_domain', 'example.com')
//
    define('server_domain', $_SERVER['SERVER_NAME'] ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST']);

// Email address to which php and database errors are mailed to.
//
//    eg. define('error_email', 'mythweb_errors@example.com');
//
//    Or the match below will send mail to your server, such that if your box is
//    defined as mythtv.mydomain.com in server_domain above, mail will go to
//    mythweb_errors@mydomain.com.
//
    define('error_email', 'mythweb_errors@'.preg_replace('/.*?\b([\w\-]+\.[\w\-]+)$/', '$1', server_domain));

/*
 *  You probably don't need to edit anything below here, but the variables are
 *  provided for your convenience.
/*/

// file system encoding, uses music and video file link to local file
    define('fs_encoding', 'ISO-8859-1');

// Path to the mythvideo "covers" directory
    define('video_img_path', 'data/video_covers');

// video_url is normally determined automatically (a local link to data/recordings
//   for Linux/MacOS, and a myth:// URL for windows machines), but you can override
//   it here to something else if you really need to.
#   define('video_url', 'data/recordings');
#   define('video_url', 'file://machine_name/path_to_videos');
#   define('video_url', 'myth://slave_backend_ip:6543');

