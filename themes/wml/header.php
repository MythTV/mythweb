<?php
/***                                                                        ***\
    theme.php                             Last Updated: 2004.10.25 (jbuckshin)

    This is the main theme class for the Default MythWeb theme.  It should
    not be instantiated directly, but will most likely contain methods
    called from its child classes via the parent:: construct.
\***                                                                        ***/

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
<p><img src="<?php echo root ?>themes/wml/img/myth.wbmp" alt="mythtv"></img></p>
<p><a href="<?php echo root ?>tv/list"><?php echo t('Listings') ?></a></p>
<p><a href="<?php echo root ?>tv/upcoming"><?php echo t('Upcoming Recordings') ?></a></p>
<p><a href="<?php echo root ?>tv/recorded"><?php echo t('Recorded Programs') ?></a></p>
<p><a href="<?php echo root ?>tv/search"><?php echo t('Search') ?></a></p>
<p><a href="<?php echo root ?>status/xml"><?php echo t('Backend Status') ?></a></p>
