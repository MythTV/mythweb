<?
/***                                                                        ***\
	recorded_programs.php                    Last Updated: 2003.08.03 (xris)

	view and manipulate recorded programs.
\***                                                                        ***/


// Initialize the script, database, etc.
	require_once "includes/init.php";
	require_once "includes/sorting.php";

// Delete a program?
	$_GET['delete'] or $_GET['delete'] = $_POST['delete'];
	$_GET['file']   or $_GET['file']   = $_POST['file'];
	if ($_GET['delete'] && preg_match('/\\d+_\\d+/', $_GET['file'])) {
	// We need to scan through the available recordings to get at the additional information required by the DELETE_RECORDING query
		foreach (get_backend_rows('QUERY_RECORDINGS Delete') as $row) {
		// This row isn't the one we're looking for
			if ($row[8] != $_GET['file'])
				continue;
		// Delete the recording
			backend_command('DELETE_RECORDING' . backend_sep . implode(backend_sep, $row) . backend_sep . '0');
		// No need to scan the rest of the items, so leave early
			break;
		}
	}

// Queries for a specific program title
	isset($_GET['title'])  or $_GET['title']  = $_POST['title'];
	isset($_GET['title'])  or $_GET['title']  = $_SESSION['recorded_title'];


// Parse the program list
	$recordings = get_backend_rows('QUERY_RECORDINGS Delete');
	$All_Shows      = array();
	$Programs       = array();
	$Channels       = array();
	while (true) {
		$Program_Titles = array();
		foreach ($recordings as $key => $record) {
		// Skip the offset
			if ($key === 'offset')
				continue;
		// Skip programs the user doesn't want to look at, but keep track of their names and how many episodes we have recorded
			$Program_Titles[$record[0]]++;
			if ($_GET['title'] && $_GET['title'] != $record[0])
				continue;
		// Create a new program object
			$show = new Program($record);
		// Make sure this is a valid show (ie. skip in-progress recordings and other junk)
			if (!$show->chanid || $show->duration < 1)
				continue;
		// Assign a reference to this show to the various arrays
			$All_Shows[]                 = &$show;
			$Programs[$show->title][]    = &$show;
			$Channels[$show->chanid][]   = &$show;
			unset($show);
		}
	// Did we try to view a program that we don't have recorded?  Revert to showing all programs
		if ($_GET['title'] && !count($Programs)) {
			$Warnings[] = 'No matching programs found.  Showing all programs.';
			unset($_GET['title']);
		}
	// Found some programs, let's move on
		else
			break;
	}

// Sort the program titles
	ksort($Program_Titles);

// Keep track of the program/title the user wants to view
	$_SESSION['recorded_title'] = $_GET['title'];

// The default sorting choice isn't so good for recorded programs, so we'll set our own default
	if (!is_array($_SESSION['recorded_sortby']))
		$_SESSION['recorded_sortby'] = array(array('field' => 'airdate',
												   'reverse' => true),
											 array('field' => 'title',
												   'reverse' => false));

// Sort the programs
	sort_programs($All_Shows, 'recorded_sortby');

// Make sure the image cache path exists
	$path = '';
	foreach (split('/+', pixmap_local_path) as $dir) {
		$path .= $path ? '/' . $dir : $dir;
		if(!is_dir($path) && !mkdir($path, 0755))
			trigger_error('Error creating path for '.$path.': Please check permissions.', FATAL);
	}

// Clean out stale thumbnails
	if ($dir = opendir(pixmap_local_path)) {
		while (($file = readdir($dir))) {
			if (!is_file(pixmap_local_path.'/'.$file))
				continue;
		// Delete files that haven't been touched in the last 3 days
			if (fileatime(pixmap_local_path.'/'.$file) > 3 * 24 * 60 * 60)
				unlink(pixmap_local_path.'/'.$file);
		}
		closedir($dir);
	}

// How much free disk space on the backend machine?
	list($freespace, $disk_size) = explode(backend_sep, backend_command('QUERY_FREESPACE'));
	define(disk_free, nice_filesize($disk_size * 1024 * 1024));
	define(disk_size, nice_filesize($freespace * 1024 * 1024));

// Load the class for this page
	require_once theme_dir.'recorded_programs.php';

// Create an instance of this page from its theme object
	$Page = new Theme_recorded_programs();

// Display the page
	$Page->print_page();

// Exit
	exit;

?>

