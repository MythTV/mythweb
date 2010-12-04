<?php
/**
 * An index for handy SQL searches in the listings data
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Load the canned searches
    require_once 'modules/tv/canned_searches.conf.php';
// Load the local canned searches (if it exists)
    if (file_exists('configuration/canned_searches.conf.php'))
        include 'configuration/canned_searches.conf.php';

// Load the class for this page
    require_once tmpl_dir.'searches.php';

// Exit
    exit;
