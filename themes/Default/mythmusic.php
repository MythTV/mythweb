<?php
/***                                                                        ***\
    music.php                       Last Updated: 2003.08.06 (xris)

    This file defines a theme class for the music section.
    It must define one method.   documentation will be added someday.
\***                                                                        ***/

class Theme_mythmusic extends Theme {

    var $maxPerPage;
    var $totalCount;
    var $offset;

    var $result;
    var $statusMessage;
    var $filterPlaylist;

    function getMaxPerPage()
    {
        return($this->maxPerPage);
    }

    function setTotalCount($newTotal)
    {
        $this->totalCount=$newTotal;
    }
    function setOffset($newOffset)
    {
        $this->offset=$newOffset;
    }

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


    function Theme_mythmusic() {
        $this->maxPerPage=100;
    }



    function printNavBar()
    {

        $pageCount=($this->totalCount / $this->maxPerPage) +1;
        printf("<table class=\"musicTable\" width=\"100%%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n");
        printf("<tr class=\"menu\">\n");
        if($this->offset > 0)
        {
            printf("<td align=\"left\"><a href=\"mythmusic.php\" >%s</a>","All Music");
            printf("%s<a href=\"mythmusic.php?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",0,$this->keepFilters,"Top");

            if( ($this->offset - ($this->maxPerPage * 5)) > 0)
                printf("%s<a href=\"mythmusic.php?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",
                       $this->offset - (5 * $this->maxPerPage),$this->keepFilters,"-" .  (5 * $this->maxPerPage));
            else
                printf("%s","&nbsp;|&nbsp;-" . (5 * $this->maxPerPage));

            printf("%s<a href=\"mythmusic.php?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",
                   $this->offset - $this->maxPerPage,$this->keepFilters, "Previous");
            printf("</td>");

        } else {
            printf("<td align=\"left\"><a href=\"mythmusic.php\" >%s</a>","All Music");
            printf("%s","&nbsp;|&nbsp;Top");
            printf("%s","&nbsp;|&nbsp;-" . (5 * $this->maxPerPage));
            printf("%s","&nbsp;|&nbsp;Previous");
            printf("</td>");
        }

        if($this->totalCount > ($this->maxPerPage + $this->offset))
        {
            printf("<td align=\"right\"><a href=\"mythmusic.php?offset=%d%s\" >%s</a>",
                   $this->offset + $this->maxPerPage,$this->keepFilters,"Next");
            if( (($this->maxPerPage * 5) + $this->offset) < $this->totalCount )
                printf("%s<a href=\"mythmusic.php?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",
                       $this->offset + (5 * $this->maxPerPage),$this->keepFilters,"+" . (5 * $this->maxPerPage));
            else
                printf("%s","&nbsp;|&nbsp;+" . 5 * $this->maxPerPage);
            printf("%s<a href=\"mythmusic.php?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",
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
    function printDetail($trackName,$trackTime,$trackArtist,$trackAlbum,$trackGenre) {
        printf("<tr class=\"musicRow\">\n");
        printf("<td class=\"musicTrack\"> %s</td>\n",htmlspecialchars($trackName));
        $calcLength=$trackTime/1000;
        $calcMin=$calcLength/60;
        $calcSec=$calcLength%60;
        printf("<td class=\"musicTime\">%d:%02d</td>\n",$calcMin,$calcSec);
        printf("<td class=\"musicArtist\"> <a href=\"mythmusic.php?filterArtist=%s\" >%s</a></td>\n",urlencode($trackArtist),htmlspecialchars($trackArtist));
        printf("<td class=\"musicAlbum\"> <a href=\"mythmusic.php?&amp;filterAlbum=%s\" >%s</a></td>\n",urlencode($trackAlbum),htmlspecialchars($trackAlbum));
        printf("<td class=\"musicGenre\"> <a href=\"mythmusic.php?filterGenre=%s\" > %s</a></td>\n",urlencode($trackGenre),htmlspecialchars($trackGenre));
        printf("</tr>\n");
    }
    function printNoDetail()
    {
        printf("<tr><td>No Tracks Available</p>\n");
    }

    function print_menu_content() {
        echo "MythMusic";
    }

    function print_header($filterPlaylist,$filterArtist,$filterAlbum,$filterGenre) {
        $this->filterPlaylist=$filterPlaylist;
        parent::print_header("MythWeb - Music: ");
        printf("<form  action=\"mythmusic.php\" method=\"GET\" >\n");
        printf("<input type=\"hidden\" name=\"mode\" value=\"music\" />\n");


        printf("<table width=\"100%%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"");
        printf("<tr class=\"menu\" >");

        if($filterArtist != "_All_" || $filterAlbum != "_All_" || $filterGenre != "_All_" || $filterPlaylist != "_All_")
            printf("%s\n","<td align=\"left\" >" . $this->totalCount . " Filtered</td>");
        else
            printf("%s\n","<td align=\"left\" >" . $this->totalCount . " Unfiltered</td>");




        printf("<td align=\"center\" >");

        $this->playListSelector();
        $this->actionSelector();
        printf("<input TYPE=\"SUBMIT\" NAME=\"updateButton\" VALUE=\"Update\">");

        printf("</td>");
        if($filterArtist != "_All_" || $filterAlbum != "_All_" || $filterGenre != "_All_" )
        {
            if( ($this->offset + $this->maxPerPage) > $this->totalCount)
                printf("%s\n","<td align=\"right\" >"  . "Displaying: " .(0 + $this->offset) . "-" . $this->totalCount . "</td>");
            else
                printf("%s\n","<td align=\"right\" >" . "Displaying: " .( 0 + $this->offset) . "-" . ( $this->offset + $this->maxPerPage) . "</td>");
        } else {
            if( ($this->offset + $this->maxPerPage) > $this->totalCount)
                printf("%s\n","<td align=\"right\" >"  . "Displaying: " .( 0 + $this->offset) . "-" . $this->totalCount . "</td>");
            else
                printf("%s\n","<td align=\"right\" >" . "Displaying: " .( 0 + $this->offset) . "-" . ( $this->offset + $this->maxPerPage) . "</td>");
        }

        printf("</tr>");
        printf("</table>");
        $this->printNavBar();
        printf("<table class=\"list small\" width=\"100%%\" border=\"0\" cellpadding=\"4\" cellspacing=\"2\">\n");
        printf("<tr class=\"menu\">");
        printf("<td>Track Name</td>\n");
        printf("<td>Time</td>\n");
        if($filterArtist=="_All_")
            printf("<td>Artist</td>\n");
        else
            printf("<td>Artist (filtered)</br>%s</td>",htmlspecialchars($filterArtist));
        if($filterAlbum=="_All_")
            printf("<td>Album</td>\n");
        else
            printf("<td>Album (filtered)</br>%s</td>",htmlspecialchars($filterAlbum));
        if($filterGenre=="_All_")
            printf("<td>Genre</td>\n");
        else
            printf("<td>Genre (filtered)</br>%s</td>",htmlspecialchars($filterGenre));
        printf("</tr>");


    }
    function print_footer()
    {
        printf("</table>\n");
        $this->printNavBar();

        printf("</form>");

        parent::print_footer();
    }

}
?>
