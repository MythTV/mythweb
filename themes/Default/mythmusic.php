<?php
/***                                                                        ***\
    music.php                       Last Updated: 2003.08.02 (brent)

    This file defines a theme class for the music section.
    It must define one method.   documentation will be added someday.
\***                                                                        ***/

class Theme_mythmusic extends Theme {

    var $maxPerPage;
    var $totalCount;
    var $offset;

    var $filterPlaylist;
    var $filterArtist;
    var $filterAlbum;
    var $filterGenre;
    var $filterRank;
    var $filterSonglist;
    var $keepFilters;
    var $filter;
    var $result;
    var $statusMessage;

    function playListSelector()
    {
        $query="SELECT playlistid, name from musicplaylist order by name";
        $queryResults=mysql_query($query);

        if($queryResults)
        {
            $row=mysql_fetch_row($queryResults);
            printf("<select name=\"filterPlaylist\">\n");
            printf("\t<option value=\"_All_\" ");
            if($this->filterPlaylist != "_All_")
                printf("selected >");
            else
                printf(">");
            printf("All Music</option>\n");

            do {
                printf("\t<option value=\"%d\" ",$row[0]);
                if($this->filterPlaylist  == ($row[0]) )
                    printf("selected >");
                else
                    printf(">");

                printf("%s</option>\n",$row[1]);
            } while ($row=mysql_fetch_row($queryResults));
            printf("</select>");
        }
    }
    function actionSelector()
    {
        printf("<select name=\"action\" >\n");
        printf("<option value=\"0\" selected >View Play List or Summary</option>");
        printf("</select>");
    }


    function musicInfo() {
        $this->maxPerPage=100;



        if($_GET['offset'] >=0 )
            $this->offset=$_GET['offset'];
        else
            $this->offset=0;


        if($_GET['filterPlaylist'])
        {
            $this->filterPlaylist=$_GET['filterPlaylist'];
            $_GET['filterPlaylist'];
        }
        else
            $this->filterPlaylist="_All_";

        if($_GET['filterArtist'])
        {
            $this->filterArtist=$_GET['filterArtist'];
        }
        else
            $this->filterArtist="_All_";

        if($_GET['filterAlbum'])
        {
            $this->filterAlbum=$_GET['filterAlbum'];
        }
        else
            $this->filterAlbum="_All_";
        if($_GET['filterGenre'])
        {
            $this->filterGenre=$_GET['filterGenre'];
        }
        else
            $this->filterGenre="_All_";


        if($_GET['filterRank'])
            $this->filterRank=$_GET['filterRank'];
        else
            $this->filterRank="_All_";
    }

    function prepFilter()
    {
        $prevFilter=0;
        $thisFilter="";

        if($this->filterPlaylist != "_All_")
        {
            $playlistResult = mysql_query("select playlistid,name,songlist,hostname from musicplaylist where playlistid=\"" . $this->filterPlaylist . "\"");
            if($playlistResult)
            {
                if(mysql_num_rows($playlistResult)==1)
                {
                    $row=mysql_fetch_row($playlistResult);
                    if($row)
                    {

                        $this->filterSonglist=$row[2];
                        if($prevFilter==1)
                            $this->filter=$this->filter . "and intid in (" . $this->filterSonglist . ")";
                        else
                        {
                            $this->filter="intid in (" . $this->filterSonglist . ")";
                            $prevFilter=1;
                        }

                        $this->keepFilters="&amp;filterPlaylist=" . urlencode($this->filterPlaylist);

                    }
                }
            }
        }

        if($this->filterArtist != "_All_" )
        {
            if($prevFilter==1)
                $this->filter=$this->filter . "and artist=\"" . $this->filterArtist . "\"";
            else
            {
                $this->filter="artist=\"" . $this->filterArtist . "\"";
                $prevFilter=1;
            }

            $this->keepFilters="&amp;filterArtist=" . urlencode($this->filterArtist);

        }
        if($this->filterAlbum != "_All_")
        {
            if($prevFilter==1)
            {
                $this->filter= $this->filter . "and album=\"" . $this->filterAlbum . "\"";
            }
            else
            {
                $this->filter="album=\"" . $this->filterAlbum . "\"";
                $prevFilter=1;
            }
            $this->keepFilters =$this->keepFilters . "&amp;filterAlbum=" . urlencode($this->filterAlbum) ;

        }
        if($this->filterGenre != "_All_")
        {
            if($prevFilter==1)
            {
                $this->filter= $this->filter . "and genre=" . $this->filterGenre ;
            }
            else
            {
                $this->filter="genre=\"" . $this->filterGenre . "\"";
                $prevFilter=1;
            }
            $this->keepFilters =$this->keepFilters . "&amp;filterGenre=" . urlencode($this->filterGenre);

        }

        if($this->filterRank != "_All_")
        {
            if($prevFilter==1)
            {
                $this->filter=$this->filter . "and rank=" . $this->filterRank;
            }
            else
            {
                $this->filter="rank=" . $this->filterRank;
                $prevFilter=1;
            }
            $this->keepFilters =$this->keepFilters . "&amp;filterRank=" . urlencode($this->filterRank);
        }



    }

