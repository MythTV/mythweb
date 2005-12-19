<?php
/***                                                                        ***\
    theme.php                             Last Updated: 2004.10.25 (jbuckshin)

    This is the main theme class for the Default MythWeb theme.  It should
    not be instantiated directly, but will most likely contain methods
    called from its child classes via the parent:: construct.
\***                                                                        ***/

class Theme {

    function print_header($page_title = 'MythWeb') {
        // Print the appropriate header information
        header("Content-Type: text/vnd.wap.wml");
        //header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        //header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");

        echo "<?php xml version=\"1.0\" ?>"
?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">

<wml>

<card id="main" title="MythWeb">
<p><img src="<?php echo theme_dir ?>img/myth.wbmp" alt="mythtv"></img></p>
<?php
    }

    function print_menu_content() {
?>
<p><a href="program_listing.php"><?php echo t('Listings') ?></a></p>
<p><a href="scheduled_recordings.php"><?php echo t('Upcoming Recordings') ?></a></p>
<p><a href="recorded_programs.php"><?php echo t('Recorded Programs') ?></a></p>
<p><a href="search.php"><?php echo t('Search') ?></a></p>
<p><a href="<?php echo theme_dir ?>status.php"><?php echo t('Backend Status') ?></a></p>
<?php
    }

    function print_footer() {
?>
</wml>
<?php
    }
}

