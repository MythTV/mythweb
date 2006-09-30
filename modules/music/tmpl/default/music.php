<?php
/**
 * MythMusic browser.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Music
 *
/**/

class Theme_music {

    var $maxPerPage;
    var $totalCount;
    var $offset;

    var $result;
    var $statusMessage;
    var $filterPlaylist;

    var $alphacount;

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
        $query="SELECT playlist_id, playlist_name FROM music_playlists ORDER BY playlist_name";
        $queryResults=mysql_query($query);

        if($queryResults)
        {
            printf("<td align=\"center\">");
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


    function Theme_music() {
        $this->maxPerPage=100;
    }



    function printNavBar()
    {

        $pageCount=($this->totalCount / $this->maxPerPage) +1;
        /*** printf("<table class=\"musicTable\" width=\"100%%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n");  ***/
        printf("<tr class=\"menu\">\n");
        if($this->offset > 0)
        {
            printf("<td align=\"left\"><a href=\"".root."music\" >%s</a>",t('All Music'));
            printf("%s<a href=\"".root."music?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",0,$this->keepFilters,t('Top'));

            if( ($this->offset - ($this->maxPerPage * 5)) > 0)
                printf("%s<a href=\"".root."music?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",
                       $this->offset - (5 * $this->maxPerPage),$this->keepFilters,"-" .  (5 * $this->maxPerPage));
            else
                printf("%s","&nbsp;|&nbsp;-" . (5 * $this->maxPerPage));

            printf("%s<a href=\"".root."music?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",
                   $this->offset - $this->maxPerPage,$this->keepFilters, t('Previous'));

        } else {
            printf("<td align=\"left\"><a href=\"".root."music\" >%s</a>",t('All Music'));
            printf("%s","&nbsp;|&nbsp;" . t('Top'));
            printf("%s","&nbsp;|&nbsp;-" . (5 * $this->maxPerPage));
            printf("%s","&nbsp;|&nbsp;" . t('Previous'));
        }

        /**** Print out alphabet links ****/
        printf("</td><td align=\"center\">\n");
        for ($alphacount = 65; $alphacount <= 90; $alphacount++)
            printf('<a href="'.root."music?alphalink=%s\" >%s</a> \n", chr($alphacount), chr($alphacount));

        printf("</td>");

        if($this->totalCount > ($this->maxPerPage + $this->offset))
        {
            printf("<td align=\"right\"><a href=\"".root."music?offset=%d%s\" >%s</a>",
                   $this->offset + $this->maxPerPage,$this->keepFilters,t('Next'));
            if( (($this->maxPerPage * 5) + $this->offset) < $this->totalCount )
                printf("%s<a href=\"".root."music?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",
                       $this->offset + (5 * $this->maxPerPage),$this->keepFilters,"+" . (5 * $this->maxPerPage));
            else
                printf("%s","&nbsp;|&nbsp;+" . 5 * $this->maxPerPage);
            printf("%s<a href=\"".root."music?offset=%d%s\" >%s</a>","&nbsp;|&nbsp;",
                   $this->totalCount - $this->maxPerPage,$this->keepFilters,t('End'));
            printf("</td>");

        } else {
            printf("<td align=\"right\">%s",t('Next'));
            printf("%s","&nbsp;|&nbsp;+" .(5 * $this->maxPerPage));
            printf("%s","&nbsp;|&nbsp;".t('End'));
            printf("</td>");
        }



        printf("</tr>\n");
        printf("</table>\n");
    }
    function printDetail($trackName,$trackTime,$trackArtist,$trackAlbum,$trackGenre,$urlfilename) {
        printf("<tr class=\"musicRow\">\n");
        printf("<td class=\"musicTrack\"> <a href=\"%s\">%s</a></td>\n",$urlfilename,htmlspecialchars($trackName));
        $calcLength=$trackTime/1000;
        $calcMin=$calcLength/60;
        $calcSec=$calcLength%60;
        printf("<td class=\"musicTime\">%d:%02d</td>\n",$calcMin,$calcSec);
        printf("<td class=\"musicArtist\"> <a href=\"".root."music?filterArtist=%s\" >%s</a></td>\n",urlencode($trackArtist),htmlspecialchars($trackArtist));
        printf("<td class=\"musicAlbum\"> <a href=\"".root."music?&amp;filterAlbum=%s\" >%s</a></td>\n",urlencode($trackAlbum),htmlspecialchars($trackAlbum));
        printf("<td class=\"musicGenre\"> <a href=\"".root."music?filterGenre=%s\" > %s</a></td>\n",urlencode($trackGenre),htmlspecialchars($trackGenre));
        printf("</tr>\n");
    }
    function printNoDetail()
    {
        printf("<tr><td>".t('No Tracks Available')."</p>\n");
    }

    function print_menu_content() {
        echo "MythMusic";
    }

    function print_header($filterPlaylist,$filterArtist,$filterAlbum,$filterGenre) {
        $this->filterPlaylist=$filterPlaylist;
    // Set the desired page title
        global $page_title, $Modules, $headers;
        $page_title = 'MythWeb - '.t('Music');
    // Print the page header
        require 'modules/_shared/tmpl/'.tmpl.'/header.php';

        printf("<form  action=\"".root."music\" method=\"GET\" >\n");
        printf("<input type=\"hidden\" name=\"mode\" value=\"music\" />\n");


        printf("<table width=\"100%%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"");
        printf("<tr class=\"menu\" >");

        if($filterArtist != "_All_" || $filterAlbum != "_All_" || $filterGenre != "_All_" || $filterPlaylist != "_All_")
            printf("%s\n","<td align=\"left\" >" . $this->totalCount . " ".t('Filtered')."</td>");
        else
            printf("%s\n","<td align=\"left\" >" . $this->totalCount . " ".t('Unfiltered')."</td>");


        $this->playListSelector();
        $this->actionSelector();
        printf("<input TYPE=\"SUBMIT\" NAME=\"updateButton\" VALUE=\"Update\">");

        printf("</td>");
        if($filterArtist != "_All_" || $filterAlbum != "_All_" || $filterGenre != "_All_" )
        {
            if( ($this->offset + $this->maxPerPage) > $this->totalCount)
                printf("%s\n","<td align=\"right\" >" . t('Displaying') . ": " . (0 + $this->offset) . "-" . $this->totalCount . "</td>");
            else
                printf("%s\n","<td align=\"right\" >" . t('Displaying') . ": " . ( 0 + $this->offset) . "-" . ( $this->offset + $this->maxPerPage) . "</td>");
        } else {
            if( ($this->offset + $this->maxPerPage) > $this->totalCount)
                printf("%s\n","<td align=\"right\" >" . t('Displaying') . ": " . ( 0 + $this->offset) . "-" . $this->totalCount . "</td>");
            else
                printf("%s\n","<td align=\"right\" >" . t('Displaying') . ": " . ( 0 + $this->offset) . "-" . ( $this->offset + $this->maxPerPage) . "</td>");
        }

        printf("</tr>");
        $this->printNavBar();
        printf("<table class=\"list small\" width=\"100%%\" border=\"0\" cellpadding=\"4\" cellspacing=\"2\">\n");
        printf("<tr class=\"menu\">");
        printf("<td>" . t('Track Name') . "</td>\n");
        printf("<td>" . t('Duration') . "</td>\n");
        if($filterArtist=="_All_")
            printf("<td>" . t('Artist') . "</td>\n");
        else
            printf("<td>" . t('Artist (filtered)') . "</br>%s</td>",htmlspecialchars($filterArtist));
        if($filterAlbum=="_All_")
            printf("<td>" . t('Album') . "</td>\n");
        else
            printf("<td>" . t('Album (filtered)') . "</br>%s</td>",htmlspecialchars($filterAlbum));
        if($filterGenre=="_All_")
            printf("<td>" . t('Genre') . "</td>\n");
        else
            printf("<td>" . t('Genre (filtered)') . "</br>%s</td>",htmlspecialchars($filterGenre));
        printf("</tr>");


    }
    function print_footer()
    {
        printf("</table>\n");
        printf("<table class=\"musicTable\" width=\"100%%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n");
        $this->printNavBar();

        printf("</form>");

        require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
    }

}

