<?php


 //
 // This file is part of MythWeb,
 // a php-based interface into MythTV.
 //
 // (c) 2002 by Thor Sigvaldason and Isaac Richards
 // MythWeb is distributed under the
 // GNU GENERAL PUBLIC LICENSE version 2
 // (see http://www.gnu.org)
 //

// movies.php - give a general overview of the movies for the next
// specified number of days

$maxCols = 5;
$header = "
	<tr bgcolor=\"$list_fg_colour\" cellpadding=1>
		<td align=center bgcolor=\"$list_bg_colour\">&nbsp;</td>
		<td align=center>Time</td>
		<td align=center>Title</td>
		<td align=center>Description</td>
		<td align=center>Details...</td>
	</tr>
";

$table = "
	<p>
	<table width=\"100%\" border=0 cellpadding=2 cellspacing=1 bgcolor=\"$list_bg_colour\">
";

for ($daycount = 0; $daycount < $movie_lookahead; $daycount++)
{
	print "<a name=\"day$daycount\"><p><div align=center>Jump to day...";
	for ($daynav = 0; $daynav < $movie_lookahead; $daynav++)
	{
		if ($daycount == $daynav)
			continue;
		printf(" <a href=\"#day%d\">%d</a>", $daynav, $daynav+1);
	}
	print "</div>";
	print $table;	
	
	$alreadyprinted = FALSE;
	$listingarray = fetchMovieListings($ignore_movie_channels, $daycount);

	for ($index = 0; $proginfo = $listingarray[$index]; $index++)
	{
		if (!$proginfo->smellsLikeMovie())
			continue;

		if (!$alreadyprinted) {
			printf("<tr cellpadding=1><td></td><td align=center bgcolor=\"$list_fg_colour\" colspan=%d>", $maxCols-1);
			printTheDate($proginfo->startts, 0, 0);
			print "</td></tr>\n";

			$alreadyprinted = TRUE;
			print $header;
		}

		print "<tr>";

		$channel = $proginfo->chanstr." ".$proginfo->callsign;
		$proginfo->icon = "images/icons/" . basename($proginfo->icon);
		if ($includeIcon && is_file($proginfo->icon))
			$channel .= "<br><img src=\"$proginfo->icon\">";
		printf("<td align=center><font size=\"-1\"><a style=\"color:$menu_fg_colour\" href=\"main.php?mode=bychannel&chanid=%s\">%s</a></font></td>",
				$proginfo->chanid, $channel);

		print "<td align=center bgcolor=\"$list_fg_colour\">".$proginfo->startTime()."</td>";

		$bgcolour = $colorArray[$proginfo->progType];
		if ("" == $bgcolour)
			$bgcolour = $list_default_colour;

		if ($proginfo->willRecord())
			$fgcolour = $list_reccolour;
		else
			$fgcolour = $bgcolour;

		$proginfo->setColours($fgcolour, $bgcolour);
		$proginfo->printYourself(1, 0);

		printf("<td bgcolor=\"%s\">%s</td>", $list_default_colour, $proginfo->description);

		printf("<td bgcolor=\"%s\" align=center><a href=\"http://www.imdb.com/Tsearch?type=substring&tv=off&year=%d&sort=smart&title=%s\">IMDB</a></td>",
			$list_default_colour,
			$proginfo->airdate,
			urlencode($proginfo->title));

		print "</tr>\n";
	}
	print "</table>";
}

?>
