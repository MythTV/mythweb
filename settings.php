<?php
/***                                                                        ***\
    settings.php                            Last Updated: 2005.01.23 (xris)

    main configuration index
\***                                                                        ***/

// Which section are we in?
    define('section', 'settings');

// Initialize the script, database, etc.
    require_once "includes/init.php";

// Load the class for this page
    require_once theme_dir.'settings.php';

// Create an instance of this page from its theme object
    $Page = new Theme_settings();

// Display the page
    $Page->print_page();

// Exit
    exit;

?>