    function init() {
        $this->prepFilter();
        if($this->filter != "") {
            $result=mysql_query("select count(*) as cnt from musicmetadata where  $this->filter");
        }
        else
            $result=mysql_query("select count(*) as cnt from musicmetadata");

        if($result)
        {
            $this->totalCount = mysql_result($result,0,"cnt");
            mysql_free_result($result);
        }
        else
            $this->totalCount = 0;

        if($this->totalCount > 0)
        {
            if($this->offset > 0)
            {
                $limitText="LIMIT  " . $this->offset . " , " . $this->maxPerPage . " ";
            }
            else
                $limitText="LIMIT  " . $this->maxPerPage . " ";

            if($this->filter != "")
            {
                $this->result=mysql_query("select intid,artist,album,title,genre,length,rating from musicmetadata where  $this->filter order by artist,album,tracknum $limitText");
            }
            else
            {

                $this->result=mysql_query("select intid,artist,album,title,genre,length,rating from musicmetadata order by artist,album,tracknum " . $limitText);
            }
        }
    }
    function printNavBar()
    {

        $pageCount=($this->totalCount / $this->maxPerPage) +1;
        printf("<table class=\"musicTable\" width=\"100%%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n");
        printf("<tr class=\"menu\">\n");
        if($this->offset > 0)
        {
            printf("<td align=\"left\"><a href=\"music.php\" >%s</a>","All Music");
            printf("%s<a href=\"music.php?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",0,$this->keepFilters,"Top");

            if( ($this->offset - ($this->maxPerPage * 5)) > 0)
                printf("%s<a href=\"music.php?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",
                       $this->offset - (5 * $this->maxPerPage),$this->keepFilters,"-" .  (5 * $this->maxPerPage));
            else
                printf("%s","&nbsp;|&nbsp;-" . (5 * $this->maxPerPage));

            printf("%s<a href=\"music.php?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",
                   $this->offset - $this->maxPerPage,$this->keepFilters, "Previous");
            printf("</td>");

        } else {
            printf("<td align=\"left\"><a href=\"music.php\" >%s</a>","All Music");
            printf("%s","&nbsp;|&nbsp;Top");
            printf("%s","&nbsp;|&nbsp;-" . (5 * $this->maxPerPage));
            printf("%s","&nbsp;|&nbsp;Previous");
            printf("</td>");
        }
        if($this->filter != "")
        {
            if( ($this->offset + $this->maxPerPage) > $this->totalCount)
            {

                $this->statusMessage="<td align=\"center\" >" . $this->totalCount . " Filtered"  . "&nbsp;Displaying: " .
                    (0 + $this->offset) . "-" . $this->totalCount . "</td>";
            }
            else{
                $this->statusMessage="<td align=\"center\" >" . $this->totalCount . " Filtered" .  "&nbsp;Displaying: " .
                    ( 0 + $this->offset) . "-" . ( $this->offset + $this->maxPerPage) . "</td>";
            }
        } else {
            if( ($this->offset + $this->maxPerPage) > $this->totalCount)
            {

                $this->statusMessage="<td align=\"center\" >" . $this->totalCount . " Total "  . "&nbsp;Displaying: " .
                    ( 0 + $this->offset) . "-" . $this->totalCount . "</td>";
            }
            else{
                $this->statusMessage="<td align=\"center\" >" .  $this->totalCount . "Total #: " . "&nbsp;Displaying: " .
                    ( 0 + $this->offset) . "-" . ( $this->offset + $this->maxPerPage) . "</td>";
            }

        }
        printf("%s",$this->statusMessage);

        if($this->totalCount > ($this->maxPerPage + $this->offset))
        {
            printf("<td align=\"right\"><a href=\"music.php?offset=%d%s\" >%s</a>",
                   $this->offset + $this->maxPerPage,$this->keepFilters,"Next");
            if( (($this->maxPerPage * 5) + $this->offset) < $this->totalCount )
                printf("%s<a href=\"music.php?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",
                       $this->offset + (5 * $this->maxPerPage),$this->keepFilters,"+" . (5 * $this->maxPerPage));
            else
                printf("%s","&nbsp;|&nbsp;+" . 5 * $this->maxPerPage);
            printf("%s<a href=\"music.php?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",
                   $this->totalCount - $this->maxPerPage,$this->keepFilters,"End");
            printf("</td>");

        } else {
            printf("<td align=\"right\">%s","Next");
            printf("%s","&nbsp;|&nbsp;+" .(5 * $this->maxPerPage));
            printf("%s","&nbsp;|&nbsp;End");
            printf("</td>");
        }



        printf("</tr>\n");
        printf("</table>\n");
    }
    function printBody() {

        printf("<form  action=\"music.php\" method=\"GET\" >\n");
        printf("<input type=\"hidden\" name=\"mode\" value=\"music\" />\n");


        printf("<table width=\"100%%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"");
        printf("<tr class=\"menu\" >");
        printf("<td align=\"center\" >");
        $this->playListSelector();
        $this->actionSelector();
        printf("<input TYPE=\"SUBMIT\" NAME=\"updateButton\" VALUE=\"Update\">");
        printf("</td>");
        printf("</tr>");
        printf("</table>");
        $this->printNavBar();
        if($this->totalCount > 0)
        {
            printf("<table class=\"musicTable\" width=\"100%%\" border=\"0\" cellpadding=\"4\" cellspacing=\"2\">\n");
            printf("<tr class=\"menu\">");
            printf("<td>Track Name</td>\n");
            printf("<td>Time</td>\n");
            if($this->filterArtist=="_All_")
                printf("<td>Artist</td>\n");
            else
                printf("<td>Artist (filtered)</br>%s</td>",htmlspecialchars($this->filterArtist));
            if($this->filterAlbum=="_All_")
                printf("<td>Album</td>\n");
            else
                printf("<td>Album (filtered)</br>%s</td>",htmlspecialchars($this->filterAlbum));

            if($this->filterGenre=="_All_")
                printf("<td>Genre</td>\n");
            else
                printf("<td>Genre (filtered)</br>%s</td>",htmlspecialchars($this->filterGenre));
            printf("</tr>");

            while($row=mysql_fetch_row($this->result))
            {


                printf("<tr class=\"musicRow\">\n");
                printf("<td class=\"musicTrack\"> %s</td>\n",htmlspecialchars($row[3]));
                $calcLength=$row[5]/1000;
                $calcMin=$calcLength/60;
                $calcSec=$calcLength%60;
                printf("<td class=\"musicTime\">%d:%02d</td>\n",$calcMin,$calcSec);
                printf("<td class=\"musicArtist\"> <a href=\"music.php?filterArtist=%s\" >%s</a></td>\n",urlencode($row[1]),htmlspecialchars($row[1]));
                printf("<td class=\"musicAlbum\"> <a href=\"music.php?filterArtist=%s&amp;filterAlbum=%s\" >%s</a></td>\n",urlencode($row[1]),urlencode($row[2]),htmlspecialchars($row[2]));
                printf("<td class=\"musicGenre\"> <a href=\"music.php?filterGenre=%s\" > %s</a></td>\n",urlencode($row[4]),htmlspecialchars($row[4]));
                printf("</tr>\n");
            }
            printf("</table>\n");
        } else {
            printf("<p>No Tracks Satisfied Your Criteria</p>\n");
        }
        mysql_free_result($this->result);
        $this->printNavBar();

        printf("</form>");



    }


    function print_page() {
        parent::print_header("MythWeb - Music: ");

        $this->init();
        $this->printBody();

        parent::print_footer();
    }
}
?>
