<?
/***                                                                        ***\
	channel_detail.php                       Last Updated: 2003.07.20 (xris)


\***                                                                        ***/

// Initialize the script, database, etc.
	require_once "includes/init.php";

// Chanid?
	$_GET['chanid'] or $_GET['chanid'] = $_POST['chanid'];
	$this_channel = &load_one_channel($_GET['chanid']);

// No channel found
	if (!$_GET['chanid'] || !$this_channel->chanid) {
		header('Location: program_listing.php?time='.$_SESSION['list_time']);
		exit;
	}

// New list time?
	$_GET['time'] or $_GET['time'] = $_POST['time'];
	if ($_GET['time'])
		$_SESSION['list_time'] = $_GET['time'];

// Load the programs for today
	$this_channel->programs = load_all_program_data(mktime(0, 0, 0, date('n', $_SESSION['list_time']), date('j', $_SESSION['list_time']), date('Y', $_SESSION['list_time'])),
													mktime(0, 0, 0, date('n', $_SESSION['list_time']), date('j', $_SESSION['list_time']) + 1, date('Y', $_SESSION['list_time'])),
													$this_channel->chanid);

// Load the class for this page
	require_once theme_dir.'channel_detail.php';

// Create an instance of this page from its theme object
	$Page = new Theme_channel_detail();

// Display the page
	$Page->print_page();

// Exit
	exit;


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
//	listings.php is the default mode that
//	shows current listings.
//

//
//	If we got passed a date/time to start and maybe a time offset
//	or (if not) see if we got passed a time offset on the URL (GET)
//	or (if not) use the current system time.
//
//
//	If we got passed a date/time to start and maybe a time offset
//	or (if not) see if we got passed a time offset on the URL (GET)
//	or (if not) use the current system time.
//
if(isset($_GET["date"]))
{
	$theOffset = 0;
	$idate = $_GET["date"];
	$sqlstarttime = $idate."000000";

	$time = parseTime($sqlstarttime);
	if(isset($_GET["timeoffset"]))
	{
		$theOffset = $_GET["timeoffset"];
		$adjuster = round(30 * $timeSlots * $_GET["timeoffset"]);
		$sqlstarttime = date("YmdHis", mktime($time["hour"], 0 + $adjuster,0,$time["month"],$time["day"],$time["year"]));
		$idate = date("Ymd", mktime($time["hour"], 0 + $adjuster,0,$time["month"],$time["day"],$time["year"]));
		$ihour = date("H", mktime($time["hour"], 0 + $adjuster,0,$time["month"],$time["day"],$time["year"]));
		$theOffset=0;
	}
}
else
{
	$sqlstarttime = date('YmdHis');
	$idate = date('Ymd');
	$ihour = date('H');
	$theOffset = 0;
}
if(isset($_GET["chanid"]))
{
	$chanid = $_GET["chanid"];
}
else
{
	// if we are here something is wrong
}

//
//	Now we need to get all the programs for the chanid we got passed
//  This is an array of ProgramInfo objects
//

$listingarray = fetchChannelDaysListings($chanid,$sqlstarttime);


//	Put out the date/time adjust fields
echo "<center>";
echo "<form action=\"main.php\" method=\"get\">";
echo "<input type=\"hidden\" name=\"mode\" value=\"bychannel\">";
echo "<input type=\"hidden\" name=\"chanid\" value=\"$chanid\">";
echo "&nbsp;&nbsp;Date:&nbsp;&nbsp;";
echo "<select name=date>";
for ($i=-1;$i<14;$i++)
{
	$year = date('Y');
	$month = date('m');
	$day = date('d');
	$date = date("Ymd",mktime(0,0,0,$month,$day+$i,$year));
	$date2 = date($date_format,mktime(0,0,0,$month,$day+$i,$year));
	echo "<option value=$date ";
	if ($date==$idate) echo "selected";
	echo ">$date2</option>";
}
echo "</select>";
echo "&nbsp;&nbsp;&nbsp;<input type=submit value=Jump>";
echo "</form>";
echo "</center>";

    //
    // Start outputing. First a big
    // table in the "background" colour just to
    // set the colour and show the lines
    // between programs
    //
    print("\n\n\t\t<TABLE WIDTH=\"70%\" ALIGN=\"CENTER\" BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"0\" BGCOLOR=\"$list_bg_colour\">\n\t\t\t<TR>\n\t\t\t\t<TD ALIGN=\"CENTER\" VALIGN=\"CENTER\">\n");
    print("<H3>" . $listingarray[0]->channame . "</H3>");
	print("</TD></TR><TR><TD>");
    print("\t\t\t\t\t<TABLE WIDTH=\"100%\" BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"1\" BGCOLOR=\"$list_bg_colour\">\n");
	// print out channel row of programs
	$lasttitle = " ";
	$lastsubtitle = " ";
	$lastendts = 0;
	$programindex = 0;
	while ($proginfo = $listingarray[$programindex])
	{
        if ($proginfo == null)
            continue;

		$finalColour = $list_default_colour;
		if ($proginfo->endts != $lastendts)
		{
			$cellwidth = 1;

			if(smellsLikeMovie($proginfo->duration, $proginfo->progType))
			{
				$finalColour = $movie_colour;
			}
			else
			{
				$finalColour = $colorArray[$proginfo->progType];
			}
			if ($finalColour == "")
			{
				$finalColour = $list_default_colour;
			}
			$proginfo->setColours($finalColour, $finalColour);
			$recordArrayIndex = 0;
			//
			//	Check and see if this is in Record
			//	Once data
			//
			$isBeingSingleRecorded = isInOnceRecord($proginfo->chanid, $proginfo->startts);
			if ($isBeingSingleRecorded)
			{
			    $proginfo->setColours($list_reccolour, $finalColour);
			}

			//	Check and see if this is an
			//	always record or a timeslot
			//	record
			//
			if(isInAlwaysRecord($proginfo->title) ||
			isInChannelAlwaysRecord($mychannel->chanid, $proginfo->title) ||
			isInTimeslotRecord($proginfo->chanid, $proginfo->startts, $proginfo->endts, $proginfo->title))
			{
				$proginfo->setColours($list_reccolour, $finalColour);
			}
			$proginfo->printYourselfDetailed();

		}
		$lasttitle = $proginfo->title;
		$lastsubtitle = $proginfo->subtitle;
		$lastendts = $proginfo->endts;

		$programindex++;
	}
	print ("</TABLE></TD></TR></TABLE>");

?>
