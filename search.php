<?php
/***                                                                        ***\
	search.php                               Last Updated: 2003.07.24 (xris)

	Searches the database for programs matching a particular query.
\***                                                                        ***/

// Initialize the script, database, etc.
	require_once "includes/init.php";

// Session variables for search types
	foreach (array('search_title', 'search_subtitle', 'search_description', 'search_category', 'search_category_type') as $search_var) {
		isset($_GET[$search_var]) or $_GET[$search_var] = $_POST[$search_var];
		#isset($_GET[$search_var]) or $_GET[$search_var] = $_SESSION[$search_var];
		#$_SESSION[$search_var] = $_GET[$search_bar];
	}

// Was there a search string?
	$_GET['searchstr'] or $_GET['searchstr'] = $_POST['searchstr'];
	if (preg_match('/\\w/', $_GET['searchstr'])) {
		$query = array();
		if ($_GET['search_title'])
			$query[] = 'program.title LIKE '.escape('%'.$_GET['searchstr'].'%');
		if ($_GET['search_subtitle'])
			$query[] = 'program.subtitle LIKE '.escape('%'.$_GET['searchstr'].'%');
		if ($_GET['search_description'])
			$query[] = 'program.description LIKE '.escape('%'.$_GET['searchstr'].'%');
		if ($_GET['search_category'])
			$query[] = 'program.category LIKE '.escape('%'.$_GET['searchstr'].'%');
		if ($_GET['search_category_type'])
			$query[] = 'program.category_type LIKE '.escape('%'.$_GET['searchstr'].'%');
	// No query formed - default to quicksearch
		if (!count($query)) {
			$query[] = 'program.title LIKE '.escape('%'.preg_replace('/[\\s-_]+/', '%', $_GET['searchstr']).'%');
			$query[] = 'program.subtitle LIKE '.escape('%'.preg_replace('/[\\s-_]+/', '%', $_GET['searchstr']).'%');
			$_GET['search_title'] = true;
			$_GET['search_subtitle'] = true;
		}
	// No query?
		if (count($query) < 1) {
			$GLOBALS['Errors'][] = 'Please search for something';
			return NULL;
		}
		#starttime
		#endtime
	// Query and return
		$Results = &load_all_program_data(time(), strtotime('+1 month'), false, false, '('.implode(' OR ', $query).')');
	}
	else {
		$_GET['search_title'] = true;
		$_GET['search_subtitle'] = true;
	}

// Load the class for this page
	require_once theme_dir."search.php";

// Create an instance of this page from its theme object
	$Page = new Theme_search();

// Display the page
	$Page->print_page();

// Exit
	exit;

?>
