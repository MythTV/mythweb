<?php
/***                                                                        ***\
    settings.php                            Last Updated: 2003.08.22 (xris)

	main configuration index
\***                                                                        ***/

// Load the parent class for all settings pages
	require_once theme_dir.'settings.php';

class Theme_settings_mythweb extends Theme_settings {

	function print_page() {
		$this->print_header();
?>
This page will eventually contain user-specific settings for mythweb itself
<?php
		$this->print_footer();
	}

    function print_header() {
        parent::print_header("MythWeb - Configure Mythweb");
    }

	function print_footer() {
		parent::print_footer();
	}

}
?>
