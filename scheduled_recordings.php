<?
/***                                                                        ***\
	scheduled_recordings.php                 Last Updated: 2004.04.19 (xris)

	view and fix scheduling conflicts.
\***                                                                        ***/


// Initialize the script, database, etc.
	require_once "includes/init.php";
	require_once "includes/sorting.php";

// Make sure we get the form data
	isset($_GET['chanid'])    or $_GET['chanid']    = $_POST['chanid'];
	isset($_GET['starttime']) or $_GET['starttime'] = $_POST['starttime'];

// Doing something to a program?  Load its detailed info
	if ($_GET['chanid'] && $_GET['starttime']) {
		$program = load_one_program($_GET['starttime'], $_GET['chanid']);

	// Forget all knowledge of old recordings
		if ($_GET['forget_old'] || $_POST['forget_old']) {
			$result = mysql_query('DELETE FROM oldrecorded WHERE title='.escape($program->title).' AND subtitle='.escape($program->subtitle).' AND description='.escape($program->description))
				or trigger_error('SQL Error: '.mysql_error(), FATAL);
		}
	// Fake an old recording so that this show won't record again
		elseif ($_GET['never_record'] || $_POST['never_record']) {
			$result = mysql_query('REPLACE INTO oldrecorded (chanid, starttime, endtime, title, subtitle, description, category) VALUES ('
									.escape($program->chanid)                    .','
									.'FROM_UNIXTIME('.escape($program->starttime).'),'
									#.'"1970-01-01",'
									#.'FROM_UNIXTIME('.escape($program->endtime)  .'),'
									.'"1970-01-01",'
									.escape($program->title)                     .','
									.escape($program->subtitle)                  .','
									.escape($program->description)               .','
									.escape($program->category)                  .')')
				or trigger_error('SQL Error: '.mysql_error(), FATAL);
		// Make sure the aren't any manual overrides set for this show, either
			$result = mysql_query('DELETE FROM recordoverride WHERE chanid='.escape($_GET['chanid']).' AND title='.escape($program->title).' AND subtitle='.escape($program->subtitle).' AND description='.escape($program->desription))
				or trigger_error('SQL Error: '.mysql_error().' [#'.mysql_errno().']', FATAL);
		}
	// Suppress something that shouldn't be recorded
		elseif ($_GET['suppress'] || $_POST['suppress']) {
			$result = mysql_query('DELETE FROM recordoverride WHERE chanid='.escape($program->chanid).' AND starttime=FROM_UNIXTIME('.escape($program->starttime).') AND endtime=FROM_UNIXTIME('.escape($program->endtime).')')
				or trigger_error('SQL Error: '.mysql_error().' [#'.mysql_errno().']', FATAL);
			$result = mysql_query('REPLACE INTO recordoverride (recordid,type,chanid,station,starttime,endtime,title,subtitle,description) VALUES ('
									.escape($program->recordid).','
									.'2,'	// record override type:   1 == record, 2 == don't record
									.escape($program->chanid)                    .','
									.escape($program->channel->callsign)         .','
									.'FROM_UNIXTIME('.escape($program->starttime).'),'
									.'FROM_UNIXTIME('.escape($program->endtime)  .'),'
									.escape($program->title)                     .','
									.escape($program->subtitle)                  .','
									.escape($program->description)               .')')
				or trigger_error('SQL Error: '.mysql_error().' [#'.mysql_errno().']', FATAL);
		}
	// Record a show that wouldn't otherwise record (various reasons, read below)
		elseif ($_GET['record'] || $_POST['record']) {
		// Activate a program that was inactive for other reasons
			if ($show->recording == 0 || $show->recstatus) {
				$result = mysql_query('DELETE FROM recordoverride WHERE chanid='.escape($program->chanid).' AND starttime=FROM_UNIXTIME('.escape($program->starttime).') AND endtime=FROM_UNIXTIME('.escape($program->endtime).')')
					or trigger_error('SQL Error: '.mysql_error().' [#'.mysql_errno().']', FATAL);
				$result = mysql_query('REPLACE INTO recordoverride (recordid,type,chanid,station,starttime,endtime,title,subtitle,description) VALUES ('
										.escape($program->recordid).','
										.'1,'	// record override type:   1 == record, 2 == don't record
										.escape($program->chanid)                    .','
										.escape($program->channel->callsign)         .','
										.'FROM_UNIXTIME('.escape($program->starttime).'),'
										.'FROM_UNIXTIME('.escape($program->endtime)  .'),'
										.escape($program->title)                     .','
										.escape($program->subtitle)                  .','
										.escape($program->description)               .')')
					or trigger_error('SQL Error: '.mysql_error().' [#'.mysql_errno().']', FATAL);
			}
		}

	// Notify the backend of the changes
		backend_notify_changes();

	// Redirect back to the page again, but without the query string, so reloads are cleaner
		header('Location: scheduled_recordings.php');
		exit;
	}



// Load the scheduled programs
    $records = get_backend_rows('QUERY_GETALLPENDING', 2);

// Extract some info not related to specific programs
	list($conflicts, $num_programs) = $records['offset'];
	unset($records['offset']);

// Parse the program list
	$All_Shows = array();
	$Programs  = array();
	$Channels  = array();
	foreach ($records as $record) {
		$show = new Program($record);
	// Skip things we've already recorded
		if ($show->starttime <= time())
			continue;
	// Make sure this is a valid show (ie. skip in-progress recordings and other junk)
		if (!$show->chanid || $show->length < 1)
			continue;
	// Assign a reference to this show to the various arrays
		$All_Shows[]                 = &$show;
		$Programs[$show['title']][]  = &$show;
		$Channels[$show['chanid']][] = &$show;
		unset($show);
	}

// Sort the programs
	if (count($All_Shows))
		sort_programs($All_Shows, 'scheduled_sortby');

// Load the class for this page
	require_once theme_dir."scheduled_recordings.php";

// Create an instance of this page from its theme object
	$Page = new Theme_scheduled_recordings();

// Display the page
	$Page->print_page();

// Exit
	exit;

?>
