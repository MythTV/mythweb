<?
/***                                                                        ***\
	recordings.php                           Last Updated: 2004.02.04 (xris)

	The Recording object, and a couple of related subroutines.
\***                                                                        ***/

// Make sure the "Channels" class gets loaded   (yes, I know this is recursive, but require_once will handle things nicely)
	require_once 'includes/channels.php';

//
	$RecTypes = array(
						1 => 'Once',
						2 => 'Daily',
						3 => 'Channel',
						4 => 'Always',
						5 => 'Weekly'
					 );

/*
	load_all_recordings:
	loads all recording data for the specified time range into the $Channels array.
	Set $single_recording to true if you only want information about recordings that
	start exactly at $start_time (used by recording_detail.php)
*/
	function &load_all_recordings($recordid = 0) {
		global $Channels;
	// An array (that later gets converted to a string) containing the id's of channels we want to load
		$these_channels = array();
	// No channel data?  Load it
		if (!is_array($Channels) || !count($Channels))
			load_all_channels();

	// Build the sql query, and execute it
		$query = 'SELECT *, UNIX_TIMESTAMP(startdate)+TIME_TO_SEC(starttime) AS starttime_unix,'
				.' UNIX_TIMESTAMP(enddate)+TIME_TO_SEC(endtime) AS endtime_unix '
				.'FROM record ';
		if ($recordid > 0)
			$query .= " WHERE recordid = $recordid ";
		$query .= 'ORDER BY title, subtitle, description, startdate, starttime';

		$result = mysql_query($query)
			or trigger_error('SQL Error: '.mysql_error(), FATAL);
	// Load in all of the recordings (if any?)
		$these_recordings = array();
		while ($recording_data = mysql_fetch_assoc($result)) {
			$recording =& new Recording($recording_data);
			if ($recordid > 0) {
				mysql_free_result($result);
				return $recording;
			}
			$these_recordings[] = &$recording;
		}

	// Cleanup
		mysql_free_result($result);
	// Just in case, return an array of all recordings found

		return $these_recordings;
	}

//
//	Recordings class
//
class Recording {
	var $recordid;
	var $type;
	var $chanid;
	var $starttime;
	var $endtime;
	var $title;
	var $subtitle;
	var $description;
	var $category;
	var $profile;
	var $recpriority;
	var $autoexpire;
	var $maxepisodes;
	var $maxnewest;
	var $recorddups;
	var $preroll;
	var $postroll;

	var $texttype;
	var $channel;

	var $will_record    = false;
	var $record_daily   = false;
	var $record_weekly  = false;
	var $record_once    = false;
	var $record_channel = false;
	var $record_always  = false;

	var $class;			// css class, based on category and/or category_type

