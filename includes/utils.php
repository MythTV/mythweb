<?

	//
	//	This file is part of MythWeb,
	//	a php-based interface into MythTV.
	//
	//	(c) 2002 by Thor Sigvaldason and Isaac Richards
	//	MythWeb is distributed under the
	//	GNU GENERAL PUBLIC LICENSE version 2
	//	(see http://www.gnu.org)
	//

// Set up some constants used by nice_filesystem()
	define('kb', 1024);			// Kilobyte
	define('mb', 1024 * kb);	// Megabyte
	define('gb', 1024 * mb);	// Gigabyte
	define('tb', 1024 * gb);	// Terabyte

/*
	nice_filesize:
	pass in a filesize in bytes, and receive a more human-readable version
	JS: adapted from php.net: sponger 10-Jun-2002 12:28
*/
function nice_filesize($size) {
//	If it's less than a kb we just return the size
	if ($size < kb)
		return $size.' B';
// Otherwise we keep going until the size is in the appropriate measurement range.
	elseif ($size < mb)
		return round($size / kb, 1).' KB';
	elseif ($size < gb)
		return round($size / mb, 1).' MB';
	elseif ($size < tb)
		return round($size / gb, 1).' GB';
	else
		return round($size / tb, 1).' TB';
}

/*
	nice_largefilesize:
	pass in high- and low-word portions of a large filesize in bytes,
	and receive a more human-readable version
*/

