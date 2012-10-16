<?php
/**
 * View MythVideo files
 *
 *
 * @package     MythWeb
 * @subpackage  Video
 *
/**/

/**
 * This points to the local filesystem path where MythVideo has been told to
 * look for videos.
 *
 * @global  string   $GLOBALS['mythvideo_dir']
 * @name    $mythvideo_dir
/**/

//// dont need this...
//    global $mythvideo_dir;
//    $mythvideo_dir = setting('VideoStartupDir', hostname);

// Load the video storage directories
    $video_dirs = $db->query_list('
        SELECT  dirname
        FROM    storagegroup
        WHERE   groupname="Videos"
        ');
    if (empty($video_dirs)) {
        custom_error('MythWeb now requires use of the Videos Storage Group.');
    }

// a extra function
    function makeImdbWebUrl($num) {
        $imdbwebtype = setting('web_video_imdb_type', hostname);
        switch ($imdbwebtype) {
            case 'ALLOCINE':    return "http://www.allocine.fr/film/fichefilm_gen_cfilm=".$num.".html";
            default:            return "http://www.imdb.com/Title?".$num;
        }
    }

/** nor any of this...
// Make sure the video directory exists
    if (file_exists('data/video')) {
    // File is not a directory or a symlink
        if (!is_dir('data/video') && !is_link('data/video')) {
            custom_error('An invalid file exists at data/video.  Please remove it in'
                        .' order to use the video portions of MythWeb.');
        }
    }
// Create the symlink, if possible.
    else {
        if ($mythvideo_dir) {
        // You can't symlink on windows
            if (strtoupper(substr(php_uname('s'), 0, 3)) != 'WIN') {
                $ret = @symlink($mythvideo_dir, 'data/video');
                if (!$ret) {
                    custom_error("Could not create a symlink to $mythvideo_dir, the local MythVideo"
                                .' directory for this hostname ('.hostname.').  Please create a'
                                .' symlink to your MythVideo directory at data/video in order to'
                                .' use the video portions of MythWeb.');
                }
            }
        }
        else {
            custom_error('Could not find a value in the database for the'
                        .' MythVideo directory for this hostname ('.hostname.').'
                        .' Please update your <a href="'.root_url.'settings/mythweb">settings</a>'
                        .' to point to the correct location.');
        }
    }

// Make sure the video covers directory exists
    if (file_exists('data/video_covers')) {
    // File is not a directory or a symlink
        if (!is_dir('data/video_covers') && !is_link('data/video_covers')) {
            custom_error('An invalid file exists at data/video_covers.  Please'
                        .' remove it in order to use the video portions of MythWeb.');
        }
    }
// Create the symlink, if possible.
    else {
        $artwork_dirs = $db->query_list('
            SELECT  dirname
            FROM    storagegroup
            WHERE   groupname="Coverart"
            ');
        if (empty($artwork_dirs)) {
            custom_error('MythWeb now requires use of the Coverart Storage Group.');
        }
    // You can't symlink on windows
        if (strtoupper(substr(php_uname('s'), 0, 3)) == 'WIN') {
            custom_error('MythWeb would like to create a symlink at data/video_covers,'
                        .' but this host is running Windows, which does not work with'
                        .' symbolic links.  Please create this directory manually and'
                        .' reload this page.');
        }
    // Create a symlink to the first artwork directory that we find.
    // @todo we should really support multiple directories, but it's too much effort to hack in at the moment.
        else {
            foreach ($artwork_dirs as $dir) {
                if (is_dir($dir) || is_link($dir)) {
                    $artwork_dir = $dir;
                    break;
                }
            }
            if (empty($artwork_dir)) {
                custom_error("Could not find any valid Coverart storage directories.  Please"
                            .' create a symlink to your Coverart storage directory at'
                            .' data/video_covers in order to use the video artwork portions'
                            .' of MythWeb.');
            }
            $ret = @symlink($artwork_dir, 'data/video_covers');
            if (!$ret) {
                custom_error("Could not create a symlink to $dir, the local MythVideo artwork"
                            .' directory for this hostname ('.hostname.').  Please create a'
                            .' symlink to your MythVideo directory at data/video_covers in order to'
                            .' use the video artwork portions of MythWeb.');
            }
        }
    }
*/

    define('video_img_height',  _or(setting('web_video_thumbnail_height', hostname), 140));
    define('video_img_width',   _or(setting('web_video_thumbnail_width', hostname),   94));

// Load a custom page
    switch ($Path[1]) {
        case 'edit':
            require_once 'modules/video/edit.php';
            exit;
//// this is probably doing bad things
//        case 'imdb':
//            require_once 'modules/video/imdb.php';
//            exit;
//// this is broken, so disable it
//        case 'scan':
//            require_once 'modules/video/scan.php';
//            exit;
//// new stuff
        case 'stream':
            require_once 'modules/video/stream.php';
            exit;
    }

// Get the filesystem layout
    $PATH_TREE = array();
    $sh = $db->query('
        SELECT      DISTINCT IF(INSTR(filename,"/"), LEFT(filename, CHAR_LENGTH(filename) - LOCATE("/", REVERSE(filename))), "/") AS dirname
        FROM        videometadata
        ORDER BY    dirname');
    while ($dirname = $sh->fetch_col()) {
    // Skip the root path, which we already know exists
        if ($dirname == '/')
            continue;
    // Split up the path into individual directories
        $paths = explode('/', $dirname);
    // Process the basename
        $dir = array_shift($paths);
        if (empty($PATH_TREE[$dir])) {
            $PATH_TREE[$dir] = array(
                'display' => $dir,
                'path'    => "/$dir",
                'subs'    => array()
                );
        }
        $PATH = &$PATH_TREE[$dir];
    // And any subdirectories
        if (!empty($paths)) {
            foreach ($paths AS $key => $path) {
                if (empty($path))
                    continue;
                if (!isset($PATH['subs'][$path])) {
                    $p = '';
                    for ($i=0; $i<=$key;$i++) {
                        $p .= '/'.$paths[$i];
                    }
                    $PATH['subs'][$path] = array('display' => $path,
                                                 'path'    => "/$dir/$p",
                                                 'subs'    => array());
                }
                $PATH = &$PATH['subs'][$path];
            }
        }
        unset($PATH);
    }
    $sh->finish();

    function output_path_picker($path, $padding=0) {
        for ($i = 0; $i < $padding; $i++) {
            echo '&nbsp;&nbsp;&nbsp;&nbsp;';
        }
        if (strlen($path['path']) > 0) {
            echo '<a class="'.($_SESSION['video']['path'] == $path['path']?'active':'').'" href="'.root_url.'video?path='.urlencode($path['path']).'">'.$path['display']."</a><br>\n";
        }
        if (count($path['subs'])) {
            foreach ($path['subs'] AS $p) {
                output_path_picker($p, $padding+1);
            }
        }
    }

// Load the sorting routines
    require_once 'includes/sorting.php';

// Get the video categories on the system
    $Category_String = array();
    $sh = $db->query('SELECT * FROM videocategory ORDER BY category');
    while ($row = $sh->fetch_assoc())
        $Category_String[$row['intid']] = $row['category'];
    $sh->finish();
    $Category_String[0] = t('Uncategorized');

// New:  Get the video genres on the system
    $Genre_String = array();
    $sh = $db->query('SELECT * FROM videogenre ORDER BY genre');
    while ($row = $sh->fetch_assoc())
        $Genre_String[$row['intid']] = $row['genre'];
    $sh->finish();
    $Genre_String[0] = t('No Genre');

// Parse the list
// Filter_Category of -1 means All, 0 mean uncategorized
    $Total_Programs = 0;
    $All_Videos     = array();
    if (isset($_REQUEST['category']) ) {
        $Filter_Category = $_REQUEST['category'];
        if ($Filter_Category != -1) {
            $where = ' AND videometadata.category='.$db->escape($Filter_Category);
        }
    }
    else
        $Filter_Category = -1;

// New:  sort fields
    if (isset($_REQUEST['genre']) ) {
        $Filter_Genre = $_REQUEST['genre'];
        if ($Filter_Genre != -1) {
            $where .= ' AND videometadatagenre.idgenre='.$db->escape($Filter_Genre);
        }
    }
    else {
        $Filter_Genre = -1;
    }

    if (isset($_REQUEST['browse']))
        $_SESSION['video']['browse'] = $_REQUEST['browse'];

    if (isset($_SESSION['video']['browse']) ) {
        $Filter_Browse = $_SESSION['video']['browse'];
        if ($Filter_Browse != -1) {
            $where .= ' AND videometadata.browse='.$db->escape($Filter_Browse);
        }
    }
    else {
        $Filter_Browse = -1;
    }

    if (isset($_REQUEST['search']) ) {
        $Filter_Search = $_REQUEST['search'];
        if (strlen($Filter_Search) != 0)
            $where .= ' AND videometadata.title LIKE '.$db->escape("%".$Filter_Search."%");
    }
    else
        $Filter_Search = "";

    if (isset($_REQUEST['path'])) {
        $_REQUEST['path'] = str_replace('//', '/', $_REQUEST['path']);
        $_SESSION['video']['path'] = preg_replace('#^/*#', '/', preg_replace('#/+$#', '', $_REQUEST['path']));
    }

    if (isset($_SESSION['video']['path'])) {
        $where .= ' AND CONCAT("/", IF(INSTR(filename,"/"), LEFT(filename, CHAR_LENGTH(filename) - LOCATE("/", REVERSE(filename))), "")) = '.$db->escape($_SESSION['video']['path']);
    }
// Deal with the parental locks
    if (isset($_REQUEST['VideoAdminPassword']))
        $_SESSION['video']['VideoAdminPassword'] = $_REQUEST['VideoAdminPassword'];

    if ($_SESSION['video']['VideoAdminPassword'] != setting('VideoAdminPassword', hostname))
        $where .= ' AND videometadata.showlevel <= '.$db->escape(setting('VideoDefaultParentalLevel', hostname));

    if ($where)
        $where = 'WHERE '.substr($where, 4);

    $sh = $db->query('
        SELECT      videometadata.intid
        FROM        videometadata
        LEFT JOIN   videometadatagenre
                 ON videometadata.intid = videometadatagenre.idvideo
        ' . $where . '
        GROUP BY    intid
        ORDER BY    title,season,episode');
    while ($intid = $sh->fetch_col()) {
        $All_Videos[] = new Video($intid);
    }
    $sh->finish();

// Set sorting
    if (!is_array($_SESSION['video_sortby']))
        $_SESSION['video_sortby'] = array(array('field'   => 'title',
                                                'reverse' => false));

// Load the class for this page
    require_once tmpl_dir.'video.php';
