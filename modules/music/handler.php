<?php
/**
 * MythMusic browser
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

// Make sure the music directory exists
    if (file_exists('data/music')) {
    // File is not a directory or a symlink
        if (!is_dir('data/music') && !is_link('data/music')) {
            custom_error('An invalid file exists at data/music.  Please remove it in'
                        .' order to use the music portions of MythWeb.');
        }
    }
// Create the symlink, if possible.
//
// NOTE:  Errors have been disabled because if I turn them on, people hosting
//        MythWeb on Windows machines will have issues.  I will turn the errors
//        back on when I find a clean way to do so.
//
    else {
        $dir = $db->query_col('SELECT data
                                 FROM settings
                                WHERE value="MusicLocation" AND hostname=?',
                              hostname
                             );
        if ($dir) {
            $ret = @symlink($dir, 'data/music');
            if (!$ret) {
                #custom_error("Could not create a symlink to $dir, the local MythMusic directory"
                #            .' for this hostname ('.hostname.').  Please create a symlink to your'
                #            .' MythMusic directory at data/music in order to use the music'
                #            .' portions of MythWeb.');
            }
        }
        else {
            #custom_error('Could not find a value in the database for the MythMusic directory'
            #            .' for this hostname ('.hostname.').  Please create a symlink to your'
            #            .' MythMusic directory at data/music in order to use the music'
            #            .' portions of MythWeb.');
        }
    }

//
//  Someday, music.php will let us stream
//  entire playlists to any spot on planet earth
//
require_once tmpl_dir.'music.php';

$mythmusic = new mythMusic();
$mythmusic->display();

class mythMusic {
    var $filterPlaylist;
    var $filterArtist;
    var $filterAlbum;
    var $filterGenre;
    var $filterRank;
    var $filterSonglist;
    var $keepFilters;
    var $filter;
    var $totalCount;
    var $offset;

    var $result;


    var $intid;
    var $artist;
    var $album;
    var $title;
    var $genre;
    var $length;
    var $rating;
    var $filename;
    var $urlfilename;

    var $alphalink;
    var $alphaoffset;

    function mythMusic()
    {
        if($_GET['offset'] >=0 )
            $this->offset=$_GET['offset'];
        else
            $this->offset=0;

        /**** If alphalink set, then change offset to new value ****/
        if ($_GET['alphalink']) {
            $alphalink = mysql_real_escape_string($_GET['alphalink']);

            $result = mysql_query(sprintf("SELECT COUNT(*) FROM music_songs ".
                                          "LEFT JOIN music_artists ON music_songs.artist_id=music_artists.artist_id ".
                                          "WHERE UPPER(music_artists.artist_name) < %s ".
                                          "ORDER BY music_artists.artist_name;",
                                          escape($_GET['alphalink'])));
            if ($result)
			{
                $alphaoffset=mysql_fetch_row($result);
                $this->offset=$alphaoffset[0];
                mysql_free_result($result);
            }
        }

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

    function readRow()
    {

            if($row=mysql_fetch_row($this->result))
            {
                $this->intid=$row[0];
                $this->artist=$row[1];
                $this->album=$row[2];
                $this->title=$row[3];
                $this->genre=$row[4];
                $this->length=$row[5];
                $this->rating=$row[6];
                $this->filename=$row[7];

                $this->urlfilename=root.'data/music';
                global $musicdir;
                foreach (preg_split('/\//', substr($this->filename, strlen($musicdir))) as $dir) {
                    if (!$dir) continue;
                    $this->urlfilename .= '/'.rawurlencode(utf8tolocal($dir));
                }

                return(true);
            }
            return(false);
    }



    function display()
    {
        $music = new Theme_music();
        $this->init($music->getMaxPerPage());
        $music->setOffset($this->offset);
        $music->setTotalCount($this->totalCount);

        $music->print_header($this->filterPlaylist,$this->filterArtist,$this->filterAlbum,$this->filterGenre);
        if($this->totalCount > 0)
        {
            while($this->readRow())
            {
                $music->printDetail($this->title,$this->length,$this->artist,$this->album,$this->genre,$this->urlfilename);
            }
        }
        else
        {
            $music->printNoDetail();
        }
        if($this->result)
            mysql_free_result($this->result);

        $music->print_footer();
    }

    function prepFilter()
    {
        $this->filter="1=1"; // A true statement that will always return everything in SQL.

        if($this->filterPlaylist != "_All_")
        {
            $playlistResult = mysql_query("SELECT playlist_id,playlist_name,playlist_songs,hostname FROM music_playlists WHERE playlist_id=".escape($this->filterPlaylist));
            if($playlistResult)
            {
                if(mysql_num_rows($playlistResult)==1)
                {
                    $row=mysql_fetch_row($playlistResult);
                    if($row && !empty($row[2]))
                    {
                        $this->filterSonglist=$row[2];

                        $this->filter .= " AND song_id IN (" . $this->filterSonglist . ")";
                        $this->keepFilters .= "&amp;filterPlaylist=" . urlencode($this->filterPlaylist);
                    }
                }
            }
        }

        if($this->filterArtist != "_All_" )
        {
            $this->filter .= " AND artist_name=".escape($this->filterArtist);
            $this->keepFilters .= "&amp;filterArtist=" . urlencode($this->filterArtist);
        }

        if($this->filterAlbum != "_All_")
        {
            $this->filter .= " AND album_name=" . escape($this->filterAlbum);
            $this->keepFilters .= "&amp;filterAlbum=" . urlencode($this->filterAlbum) ;
        }

        if($this->filterGenre != "_All_")
        {
            $this->filter .= " AND genre=" . escape($this->filterGenre);
            $this->keepFilters .= "&amp;filterGenre=" . urlencode($this->filterGenre);
        }

        if($this->filterRank != "_All_")
        {
            $this->filter .= " AND rank=" . escape($this->filterRank);
            $this->keepFilters .= "&amp;filterRank=" . urlencode($this->filterRank);
        }
    }

    function init($maxPerPage) {
        global $db;
        $this->prepFilter();
        $query_base = ' FROM music_songs'.
                      ' LEFT JOIN music_artists ON music_songs.artist_id=music_artists.artist_id'.
                      ' LEFT JOIN music_albums ON music_songs.album_id=music_albums.album_id'.
                      ' LEFT JOIN music_genres ON music_songs.genre_id=music_genres.genre_id'.
                      ' WHERE '.$this->filter.
                      ' ORDER BY artist_name,album_name,track';
	
        // Cannot use $db->query_col here as the preg_replace kills PHP when using large filterSongList queries
        $this->totalCount = 0;
        $result = mysql_query('SELECT COUNT(*)'.$query_base);
        if ($result)
        {
            $row=mysql_fetch_row($result);
            $this->totalCount=$row[0];
            mysql_free_result($result);
        }

        if ($this->totalCount > 0) {
            if($this->offset > 0)
                $query_base .= ' LIMIT ' . $this->offset . ',' . $maxPerPage;
            else
                $query_base .= ' LIMIT ' . $maxPerPage;
	    
	        $this->result = mysql_query('SELECT music_songs.song_id, music_artists.artist_name, music_albums.album_name, music_songs.name, music_genres.genre, music_songs.length, music_songs.rating, music_songs.filename '.$query_base);
        }
    }
}


