<?php
/***                                                                        ***\
    theme.php                             Last Updated: 2005.02.27 (xris)

    This is the main theme class for the Default MythWeb theme.  It should
    not be instantiated directly, but will most likely contain methods
    called from its child classes via the parent:: construct.
\***                                                                        ***/

class Theme {

    var $headers = array(); // Any extra headers that child objects might want to display.

    function print_header($page_title = 'MythWeb') {
// Print the appropriate header information
        header("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">

    <title><?php echo $page_title?></title>

    <link rel="stylesheet" type="text/css" href="<?php echo theme_dir?>style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo theme_dir?>header.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo theme_dir?>menus.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo theme_dir?>programming.css" />
    <script type="text/javascript" src="js/init.js"></script>
<?php
    if (count($this->headers)) {
        echo "\n";
        foreach ($this->headers as $header) {
            echo "    $header\n";
        }
    }
?>
</head>

<body>

<div id="page_header" class="clearfix">
    <div id="logo_box">
        <a id="mythtv_logo" href="http://www.mythtv.org">
        <img src="<?php echo theme_dir?>img/mythtv-logo.png" width="174" height="48" border="0" alt="MythTV" class="alpha_png">
        </a>
    </div>
    <div id="sections">
        <a id="tv_link"<?php if (section == 'tv') echo ' class="current_section"' ?> href="program_listing.php" onmouseover="return help_text('<?php echo str_replace("'", "\\'", t('TV functions, including recorded programs.')) ?>')" onmouseout="return help_text()">
            <img src="<?php echo theme_dir ?>img/tv.png" width="48" height="48" class="alpha_png" alt="MythTV"/>
        </a>
        <a id="music_link"<?php if (section == 'music') echo ' class="current_section"' ?> href="music.php" onmouseover="return help_text('<?php echo str_replace("'", "\\'", t('MythMusic on the web.')) ?>')" onmouseout="return help_text()">
            <img src="<?php echo theme_dir ?>img/music.png" width="48" height="48" class="alpha_png" alt="MythMusic" />
        </a>
        <a id="video_link"<?php if (section == 'video') echo ' class="current_section"' ?> href="video.php" onmouseover="return help_text('<?php echo str_replace("'", "\\'", t('MythVideo on the web.')) ?>')" onmouseout="return help_text()">
            <img src="<?php echo theme_dir ?>img/video.png" width="48" height="48" class="alpha_png" alt="MythVideo" />
        </a>
        <a id="weather_link"<?php if (section == 'weather') echo ' class="current_section"' ?> href="weather.php" onmouseover="return help_text('<?php echo str_replace("'", "\\'", t('MythWeb Weather.')) ?>')" onmouseout="return help_text()">
            <img src="<?php echo theme_dir ?>img/weather.png" width="48" height="48" class="alpha_png" alt="MythWeather" />
        </a>
        <a id="settings_link"<?php if (section == 'settings') echo ' class="current_section"' ?> href="settings.php" onmouseover="return help_text('<?php echo str_replace("'", "\\'", t('Edit MythWeb and some MythTV settings.')) ?>')" onmouseout="return help_text()">
            <img src="<?php echo theme_dir ?>img/settings.png" width="48" height="48" class="alpha_png" alt="<?php echo t('Settings') ?>" />
        </a>
    </div>
    <div id="extra_header">
        <div id="help_wrapper">
            <div id="help_box">
                <div id="help_text_default">
                MythWeb: <?php echo strftime($_SESSION['date_statusbar'], time())?>
                </div>
                <div id="help_text">
                </div>
            </div>
        </div>
        <div id="search" onmouseover="popup('search', 'search_options', 0, 0, false, true); return true;">
            <form action="search.php" method="post">
                <div id="simple_search">
                    <input id="search_text" type="text" name="searchstr" size="15" value="<?php echo htmlentities($_SESSION['search']['searchstr'], ENT_COMPAT, 'UTF-8') ?>">
                    <input id="search_submit" type="submit" class="submit" value="<?php echo t('Search') ?>">
                </div>
                <div id="search_options">
                    <?php echo t('Search fields') ?>:<br />
                    <!-- is there a better way to do this cleanly without tables ---- enlighten me, please! -->
                    <div class="search_table clearfix">
                        <div class="cell">
                            <input type="checkbox" class="radio" id="search_title" name="search_title" value="1"<?php echo $_SESSION['search']['search_title'] ? ' CHECKED' : ''?>>
                            <a onclick="get_element('search_title').checked=get_element('search_title').checked ? false : true;"><?php echo t('Title') ?></a>
                        </div>
                        <div class="cell">
                            <input type="checkbox" class="radio" id="search_subtitle" name="search_subtitle" value="1"<?php echo $_SESSION['search']['search_subtitle'] ? ' CHECKED' : ''?>>
                            <a onclick="get_element('search_subtitle').checked=get_element('search_subtitle').checked ? false : true;"><?php echo t('Subtitle') ?></a>
                        </div>
                        <div>
                            <input type="checkbox" class="radio" id="search_description" name="search_description" value="1"<?php echo $_SESSION['search']['search_description'] ? ' CHECKED' : ''?>>
                            <a onclick="get_element('search_description').checked=get_element('search_description').checked ? false : true;"><?php echo t('Description') ?></a>
                        </div>
                        <br/>
                        <div class="cell">
                            <input type="checkbox" class="radio" id="search_category" name="search_category" value="1"<?php echo $_SESSION['search']['search_category'] ? ' CHECKED' : ''?>>
                            <a onclick="get_element('search_category').checked=get_element('search_category').checked ? false : true;"><?php echo t('Category') ?></a>
                        </div>
                        <div>
                            <input type="checkbox" class="radio" id="search_category_type" name="search_category_type" value="1"<?php echo $_SESSION['search']['search_category_type'] ? ' CHECKED' : ''?>>
                            <a onclick="get_element('search_category_type').checked=get_element('search_category_type').checked ? false : true;"><?php echo t('Category Type') ?></a>
                        </div>
                    </div>
                    <hr/>
                    <?php echo t('Search options') ?>:<br />
                    <div class="search_table clearfix">
                        <div class="cell">
                            <input type="checkbox" class="radio" id="search_exact" name="search_exact" value="1"<?php echo $_SESSION['search']['search_exact'] ? ' CHECKED' : ''?>>
                            <a onclick="get_element('search_exact').checked=get_element('search_exact').checked ? false : true;"><?php echo t('Exact Match') ?></a>
                        </div>
                        <div>
                            <input type="checkbox" class="radio" id="search_hd" name="search_hd" value="1"<?php echo $_SESSION['search']['search_hd'] ? ' CHECKED' : ''?>>
                            <a onclick="get_element('search_hd').checked=get_element('search_hd').checked ? false : true;"><?php echo t('HD Only') ?></a>
                        </div>
                    </div>

                    <hr/>
                    <?php echo t('Search help') ?>:
                    <dl>
                        <dt><?php echo t('Search help: movie search')  ?>:</dt>
                        <dd><?php echo t('Search help: movie example') ?></dd>
                        <dt><?php echo t('Search help: regex search')  ?>:</dt>
                        <dd><?php echo t('Search help: regex example') ?></dd>
                    </dl>
                </div>
            </form>
        </div>
    </div>
</div>


<table width="100%" border="0" cellspacing="2" cellpadding="0">
<tr>

    <td colspan="2" class="menu menu_border_t menu_border_b"><table class="body" width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
            <td><?php $this->print_menu_content() ?></td>
        </tr>
        </table></td>

</tr>
</table>

<?
    }

    function print_menu_content() {
        ?><a id="category_legend" onmouseover="popup('category_legend'); return true;">MythTV:</a> &nbsp; &nbsp;
                <a href="program_listing.php"><?php echo t('Listings') ?></a>
                &nbsp; | &nbsp;
                <a href="search.php?category_type=<?php echo movie_word?>"><?php echo t('Movies') ?></a>
                <?/*&nbsp; | &nbsp;
                <a href="index.php?mode=favourites"><?php echo t('Favorites') ?></a>*/?>
                &nbsp; | &nbsp;
                <a href="schedule_manually.php"><?php echo t('Manually Schedule') ?></a>
                &nbsp; | &nbsp;
                <a href="recording_schedules.php"><?php echo t('Recording Schedules') ?></a>
                &nbsp; | &nbsp;
                <a href="scheduled_recordings.php"><?php echo t('Scheduled Recordings') ?></a>
                &nbsp; | &nbsp;
                <a href="recorded_programs.php"><?php echo t('Recorded Programs') ?></a>
                &nbsp; | &nbsp;
                <a href="status.php"><?php echo t('Backend Status') ?></a><?php
    // Create the category legend popup
        global $Categories, $Footnotes;
        $legend = <<<EOF
<div id="category_legend_popup">
<table width="400" bgcolor="#003060" border="1" cellpadding="0" cellspacing="0">
<tr>
    <td><table width="400" bgcolor="#003060" class="small" cellpadding="5" cellspacing="5">
        <tr>
EOF;
            $legend .= "\t\t\t<td colspan=\"3\">".t('Category Legend').':</td>';
            $count = 0;
            foreach ($Categories as $cat => $details) {
                if ($count++ % 3 == 0)
                    $legend .= "\n\t\t</tr><tr>\n";
                $legend .= "\t\t\t<td class=\"cat_$cat\" align=\"center\"><b>".htmlentities($details[0], ENT_COMPAT, 'UTF-8')."</b></td>\n";
            }
            $legend .= <<<EOF
        </tr>
        </table></td>
</tr>
</table>
</div>
EOF;
            $Footnotes[] = $legend;
        }

    function print_footer() {
/*?>
<p align="center">
<font size="-1">MythWeb is part of the <a href="http://www.mythtv.org">MythTV</a> Project</font>
</p>

<?*/
// Display footnotes
    global $Footnotes;
    if (is_array($Footnotes)) {
        foreach ($Footnotes as $note) {
            echo $note;
        }
    }
?>

</body>
</html>
<?
    }
}


?>
