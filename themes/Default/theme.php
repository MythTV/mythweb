<?php
/***                                                                        ***\
    theme.php                             Last Updated: 2005.01.23 (xris)

    This is the main theme class for the Default MythWeb theme.  It should
    not be instantiated directly, but will most likely contain methods
    called from its child classes via the parent:: construct.
\***                                                                        ***/

class Theme {

    function print_header($page_title = 'MythWeb') {
// Print the appropriate header information
        header("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">

    <title><?php echo $page_title?></title>

    <link rel="stylesheet" href="<?php echo theme_dir?>style.css" type="text/css">
    <link rel="stylesheet" href="<?php echo theme_dir?>menus.css" type="text/css">

    <script type="text/javascript" src="js/init.js"></script>
</head>

<body bgcolor="#003060" text="#DEDEDE" link="#3181B4" alink="#CC0000" vlink="#3181B4">

<p>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
<tr>
    <td rowspan="2" width="300" align="center" valign="top"><a href="http://www.mythtv.org"><img src="<?php echo theme_dir?>img/mythtv-logo.png" height="110" width="290" border="0" alt="MythTV" style="behavior: url('<?php echo theme_dir?>pngbehavior.htc');"></a></td>
    <td colspan="2" align="right"><table border="0" cellspacing="2" cellpadding="2" style="padding-right: 10px">
        <tr>
<?
//  Work in a random quote (anybody got more of these?)
    $quote = array();
    switch(rand(1,6)) {
        case 1:
            $quote['text']   = "Basically, I want the mythical convergence box that's been talked about for a few years now.";
            $quote['author'] = "Isaac Richards";
            break;
        case 2:
            $quote['text']   = "Anytime you skip a commercial ... you're actually stealing the programming.";
            $quote['author'] = "Jamie Kellner (then CEO, Turner Broadcasting)";
            break;
        case 3:
            $quote['text']   = "I say to you that the VCR is to the ... American public as the Boston strangler is to the woman home alone.";
            $quote['author'] = "Jack Valenti (CEO, MPAA)";
            break;
        case 4:
            $quote['text']   = "I am becoming more and more convinced that intellectual property is on a collision course with personal liberty.";
            $quote['author'] = "Posted on Slashdot";
            break;
        case 5:
            $quote['text']   = "I think that consumers just won't buy devices that don't let them do what they want to do.";
            $quote['author'] = "Linus Torvalds";
            break;
        case 6:
            $quote['text']   = "More education is necessary. One form of education is lawsuits.";
            $quote['author'] = "Jonathan Lamy (Spokesperson, RIAA)";
            break;
    }
?>
            <td><i><?php echo $quote['text']?></i></td>
        </tr><tr>
            <td colspan="2" align="right"><small>- <?php echo $quote['author']?></small></td>
        </tr>
        </table></td>
</tr><tr>

    <td valign="bottom"><table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr align="center">
            <td valign="top"><?php echo t('Go To') ?>: &nbsp; &nbsp;
                <a href="program_listing.php">MythTV</a>
                &nbsp; | &nbsp;
                <a href="mythmusic.php">MythMusic</a>
                &nbsp; | &nbsp;
                <a href="video.php">MythVideo</a>
                &nbsp; | &nbsp;
                <a href="weather.php">MythWeather</a>
                &nbsp; | &nbsp;
                <a href="settings.php"><?php echo t('Settings') ?></a></td>



            <td align="right">
                <form action="search.php" method="post">
                <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td><input type="text" name="searchstr" size="15" value="<?php echo htmlentities($_SESSION['search']['searchstr'], ENT_COMPAT, 'UTF-8') ?>"></td>
                    <td>&nbsp; <input type="submit" class="submit" value="<?php echo t('Search') ?>"></td>
                </tr>
                <tr>
                    <td align="right" colspan=3>&nbsp; <a href="search.php">[<? echo t('advanced') ?>]</a></td>
                <tr>
                </table>
                </form></td>

        </tr>
        </table></td>
</tr><tr>

    <td colspan="2" class="menu menu_border_t menu_border_b"><table class="body" width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
            <td><?php $this->print_menu_content() ?></td>
            <td align="right"><?php echo strftime($_SESSION['date_statusbar'], time())?></td>
        </tr>
        </table></td>

</tr>
</table>
</p>
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
        # really should move the category_legend footnote to this section,
        # so it doesn't render in other sections
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

<div id="category_legend_popup">
<table width="400" bgcolor="#003060" border="1" cellpadding="0" cellspacing="0">
<tr>
    <td><table width="400" bgcolor="#003060" class="small" cellpadding="5" cellspacing="5">
        <tr>
            <td colspan="3"><?php echo t('Category Legend') ?>:</td><?php
    $count = 0;
    global $Categories;
    foreach ($Categories as $cat => $details) {
        if ($count++ % 3 == 0)
            echo "\n\t\t</tr><tr>\n";
        echo "\t\t\t<td class=\"cat_$cat\" align=\"center\"><b>".htmlentities($details[0], ENT_COMPAT, 'UTF-8')."</b></td>\n";
    }
        ?>
        </tr>
        </table></td>
</tr>
</table>
</div>

</body>
</html>
<?
    }
}


?>
