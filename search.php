<?php
/***                                                                        ***\
	search.php                               Last Updated: 2003.08.06 (xris)

	Searches the database for programs matching a particular query.
\***                                                                        ***/

// Initialize the script, database, etc.
	require_once "includes/init.php";
	require_once "includes/sorting.php";

// Session variables for search types
	foreach (array('search_title', 'search_subtitle', 'search_description', 'search_category', 'search_category_type') as $search_var) {
		isset($_GET[$search_var]) or $_GET[$search_var] = $_POST[$search_var];
		#isset($_GET[$search_var]) or $_GET[$search_var] = $_SESSION[$search_var];
		#$_SESSION[$search_var] = $_GET[$search_bar];
	}

// Was there a search string?
	isset($_GET['searchstr'])      or $_GET['searchstr']      = $_POST['searchstr'];
	isset($_GET['title'])          or $_GET['title']          = $_POST['title'];
	isset($_GET['subtitle'])       or $_GET['subtitle']       = $_POST['subtitle'];
	isset($_GET['description'])    or $_GET['description']    = $_POST['description'];
	isset($_GET['category'])       or $_GET['category']       = $_POST['category'];
	isset($_GET['category_type'])  or $_GET['category_type']  = $_POST['category_type'];

// Start the query out as an array
	$query = array();
	$joiner = ' OR ';
	$compare = ' LIKE ';

// How do we want to build this query?
	if (preg_match('/^\~/', $_GET['searchstr'])) {
		$compare = ' REGEXP ';
		$search = regexp_escape($_GET['searchstr']);	
		if ($_GET['search_title'])
			$query[] = 'program.title '.$compare.' '.$search;
		if ($_GET['search_subtitle'])
			$query[] = 'program.subtitle '.$compare.' '.$search;
		if ($_GET['search_description'])
			$query[] = 'program.description '.$compare.' '.$search;
		if ($_GET['search_category'])
			$query[] = 'program.category '.$compare.' '.$search;
		if ($_GET['search_category_type'])
			$query[] = 'program.category_type '.$compare.' '.$search;
	// No query formed - default to quicksearch
		if (!count($query)) {
			$query[] = 'program.title '.$compare.' '.$search;
			$query[] = 'program.subtitle '.$compare.' '.$search;
			$_GET['search_title']    = true;
			$_GET['search_subtitle'] = true;
		}
	} else {

	if (preg_match('/\\w/', $_GET['searchstr'])) {
		$search = search_escape($_GET['searchstr']);
		if ($_GET['search_title'])
			$query[] = 'program.title '.$compare.' '.$search;
		if ($_GET['search_subtitle'])
			$query[] = 'program.subtitle '.$compare.' '.$search;
		if ($_GET['search_description'])
			$query[] = 'program.description '.$compare.' '.$search;
		if ($_GET['search_category'])
			$query[] = 'program.category '.$compare.' '.$search;
		if ($_GET['search_category_type'])
			$query[] = 'program.category_type '.$compare.' '.$search;
	// No query formed - default to quicksearch
		if (!count($query)) {
			$query[] = 'program.title '.$compare.' '.$search;
			$query[] = 'program.subtitle '.$compare.' '.$search;
			$_GET['search_title']    = true;
			$_GET['search_subtitle'] = true;
		}
	}

	else {
		$joiner = ' AND ';
		if (isset($_GET['title'])) {
			$query[] = 'program.title '.$compare.' '.search_escape($_GET['title']);
			$_GET['search_title'] = true;
		}
		if (isset($_GET['subtitle'])) {
			$query[] = 'program.subtitle '.$compare.' '.search_escape($_GET['subtitle']);
			$_GET['search_subtitle'] = true;
		}
		if (isset($_GET['description'])) {
			$query[] = 'program.description '.$compare.' '.search_escape($_GET['description']);
			$_GET['search_description'] = true;
		}
		if (isset($_GET['category'])) {
			$query[] = 'program.category '.$compare.' '.search_escape($_GET['category']);
			$_GET['search_category'] = true;
		}
		if (isset($_GET['category_type'])) {
			$query[] = 'program.category_type '.$compare.' '.search_escape($_GET['category_type']);
			$_GET['search_category_type'] = true;
		}
	}
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
		return escape('%'.preg_replace('/[\\s-_]+/', '%', $value).'%');
	}
	function regexp_escape($value) {
		return escape(preg_replace('/^\~/', '', $value));
	}

?>
