<?php
/***                                                                        ***\
    settings.php                            Last Updated: 2003.08.22 (xris)

    main configuration index
\***                                                                        ***/

class Theme_settings extends Theme {

    function print_page() {
        $this->print_header();
?>
<? echo _LANG_SETTINGS_HEADER1?>
<p>
<? echo _LANG_SETTINGS_HEADER2?>
<p>
<a href="settings_mythweb.php">MythWeb</a>
<p>
<a href="settings_channels.php"><? echo _LANG_CHANNELS?></a>
<p>
<a href="settings_keys.php"><? echo _LANG_KEY_BINDINGS?></a>
<?php
        $this->print_footer();
    }

    function print_menu_content() {
            ?><?php echo _LANG_CONFIGURE?>: &nbsp; &nbsp;
                <a href="settings_mythweb.php">MythWeb</a>
                &nbsp; | &nbsp;
                <a href="settings_channels.php"><?php echo _LANG_CHANNELS?></a>
                &nbsp; | &nbsp;
                <a href="settings_keys.php"><?php echo _LANG_KEY_BINDINGS?></a>
<?php
    }

    function print_header() {
        parent::print_header("MythWeb - Configure");
    }

    function print_footer() {
        parent::print_footer();
    }

}
?>
