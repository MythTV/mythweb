<?php
/***                                                                        ***\
    settings.php                             Last Updated: 2004.11.29 (xris)

    main configuration index
\***                                                                        ***/

class Theme_settings extends Theme {

    function print_page() {
        $this->print_header();
?>

<div style="padding: 20px">
    <? echo t('settings: overview') ?>
    <p>
    <a href="settings_mythweb.php"><?php echo t('MythWeb Settings') ?></a>
    <p>
    <a href="settings_channels.php"><? echo t('Channels') ?></a>
    <p>
    <a href="settings_keys.php"><? echo t('Key Bindings') ?></a>
</div>

<?php
        $this->print_footer();
    }

    function print_menu_content() {
            ?><?php echo t('Configure') ?>: &nbsp; &nbsp;
                <a href="settings_mythweb.php">MythWeb</a>
                &nbsp; | &nbsp;
                <a href="settings_channels.php"><?php echo t('Channels') ?></a>
                &nbsp; | &nbsp;
                <a href="settings_keys.php"><?php echo t('Key Bindings') ?></a>
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
