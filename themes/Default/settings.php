<?php
/***                                                                        ***\
    settings.php                            Last Updated: 2003.08.22 (xris)

	main configuration index
\***                                                                        ***/

class Theme_settings extends Theme {

	function print_page() {
		$this->print_header();
?>
This is the index page for the configuration settings...
<p>
It should get some nifty images to link to the various sections, but for now, we get:
<p>
<a href="settings_mythweb.php">MythWeb</a>
<p>
<a href="settings_channels.php">Channels</a>

<?php
		$this->print_footer();
	}

	function print_menu_content() {
			?>Configure: &nbsp; &nbsp;
				<a href="settings_mythweb.php">MythWeb</a>
				&nbsp; | &nbsp;
				<a href="settings_channels.php">Channels</a>
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