	function Recording($recording_data) {

		if (isset($recording_data['recordid'])) {
	// SQL data
			$this->recordid    = $recording_data['recordid'];
			$this->type        = $recording_data['type'];
			$this->chanid      = $recording_data['chanid'];
			$this->starttime   = $recording_data['starttime_unix'];
			$this->endtime     = $recording_data['endtime_unix'];
			$this->title       = $recording_data['title'];
			$this->subtitle    = $recording_data['subtitle'];
			$this->description = $recording_data['description'];
			$this->category    = $recording_data['category'] ? $recording_data['category'] : 'Unknown';
			$this->profile     = $recording_data['profile'];
			$this->recpriority = $recording_data['recpriority'];
			$this->autoexpire  = $recording_data['autoexpire'];
			$this->maxepisodes = $recording_data['maxepisodes'];
			$this->maxnewest   = $recording_data['maxnewest'];
			$this->recorddups  = $recording_data['recorddups'];
			$this->preroll     = $recording_data['preroll'];
			$this->postroll    = $recording_data['postroll'];
		} else {
			$this->recordid    = $recording_data->recordid;
			$this->type        = $recording_data->type;
			$this->chanid      = $recording_data->chanid;
			$this->starttime   = $recording_data->starttime;
			$this->startdate   = $recording_data->startdate;
			$this->endtime     = $recording_data->endtime;
			$this->enddate     = $recording_data->enddate;
			$this->title       = $recording_data->title;
			$this->subtitle    = $recording_data->subtitle;
			$this->description = $recording_data->description;
			$this->category    = $recording_data->category ? $recording_data->category : 'Unknown';
			$this->profile     = $recording_data->profile;
			$this->recpriority = $recording_data->recpriority;
			$this->autoexpire  = $recording_data->autoexpire;
			$this->maxepisodes = $recording_data->maxepisodes;
			$this->maxnewest   = $recording_data->maxnewest;
			$this->recorddups  = $recording_data->recorddups;
			$this->preroll     = $recording_data->preroll;
			$this->postroll    = $recording_data->postroll;
		}

		// We get various recording-related information, too
		if ($this->type == 1)
			$this->record_once = true;
		elseif ($this->type == 2)
			$this->record_daily = true;
		elseif ($this->type == 3)
			$this->record_channel = true;
		elseif ($this->type == 4)
			$this->record_always = true;
		elseif ($this->type == 5)
			$this->record_weekly = true;

		// Add a generic "will record" variable, too
		$this->will_record     = ($this->record_daily
						  || $this->record_weekly
						  || $this->record_once
						  || $this->record_channel
						  || $this->record_always ) ? true : false;
	// Turn type int a word
		$this->texttype = $GLOBALS['RecTypes'][$this->type];
	// Do we have a chanid?  Load some info about it
		if ($this->chanid && !isset($this->channel)) {
		// No channel data?  Load it
			global $Channels;
			if (!is_array($Channels) || !count($Channels))
				load_all_channels($this->chanid);
		// Now we really should scan the $Channel array and add a link to this recording's channel
			foreach (array_keys($Channels) as $key) {
				if ($Channels[$key]->chanid == $this->chanid) {
					$this->channel = &$Channels[$key];
					break;
				}
			}
		}

	// Find out which css category this recording falls into
		if ($this->chanid != "")
			$this->category_class();
	}

	function record_update() {

		$this->will_record    = false;
		$this->record_always  = false;
		$this->record_channel = false;
		$this->record_once    = false;
		$this->record_daily   = false;
		$this->record_weekly  = false;

		switch ($_GET['record']) {
			case 'once':
				$this->type = 1;
				$this->record_once = true;
				break;
			case 'daily':
				$this->type = 2;
				$this->record_daily = true;
				break;
			case 'channel':
				$this->type = 3;
				$this->record_channel = true;
				break;
			case 'always':
				$this->type = 4;
				$this->record_always = true;
				break;
			case 'weekly':
				$this->type = 5;
				$this->record_weekly = true;
				break;
			default:
				$this->type = 0;
		}

		if ($this->type == 0) {
	// Remove the record
			$result = mysql_query('DELETE FROM record WHERE recordid='.escape($this->recordid))
				or trigger_error('SQL Error: '.mysql_error(), FATAL);
		} else {
	// Insert this recording choice into the database
			$result = mysql_query('UPDATE record SET type='
						.escape($this->type).', profile='
						.escape($this->profile).', recpriority='
						.escape($this->recpriority).', autoexpire='
						.escape($this->autoexpire).', maxnewest='
						.escape($this->maxnewest).', recorddups='
						.escape($this->recorddups).' where recordid='
						.escape($this->recordid))
				or trigger_error('SQL Error: '.mysql_error(), FATAL);

		// Add a generic "will record" variable, too
		$this->will_record     = ($this->record_daily
						  || $this->record_weekly
						  || $this->record_once
						  || $this->record_channel
						  || $this->record_always ) ? true : false;
		}

	// Notify the backend of the changes
		backend_notify_changes();
	}

