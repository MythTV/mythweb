<?
/***                                                                        ***\
	recorded_programs.php                    Last Updated: 2003.07.22 (xris)

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

// Parse the program list
	$All_Shows = array();
	$Programs  = array();
	$Channels  = array();
	foreach (get_backend_rows('QUERY_RECORDINGS Delete') as $key => $record) {
	// Skip the offset
		if ($key === 'offset')
			continue;
	// Create a new program object
		$show = new Program($record);
	// Make sure this is a valid show (ie. skip in-progress recordings and other junk)
		if (!$show->chanid || $show->duration < 1)
			continue;
	// Assign a reference to this show to the various arrays
		$All_Shows[]                 = &$show;
		$Programs[$show['title']][]  = &$show;
		$Channels[$show['chanid']][] = &$show;
		unset($show);
	}

// The default sorting choice isn't so good for recorded programs, so we'll set our own default
	if (!is_array($_SESSION['recorded_sortby']))
		$_SESSION['recorded_sortby'] = array(array('field' => 'airdate',
												   'reverse' => true),
											 array('field' => 'title',
												   'reverse' => false));

// Sort the programs
	sort_programs($All_Shows, 'recorded_sortby');

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

