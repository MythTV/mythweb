<?php
/***                                                                        ***\
    sorting.php                              Last Updated: 2003.08.08 (xris)

    routines for sorting Program objects
\***                                                                        ***/


/*
	sort_programs:
	sorts a list of programs by the user's session preferences
*/
	function sort_programs(&$programs, $session) {
	// First, check for a sort variable passed in by the user
		isset($_GET['reverse']) or $_GET['reverse'] = $_POST['reverse'];
		isset($_GET['sortby'])  or $_GET['sortby']   = $_POST['sortby'];
	// Now we build an array the user's sort preferences
		if (!is_array($_SESSION[$session]) || !count($_SESSION[$session]))
			$_SESSION[$session] = array(array('field' => 'airdate',
											  'reverse' => false),
										array('field' => 'title',
											  'reverse' => false));
	// If we were given a sort parameter, let's put it into the sort preferences
		if ($_GET['sortby']) {
			$_GET['sortby'] = strtolower($_GET['sortby']);
			if (!function_exists('by_'.$_GET['sortby']))
				$_GET['sortby'] = 'title';
		// This sortby method is the first element in the sort array, let's reverse it (unless told otherwise)
			if ($_SESSION[$session][0]['field'] == $_GET['sortby']) {
				if (isset($_GET['reverse']))
					$_SESSION[$session][0]['reverse'] = ($_GET['reverse'] > 0 || eregi('^y', $_GET['reverse'])) ? true : false;
				else
					$_SESSION[$session][0]['reverse'] = $_SESSION[$session][0]['reverse'] ? false : true;
			}
		// Otherwise, we need to parse the array, and add the current choice to the top
			else {
			// Scan the sort array for any entries matching the current choice, and remove them
				foreach ($_SESSION[$session] as $key => $sort) {
				// Found a match, or an old/accidental sort method - remove the sort entry
					if ($sort['field'] == $_GET['sortby'] || !function_exists('by_'.$sort['field']))
						unset($_SESSION[$session][$key]);
				}
			// Add this choice to the top of the list
				array_unshift($_SESSION[$session], array('field'   => $_GET['sortby'],
														 'reverse' => $_GET['reverse'] ? true : false));
			}
		}
	// No sortby, but requested a reversal of the main field
		elseif ($_GET['reverse'])
			$_SESSION[$session][0]['reverse'] = $_SESSION[$session][0]['reverse'] ? false : true;
	// Once we've processed the information, we should make sure that we're actually sorting an array
		if (!count($programs))
			return;
	// Now we just need to sort the array
		$GLOBALS['user_sort_choice'] = &$_SESSION[$session];
		usort($programs, 'by_user_choice');
		unset($GLOBALS['user_sort_choice']);
	}


	function by_user_choice(&$a, &$b) {
		foreach ($GLOBALS['user_sort_choice'] as $sort) {
			$function = 'by_'.$sort['field'];
			$response = $function(&$a, &$b);
		// Identical response, go on to the next sort choice
			if (!$response)
				continue;
		// Return the result
			return $sort['reverse'] ? -$response : $response;
		}
	}

	function by_title(&$a, &$b) {
		return strcasecmp($a->title, $b->title);
	}

	function by_subtitle(&$a, &$b) {
		return strcasecmp($a->subtitle, $b->subtitle);
	}

	function by_channum(&$a, &$b) {
		return strnatcasecmp($a->channel->channum, $b->channel->channum);
	}

	function by_airdate(&$a, &$b) {
        if ($a->starttime == $b->starttime) return 0;
        return ($a->starttime > $b->starttime) ? 1 : -1;
	}

	function by_length(&$a, &$b) {
        if ($a->length == $b->length) return 0;
        return ($a->length > $b->length) ? 1 : -1;
	}

	function by_filesize(&$a, &$b) {
        if ($a->filesize == $b->filesize) return 0;
        return ($a->filesize > $b->filesize) ? 1 : -1;
	}

?>