	function category_class() {
		$this->class = '';
	// Category type?
		if ($this->category_type && !preg_match('/unknown/i', $this->category_type))
			$this->class .= 'type_'.preg_replace("/[^a-zA-Z0-9\-_]+/", '_', $this->category_type).' ';
	// Category cache
		$category = strtolower($this->category);	// user lowercase to avoid a little overhead later
		static $cache = array();
		if ($cache[$category])
			$this->class .= $cache[$category];
	// Now comes the hard part
		elseif (preg_match('/\\b(?:action|adven)/', $category))
			$this->class .= $cache[$category] = 'cat_Action';
		elseif (preg_match('/\\b(?:adult|erot)/', $category))
			$this->class .= $cache[$category] = 'cat_Adult';
		elseif (preg_match('/\\b(?:animal|tiere)/', $category))
			$this->class .= $cache[$category] = 'cat_Animals';
		elseif (preg_match('/\\b(?:art|dance|musi[ck]|kunst|[ck]ultur)/', $category))
			$this->class .= $cache[$category] = 'cat_Art_Music';
		elseif (preg_match('/\\b(?:biz|busine)/', $category))
			$this->class .= $cache[$category] = 'cat_Business';
		elseif (preg_match('/\\b(?:child|kin?d|infan|animation)/', $category))
			$this->class .= $cache[$category] = 'cat_Children';
		elseif (preg_match('/\\b(?:comed|entertain|sitcom)/', $category))
			$this->class .= $cache[$category] = 'cat_Comedy';
		elseif (preg_match('/\\b(?:[ck]rim|myster)/', $category))
			$this->class .= $cache[$category] = 'cat_Crime_Mystery';
		elseif (preg_match('/\\b(?:do[ck])/', $category))
			$this->class .= $cache[$category] = 'cat_Documentary';
		elseif (preg_match('/\\b(?:drama)/', $category))
			$this->class .= $cache[$category] = 'cat_Drama';
		elseif (preg_match('/\\b(?:edu|bildung|interests)/', $category))
			$this->class .= $cache[$category] = 'cat_Educational';
		elseif (preg_match('/\\b(?:food|cook|essen|[dt]rink)/', $category))
			$this->class .= $cache[$category] = 'cat_Food';
		elseif (preg_match('/\\b(?:game|spiele)/', $category))
			$this->class .= $cache[$category] = 'cat_Game';
		elseif (preg_match('/\\b(?:health|medic|gesundheit)/', $category))
			$this->class .= $cache[$category] = 'cat_Health_Medical';
		elseif (preg_match('/\\b(?:hist|geschichte)/', $category))
			$this->class .= $cache[$category] = 'cat_History';
		elseif (preg_match('/\\b(?:how|home|house|garden)/', $category))
			$this->class .= $cache[$category] = 'cat_HowTo';
		elseif (preg_match('/\\b(?:horror)/', $category))
			$this->class .= $cache[$category] = 'cat_Horror';
		elseif (preg_match('/\\b(?:special|variety|info|collect)/', $category))
			$this->class .= $cache[$category] = 'cat_Misc';
		elseif (preg_match('/\\b(?:news|nachrichten|current)/', $category))
			$this->class .= $cache[$category] = 'cat_News';
		elseif (preg_match('/\\b(?:reality)/', $category))
			$this->class .= $cache[$category] = 'cat_Reality';
		elseif (preg_match('/\\b(?:romance|lieb)/', $category))
			$this->class .= $cache[$category] = 'cat_Romance';
		elseif (preg_match('/\\b(?:fantasy|sci\\w*\\W*fi)/', $category))
			$this->class .= $cache[$category] = 'cat_SciFi_Fantasy';
		elseif (preg_match('/\\b(?:science|nature|environment|wissenschaft)/', $category))
			$this->class .= $cache[$category] = 'cat_Science_Nature';
		elseif (preg_match('/\\b(?:shop)/', $category))
			$this->class .= $cache[$category] = 'cat_Shopping';
		elseif (preg_match('/\\b(?:soaps)/', $category))
			$this->class .= $cache[$category] = 'cat_Soaps';
		elseif (preg_match('/\\b(?:spirit|relig)/', $category))
			$this->class .= $cache[$category] = 'cat_Spiritual';
		elseif (preg_match('/\\b(?:sport|deportes|futbol)/', $category))
			$this->class .= $cache[$category] = 'cat_Sports';
		elseif (preg_match('/\\b(?:talk)/', $category))
			$this->class .= $cache[$category] = 'cat_Talk';
		elseif (preg_match('/\\b(?:travel|reisen)/', $category))
			$this->class .= $cache[$category] = 'cat_Travel';
		elseif (preg_match('/\\b(?:war|krieg)/', $category))
			$this->class .= $cache[$category] = 'cat_War';
		elseif (preg_match('/\\b(?:west)/', $category))
			$this->class .= $cache[$category] = 'cat_Western';
		else
			$this->class .= $cache[$category] = 'cat_Unknown';
	}
}

?>
