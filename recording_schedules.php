<?
/***                                                                        ***\
	recording_schedules.php                      Last Updated: 2004.01.29 (alden)

	view and fix scheduling conflicts.
\***                                                                        ***/


// Initialize the script, database, etc.
	require_once "includes/init.php";
	require_once "includes/sorting.php";

// Make sure we get the form data
	isset($_GET['chanid'])    or $_GET['chanid']    = $_POST['chanid'];
	isset($_GET['starttime']) or $_GET['starttime'] = $_POST['starttime'];

// Doing something to a recording?  Load its detailed info
	if ($_GET['chanid'] && $_GET['starttime']) {
		$recording = load_one_recording($_GET['starttime'], $_GET['chanid']);

	// Fake an old recording so that this show won't record again
		if ($_GET['never_record'] || $_POST['never_record']) {
			$result = mysql_query('REPLACE INTO oldrecorded (chanid, starttime, endtime, title, subtitle, description, category) VALUES ('
									.escape($recording->chanid)                    .','
									.escape($recording->starttime)                 .'),'
									.escape($recording->endtime)                   .'),'
									.escape($recording->title)                     .','
									.escape($recording->subtitle)                  .','
									.escape($recording->description)               .','
									.escape($recording->category)                  .')')
				or trigger_error('SQL Error: '.mysql_error(), FATAL);
		// Make sure the aren't any manual overrides set for this show, either
			$result = mysql_query('DELETE FROM recordoverride WHERE chanid='.escape($_GET['chanid']).' AND title='.escape($recording->title).' AND subtitle='.escape($recording->subtitle).' AND description='.escape($recording->desription))
				or trigger_error('SQL Error: '.mysql_error().' [#'.mysql_errno().']', FATAL);
		}
	// Suppress something that shouldn't be recorded
		elseif ($_GET['suppress'] || $_POST['suppress']) {
			$result = mysql_query('DELETE FROM recordoverride WHERE chanid='.escape($recording->chanid).' AND starttime=FROM_UNIXTIME('.escape($recording->starttime).') AND endtime=FROM_UNIXTIME('.escape($recording->endtime).')')
				or trigger_error('SQL Error: '.mysql_error().' [#'.mysql_errno().']', FATAL);
			$result = mysql_query('REPLACE INTO recordoverride (recordid,type,chanid,starttime,endtime,title,subtitle,description) VALUES ('
									.escape($recording->recordid).','
									.'2,'	// record override type:   1 == record, 2 == don't record
									.escape($recording->chanid)                    .','
									.'FROM_UNIXTIME('.escape($recording->starttime).'),'
									.'FROM_UNIXTIME('.escape($recording->endtime)  .'),'
									.escape($recording->title)                     .','
									.escape($recording->subtitle)                  .','
									.escape($recording->description)               .')')
				or trigger_error('SQL Error: '.mysql_error().' [#'.mysql_errno().']', FATAL);
		}

	// Notify the backend of the changes
		backend_notify_changes();
	}

// Load the recordings
	$records = load_all_recordings();

// Parse the recording list
	$All_Shows = array();
	$Recordings  = array();
	$Channels  = array();

	foreach ($records as $record) {
		$show = new Recording($record);
	// Assign a reference to this show to the various arrays
		$All_Shows[]                 = &$show;
		$Recordings[$show['title']][]  = &$show;
		$Channels[$show['chanid']][] = &$show;
		unset($show);
	}

// Sort the recordings
	if (count($All_Shows))
		sort_programs($All_Shows, 'scheduled_sortby');

// Load the class for this page
	require_once theme_dir."recording_schedules.php";

// Create an instance of this page from its theme object
	$Page = new Theme_recording_schedules();

// Display the page
	$Page->print_page();

// Exit
	exit;

?>
