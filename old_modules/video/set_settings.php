<?php
/**
 * Video settings
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Weather
/**/

// Load all of the known mythtv frontend hosts
    $Settings_Hosts = array();
    $sh = $db->query('SELECT DISTINCT hostname
                        FROM settings
                       WHERE LENGTH(hostname) > 0
                    ORDER BY hostname');
    while (list($host) = $sh->fetch_row())
        $Settings_Hosts[$host] = $host;
    $sh->finish();

// Make sure we have a valid host selected
    if (!isset($Settings_Hosts[$_SESSION['settings']['host']]))
        $_SESSION['settings']['host'] = reset(array_keys($Settings_Hosts));

// Make sure the session host gets updated to the posted one.
    if (isset($_POST['host']))
        $_SESSION['settings']['host'] = $_POST['host'];

    if ($_POST['save']) {
        setting('web_video_imdb_path',          $_SESSION['settings']['host'], $_POST['web_video_imdb_path']);
        setting('web_video_imdb_type',          $_SESSION['settings']['host'], $_POST['web_video_imdb_type']);
        setting('VideoAggressivePC',            $_SESSION['settings']['host'], $_POST['VideoAggressivePC']);
        setting('VideoArtworkDir',              $_SESSION['settings']['host'], $_POST['VideoArtworkDir']);
        setting('VideoBrowserNoDB',             $_SESSION['settings']['host'], $_POST['VideoBrowserNoDB']);
        setting('VideoDefaultParentalLevel',    $_SESSION['settings']['host'], $_POST['VideoDefaultParentalLevel']);
        setting('VideoDefaultPlayer',           $_SESSION['settings']['host'], $_POST['VideoDefaultPlayer']);
        setting('VideoGalleryAspectRatio',      $_SESSION['settings']['host'], $_POST['VideoGalleryAspectRatio']);
        setting('VideoGalleryColsPerPage',      $_SESSION['settings']['host'], $_POST['VideoGalleryColsPerPage']);
        setting('VideoGalleryNoDB',             $_SESSION['settings']['host'], $_POST['VideoGalleryNoDB']);
        setting('VideoGalleryRowsPerPage',      $_SESSION['settings']['host'], $_POST['VideoGalleryRowsPerPage']);
        setting('VideoGallerySubtitle',         $_SESSION['settings']['host'], $_POST['VideoGallerySubtitle']);
        setting('VideoListUnknownFiletypes',    $_SESSION['settings']['host'], $_POST['VideoListUnknownFiletypes']);
        setting('VideoNewBrowsable',            $_SESSION['settings']['host'], $_POST['VideoNewBrowsable']);
        setting('VideoStartupDir',              $_SESSION['settings']['host'], $_POST['VideoStartupDir']);
        setting('VideoTreeLoadMetaData',        $_SESSION['settings']['host'], $_POST['VideoTreeLoadMetaData']);
        setting('VideoTreeNoDB',                $_SESSION['settings']['host'], $_POST['VideoTreeNoDB']);
        setting('Default MythVideo View',       $_SESSION['settings']['host'], $_POST['DefaultMythVideoView']);
        setting('mythvideo.sort_ignores_case',  $_SESSION['settings']['host'], $_POST['mythvideosort_ignores_case']);
        setting('mythvideo.db_folder_view',     $_SESSION['settings']['host'], $_POST['mythvideodb_folder_view']);
        setting('mythvideo.ImageCacheSize',     $_SESSION['settings']['host'], $_POST['mythvideoImageCacheSize']);
        setting('web_video_thumbnail_height',   $_SESSION['settings']['host'], $_POST['web_video_thumbnail_height']);
        setting('web_video_thumbnail_width',    $_SESSION['settings']['host'], $_POST['web_video_thumbnail_width']);
    }

    $imdb_path = setting('web_video_imdb_path', $_SESSION['settings']['host']);
// If the path is not set, we check the usual suspects...
    if (!$imdb_path && $_SESSION['settings']['host'] == hostname) {
        if (file_exists('/usr/share/mythtv/mythvideo/scripts/imdb.pl'))
            $imdb_path = '/usr/share/mythtv/mythvideo/scripts/imdb.pl';
        elseif (file_exists('/usr/local/share/mythtv/mythvideo/scripts/imdb.pl'))
            $imdb_path = '/usr/local/share/mythtv/mythvideo/scripts/imdb.pl';
    }
