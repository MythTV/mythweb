<?
/***                                                                        ***\
	scheduled_recordings.php                 Last Updated: 2003.12.02 (xris)

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
									.'FROM_UNIXTIME('.escape($program->endtime)  .'),'
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
			$result = mysql_query('REPLACE INTO recordoverride (recordid,type,chanid,starttime,endtime,title,subtitle,description) VALUES ('
									.escape($program->recordid).','
									.'2,'	// record override type:   1 == record, 2 == don't record
									.escape($program->chanid)                    .','
									.'FROM_UNIXTIME('.escape($program->starttime).'),'
									.'FROM_UNIXTIME('.escape($program->endtime)  .'),'
									.escape($program->title)                     .','
									.escape($program->subtitle)                  .','
									.escape($program->description)               .')')
				or trigger_error('SQL Error: '.mysql_error().' [#'.mysql_errno().']', FATAL);
		}
	// Record a show that wouldn't otherwise record (various reasons, read below)
		elseif ($_GET['record'] || $_POST['record']) {
		// Conflict - set conflicting shows to a lower priority?
			if ($program->conflicting) {
			// Scan through the pending shows for anything that's currently conflicting
				foreach (get_backend_rows('QUERY_GETALLPENDING', 2) as $program) {
					if ($program[13] != 1)
						continue;
				// Found a conflict
					$chanid     = $program[4];
					$start_time = myth2unixtime($program[11]);	// start time
					$end_time   = myth2unixtime($program[12]);	// end time
				// Anything in the timeslot and NOT on this channel should be ignored
					if ($chanid != $program->chanid && $end_time >= $program->starttime && $start_time <= $program->endtime)
						$result = mysql_query('INSERT INTO conflictresolutionsingle (preferchanid,preferstarttime,preferendtime,dislikechanid,dislikestarttime,dislikeendtime) VALUES ('
											  .escape($program->chanid)                    .','
											  .'FROM_UNIXTIME('.escape($program->starttime).'),'
											  .'FROM_UNIXTIME('.escape($program->endtime)  .'),'
											  .escape($chanid)                            .','
											  .'FROM_UNIXTIME('.escape($start_time)       .'),'
											  .'FROM_UNIXTIME('.escape($end_time)         .'))')
							or trigger_error('SQL Error: '.mysql_error(), FATAL);
				}
			}
		// Activate a recording that was deactivated because of a conflict?
			elseif ($show->norecord == 'AutoConflict') {
			// Find the previous (disabled) recording setting for this show
				$result = mysql_query('SELECT preferchanid, preferstarttime, preferendtime FROM conflictresolutionsingle WHERE dislikechanid='.escape($program->chanid).' AND dislikestarttime=FROM_UNIXTIME('.escape($program->starttime).') AND dislikeendtime=FROM_UNIXTIME('.escape($program->endtime).')')
					or trigger_error('SQL Error: '.mysql_error(), FATAL);
				$old_prefer = mysql_fetch_assoc($result);
				mysql_free_result($result);
			// Swap this choice with it's main alternative
				$result = mysql_query('UPDATE conflictresolutionsingle SET preferchanid='.escape($program->chanid).','
										.'preferstarttime=FROM_UNIXTIME('.escape($program->starttime).'),'
										.'preferendtime=FROM_UNIXTIME('.escape($program->endtime)    .'),'
										.'dislikechanid='.escape($old_prefer['preferchanid'])       .','
										.'dislikestarttime='.escape($old_prefer['preferstarttime']) .','
										.'dislikeendtime='.escape($old_prefer['preferendtime'])
										.' WHERE dislikechanid='.escape($program->chanid).' AND dislikestarttime=FROM_UNIXTIME('.escape($program->starttime).') AND dislikeendtime=FROM_UNIXTIME('.escape($program->endtime).')')
					or trigger_error('SQL Error: '.mysql_error(), FATAL);
			// Update any other conflicting shows with the new preferred show
				$result = mysql_query('UPDATE conflictresolutionsingle SET preferchanid='.escape($program->chanid).','
										.'preferstarttime=FROM_UNIXTIME('.escape($program->starttime).'),'
										.'preferendtime=FROM_UNIXTIME('.escape($program->endtime)    .')'
										.' WHERE preferchanid='.escape($old_prefer['preferchanid']).' AND preferstarttime='.escape($old_prefer['preferstarttime']).' AND preferendtime='.escape($old_prefer['preferendtime']))
					or trigger_error('SQL Error: '.mysql_error(), FATAL);
			}
		// Activate a program that was inactive for other reasons
			elseif ($show->recording == 0 || $show->norecord) {
				$result = mysql_query('DELETE FROM recordoverride WHERE chanid='.escape($program->chanid).' AND starttime=FROM_UNIXTIME('.escape($program->starttime).') AND endtime=FROM_UNIXTIME('.escape($program->endtime).')')
					or trigger_error('SQL Error: '.mysql_error().' [#'.mysql_errno().']', FATAL);
				$result = mysql_query('REPLACE INTO recordoverride (recordid,type,chanid,starttime,endtime,title,subtitle,description) VALUES ('
										.escape($program->recordid).','
										.'1,'	// record override type:   1 == record, 2 == don't record
										.escape($program->chanid)                    .','
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
