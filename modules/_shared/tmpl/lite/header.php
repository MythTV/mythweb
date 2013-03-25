<?php
/**
 * This header file is shared by all MythWeb modules.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// UTF-8 content
    header("Content-Type: text/html; charset=utf-8");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <base href="<?php echo root_url; ?>">
    <title><?php echo html_entities($page_title) ?></title>

    <link rel="icon"          href="<?php echo skin_url ?>/img/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo skin_url ?>/img/favicon.ico" type="image/x-icon" />

    <link rel="apple-touch-icon" href="<?php echo skin_url ?>img/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo skin_url ?>img/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo skin_url ?>img/apple-touch-icon-114x114.png" />

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="robots" content="noindex, nofollow">

    <link rel="stylesheet" type="text/css" href="<?php echo skin_url ?>/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo skin_url ?>/header.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo skin_url ?>/menus.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo skin_url ?>/programming.css" />

<?php
    if (!empty($headers) && is_array($headers))
        echo '    ', implode("\n    ", $headers), "\n";
?>

</head>

<body>

<div id="page_header" class="clearfix">
    <div id="logo_box">
        <a id="mythtv_logo" href="<?php echo root_url; ?>">
        <img src="<?php echo skin_url ?>img/mythtv-logo.png" width="174" height="48" border="0" alt="MythTV" class="alpha_png">
        </a>
    </div>
    <div id="sections">
        <a id="tv_link"<?php if ($Path[0] == 'tv') echo ' class="current_section"' ?> href="tv" onmouseover="return help_text('<?php echo str_replace("'", "\\'", t('TV functions, including recorded programs.')) ?>')" onmouseout="return help_text()">
            <img src="<?php echo skin_url ?>img/tv.png" width="48" height="48" class="alpha_png" alt="MythTV"/>
        </a>
<?php if (Modules::getModule('music')) { ?>
        <a id="music_link"<?php if ($Path[0] == 'music') echo ' class="current_section"' ?> href="music" onmouseover="return help_text('<?php echo str_replace("'", "\\'", t('MythMusic on the web.')) ?>')" onmouseout="return help_text()">
            <img src="<?php echo skin_url ?>img/music.png" width="48" height="48" class="alpha_png" alt="MythMusic" />
        </a>
<?php
      }
      if (Modules::getModule('video')) {
?>
        <a id="video_link"<?php if ($Path[0] == 'video') echo ' class="current_section"' ?> href="video" onmouseover="return help_text('<?php echo str_replace("'", "\\'", t('MythVideo on the web.')) ?>')" onmouseout="return help_text()">
            <img src="<?php echo skin_url ?>img/video.png" width="48" height="48" class="alpha_png" alt="MythVideo" />
        </a>
<?php
      }
      if (Modules::getModule('weather')) {
?>
        <a id="weather_link"<?php if ($Path[0] == 'weather') echo ' class="current_section"' ?> href="weather" onmouseover="return help_text('<?php echo str_replace("'", "\\'", t('MythWeb Weather.')) ?>')" onmouseout="return help_text()">
            <img src="<?php echo skin_url ?>img/weather.png" width="48" height="48" class="alpha_png" alt="MythWeather" />
        </a>
<?php
      }
?>
        <a id="settings_link"<?php if ($Path[0] == 'settings') echo ' class="current_section"' ?> href="settings" onmouseover="return help_text('<?php echo str_replace("'", "\\'", t('Edit MythWeb and some MythTV settings.')) ?>')" onmouseout="return help_text()">
            <img src="<?php echo skin_url ?>img/settings.png" width="48" height="48" class="alpha_png" alt="<?php echo t('Settings') ?>" />
        </a>
    </div>
    <div id="extra_header">
        <div id="help_wrapper">
            <div id="help_box">
                <div id="help_text_default">
                MythWeb: <?php echo strftime($_SESSION['date_statusbar'], time()) ?>
                </div>
                <div id="help_text">
                </div>
            </div>
        </div>
        <div id="search">
            <form action="tv/search" method="get">
            <input type="hidden" name="type" value="q">
                <div id="simple_search">
                    <input id="search_text" type="text" name="s" size="15" value="<?php echo html_entities($_SESSION['search']['s']) ?>">
                    <input id="search_submit" type="submit" class="submit" name="search" value="<?php echo t('Search') ?>">
                    (<a href="tv/search"><?php echo t('Advanced') ?></a>)
                </div>
            </form>
        </div>
    </div>
</div>


<table width="100%" border="0" cellspacing="2" cellpadding="0">
<tr>

    <td colspan="2" class="menu menu_border_t menu_border_b"><table class="body" width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
            <td><div id="command_choices">
                    <a href="">MythTV:</a> &nbsp; &nbsp;
                    <a href="tv/list"><?php echo t('Listings') ?></a>
                    &nbsp; | &nbsp;
                    <a href="tv/searches"><?php echo t('Searches') ?></a>
                    &nbsp; | &nbsp;
                    <a href="tv/schedules"><?php echo t('Recording Schedules') ?></a>
                    (<a href="tv/schedules/manual"><?php echo t('Manual') ?></a>,
                    <a href="tv/schedules/custom"><?php echo t('Custom') ?></a>)
                    &nbsp; | &nbsp;
                    <a href="tv/upcoming"><?php echo t('Upcoming Recordings') ?></a>
                    &nbsp; | &nbsp;
                    <a href="tv/recorded"><?php echo t('Recorded Programs') ?></a>
                    &nbsp; | &nbsp;
                    <a href="status"><?php echo t('Backend Status') ?></a>
<?php if (Modules::getModule('backend_log')) { ?>
                    &nbsp; | &nbsp;
                    <a href="backend_log"><?php echo t('Backend Logs') ?></a>
<?php } ?>
                </div></td>
        </tr>
        </table></td>

</tr>
</table>

<?php
// Errors go here
    display_errors();
