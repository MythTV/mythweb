<?php
/***                                                                        ***\
    search.php                               Last Updated: 2005.02.27 (xris)

    Searches the database for programs matching a particular query.
\***                                                                        ***/

// Which section are we in?
    define('section', 'tv');

// Initialize the script, database, etc.
    require_once "includes/init.php";
    require_once "includes/sorting.php";

// Load all channels
    load_all_channels();

// A single search string passed in
    if ($_GET['searchstr'] || $_POST['searchstr']) {
        unset($_SESSION['search']);
        $_SESSION['search']['searchstr']            = _or($_GET['searchstr'],            $_POST['searchstr']);
        $_SESSION['search']['search_title']         = _or($_GET['search_title'],         $_POST['search_title']);
        $_SESSION['search']['search_subtitle']      = _or($_GET['search_subtitle'],      $_POST['search_subtitle']);
        $_SESSION['search']['search_description']   = _or($_GET['search_description'],   $_POST['search_description']);
        $_SESSION['search']['search_category']      = _or($_GET['search_category'],      $_POST['search_category']);
        $_SESSION['search']['search_category_type'] = _or($_GET['search_category_type'], $_POST['search_category_type']);
    }
// Individual search strings for different fields
    elseif ($_GET['title'] || $_GET['subtitle'] || $_GET['description'] || $_GET['category'] || $_GET['category_type'] || $_GET['originalairdate']
            || $_POST['title'] || $_POST['subtitle'] || $_POST['description'] || $_POST['category'] || $_POST['category_type'] || $_POST['originalairdate'] ) {
        unset($_SESSION['search']);
        $_SESSION['search']['title']           = _or($_GET['title'],           $_POST['title']);
        $_SESSION['search']['subtitle']        = _or($_GET['subtitle'],        $_POST['subtitle']);
        $_SESSION['search']['description']     = _or($_GET['description'],     $_POST['description']);
        $_SESSION['search']['category']        = _or($_GET['category'],        $_POST['category']);
        $_SESSION['search']['category_type']   = _or($_GET['category_type'],   $_POST['category_type']);
        $_SESSION['search']['originalairdate'] = _or($_GET['originalairdate'], $_POST['originalairdate']);
    }
// Update some universal search settings
    if ($_GET['search_exact'] || $_POST['search_exact'])
        $_SESSION['search']['search_exact'] = _or($_GET['search_exact'], $_POST['search_exact']);
    if ($_GET['search_hd'] || $_POST['search_hd'])
        $_SESSION['search']['search_hd'] = _or($_GET['search_hd'], $_POST['search_hd']);

// Start the query out as an array
    $query       = array();
    $extra_query = array();
    if ($_SESSION['search']['search_exact'])
        $compare = ' = ';
    else
        $compare = ' LIKE ';

// HDTV only?
    if ($_SESSION['search']['search_hd'])
        $extra_query[] = 'hdtv=1';

// How do we want to build this query?
    if (preg_match('/\\S/', $_SESSION['search']['searchstr'])) {
        $search_str = $_SESSION['search']['searchstr'];
    // Normal search is an OR search
        $joiner = ' OR ';
    // If it starts with a pair of stars, it's a movie rating query
        if (preg_match('#(\\*+\s*(1/2\b|0?\.5\b|-)?)\s*#', $search_str, $stars)) {
            $starcount = substr_count($stars[1], '*') / 4.0;
            if (preg_match( "/1\\/2|\\.5|-/", $stars[1]))
                $starcount += 0.125;
        // Add this to the query -- convert european decimal to something mysql can understand
            $extra_query[] = 'program.stars >= '.str_replace(',', '.', $starcount);
        // Remove the stars from the search string so we can continue looking for other things
            $search_str = preg_replace('#(\\*+\s*(1/2\b|0?\.5\b|-)?)\s*#', '', $search_str);
        }
    // Regex search?
        if (preg_match('#^/(.+)/$#', $search_str, $match)) {
            $compare = ' REGEXP ';
            $search = escape($match[1]);
        }
        else
            $search = search_escape($search_str);
    // Build the query
        if ($_SESSION['search']['search_title'])
            $query[] = "program.title$compare$search";
        if ($_SESSION['search']['search_subtitle'])
            $query[] = "program.subtitle$compare$search";
        if ($_SESSION['search']['search_description'])
            $query[] = "program.description$compare$search";
        if ($_SESSION['search']['search_category'])
            $query[] = "program.category$compare$search";
        if ($_SESSION['search']['search_category_type'])
            $query[] = "program.category_type$compare$search";
    // No query formed - default to quicksearch
        if (!count($query)) {
            $query[] = "program.title$compare$search";
            $query[] = "program.subtitle$compare$search";
            $_SESSION['search']['search_title']    = true;
            $_SESSION['search']['search_subtitle'] = true;
        }
    }
    else {
    // Individual-field search is an AND search
        $joiner = ' AND ';
    // Build the query
        if ($_SESSION['search']['title'])
            $query[] = "program.title$compare".search_escape($_SESSION['search']['title']);
        if (isset($_SESSION['search']['subtitle']))
            $query[] = "program.subtitle$compare".search_escape($_SESSION['search']['subtitle']);
        if (isset($_SESSION['search']['description']))
            $query[] = "program.description$compare".search_escape($_SESSION['search']['description']);
        if (isset($_SESSION['search']['category']))
            $query[] = "program.category$compare".search_escape($_SESSION['search']['category']);
        if (isset($_SESSION['search']['category_type']))
            $query[] = "program.category_type$compare".search_escape($_SESSION['search']['category_type']);
        if (isset($_SESSION['search']['originalairdate']))
            $query[] = "program.originalairdate > NOW()";
    }

// No query?
    if (count($query) < 1)
        $Errors[] = 'Please search for something';

// Get ready to perform the query
    else {
    // Limit by start and end times?
        # obviously, we need to do something here
        # starttime
        # endtime
    // Build the query string
        $query = '('.implode($joiner, $query).')';
        if (count($extra_query))
            $query = "($query AND ".implode(' AND ', $extra_query).')';
    // Perform the query
        $Results =& load_all_program_data(time(), strtotime('+1 month'), NULL, false, $query);
    // Sort the results
        if (count($Results))
            sort_programs($Results, 'search_sortby');
    }

// Load the class for this page
    require_once theme_dir."search.php";

// Create an instance of this page from its theme object
    $Page = new Theme_search();

// Display the page
    $Page->print_page();

// Exit
    exit;

// One little function to help us format search queries
    function search_escape($value) {
    // If we are asking for an exact match, dont put the '%'s in
        if ($_SESSION['search']['search_exact'])
            return escape($value);
    // Replace whitespace with the % wildcard
        return escape('%'.preg_replace('/[\\s-_]+/', '%', $value).'%');
    }

?>
