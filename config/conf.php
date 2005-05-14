<?php
/***                                                                        ***\
    conf.php                                  Last Updated: 2005.05.13 (xris)

    global configuration for mythweb
\***                                                                        ***/

//
//  All end-user customizations (should?) happen here
//  Most of this should really by in a MySQL table with
//  a php interface to change it (someday...)
//

//
//  How to access the database
//
    define('db_host',     'localhost');
    define('db_username', 'mythtv');
    define('db_password', 'mythtv');
    define('db_dbname',   'mythconverg');

// The domain of this webserver, for cookie validation and other things.  If you
// don't have "canonical names" turned on in apache, you need to set this to the
// name or IP you use to access this server, or session data will not work.
// Turning on "canonical names" in apache's httpd.conf is the preferred option.
    define('server_domain', $_SERVER['SERVER_NAME'] ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST']);

// Email address to which php and database errors are mailed to
    define('Error_Email', 'php_errors@'.preg_replace('/.*?\b([\w\-]+\.[\w\-]+)$/', '$1', server_domain));

// For the "movies" search -- set this to the word your listings provider uses to
//   describe movies/films/peliculas/etc.
    define('movie_word', 'movie');

/***
    You probably don't need to edit anything below here, but the variables are
    provided for your convenience.
***/

// The hostname of this machine -- so you can override manually as needed
    define('hostname', chop(`/bin/hostname`));

// file system encoding, uses music and video file link to local file
    define('fs_encoding', 'ISO-8859-1');

// Path to the image cache directory
    define('image_cache', 'image_cache');

// Local (web-friendly) path to the mythtv video dir (use a symlink to the real one - one will be auto-created if it can be)
    define('video_dir', 'video_dir');

// Type of url for the links to mythmusic files. Filename will be added to the end.
// For this to work, create a 'music' symlink in mythweb which points to the path for mythmusic files.
    define('music_url', 'music');

// Path to the mythvideo "covers" directory
    define('video_img_path', '');

// video_url is normally determined automatically (a local link to video_dir for
//   Linux/MacOS, and a myth:// URL for windows machines), but you can override
//   it here to something else if you really need to.
#   define('video_url', video_dir);
#   define('video_url', 'file://machine_name/path_to_videos');
#   define('video_url', 'myth://slave_backend_ip:6543');

?>
