<?
/***                                                                        ***\
	scheduled_recordings.php                 Last Updated: 2003.12.02 (xris)

	view and fix scheduling conflicts.
\***                                                                        ***/


// Initialize the script, database, etc.
	require_once "includes/init.php";
	require_once "includes/sorting.php";

// Make sure we get the form data
	isset($_GET['recordid'])    or $_GET['recordid']    = $_POST['recordid'];
	isset($_GET['chanid'])      or $_GET['chanid']      = $_POST['chanid'];
	isset($_GET['starttime'])   or $_GET['starttime']   = $_POST['starttime'];
	isset($_GET['endtime'])     or $_GET['endtime']     = $_POST['endtime'];
	isset($_GET['title'])       or $_GET['title']       = $_POST['title'];
	isset($_GET['subtitle'])    or $_GET['subtitle']    = $_POST['subtitle'];
	isset($_GET['description']) or $_GET['description'] = $_POST['description'];
	isset($_GET['category'])    or $_GET['category']    = $_POST['category'];

# Should see about pulling description, etc from the database so we don't have to pass it on the url

// Re-recording something that has been suppressed
	if ($_GET['rerecord'] || $_POST['rerecord']) {
#insert into oldrecorded (chanid, starttime, endtime, title, subtitle, description)
#    values (1035, 20030525153000, 20030525160000, 'Good Eats', 'Tomatoes', 'Tomato sandwich; tomato sauce; close look at serrated knives.');
		$result = mysql_query('DELETE FROM oldrecorded WHERE title='.escape($_GET['title']).' AND subtitle='.escape($_GET['subtitle']).' AND description='.escape($_GET['description']))
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
#		$result = mysql_query('DELETE FROM recordoverride WHERE chanid='.escape($_GET['chanid']).' AND starttime=FROM_UNIXTIME('.escape($_GET['starttime']).') AND endtime=FROM_UNIXTIME('.escape($_GET['endtime']).')')
#			or trigger_error('SQL Error: '.mysql_error().' [#'.mysql_errno().']', FATAL);
#		$result = mysql_query('REPLACE INTO recordoverride (recordid,type,chanid,starttime,endtime,title,subtitle,description) VALUES ('
#								.escape($_GET['recordid']).','
#								.'1,'	// record override type:   1 == record, 2 == don't record
#								.escape($_GET['chanid'])                    .','
#								.'FROM_UNIXTIME('.escape($_GET['starttime']).'),'
#								.'FROM_UNIXTIME('.escape($_GET['endtime'])  .'),'
#								.escape($_GET['title'])                     .','
#								.escape($_GET['subtitle'])                  .','
#								.escape($_GET['description'])               .')')
#			or trigger_error('SQL Error: '.mysql_error().' [#'.mysql_errno().']', FATAL);
	// Notify the backend of the changes
		backend_notify_changes();
	}

// Suppressing something that shouldn't be recorded
	elseif ($_GET['suppress'] || $_POST['suppress']) {
		$result = mysql_query('REPLACE INTO oldrecorded (chanid, starttime, endtime, title, subtitle, description, category) VALUES ('
								.escape($_GET['chanid'])                    .','
								.'FROM_UNIXTIME('.escape($_GET['starttime']).'),'
								.'FROM_UNIXTIME('.escape($_GET['endtime'])  .'),'
								.escape($_GET['title'])                     .','
								.escape($_GET['subtitle'])                  .','
								.escape($_GET['description'])               .','
								.escape($_GET['category'])                  .')')
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
	// Notify the backend of the changes
		backend_notify_changes();
	}

// Set myth to record a show in order to resolve a conflict
	elseif ($_GET['record'] || $_POST['record']) {
	// Scan through the pending shows for anything that's currently conflicting
		foreach (get_backend_rows('QUERY_GETALLPENDING', 2) as $program) {
			if ($program[13] != 1)
				continue;
		// Found a conflict
			$chanid     = $program[4];
			$start_time = myth2unixtime($program[11]);	// start time
			$end_time   = myth2unixtime($program[12]);	// end time
		// Anything in the timeslot and NOT on this channel should be ignored
			if ($chanid != $_GET['chanid'] && $end_time >= $_GET['starttime'] && $start_time <= $_GET['endtime'])
				$result = mysql_query('INSERT INTO conflictresolutionsingle (preferchanid,preferstarttime,preferendtime,dislikechanid,dislikestarttime,dislikeendtime) VALUES ('
									  .escape($_GET['chanid'])                    .','
									  .'FROM_UNIXTIME('.escape($_GET['starttime']).'),'
									  .'FROM_UNIXTIME('.escape($_GET['endtime'])  .'),'
									  .escape($chanid)                            .','
									  .'FROM_UNIXTIME('.escape($start_time)       .'),'
									  .'FROM_UNIXTIME('.escape($end_time)         .'))')
					or trigger_error('SQL Error: '.mysql_error(), FATAL);
		}
	// Notify the backend of the changes
		backend_notify_changes();
	}

// Activating a recording?
	elseif ($_GET['activate'] || $_POST['activate']) {
	// Find the previous (disabled) recording setting for this show
		$result = mysql_query('SELECT preferchanid, preferstarttime, preferendtime FROM conflictresolutionsingle WHERE dislikechanid='.escape($_GET['chanid']).' AND dislikestarttime=FROM_UNIXTIME('.escape($_GET['starttime']).') AND dislikeendtime=FROM_UNIXTIME('.escape($_GET['endtime']).')')
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
		$old_prefer = mysql_fetch_assoc($result);
		mysql_free_result($result);
	// Swap this choice with it's main alternative
		$result = mysql_query('UPDATE conflictresolutionsingle SET preferchanid='.escape($_GET['chanid']).','
								.'preferstarttime=FROM_UNIXTIME('.escape($_GET['starttime']).'),'
								.'preferendtime=FROM_UNIXTIME('.escape($_GET['endtime'])    .'),'
								.'dislikechanid='.escape($old_prefer['preferchanid'])       .','
								.'dislikestarttime='.escape($old_prefer['preferstarttime']) .','
								.'dislikeendtime='.escape($old_prefer['preferendtime'])
								.' WHERE dislikechanid='.escape($_GET['chanid']).' AND dislikestarttime=FROM_UNIXTIME('.escape($_GET['starttime']).') AND dislikeendtime=FROM_UNIXTIME('.escape($_GET['endtime']).')')
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
	// Update any other conflicting shows with the new preferred show
		$result = mysql_query('UPDATE conflictresolutionsingle SET preferchanid='.escape($_GET['chanid']).','
								.'preferstarttime=FROM_UNIXTIME('.escape($_GET['starttime']).'),'
								.'preferendtime=FROM_UNIXTIME('.escape($_GET['endtime'])    .')'
								.' WHERE preferchanid='.escape($old_prefer['preferchanid']).' AND preferstarttime='.escape($old_prefer['preferstarttime']).' AND preferendtime='.escape($old_prefer['preferendtime']))
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
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
