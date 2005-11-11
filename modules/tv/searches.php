<?php
/***                                                                        ***\
    handy.php                            Last Updated: 2005.02.28 (xris)

    An index for handy SQL searches in the listings data
\***                                                                        ***/

// Which section are we in?
    define('section', 'tv');


// Initialize the script, database, etc.
    require_once "includes/init.php";

// Load the canned searches
    require_once "config/canned_searches.php";

// Load the class for this page
    require_once theme_dir.'canned_searches.php';

// Create an instance of this page from its theme object
    $Page = new Theme_canned_searches();

// Display the page
    $Page->print_page($Canned_Searches);

// Exit
    exit;

