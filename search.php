<?php
/***                                                                        ***\
    search.php                               Last Updated: 2004.04.12 (xris)

    Searches the database for programs matching a particular query.
\***                                                                        ***/

// Initialize the script, database, etc.
    require_once "includes/init.php";
    require_once "includes/sorting.php";

// A single search string passed in
    if ($_GET['searchstr'] || $_POST['searchstr']) {
        unset($_SESSION['search']);
        $_SESSION['search']['searchstr']            = _or($_GET['searchstr'],            $_POST['searchstr']);
        $_SESSION['search']['search_title']         = _or($_GET['search_title'],         $_POST['search_title']);
        $_SESSION['search']['search_subtitle']      = _or($_GET['search_subtitle'],      $_POST['search_subtitle']);
        $_SESSION['search']['search_description']   = _or($_GET['search_description'],   $_POST['search_description']);
        $_SESSION['search']['search_category']      = _or($_GET['search_category'],      $_POST['search_category']);
        $_SESSION['search']['search_category_type'] = _or($_GET['search_category_type'], $_POST['search_category_type']);
        $_SESSION['search']['search_exact']         = _or($_GET['search_exact'],         $_POST['search_exact']);
    }
// Individual search strings for different fields
    elseif ($_GET['title'] || $_GET['subtitle'] || $_GET['description'] || $_GET['category'] || $_GET['category_type']
            || $_POST['title'] || $_POST['subtitle'] || $_POST['description'] || $_POST['category'] || $_POST['category_type']) {
        unset($_SESSION['search']);
        $_SESSION['search']['title']         = _or($_GET['title'],         $_POST['title']);
        $_SESSION['search']['subtitle']      = _or($_GET['subtitle'],      $_POST['subtitle']);
        $_SESSION['search']['description']   = _or($_GET['description'],   $_POST['description']);
        $_SESSION['search']['category']      = _or($_GET['category'],      $_POST['category']);
        $_SESSION['search']['category_type'] = _or($_GET['category_type'], $_POST['category_type']);
        $_SESSION['search']['search_exact']  = _or($_GET['search_exact'],  $_POST['search_exact']);
    }

// Start the query out as an array
    $query = array();
    if ($_SESSION['search']['search_exact'])
        $compare = ' = ';
    else
        $compare = ' LIKE ';

// How do we want to build this query?
    if (preg_match('/\\w/', $_SESSION['search']['searchstr'])) {
    // Normal search is an OR search
        $joiner = ' OR ';
    // Regex search?
        if (preg_match('/^~/', $_SESSION['search']['searchstr'])) {
            $compare = ' REGEXP ';
            $search = escape(preg_replace('/^~/', '', $_SESSION['search']['searchstr']));
        }
        else
            $search = search_escape($_SESSION['search']['searchstr']);
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
    // Perform the query
        $Results = &load_all_program_data(time(), strtotime('+1 month'), false, false, '('.implode($joiner, $query).')');
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