function nice_largefilesize($high_word, $low_word) {
// An array of the various human-readable sizes
	static $label = array(' B', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB');
// Make sure we have integers
	$high_word = (int)$high_word;
	$low_word  = (int)$low_word;
// Leave early?  (zero-byte file)
	if ($low_word == 0)
		return '0 B';
// start going through the bits and doing some shifting
	$shiftcount = 0;
	while ($shiftcount < 6 && ($high_word != 0 || $low_word <= 0 || $low_word > 1024)) {
		$high_lowbits = $high_word & 0x3FF;
		$high_word >>= 10;

		$low_lowbits = $low_word & 0x3FF;
		if ($low_word < 0)
			$low_word = (((($low_word & 0x7FFFFFFF)) >> 1) | 0x40000000) >> 9;
		else
			$low_word >>= 10;
		$low_word |= $high_lowbits << 22;
		$shiftcount++;
	}
// Cleanup and return
	$low_word += round($low_lowbits / 1024, 1);
	return $low_word . $label[$shiftcount];
}

/*
	unixtime:
	converts an sql timestamp into unixtime
*/
	function unixtime($sql_timestamp) {
		return mktime(substr($sql_timestamp, 8, 2),		// hour
					  substr($sql_timestamp, 10, 2),	// minute
					  substr($sql_timestamp, 12, 2),	// second
					  substr($sql_timestamp, 4, 2),		// month
					  substr($sql_timestamp, 6, 2),		// day
					  substr($sql_timestamp, 0, 4));	// year
	}

/*
	escape:
	For lack of a function that escapes strings AND adds quotes, I wrote one
	myself to make the rest of my code read a bit easier.
*/
	function escape($string) {
		return "'".mysql_escape_string($string)."'";
	}

/*
	DEBUG:
	prints out a piece of data
*/
	function DEBUG($data) {
		echo "<hr>";
		if (is_array($data) || is_object($data)) {
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}
		elseif (isset($data))
			echo $data;
		else
			echo "NULL";
		echo "<hr>";
	}

###############################







//
//	This file contains a few handy functions
//

//
//	Print the date with any offset included
//

function printTheDate($time, $offset, $numbSlots)
{
	$adjuster = round(30 * $numbSlots * $offset);
	$theYear = substr($time, 0, 4);
	$theMonth = substr($time, 4, 2);
	$theDay = substr($time, 6, 2);
	$theHour = substr($time, 8, 2);
	$theMinute = substr($time, 10, 2);

	$soTheDateMustBe = date("l (F j)", mktime($theHour, $theMinute + adjuster, 0, $theMonth, $theDay, $theYear));
	print("$soTheDateMustBe");
}


//
//	Boolean check to see if a given title is in
//	the allrecord table
//

function isInAlwaysRecord($theTitle)
{
	$aQuery = mysql_query("select * from record where title = \"$theTitle\" and type = 4");
	if(mysql_num_rows($aQuery) > 0)
	{
		return(TRUE);
	}
	return(FALSE);
}

//
//	Boolean check to see if a given title
//	is set to always record on a certain channel
//

function isInChannelAlwaysRecord($theChannel, $theTitle)
{
	$aQuery = mysql_query("select * from record where title = \"$theTitle\" and chanid = \"$theChannel\" and type = 3 ");
	if(mysql_num_rows($aQuery) > 0)
	{
		return(TRUE);
	}
	return(FALSE);
}

//
//	Boolean check to see if a given title is in
//	the timeslotrecord table
//

function isInTimeslotRecord($theChannel, $theStart, $theEnd, $theTitle)
{
	$aQuery = mysql_query("select * from record where type = 2 and chanid = \"$theChannel\" and starttime = \"$theStart\" and endtime = \"$theEnd\" and title = \"$theTitle\"");
	if(mysql_num_rows($aQuery) > 0)
	{
		return(TRUE);
	}
	return(FALSE);
}
//
//	Boolean check to see if a given title is in
//	the once record table
//

function isInOnceRecord($theChannel, $theStart)
{
	$aQuery = mysql_query("select * from record where type = 1 and chanid = \"$theChannel\" and starttime = SEC_TO_TIME(TIME_TO_SEC(\"$theStart\")) and startdate = FROM_DAYS(TO_DAYS(\"$theStart\"))" );
	if(mysql_num_rows($aQuery) > 0)
	{
		return(TRUE);
	}
	return(FALSE);
}


// fetch all the movie listings for N days in the future
function fetchMovieListings($ppv_channels, $day)
{
	$maxStars = $GLOBALS['maximumStarRating'];
	$star = $GLOBALS['starRatingCharacter'];

	if (count($ppv_channels) > 0)
	{
		foreach ($ppv_channels as $hostname => $capturecards)
		{
			foreach ($capturecards as $card => $input)
			{
				foreach ($input as $inputname => $channels)
				{
					$source = singleSelect("select ".
								"capturecard.videodevice, ".
								"cardinput.inputname, ".
								"cardinput.sourceid as 'id' ".
							"from capturecard left join cardinput using (cardid) ".
							"where capturecard.videodevice = \"$card\" and ".
								"cardinput.inputname = \"$inputname\" and ".
								"capturecard.hostname = \"$hostname\";");
					foreach ($channels as $start => $stop)
					{
						$ignore .= "and ";
						if ((int) $start && (int) $stop)
						{
							$ignore .= "(channel.sourceid != ".$source['id'].
							" or channel.channum not between $start and $stop) ";
						}
						else
						{
							$ignore .= "(channel.sourceid != ".$source['id'].
							" or channel.channum not in (\"$start\", \"$stop\")) ";
						}
					}
				}
			}
		}
	}

	$query = "SELECT ".
			"sum(record.type = 4)>0 as 'type4', ".
			"sum(record.type = 3 and record.chanid = program.chanid)>0 as 'type3', ".
			"sum(record.type = 2 and record.chanid = program.chanid and ".
			"     record.starttime = sec_to_time(time_to_sec(program.starttime)) and ".
			"     record.endtime = sec_to_time(time_to_sec(program.endtime)))>0 as 'type2', " .
			"sum(record.type = 1 and record.chanid = program.chanid and ".
			"     record.starttime = sec_to_time(time_to_sec(program.starttime)) and ".
			"     record.startdate = from_days(to_days(program.starttime)))>0 as 'type1', ".
			"channel.chanid, ".
			"channel.channum, ".
			"channel.callsign, ".
			"channel.icon, ".
			"program.starttime, ".
			"program.starttime, ".
			"program.endtime, ".
			"program.title, ".
			"program.subtitle, ".
			"program.description, ".
			"program.category, ".
			"program.airdate, ".
			"program.stars, ".
			"concat(repeat('$star', program.stars*$maxStars), if((program.stars*$maxStars*10) % 10, '&frac12;', '')) as starstring, ".
			"ifnull(programrating.system, '') as rater, ".
			"ifnull(programrating.rating, '') as rating, ".
			"((UNIX_TIMESTAMP(program.endtime) - UNIX_TIMESTAMP(program.starttime)) / 60) as duration ".
		"FROM programrating left join program using (chanid, starttime) left join record using (title), channel ".
		"WHERE programrating.starttime between if($day, date_add(curdate(), interval $day day), now()) ".
			                        "and date_add(curdate(), interval $day+1 day) ".
			"AND program.chanid = channel.chanid ".
			"AND (UNIX_TIMESTAMP(program.endtime) - UNIX_TIMESTAMP(program.starttime)) / 60 > 70 ".
			"AND program.stars > 0 AND program.airdate > 0 ".
			$ignore.
		"GROUP BY programrating.chanid, programrating.starttime ".
		"ORDER BY programrating.starttime ASC, programrating.system ASC;";

	$result = mysql_query($query) or die("Gadzooks! I can't open the program table.");

	for ($i = 0; $line = mysql_fetch_array($result, MYSQL_ASSOC); $i++)
	{
		$myprog = new ProgramInfo;
		$myprog->title = $line["title"];
		$myprog->subtitle = $line["subtitle"];
		$myprog->chanid = $line["chanid"];
		$myprog->chanstr = $line["channum"];
		$myprog->startts = $line["starttime"];
		$myprog->endts = $line["endtime"];
		$myprog->progType = $line["category"];
		$myprog->duration = $line["duration"];
		$myprog->description = $line["description"];
		$myprog->rater = $line["rater"];
		$myprog->rating = $line["rating"];
		$myprog->airdate = $line["airdate"];
		$myprog->stars = $line["stars"];
		$myprog->starstring = $line["starstring"];
		$myprog->callsign = $line["callsign"];
		$myprog->icon = $line["icon"];

		$myprog->whenRecord += $line["type1"] << 1;
		$myprog->whenRecord += $line["type2"] << 2;
		$myprog->whenRecord += $line["type3"] << 3;
		$myprog->whenRecord += $line["type4"] << 4;

		$listingarray[$i] = $myprog;
	}

	mysql_free_result($result);

	return $listingarray;
}

// Functions added by Russell Hatch

// gather info from the allrecord table
function setupAllRecordings() {
	$theQuery = "select * from record where type = 3 or type = 4 order by title asc;";
	$recordQuery = mysql_query($theQuery) or die("ERROR: Unable to open the allrecord table");
	$i = 0;
	$now = buildMythTime(time());
	while($recordTuple = mysql_fetch_array($recordQuery, MYSQL_ASSOC)) {
		$chanid = 0;
		$aRecord = new Recording;
		$channel = "";
		$aRecord->title = $recordTuple['title'];
		if ($recordTuple['chanid']) { // see if this program is always recorded on a certain channel
			$aRecord->chanid = $recordTuple['chanid'];
			$chanid = $aRecord->chanid;
			$channel = "&& chanid = \"$aRecord->chanid\"";
		}
		$progQuery = mysql_query("select * from program where (title = \"$aRecord->title\" && starttime > \"$now\" $channel) order by starttime;") or die("ERROR: Unable to open the allrecord table");
		if ($progInfo = mysql_fetch_array($progQuery, MYSQL_ASSOC)) {
			$aRecord->starttime = $progInfo["starttime"];
			$aRecord->endtime = $progInfo["endtime"];
			$chanid = $progInfo["chanid"];
			$aRecord->subtitle = $progInfo["subtitle"];
			$aRecord->description = $progInfo["description"];
		}
		mysql_free_result($progQuery);
		if ($chanid) {
			$chanQuery = mysql_query("select channum from channel where chanid=\"$chanid\";");
			$aRow = mysql_fetch_row($chanQuery);
			$aRecord->channum = $aRow[0];
			mysql_free_result($chanQuery);
		}
		$recordArray[$i] = $aRecord;
		$i++;
	}
	mysql_free_result($recordQuery);
	return($recordArray);
}

// gather information from the timeslotrecord table
function setupTimeSlotRecordings() {
	$now = buildMythTime(time());
	$theQuery = "select record.*,channel.channum from record,channel where type = 2 and record.chanid=channel.chanid order by title asc;";
	$recordQuery = mysql_query($theQuery) or die("ERROR: Unable to open the record table");;
	$i = 0;
	while($recordTuple = mysql_fetch_array($recordQuery, MYSQL_ASSOC))
	{
		$aRecord = new Recording;
		$aRecord->chanid = $recordTuple["chanid"];
		$aRecord->channum = $recordTuple["channum"];
		$aRecord->starttime = $recordTuple["starttime"];
		$aRecord->endtime = $recordTuple["endtime"];
		$aRecord->title = $recordTuple["title"];
		$mythstart = parseTimeSlotTime($aRecord->starttime);
		$mythstart = $mythstart["hour"] . $mythstart["minute"] . $mythstart["second"];
		$mythend = parseTimeSlotTime($aRecord->endtime);
		$mythend = $mythend["hour"] . $mythend["minute"] . $mythend["second"];
		$progQuery = mysql_query("select * from program where (title = \"$aRecord->title\" && starttime > '$now' && chanid = '$aRecord->chanid') order by starttime") or die("ERROR: Unable to open the allrecord table");
		while ($progInfo = mysql_fetch_array($progQuery, MYSQL_ASSOC)) {
			if (substr($progInfo["starttime"],8) == $mythstart &&
			    substr($progInfo["endtime"],8) == $mythend) {
			$aRecord->startdate = $progInfo["starttime"];
			$aRecord->enddate = $progInfo["endtime"];
			$aRecord->subtitle = $progInfo["subtitle"];
			$aRecord->description = $progInfo["description"];
			break;
			}
		}
		mysql_free_result($progQuery);
		$recordArray[$i] = $aRecord;
		$i++;
	}
	mysql_free_result($recordQuery);
	return $recordArray;
}

// parse the time strings into an array
function parseTime($time) {
	$theTime['year'] = substr($time, 0, 4);
	$theTime['month'] = substr($time, 4, 2);
	$theTime['day'] = substr($time, 6, 2);
	$theTime['hour'] = substr($time, 8, 2);
	$theTime['minute'] = substr($time, 10, 2);
	$theTime['second'] = substr($time, 12, 2);

	return($theTime);
}

// parse the time strings into an array
function parseTime2($time) {
	$theTime['year'] = substr($time, 0, 4);
	$theTime['month'] = substr($time, 5, 2);
	$theTime['day'] = substr($time, 8, 2);
	$theTime['hour'] = substr($time, 10, 2);
	$theTime['minute'] = substr($time, 13, 2);
	$theTime['second'] = substr($time, 16, 2);

	return($theTime);
}

// since the timeslotrecord table stores times differently, here is another function to parse it
function parseTimeSlotTime($time) {
	$theTime['hour'] = substr($time, 0, 2);
	$theTime['minute'] = substr($time, 3, 2);
	$theTime['second'] = substr($time, 6, 2);

	return($theTime);
}

// return a nice time string to print
function getTimeString2($time) {
	$theTime = parseTime2($time);
	list ($theHour, $ampm) = getHour($theTime['hour']);
	$returnTime = $theTime['month'] . "/" . $theTime['day'] . "/" . $theTime['year'] . " " . $theHour . ":" . $theTime['minute'] . $ampm;
	return($returnTime);
}

// return a nice time string to print
function getTimeString($time) {
	$theTime = parseTime($time);
	list ($theHour, $ampm) = getHour($theTime['hour']);
	$returnTime = $theTime['month'] . "/" . $theTime['day'] . "/" . $theTime['year'] . " " . $theHour . ":" . $theTime['minute'] . $ampm;
	return($returnTime);
}

// return the time as formatted in mysql database
function buildMythTime($time) {
	$local = localtime($time);
	$returnTime = sprintf("%04d%02d%02d%02d%02d%02d", $local[5]+1900, $local[4]+1, $local[3], $local[2], $local[1], $local[0]);
	return($returnTime);
}



// Adapted from my_filesize (see below)
function my_time($time) {
      $min = 60;          // Minute
      $hr  = 60 * $min;   // Hour
      if($time < $hr) {
         return round($time/$min,1)." mins";
      } else if($time > $hr) {
         return round($time/$hr,1)." hrs";
      } else if($time = $hr) {
         return "1 hr";
      }
}


// fetch all the listings for a certain channel and day
function fetchChannelDaysListings($chanid, $day)
{
	$i = 0;
	$theTime = parseTime($day);

	$from = date('YmdHis', mktime($theTime['hour'], 00, 00, $theTime['month'], $theTime['day'], $theTime['year']));
	$to = date('YmdHis', mktime(23, 59, 59, $theTime['month'], $theTime['day'], $theTime['year']));

	$query = "SELECT channel.chanid, channel.channum, icon, name, starttime, endtime, title, subtitle, description, category, ((UNIX_TIMESTAMP(endtime) - UNIX_TIMESTAMP(starttime)) / 60 ) as duration FROM program,channel WHERE program.chanid = channel.chanid AND program.chanid = $chanid AND starttime >= $from  AND starttime <= $to ORDER BY starttime ASC;";

	$result = mysql_query($query) or die("Gadzooks! I can't open the program table.");

	while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$myprog = new ProgramInfo;
		$myprog->title = $line["title"];
		$myprog->subtitle = $line["subtitle"];
		$myprog->chanid = $line["chanid"];
		$myprog->chanstr = $line["channum"];
		$myprog->startts = $line["starttime"];
		$myprog->endts = $line["endtime"];
		$myprog->progType = $line["category"];
		$myprog->duration = $line["duration"];
		$myprog->description = $line["description"];
		$myprog->channame = $line["name"];

		$listingarray[$i] = $myprog;
		$i++;
	}

	mysql_free_result($result);

	return $listingarray;
}

function getHour($hour)  {
	if ($hour > 12) {
		$hour -= 12;
		$ampm = "pm";
	}
	else if ($hour == 0) {
		$hour = 12;
		$ampm = "am";
	}
	else if ($hour == 12) {
		$ampm = "pm";
	}
	else $ampm = "am";
	return array($hour, $ampm);
}


?>
