<?php

	//
	//	This file is part of MythWeb,
	//	a php-based interface into MythTV.
	//
	//	(c) 2002 by Thor Sigvaldason and Isaac Richards
	//	MythWeb is distributed under the
	//	GNU GENERAL PUBLIC LICENSE version 2
	//	(see http://www.gnu.org)
	//


//
//	This file contains some classes
//




//
//	A Time class that understands SQL formatted time,
//	human readable time and UNIX timestamps.
//
class TimeValue
{
	var $sqltime;
	var $unixtime;
	var $humantime;

 	var $fgColour;
	var $bgColour;

	function TimeValue($datestr) {
		$this->setVals($datestr);
	}

   	//
   	//	Set the background and foreground colours
   	//	for how time is displayed (at the top of
   	//	the listings table).
   	//

	function setColour($fg, $bg)
 	{
		$this->fgColour = $fg;
		$this->bgColour = $bg;
	}

	//
	//	Given colours, print yourself.
	//

	function printYourself()
	{
		print("\t\t\t\t\t<TD BGCOLOR=\"$this->bgColour\">\n");
		print("\t\t\t\t\t\t&nbsp; <font style=\"color:$this->fgcolor\">$this->humantime</font>\n");
		print("\t\t\t\t\t</TD>\n");
	}

	function setVals($datestr)
	{
		$year = substr($datestr, 0, 4);
		$month = substr($datestr, 4, 2);
		$day = substr($datestr, 6, 2);
		$hour = substr($datestr, 8, 2);
 		$mins = substr($datestr, 10, 2);
		$secs = substr($datestr, 12, 2);

		if ((int)$mins >= 30) {
			$mins = 30;
			$sqlmins = 45;
		}
		else {
			$mins = 0;
			$sqlmins = 15;
		}

		$am = $hour < 12 ? true : false;

		$this->unixtime = mktime($hour, $mins, 0, $month, $day, $year);
		$this->humantime = date($GLOBALS['time_format'],$this->unixtime);
		$this->sqltime = date('YmdHis', mktime($hour, $sqlmins, 50, $month, $day, $year));
	}
}



//
//	Container for recording data
//

class Recording
{
	var $chanid;
	var $channum;
	var $starttime;
	var $endtime;
	var $title;
	var $subtitle;
	var $description;
}





?>
