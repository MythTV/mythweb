<?php
/**
 * Common Functions for the MP3Act part of the MythWeb Music module
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Music
 *
 **/


require_once('modules/music/mp3act_html_functions.php');

define('MYTH_WEB_PLAYLIST_NAME', 'MythWeb Temporary Playlist');
define('MYTH_PLAYLIST_SAVE_TIME', 60*60*24*7);

/******************************************
*  mp3act functions
*  http://www.mp3act.net
*  Stripped, because not all this funcionality is needed in MythWEB
*
******************************************/
function pic_dir()
{
  return skin_url.'img/music/';
}

function GarbageCollector()
{
    global $db;
    // Run this occasionally to tidy up.
    if (0 == mt_rand(0, 30))
    {
        $query = 'DELETE FROM music_playlists '.
            "WHERE playlist_name=".$db->escape('MythWeb Temporary Playlist').
            ' AND (NOW() - last_accessed) > ('.MYTH_PLAYLIST_SAVE_TIME.');';
        $sh = $db->query($query);
        $sh->finish();
    }
}

function getplaylistnames()
{
  global $db;
  $output='';
  $query = 'SELECT playlist_name, hostname FROM music_playlists WHERE hostname=\'\';';
  $sh = $db->query($query);

  if (!$sh)
    return '';

  while ($row = $sh->fetch_array())
  {
    $output .= '<option>'.$row['playlist_name'].'</option>';
  }
  $sh->finish();
  return $output;
}

function genreform()
{
  global $db;
  $query = "SELECT genre FROM music_genres ORDER BY genre";
  $sh = $db->query($query);

  if (!$sh)
    return '';

  $output = '<select id="genre" name="genre" onchange="updateBox(\'genre\',this.options[selectedIndex].value); return false;">
    <option value="" selected>'.t('Choose Genre..').'</option>';

  while ($genre = $sh->fetch_array())
  {
    $output .= '<option value="'.$genre['genre'].'">'.$genre['genre'].'</option>';
  }
  $output .= '</select>';
  $sh->finish();
  return $output;
}

function letters()
{
  $output = '<ul class="music" id="letters">';
  $letters = array('#','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

  foreach($letters as $letter)
  {
    $output .= '<li><a class=music href="#" onclick="updateBox(\'letter\',\''.$letter.'\'); return false;">'.strtoupper($letter).'</a></li>';
  }
  $output .= '</ul>';
  return $output;
}

function getDropDown($type, $id)
{
  return "";
}

function buildBreadcrumb($page, $parent, $parentitem, $child, $childitem)
{
  global $db;
  $childoutput='';
  $parentoutput ='';
  if ($page == 'browse' && $child != '')
  {
    $output = '<a class="music" href="#" onclick="updateBox(\'browse\',0); return false;">'.t('Browse').'</a> &#187; ';
  }
  switch ($child)
  {
    case 'album':
      $query = 'SELECT music_albums.album_name, music_artists.artist_name, music_artists.artist_id '.
        'FROM music_albums '.
        'LEFT JOIN music_artists ON music_albums.artist_id=music_artists.artist_id '.
        'WHERE music_albums.album_id='.$db->escape($childitem);
      $sh = $db->query($query);
      if (!$sh)
        break;

      $row = $sh->fetch_array();
      $sh->finish();

      $query = 'SELECT album_name, album_id '.
        'FROM music_albums '.
        'WHERE artist_id='.$row['artist_id'].' '.
        'ORDER BY album_name';
      $sh = $db->query($query);
      if (!$sh)
        break;

      $albums = '';
      while ($row2 = $sh->fetch_array())
      {
        $albums .= '<li><a class="music" href="#"'.
          ' onclick="updateBox(\'album\','.$row2['album_id'].'); return false;"'.
          ' title="'.sprintf(t('View Details of %s'), $row2['album_name']).'">'.
          $row2['album_name'].'</a></li>';
      }
      $sh->finish();

      $childoutput .= '<span><a class="music" href="#"'.
        ' onclick="updateBox(\'artist\','.$row['artist_id'].'); return false;">'.
        $row['artist_name'].'</a>'.
        '<ul class="music">'.$albums.'</ul></span> &#187; '.
        html_entities($row['album_name']);
      break;

    case 'artist':
      $query = 'SELECT artist_name '.
        'FROM music_artists '.
        'WHERE artist_id='.$db->escape($childitem);
      $sh = $db->query($query);
       if (!$sh)
        break;
      $row = $sh->fetch_array();
      $sh->finish();

      $query = 'SELECT music_albums.album_id, album_name '.
        'FROM music_songs '.
        'LEFT JOIN music_albums ON music_songs.album_id=music_albums.album_id '.
        'WHERE music_songs.artist_id='.$db->escape($childitem).' '.
        'GROUP BY music_albums.album_id;';
      $sh = $db->query($query);
      if (!$sh)
        break;
      $albums = '';
      while ($row2 = $sh->fetch_array())
      {
        $albums .= '<li><a class="music" href="#"'.
          ' onclick="updateBox(\'album\','.$row2['album_id'].'); return false;"'.
          ' title="'.sprintf(t('View Details of %s'), $row2['album_name']).'">'.
          $row2['album_name'].'</a></li>';
      }
      $sh->finish();

      $childoutput .= '<span><a class="music" href="#"'.
        ' onclick="updateBox(\'artist\','.$childitem.'); return false;">'.
        $row['artist_name'].'</a>'.
        '<ul class="music">'.$albums.'</ul></span>';
      break;

    case 'letter':
      $childoutput .= '<span><a class="music" href="#"'.
        ' onclick="updateBox(\'letter\',\''.$childitem.'\'); return false;">'.
        strtoupper($childitem).'</a>'.letters().'</span>';
      break;

    case 'genre':
    case 'all':
      $childoutput .=  $childitem;
      break;
  }
  switch ($parent)
  {
    case 'letter':
      $parentoutput .= '<span><a class="music" href="#"'.
        ' onclick=\"updateBox(\'letter\',\''.$parentitem.'\'); return false;">'.
        strtoupper($parentitem).'</a>'.letters().'</span> &#187; ';
      break;

    case 'genre':
    case 'all':
      $parentoutput .= '<a class="music" href="#"'.
        ' onclick="updateBox(\''.$parent.'\',\''.$parentitem.'\'); return false;">'.
        $parentitem.'</a> &#187; ';
      break;
  }

  if (isset($output))
  {
    return $output.$parentoutput.$childoutput;
  }

  return '';
}

function musicLookup($type, $itemid)
{
  global $db;
  $sql_itemid = $db->escape($itemid);
  switch($type)
  {
    case 'browse':
      $output = '<div class="head">
        <h2 class="music">'.t('Browse the Music Database').'</h2></div>
        <p>
        <strong>'.t('By Artist Beginning With').'</strong><br/>'.letters().'<br/></p>
        <p><strong>'.t('By Genre').'</strong><br/>
        '.genreForm().'<br/><br/>
        <input type="button" value="'.t('Browse All Albums').'" onclick="updateBox(\'all\',\'All\'); return false;" class="btn2">
        </p>';
      break;

    case 'search':
      $output = '<div class="head">
        <h2 class="music">'.t('Search the Music Database').'</h2></div>
        <form onsubmit="return searchMusic(this)" method="get" action="">
        <p>
        <strong>'.t('Keywords').'</strong><br/>
        <input type="text" onfocus="this.select()" name="searchbox" size="35" id="searchbox" value="['.t('Enter your search terms').']">
        <br/><br/>
        <strong>'.t('Narrow Your Search').'</strong>
        <br/>
        <select name="search_options" size="1">
          <option value="all">'.t('All Fields').'</option>
          <option value="artists">'.t('Artists').'</option>
          <option value="albums">'.t('Albums').'</option>
          <option value="songs">'.t('Songs').'</option>
        </select><br/><br/>
        <input type="submit" value="'.t('Submit Search').'" class="btn"></form>
        </p>';
      break;

    case 'letter':
      // Define the list of prefixes we wish to ignore (perhaps define them as database item(s) somewhere so users can extend them)
      $prefixes = explode(' ', t('MythMusic_Prefixes_To_Ignore'));

      if($itemid == "#")
      {
          $query = "SELECT artist_id, artist_name, " .
                   "LOWER(CASE WHEN SUBSTRING_INDEX(artist_name, ' ', 1) IN ('" . implode("', '", $prefixes) . "') " .
                   "THEN " .
                   "CONCAT( SUBSTRING(artist_name, INSTR(artist_name , ' ') + 1), ' (', SUBSTRING_INDEX(artist_name, ' ', 1), ')' ) " .
                   "ELSE artist_name END) " .
                   "AS artist_name_sort " .
                   "FROM music_artists " .
                   "GROUP BY artist_name_sort " .
                   "HAVING artist_name REGEXP '^[0-9].*' " .
                   "ORDER BY artist_name_sort";
      }
      else
      {
          $query = "SELECT artist_id, artist_name, " .
                   "LOWER(CASE WHEN SUBSTRING_INDEX(artist_name, ' ', 1) IN ('" . implode("', '", $prefixes) . "') " .
                   "THEN " .
                   "CONCAT( SUBSTRING(artist_name, INSTR(artist_name , ' ') + 1), ' (', SUBSTRING_INDEX(artist_name, ' ', 1), ')' ) " .
                   "ELSE artist_name END) " .
                   "AS artist_name_sort " .
                   "FROM music_artists " .
                   "GROUP BY artist_name_sort " .
                   "HAVING artist_name_sort " .
                   "LIKE " . $db->escape($itemid.'%') . " " .
                   "ORDER BY artist_name_sort";
      }
      $sh = $db->query($query);
      if (!$sh)
        break;

      $output = '<div class="head">
        <div class="right">
        <a class="music" href="#" onclick="updateBox(\'browse\',0); return false;"
         title="'.t('Browse').'">'.t('Back').'</a></div>
        <h2 class="music">'.sprintf(t('Artists Beginning with %s'), "'".strtoupper($itemid)."'").'</h2></div>
        <p>
        <strong>'.t('Artist Listing').'</strong></p>
        <ul class="music">';
      $alt = false;
      while ($row = $sh->fetch_array())
      {
        $output .= '<li'.($alt ? ' class="alt"' : '').'>
          <a class="music" href="#"
           onclick="updateBox(\'artist\','.$row['artist_id'].'); return false;"
           title="'.sprintf(t('View Albums by %s'), $row['artist_name']).'">'.
          $row['artist_name'].'</a></li>';
        $alt = !$alt;
      }
      $sh->finish();
      $output .= '</ul>';
      break;

    case 'all':
      $output = '<div class="head">
        <div class="right">
        <a class="music" href="#" onclick="updateBox(\'browse\',0); return false;"
         title="'.t('Browse').'">'.t('Back').'</a></div>
        <h2 class="music">'.t('All Albums').'</h2></div>
        <p>
        <strong>'.t('Album Listing').'</strong></p>
        <ul class="music">';
      $start = $itemid;
      $query  = 'SELECT ma.album_id, ma.album_name, mt.artist_name '.
        'FROM music_albums AS ma '.
        'LEFT JOIN music_artists AS mt ON ma.artist_id=mt.artist_id '.
        'ORDER BY album_name, artist_name';

      $sh = $db->query($query);
      if (!$sh)
        break;

      $alt = false;
      while ($row = $sh->fetch_array())
      {
        $output .= getHtmlAlbum($row['album_id'], $row['album_name'],
          $row['artist_name']);
      }
      $sh->finish();
      $output .= '</ul>';
      break;

    case 'album':
      // Get some statistics about the album
      $query = 'SELECT COUNT(*), SEC_TO_TIME(SUM(music_songs.length)/1000) '.
               'FROM music_songs '.
               'WHERE music_songs.album_id='.$sql_itemid.' '.
               'GROUP BY music_songs.album_id;';
      $sh = $db->query($query);
      if (!$sh)
        break;

      $row = $sh->fetch_array();
      $sh->finish();
      $num_tracks = $row[0];
      $length = $row[1];

      // Attempt to find some album art.
      $query='SELECT ms.filename, ms.album_id, md.path, ma.artist_name, ma.artist_id, ms.directory_id, mal.album_name
                FROM music_songs AS ms
                     LEFT JOIN music_directories AS md
                            ON ms.directory_id=md.directory_id
                     LEFT JOIN music_artists AS ma
                            ON ms.artist_id=ma.artist_id
                     LEFT JOIN music_albums AS mal
                            ON ms.album_id=mal.album_id
               WHERE ms.album_id='.$sql_itemid.'
               LIMIT 1';
      $sh = $db->query($query);
      if (!$sh)
        break;

      $row = $sh->fetch_array();
      $sh->finish();

    // Load album art
        $art_id = $db->query_col('SELECT ma.albumart_id
                                    FROM music_albumart AS ma
                                         LEFT JOIN music_directories AS md
                                                ON ma.directory_id=md.directory_id
                                   WHERE ma.directory_id = ?
                                   AND ma.imagetype = 1
                                   LIMIT 1',
                                 $row['directory_id']);

      $output = '<div class="head">
        <div class="right">
        <a class="music" href="#"
         onclick="play(\'album\','.$row['album_id'].'); return false;"
         title="'.t('Play this Album Now').'">'.t('Play').'</a>
        <a class="music" href="#"
         onclick="pladd(\'album\','.$row['album_id'].'); return false;"
         title="'.t('Add Album to Current Playlist').'">'.t('Add').'</a>
        <a class="music" href="#" onclick="updateBox(\'artist\','.$row['artist_id'].'); return false;"
         title="'.$row['artist_name'].'">'.t('Back').'</a>
        </div>
        <h2 class="music">'.$row['album_name'].'</h2>
        </div>'.
        (!empty($art_id) ? '<center><img width="200" src="'.stream_url().'stream?a='.$art_id.'" /></center><br>' : '').
        '<strong>'.t('Play Time').':</strong> '.$length.
        '<br><br>
        <strong>'.t('Album Tracks').'</strong>
        <ul class="music">';

      $query = 'SELECT ms.song_id, ms.track, ms.name, ms.length, ms.numplays, ms.rating, '.
               'SEC_TO_TIME(ms.length/1000) AS length, artist_name, genre '.
               'FROM music_songs AS ms '.
               'LEFT JOIN music_artists ON ms.artist_id=music_artists.artist_id '.
               'LEFT JOIN music_genres ON ms.genre_id=music_genres.genre_id '.
               'WHERE ms.album_id='.$sql_itemid.' '.
               'ORDER BY ms.track';
      $sh = $db->query($query);
      if (!$sh)
        break;

      while ($row = $sh->fetch_array())
      {
        $output .= getHtmlSong($row['song_id'], $row['artist_name'],
          '', $row['track'], $row['name'],
          $row['length'], $row['numplays'], $row['genre'], $row['rating']);
      }
      $sh->finish();
      $output .= '</ul>';
      break;

    case 'genre':
      $output = '<div class="head">
        <div class="right">
        <a class="music" href="#" onclick="updateBox(\'browse\',0); return false;"
         title="'.t('Browse').'">'.t('Back').'</a></div>
        <h2 class="music">'.t('Songs for Genre')." '".utf8_encode($itemid)."'</h2></div>
        <p><strong>".t('Songs').'</strong></p>
        <ul class="music">';

      $query = 'SELECT ms.song_id, ms.name, SEC_TO_TIME(ms.length/1000) AS length, ms.numplays, ms.rating, ma.artist_name, mg.genre '.
               'FROM music_songs AS ms '.
               'LEFT JOIN music_artists AS ma ON ms.artist_id=ma.artist_id '.
               'LEFT JOIN music_genres AS mg ON ms.genre_id=mg.genre_id '.
               'WHERE genre='.utf8_encode($sql_itemid);

      $sh = $db->query($query);
      if (!$sh)
        break;

      while ($row = $sh->fetch_array())
      {
        $output .= getHtmlSong($row['song_id'], $row['artist_name'],
          '', '', $row['name'],
          $row['length'], $row['numplays'], '', $row['rating']);
      }
      $sh->finish();
      $output .= '</ul>';
      break;

    case 'artist':
      $query = 'SELECT artist_name '.
        'FROM music_artists '.
        'WHERE artist_id='.$sql_itemid;
      $sh = $db->query($query);
      if (!$sh)
        break;

      $row = $sh->fetch_array();
      $sh->finish();
      $artist = $row['artist_name'];

      $letter = (!preg_match('/^[0-9]/', $artist) ? strtoupper($artist[0]) : '#');

      $output = '<div class="head">
        <div class="right">
        <a class="music" href="#" onclick="updateBox(\'letter\',\''.$letter.'\'); return false;"
         title="'.sprintf(t('Artists Beginning with %s'), "'".$letter."'").'">'.t('Back').'</a></div>
        <h2 class="music">'.$artist.'</h2></div>
        <p><strong>'.sprintf(t('Albums with songs by %s'),'<i>'.$artist.'</i>').'</strong></p>
        <ul class="music">';

      $query = 'SELECT ma.album_id, album_name, ma.year, ma.artist_id, artist_name'.
        ',SEC_TO_TIME(SUM(ms.length)/1000) AS length, COUNT(ms.song_id) AS num_tracks '.
        'FROM music_songs AS ms '.
        'LEFT JOIN music_albums AS ma ON ms.album_id=ma.album_id '.
        'LEFT JOIN music_artists AS mt ON ma.artist_id=mt.artist_id '.
        'WHERE ms.artist_id='.$sql_itemid.' '.
        'GROUP BY ma.album_id;';
      $sh = $db->query($query);
      if (!$sh)
        break;

      while ($row = $sh->fetch_array())
      {
        $artist = '';
        if ($itemid != $row['artist_id'])
          $artist = $row['artist_name'];

        $output .= getHtmlAlbum($row['album_id'], $row['album_name'],
          $artist, $row['year'], $row['num_tracks'], $row['length']);
      }
      $sh->finish();

      $output .='</ul><p><strong>'.t('Songs').'</strong></p>
        <ul class="music">';

      $query = 'SELECT ms.song_id, ms.track, ms.name, ms.length, ms.numplays, ms.rating, '.
        'SEC_TO_TIME(ms.length/1000) AS length, music_artists.artist_name, track, '.
        'music_albums.album_name, genre '.
        'FROM music_songs AS ms '.
        'LEFT JOIN music_artists ON ms.artist_id=music_artists.artist_id '.
        'LEFT JOIN music_albums ON ms.album_id=music_albums.album_id '.
        'LEFT JOIN music_genres ON ms.genre_id=music_genres.genre_id '.
        'WHERE ms.artist_id='.$sql_itemid.';';
      $sh = $db->query($query);
      if (!$sh)
        break;

      while ($row = $sh->fetch_array())
      {
        $output .= getHtmlSong($row['song_id'], '',
          $row['album_name'], $row['track'], $row['name'],
          $row['length'], $row['numplays'], $row['genre'], $row['rating']);
      }
      $sh->finish();
      $output .= '</ul>';
      break;

    case 'random':
      $output = '<div class="head">
        <h2 class="music">'.t('Random Mix Maker').'</h2></div>
        <form onsubmit="return randAdd(this)" method="get" action="">
        <strong>'.t('Number of Songs').'</strong><br>
        <select name="random_count">
        <option>5</option>
        <option>10</option>
        <option>20</option>
        <option>30</option>
        <option>40</option>
        <option>50</option>
        <option>100</option>
        </select><br />

        <strong>'.t('Rating').'</strong><br />
        <select name="rating">
        <option value="all">All</option>
        <option value=">">></option>
        <option value="=">=</option>
        <option value="<"><</option>
        </select>

        <select name="rating_value">
        <option value="9">9</option>
        <option value="8">8</option>
        <option value="7">7</option>
        <option value="6">6</option>
        <option value="5">5</option>
        <option value="4">4</option>
        <option value="3">3</option>
        <option value="2">2</option>
        <option value="1">1</option>
        </select><br />

        <strong>'.t('Random Type').'</strong><br />

        <select name="random_type" onchange="getRandItems(this.options[selectedIndex].value); return false;">
        <option value="">'.t('Choose Type').'...</option>
        <option value="artists">'.t('Artists').'</option>
        <option value="genre">'.t('Genre').'</option>
        <option value="albums">'.t('Albums').'</option>
        <option value="all">'.t('Everything').'</option>
        </select><br>
        <strong>'.t('Random Items').'</strong>
        <span id="rand_items"></span>
        <br><br>
        <input type="submit" value="'.t('Add Mix').'" class="btn">
        </form>';
      break;

    case 'playlists':
      $query = 'SELECT playlist_id, playlist_name, songcount, hostname, SEC_TO_TIME(length/1000) AS length '.
        'FROM music_playlists '.
        'WHERE hostname=\'\'';
      $sh = $db->query($query);
      if (!$sh)
        break;

      $output = '<div class="head">
        <h2 class="music">'.t('Saved Playlists').'</h2></div><br>';

      if ($sh->num_rows == 0)
      {
        $output .= t('No Public Playlists');
      }
      else
      {
        $unsaved_id = 0;
        $pl = internalGetPlaylist();
        if (!empty($pl['playlist_name'])
            && MYTH_WEB_PLAYLIST_NAME == $pl['playlist_name'])
        {
          $unsaved_id = $pl['playlist_id'];
        }

        $output .= '<ul class="music">';
        while ($row = $sh->fetch_array())
        {
          $output .= getHtmlPlaylist($row['playlist_id'], $row['playlist_name'],
            $row['songcount'], $row['length'], $unsaved_id);
        }
        $output .= '</ul>';
      }
      $sh->finish();
      break;

    case 'saved_pl':
      $query = 'SELECT playlist_id, playlist_name, playlist_songs, songcount, SEC_TO_TIME(length/1000) AS length '.
        'FROM music_playlists '.
        'WHERE playlist_id='.$sql_itemid;
      $sh = $db->query($query);
      if (!$sh)
        break;

      $row = $sh->fetch_array();
      $sh->finish();

      $unsaved_id = 0;
      $pl = internalGetPlaylist();
      if (!empty($pl['playlist_name'])
          && MYTH_WEB_PLAYLIST_NAME == $pl['playlist_name'])
      {
        $unsaved_id = $pl['playlist_id'];
      }

      $output = '<div class="head">
        <div class="right">
        <a class="music" href="#"
          onclick="checkPlaylistLoad(\''.$row['playlist_id'].'\', '.$unsaved_id.')'.
          ' && pladd(\'loadplaylist\','.$row['playlist_id'].'); return false;"
          title="'.t('Load Playlist').'">'.t('Load').
        '</a>
        <a class="music" href="#"
          onclick="pladd(\'playlist\','.$row['playlist_id'].'); return false;"
          title="'.t('Append to Current Playlist').'">'.t('Append').
        '</a>
        <a class="music" href="#"
          onclick="play(\'pl\','.$row['playlist_id'].'); return false;"
          title="'.t('Play this Playlist Now').'">'.t('Play').
        '</a>
        </div>
        <h2 class="music">'.t('View Saved Playlist').'</h2></div>
        <p><strong>'.t('Playlist Info').'</strong><br>'.
        sprintf('%s Songs', $row['songcount']).'<br>'.$row['length'].'</p>
        <p><strong>'.t('Playlist Items').'</strong></p>';


      if (empty($row['playlist_songs']))
      {
        $output = '<b>'.t('There are no items in this Playlist!').'</b>';
      }
      else
      {
        // Load the song information
        $query = 'SELECT ms.song_id, mt.artist_name, ms.name, ma.album_name, ms.track'.
            ', SEC_TO_TIME(ms.length/1000) AS length '.
            'FROM music_songs AS ms '.
            'LEFT JOIN music_artists AS mt ON ms.artist_id=mt.artist_id '.
            'LEFT JOIN music_albums AS ma ON ms.album_id=ma.album_id '.
            'WHERE ms.song_id IN ('.$row['playlist_songs'].');';
        $sh = $db->query($query);
        if (!$sh)
            return;

        $song_info = array();
        while ($row2 = $sh->fetch_array())
        {
            $song_info[$row2['song_id']] = $row2;
        }
        $sh->finish();

        // Load the sub-playlist information
        // NB: MySQL 3.xx cannot use the CAST() function hense the negative number decimal
        // conversion hack as outlined on: http://dev.mysql.com/doc/refman/4.1/en/cast-functions.html
        $query = 'SELECT playlist_id, playlist_name, SEC_TO_TIME(length/1000) AS length, songcount '.
            'FROM music_playlists '.
            'WHERE (-1.0 * (playlist_id+0.0)) IN ('.$row['playlist_songs'].');';
        $sh = $db->query($query);
        if (!$sh)
            return;

        $pl_info = array();
        while ($row2 = $sh->fetch_array())
        {
            $pl_info[$row2['playlist_id']] = $row2;
        }
        $sh->finish();

        $songs = explode(',', $row['playlist_songs']);
        $output .= '<ul class="music">';
        foreach ($songs as $song_id)
        {
          if ($song_id > 0)
          {
            $row = $song_info[$song_id];
            $output .= getHtmlSong($row['song_id'], $row['artist_name'],
              '', '', $row['name'],
              $row['length'], $row['numplays'], '', '');
          }
          else if ($song_id < 0)
          {
            $row = $pl_info[-1 * $song_id];
            $output .= getHtmlPlaylist($row['playlist_id'], $row['playlist_name'],
              $row['songcount'], $row['length'], $unsaved_id, false);
          }
        }
        $output .= '</ul>';
      }
      break;

    case 'stats':
      $query = 'SELECT * FROM music_stats';
      $sh = $db->query($query);
      if (!$sh)
        break;

      $row = $sh->fetch_array();
      $sh->finish();

      $query = 'SELECT COUNT(*) AS songs FROM music_songs WHERE numplays>0';
      $sh = $db->query($query);
      if (!$sh)
        break;

      $row2 = $sh->fetch_array();
      $sh->finish();

      $output = '<div class="head">
        <h2 class="music">'.t('Server Statistics').'</h2></div>
        <p><a class="music" href="#" onclick="updateBox(\'recentadd\',0); return false;">'.
        t('Recently Added Albums').'</a><br>
        <a class="music" href="#" onclick="updateBox(\'recentplay\',0); return false;">'.
        t('Recently Played Songs').'</a><br>
        <a class="music" href="#" onclick="updateBox(\'recentplayalbum\',0); return false;">'.
        t('Recently Played Albums').'</a><br>
        <a class="music" href="#" onclick="updateBox(\'topplay\',0); return false;">'.
        t('Top Played Songs').'</a><br>
        <a class="music" href="#" onclick="updateBox(\'topplayalbum\',0); return false;">'.
        t('Top Played Albums').'</a><br>
        <a class="music" href="#" onclick="updateBox(\'topplayartist\',0); return false;">'.
        t('Top Played Artist').'</a><br>
        <a class="music" href="#" onclick="updateBox(\'toprated\',0); return false;">'.
        t('Top Rated Songs').'</a><br>
        </p>
        <h3>'.t('Local Server Statistics').'</h3>
        <p>';

      foreach (array('music_songs'   => t('Songs'),
                     'music_albums'  => t('Albums'),
                     'music_artists' => t('Artists'),
                     'music_genres'  => t('Genres')) as $table => $title)
      {
        $sh = $db->query('SELECT COUNT(*) FROM '.$table.';');
        if (!$sh)
          continue;
        $count = $sh->fetch_array();
        $sh->finish();
        $output .= '<strong>'.$title.':</strong> '.$count[0].'<br>';
      }
      $output .= '<br><strong>'.t('Songs Played').':</strong> '.$row2['songs'].'<br>';

      $sh = $db->query('SELECT COUNT(*) AS songs FROM music_songs WHERE rating > 0;');
      if (!$sh)
        break;

      $row3 = $sh->fetch_array();
      $sh->finish();
      $output .= '<strong>'.t('Songs Rated').':</strong> '.$row3['songs'].'<br></p>';

      break;

    case 'recentadd':
      $query = 'SELECT ma.album_name, ma.album_id, mt.artist_name, UNIX_TIMESTAMP(ms.date_entered) AS pubdate '.
        'FROM music_songs AS ms '.
        'LEFT JOIN music_albums AS ma ON ms.album_id=ma.album_id '.
        'LEFT JOIN music_artists AS mt ON ms.artist_id=mt.artist_id '.
        'GROUP BY ms.album_id '.
        'ORDER BY ms.date_entered DESC '.
        'LIMIT 40';
      $sh = $db->query($query);
      if (!$sh)
        break;

      $output = '<div class="head">
        <div class="right">
        <a class="music" href="#"
          onclick="switchPage(\'stats\'); return false;"
          title="'.t('Return to Statistics Page').'">'.t('Back').'</a></div>
        <h2 class="music">'.t('Recently Added Albums').'</h2></div>
        <ul class="music">';
      while ($row = $sh->fetch_array())
      {
        $output .= getHtmlAlbum($row['album_id'], $row['album_name'],
          $row['artist_name'], '', '', '', date('m.d.Y', $row['pubdate']));
      }
      $sh->finish();
      $output .= '</ul>';
      break;

    case 'topplay':
      $query = 'SELECT ma.album_name, ms.numplays, ms.name, mt.artist_name, ms.song_id '.
        'FROM music_songs AS ms '.
        'LEFT JOIN music_albums AS ma ON ms.album_id=ma.album_id '.
        'LEFT JOIN music_artists AS mt ON ms.artist_id=mt.artist_id '.
        'WHERE ms.numplays > 0 '.
        'ORDER BY ms.numplays DESC '.
        'LIMIT 40';
      $sh = $db->query($query);
      if (!$sh)
        break;

      $output = '<div class="head">
        <div class="right">
        <a class="music" href="#"
          onclick="switchPage(\'stats\'); return false;"
          title="'.t('Return to Statistics Page').'">'.t('Back').'</a></div>
        <h2 class="music">'.t('Top Played Songs').'</h2></div>
        <ul class="music">';
      while ($row = $sh->fetch_array())
      {
        $output .= getHtmlSong($row['song_id'], $row['artist_name'],
          '', '', $row['name'], $row['album_name'], $row['numplays'], '', '');
      }
      $sh->finish();
      $output .= '</ul>';
      break;

    case 'topplayalbum':
      $query = 'SELECT ma.album_name, ma.album_id, ms.numplays, ms.name, mt.artist_name, ms.song_id, sum(ms.numplays) as playcount '.
        'FROM music_songs AS ms '.
        'LEFT JOIN music_albums AS ma ON ms.album_id=ma.album_id '.
        'LEFT JOIN music_artists AS mt ON ms.artist_id=mt.artist_id '.
        'WHERE ms.numplays > 0 '.
        'GROUP BY ms.album_id '.
        'ORDER BY playcount DESC '.
        'LIMIT 40';
      $result = mysqli_query($query);
      if (!$result)
        break;

      $output = '<div class="head">
        <div class="right">
        <a class="music" href="#"
          onclick="switchPage(\'stats\'); return false;"
          title="'.t('Return to Statistics Page').'">'.t('Back').'</a></div>
        <h2 class="music">'.t('Top Played Albums').'</h2></div>
        <ul class="music">';
      while ($row = mysqli_fetch_array($result))
      {
        $output .= getHtmlAlbum($row['album_id'], $row['album_name'],
          $row['artist_name'], '', '', '', $row['playcount']."x");
      }
      mysqli_free_result($result);
      $output .= '</ul>';
      break;

    case 'topplayartist':
      $query = 'SELECT ma.album_name, ma.album_id, mt.artist_id, ms.numplays, ms.name, mt.artist_name, ms.song_id, sum(ms.numplays) as playcount '.
        'FROM music_songs AS ms '.
        'LEFT JOIN music_albums AS ma ON ms.album_id=ma.album_id '.
        'LEFT JOIN music_artists AS mt ON ms.artist_id=mt.artist_id '.
        'WHERE ms.numplays > 0 '.
        'GROUP BY ms.artist_id '.
        'ORDER BY playcount DESC '.
        'LIMIT 40';
      $result = mysqli_query($query);
      if (!$result)
        break;

      $output = '<div class="head">
        <div class="right">
        <a class="music" href="#"
          onclick="switchPage(\'stats\'); return false;"
          title="'.t('Return to Statistics Page').'">'.t('Back').'</a></div>
        <h2 class="music">'.t('Top Played Artist').'</h2></div>
        <ul class="music">';
      while ($row = mysqli_fetch_array($result))
      {
        $output .= getHtmlArtist($row['artist_id'], $row['artist_name'],
          '', '', '', $row['playcount']."x");
      }
      mysqli_free_result($result);
      $output .= '</ul>';
      break;

    case 'recentplay':
      $query = 'SELECT ms.name, ms.song_id, mt.artist_name, UNIX_TIMESTAMP(ms.lastplay) AS playdate '.
        'FROM music_songs AS ms '.
        'LEFT JOIN music_artists AS mt ON ms.artist_id=mt.artist_id '.
        'WHERE ms.numplays > 0 '.
        'ORDER BY ms.lastplay DESC '.
        'LIMIT 40';
      $sh = $db->query($query);
      if (!$sh)
        break;

      $output = '<div class="head">
        <div class="right">
        <a class="music" href="#"
          onclick="switchPage(\'stats\'); return false;"
          title="'.t('Return to Statistics Page').'">'.t('Back').'</a></div>
        <h2 class="music">'.t('Recently Played Songs').'</h2></div>
        <ul class="music">';
      while ($row = $sh->fetch_array())
      {
        $output .= getHtmlSong($row['song_id'], $row['artist_name'],
          '', '', $row['name'], date('m.d.Y', $row['playdate']), '', '', '');
      }
      $output .= '</ul>';
    break;

    case 'recentplayalbum':
      $query = 'SELECT ma.album_id, ms.name, ms.song_id, mt.artist_name, ma.album_name, UNIX_TIMESTAMP(ms.lastplay) AS playdate '.
        'FROM music_songs AS ms '.
        'LEFT JOIN music_artists AS mt ON ms.artist_id=mt.artist_id '.
        'LEFT JOIN music_albums AS ma ON ms.album_id=ma.album_id '.
        'WHERE ms.numplays > 0 '.
        'GROUP BY ms.album_id '.
        'ORDER BY ms.lastplay DESC '.
        'LIMIT 40';
      $result = mysqli_query($query);
      if (!$result)
        break;

      $output = '<div class="head">
        <div class="right">
        <a class="music" href="#"
          onclick="switchPage(\'stats\'); return false;"
          title="'.t('Return to Statistics Page').'">'.t('Back').'</a></div>
        <h2 class="music">'.t('Recently Played Albums').'</h2></div>
        <ul class="music">';
      while ($row = mysqli_fetch_array($result))
      {
        $output .= getHtmlAlbum($row['album_id'], $row['album_name'],
          $row['artist_name'], '', '', '', date('m.d.Y', $row['playdate']));
      }
      mysqli_free_result($result);
      $output .= '</ul>';
      break;

      case 'toprated':
        $query = 'SELECT ms.name, ms.song_id, ms.rating, mt.artist_name '.
          'FROM music_songs AS ms '.
          'LEFT JOIN music_artists AS mt ON ms.artist_id=mt.artist_id '.
          'ORDER BY ms.rating DESC '.
          'LIMIT 40';
        $sh = $db->query($query);
        if (!$sh)
          break;

        $output = '<div class="head">
          <div class="right">
            <a class="music" href="#"
              onclick="switchPage(\'stats\'); return false;"
              title="'.t('Return to Statistics Page').'">'.t('Back').'</a></div>
            <h2 class="music">'.t('Top Rated Songs').'</h2></div>
            <ul class="music">';
        while ($row = $sh->fetch_array())
        {
          $output .= getHtmlSong($row['song_id'], $row['artist_name'],
            '', '', $row['name'], '', '', '', $row['rating']);
        }
        $output .= '</ul>';
        break;
  }

  return $output;
}


function getRandItems($type)
{
  global $db;

  switch ($type)
  {
    case 'artists':
      $query = 'SELECT artist_id, artist_name FROM music_artists ORDER BY artist_name';
      break;
    case 'genre':
      $query = 'SELECT genre_id, genre FROM music_genres ORDER BY genre';
      break;
    case 'albums':
      $query = 'SELECT album_id, album_name FROM music_albums ORDER BY album_name';
      break;
    default:
      return '<br>'.t('All Songs');
  }

  $sh = $db->query($query);
  if (!$sh)
    return '';

  $options = '';
  while ($row = $sh->fetch_array())
  {
    $options .= '<option value="'.$row[0].'">'.
      $row[1].'</option>';
  }
  $sh->finish();

  return '<select name="random_items" multiple="multiple" size="12" style="width: 90%;">'.
    $options.'</select>';
}


function searchMusic($terms, $option)
{
  global $db;
  $sql_terms = "CONCAT('%', ".$db->escape($terms).", '%')";
  $query = 'SELECT ms.song_id, ma.album_name, ms.track, mt.artist_name, ms.name, ms.rating, '.
    'SEC_TO_TIME(ms.length/1000) AS length, genre '.
    'FROM music_songs AS ms '.
    'LEFT JOIN music_artists AS mt ON ms.artist_id=mt.artist_id '.
    'LEFT JOIN music_albums AS ma ON ms.album_id=ma.album_id '.
    'LEFT JOIN music_genres AS mg ON ms.genre_id=mg.genre_id '.
    'WHERE 1 AND ';

  if ($option == 'all')
  {
    $query .= '(ms.name LIKE '.$sql_terms.
      ' OR mt.artist_name LIKE '.$sql_terms.
      ' OR ma.album_name LIKE '.$sql_terms.')';
  }
  else if ($option == 'artists')
  {
    $query .= '(mt.artist_name LIKE '.$sql_terms.')';
  }
  else if ($option == 'albums')
  {
    $query .= '(ma.album_name LIKE '.$sql_terms.')';
  }
  else if ($option == 'songs')
  {
    $query .= '(ms.name LIKE '.$sql_terms.')';
  }
  $query .= ' ORDER BY mt.artist_name, ma.album_name, ms.track, ms.name';

  $sh = $db->query($query);
  if (!$sh)
    return '';

  $count = $sh->num_rows;

  $output = '<div class="head">
    <div class="right">
    <a class="music" href="#"
      onclick="switchPage(\'search\'); return false;"
      title="'.t('Begin a New Search').'">'.t('New Search').'</a></div>
    <h2 class="music">'.sprintf(t("Found %s results for '%s'"), $count, $terms).'</h2></div>';

  if($count > 0)
  {
    $output .= '<ul class="music">';
    while ($row = $sh->fetch_array())
    {
      $output .= getHtmlSong($row['song_id'], $row['artist_name'],
        $row['album_name'], $row['track'], $row['name'],
        $row['length'], '', $row['genre'], $row['rating']);
    }
    $output .= '</ul>';
  }
  return $output;
}

function internalGetPlaylist($plId = 0)
{
  global $db;
  $row = array();
  if (empty($plId))
  {
    if (empty($_COOKIE['mp3act_playlist_id']))
      return $row;
    $plId = $_COOKIE['mp3act_playlist_id'];
  }

  $query = 'SELECT playlist_id, playlist_name, playlist_songs, songcount, length AS length_in_secs'.
    ', SEC_TO_TIME(length/1000) AS length '.
    'FROM music_playlists '.
    'WHERE playlist_id='.$db->escape($plId);

  $sh = $db->query($query);
  if (!$sh)
    return $row;

  if ($sh->num_rows > 0)
    $row = $sh->fetch_array();
  $sh->finish();

  // Set the last accessed time for Temporary playlists so that
  // we can run a garbage colnctor later.
  if (MYTH_WEB_PLAYLIST_NAME == $row['playlist_name'])
  {
    $query = 'UPDATE music_playlists'.
      ' SET last_accessed=NULL '.
      'WHERE playlist_id='.$db->escape($plId);
    $db->query($query);
  }

  return $row;
}

function internalUpdatePlaylist($songs, $count, $length)
{
  global $db;
  $plId = 0;
  if (!empty($_COOKIE['mp3act_playlist_id']))
    $plId = $_COOKIE['mp3act_playlist_id'];

  $songlist = implode(',', $songs);

  $query = 'music_playlists SET'.
    " playlist_songs=".$db->escape($songlist).
    ',length='.$db->escape($length).
    ',songcount='.$db->escape($count);

  if (empty($plId))
  {
    $query = 'INSERT INTO '.$query.
      ",hostname=".$db->escape('mythweb-'.$_SERVER['SERVER_NAME']).
      ",playlist_name='".MYTH_WEB_PLAYLIST_NAME."'";
  }
  else
  {
    $query = 'UPDATE '.$query.
      ' WHERE playlist_id='.$db->escape($plId);
  }
  $db->query($query);

  if (empty($plId))
  {
    $plId = $db->insert_id();
    if ($plId)
    {
      if (PHP_VERSION_ID < 70300) {
        setcookie('mp3act_playlist_id', $plId, time()+MYTH_PLAYLIST_SAVE_TIME, '/; SameSite=Strict');
      } else {
        setcookie('mp3act_playlist_id', $plId, [
          'expires' => time()+MYTH_PLAYLIST_SAVE_TIME,
          'path' => '/',
          'samesite' => 'Strict'
        ]);
      }
      return $plId;
    }
  }
  return false;
}

function viewPlaylist()
{
  global $db;
  $pl = internalGetPlaylist();

  if (empty($pl['playlist_songs']))
  {
    return '';
  }

  // Load the song information
  $query = 'SELECT ms.song_id, mt.artist_name, ms.name, ma.album_name, ms.track'.
    ', SEC_TO_TIME(ms.length/1000) AS length '.
    'FROM music_songs AS ms '.
    'LEFT JOIN music_artists AS mt ON ms.artist_id=mt.artist_id '.
    'LEFT JOIN music_albums AS ma ON ms.album_id=ma.album_id '.
    'WHERE ms.song_id IN ('.$pl['playlist_songs'].');';
  $sh = $db->query($query);
  if (!$sh)
    return;

  $song_info = array();
  while ($row = $sh->fetch_array())
  {
    $song_info[$row['song_id']] = $row;
  }
  $sh->finish();

  // Load the sub-playlist information
  // NB: MySQL 3.xx cannot use the CAST() function hense the negative number decimal
  // conversion hack as outlined on: http://dev.mysql.com/doc/refman/4.1/en/cast-functions.html
  $query = 'SELECT playlist_id, playlist_name, SEC_TO_TIME(length/1000) AS length, songcount '.
    'FROM music_playlists '.
    'WHERE (-1.0 * (playlist_id+0.0)) IN ('.$pl['playlist_songs'].');';
  $sh = $db->query($query);
  if (!$sh)
    return;

  $pl_info = array();
  while ($row = $sh->fetch_array())
  {
    $pl_info[$row['playlist_id']] = $row;
  }
  $sh->finish();


  $songs = explode(',', $pl['playlist_songs']);
  $output = '';
  $id=0;
  foreach ($songs as $song_id)
  {
    // Create a random id for Javascript events.
    $id = md5($song_id.mt_rand());
    if ($song_id > 0)
    {
      $row = $song_info[$song_id];
      $output .= getHtmlPlaylistEntrySong($id, $row['artist_name'],
        $row['album_name'], $row['track'], $row['name'], $row['length']);
    }
    else
    {
      $row = $pl_info[-1 * $song_id];
      $output .= getHtmlPlaylistEntryPlaylist($id, $row['playlist_name'],
        $row['songcount'], $row['length']);
    }
  }
  return $output;
}


function playlistInfo()
{
  $pl = internalGetPlaylist();

  $info = '';

  if (!empty($pl) && MYTH_WEB_PLAYLIST_NAME != $pl['playlist_name'])
    $info = '<em>'.$pl['playlist_name'].'</em> &mdash; ';

  if (empty($pl['playlist_songs']))
  {
    $info .= t('Playlist is empty');
  }
  else
  {
    if (1 == $pl['count'])
      $info .= sprintf(t('%s Song (%s)'), $pl['songcount'], $pl['length']);
    else
      $info .= sprintf(t('%s Songs (%s)'), $pl['songcount'], $pl['length']);
  }

  return $info;
}


function savePlaylist($pl_name, $newpl)
{
  global $db;
  $pl = internalGetPlaylist();

  if (!empty($pl['playlist_id']))
    $pl_id = $pl['playlist_id'];
  else
    $pl_id = internalUpdatePlaylist(array(), 0, 0);

  if (empty($pl_id))
  {
    $msg = t('There was a problem saving your playlist');
  }
  else
  {
    $query = 'UPDATE music_playlists SET'.
      ' playlist_name='.$db->escape($pl_name).
      ",hostname='' ".
      'WHERE playlist_id='.$db->escape($pl['playlist_id']);

    $db->query($query);

    if (MYTH_WEB_PLAYLIST_NAME == $pl['playlist_name'])
      $msg = t('Playlist saved successfully');
    else
      $msg = t('Playlist renamed successfully');
  }

  return '<h2 class="music">'.$msg.'</h2>';
}

function clearPlaylist()
{
  $pl = internalGetPlaylist();

  // Trash the cookie (empties the playlist)
  if (PHP_VERSION_ID < 70300) {
    setcookie('mp3act_playlist_id', false, time()-3600, '/; SameSite=Strict');
  } else {
    setcookie('mp3act_playlist_id', false, [
      'expires' => time()-3600,
      'path' => '/',
      'samesite' => 'Strict'
    ]);
  }

  if (!empty($pl['playlist_name'])
      && MYTH_WEB_PLAYLIST_NAME == $pl['playlist_name'])
  {
    deletePlaylist($pl['playlist_id']);
  }

  return t('Playlist is empty');
}


function deletePlaylist($id)
{
  global $db;
  $rv = 0;
  if ($id == $_COOKIE['mp3act_playlist_id'])
  {
    $rv = 1;
    if (PHP_VERSION_ID < 70300) {
      setcookie('mp3act_playlist_id', false, time()-3600, '/; SameSite=Strict');
    } else {
      setcookie('mp3act_playlist_id', false, [
        'expires' => time()-3600,
        'path' => '/',
        'samesite' => 'Strict'
      ]);
    }
  }

  $query = 'DELETE FROM music_playlists '.
    'WHERE playlist_id='.$db->escape($id);
  $db->query($query);
  return $rv;
}


function playlist_rem($itemid)
{
  global $db;
  $pl = internalGetPlaylist();

  $songs = explode(',', $pl['playlist_songs']);
  $idx = intval($itemid);
  if (isset($songs[$idx]))
  {
    // Find the length of the song we are removing so we can update the p/l
    $id = $songs[$idx];
    if ($id > 0)
    {
      $query = 'SELECT length, 1 AS songcount FROM music_songs '.
        'WHERE song_id='.$db->escape($id);
    }
    else
    {
      $query = 'SELECT length, songcount FROM music_playlists '.
        'WHERE playlist_id='.$db->escape(-1 * $id);
    }
    $sh = $db->query($query);
    $length = $count = 0;
    if ($sh)
    {
      $row = $sh->fetch_array();
      $sh->finish();
      if ($row)
      {
        $length = $row['length'];
        $count = $row['songcount'];
      }
    }
    unset($songs[$idx]);
    internalUpdatePlaylist($songs,
      ($pl['songcount'] - $count),
      ($pl['length_in_secs'] - $length));
  }
  return $itemid;
}

function playlist_move($item1,$item2)
{
  global $db;
  $pl = internalGetPlaylist();

  $idx1 = intval($item1);
  $idx2 = intval($item2);

  $songs = explode(',',$pl['playlist_songs']);

  if (!isset($songs[$idx1]) || !isset($songs[$idx2]))
    return;

  $tmp = $songs[$idx1];
  $songs[$idx1] = $songs[$idx2];
  $songs[$idx2] = $tmp;

  $query = 'UPDATE music_playlists SET'.
    ' playlist_songs='.$db->escape(implode(',', $songs)).' '.
    'WHERE playlist_id='.$db->escape($pl['playlist_id']).';';
  $db->query($query);
}

function internalPlaylistAddPlaylistCheck($curPlId, $addPlId, $depth = 0)
{
  global $db;
  // Infinite loop protection (e.g. if the DB is messed up already)
  if ($depth > 25)
    return false;

  // Looking to see if $addPlId playlist at any point includes $curPlId playlist
  if ($curPlId == $addPlId)
    return false;

  $query = 'SELECT playlist_songs '.
    'FROM music_playlists '.
    'WHERE playlist_id='.$db->escape($addPlId);

  $sh = $db->query($query);
  if (!$sh)
    return false;

  $row = $sh->fetch_array();
  $sh->finish();

  if (!$row) // Not a real playlist.
    return false;

  $songs = explode(',', $row['playlist_songs']);
  $playlists = array_filter($songs, function ($n) { return ($n < 0); });

  foreach ($playlists as $playlist_id)
  {
    if ($playlist_id > 0)
      continue; // Shouldn't happen due to the filter above but I'm paranoid.

    $playlist_id *= -1;

    if (!internalPlaylistAddPlaylistCheck($curPlId, $playlist_id, $depth+1))
      return false;
  }

  return true;
}


function playlist_add($type, $itemid)
{
  global $db;
  $output = array(0 => '', 1 => 0);

  if ('loadplaylist' == $type)
  {
    clearPlaylist();
    if (PHP_VERSION_ID < 70300) {
      setcookie('mp3act_playlist_id', $itemid, time()+MYTH_PLAYLIST_SAVE_TIME, '/; SameSite=Strict');
    } else {
      setcookie('mp3act_playlist_id', $itemid, [
        'expires' => time()+MYTH_PLAYLIST_SAVE_TIME,
        'path' => '/',
        'samesite' => 'Strict'
      ]);
    }
    $output[0] = 1;
    return $output;
  }

  $pl = internalGetPlaylist();

  if (empty($pl['playlist_songs']))
  {
    $songs = array();
    $new_length = 0;
    $new_songcount = 0;
  }
  else
  {
    $songs = explode(',', $pl['playlist_songs']);
    $new_length = $pl['length_in_secs'];
    $new_songcount = $pl['songcount'];
  }

  if ('playlist' == $type)
  {
    if (!empty($pl['playlist_id']))
    {
      if (!internalPlaylistAddPlaylistCheck($pl['playlist_id'], $itemid))
      {
        // Some sort of nasty circular dependency.
        $output[0] = 2;
        $output[1] = t('Sorry, but you cannot add this playlist as it would create a circular dependency.');
        return $output;
      }
    }
    $pl_add = internalGetPlaylist($itemid);
    if (empty($pl_add['playlist_id']))
    {
    $output[0] = 2;
    $output[1] = t('An error occurred while adding your playlist.');
    return $output;
    }
    $new_songcount += $pl_add['songcount'];
    $new_length += $pl_add['length_in_secs'];
    $songs[] = -1 * $itemid;

    $id = md5((-1 * $itemid).mt_rand());
    $output[0] .= getHtmlPlaylistEntryPlaylist($id, $pl_add['playlist_name'],
    $pl_add['songcount'], $pl_add['length']);
    $output[1]++;
    $output[] = 'pl'.$id;

    internalUpdatePlaylist($songs, $new_songcount, $new_length);

    return $output;
  }

  $sql_itemid = $db->escape($itemid);
  $query = 'SELECT ms.song_id, mt.artist_name, ma.album_name,'.
    ' length AS length_in_secs, SEC_TO_TIME(ms.length/1000) AS length, ms.name, ms.track '.
    'FROM music_songs AS ms '.
    'LEFT JOIN music_artists AS mt ON ms.artist_id=mt.artist_id '.
    'LEFT JOIN music_albums AS ma ON ms.album_id=ma.album_id '.
    'WHERE ';
  switch ($type)
  {
    case 'song':
      $query .= 'ms.song_id='.$sql_itemid;
      break;
    case 'album':
      $query .= 'ms.album_id='.$sql_itemid;
      break;
    default:
      return $output;
  }

  $sh = $db->query($query.' ORDER BY ms.track');
  if (!$sh)
    return $output;

  while ($row = $sh->fetch_array())
  {
    $id = md5($row['song_id'].mt_rand());
    $output[0] .= getHtmlPlaylistEntrySong($id, $row['artist_name'],
      $row['album_name'], $row['track'], $row['name'], $row['length']);
    $output[1]++;
    $output[] = 'pl'.$id;

    $songs[] = $row['song_id'];
    $new_length += $row['length_in_secs'];
    $new_songcount++;
  }
  $sh->finish();

  internalUpdatePlaylist($songs, $new_songcount, $new_length);

  return $output;
}

function randAdd($type,$num=0,$items='',$rating='')
{
  global $db;
  $output = array(0 => 1);
  // Check to see if $items matches our REGEXP.
  if ($type != 'all' && !preg_match('/^[0-9]+(,[0-9]+)*$/', $items))
  {
    return $output;
  }
  $sql_items = $db->escape($items);

  $query = 'SELECT song_id, length '.
    'FROM music_songs ';
  switch($type)
  {
    case 'artists':
      $query .= 'WHERE artist_id IN ('.$sql_items.') ';
      break;
    case 'genre':
      $query .= 'WHERE genre_id IN ('.$sql_items.') ';
      break;
    case 'albums':
      $query .= 'WHERE album_id IN ('.$sql_items.') ';
      break;
  }
  if($rating != '') {
    if($type == 'all')
      $query .= 'WHERE rating '.$rating.' ';
    else
      $query .= 'AND rating '.$rating.' ';
  }

  $query .= 'GROUP BY name ORDER BY RAND()+0 '.
    'LIMIT '.$db->escape(intval($num));
  $sh = $db->query($query);

  if (!$sh)
    return $output;

  $pl = internalGetPlaylist();

  if (empty($pl['playlist_songs']))
  {
    $songs = array();
    $new_length = 0;
    $new_songcount = 0;
  }
  else
  {
    $songs = explode(',', $pl['playlist_songs']);
    $new_length = $pl['length_in_secs'];
    $new_songcount = $pl['songcount'];
  }

  while ($row = $sh->fetch_array())
  {
    $songs[] = $row['song_id'];
    $new_length += $row['length'];
    $new_songcount++;
  }
  $sh->finish();

  internalUpdatePlaylist($songs, $new_songcount, $new_length);

  return $output;
}

function getPlaylistM3u($id, $quality, $depth = 0)
{
  global $db;
  $tmp = '';
  if ($depth > 20)
    return $tmp;

  $pl = internalGetPlaylist($id);
  if (empty($pl['playlist_songs']))
  {
    return $tmp;
  }

  $query = 'SELECT ms.song_id, artist_name, ms.name, (ms.length/1000) AS length '.
    'FROM music_songs AS ms '.
    'LEFT JOIN music_artists AS mt ON ms.artist_id=mt.artist_id '.
    'WHERE ms.song_id IN ('.$db->escape($pl['playlist_songs']).')';

  $song_info = array();
  $sh = $db->query($query);
  if (!$sh)
    return $tmp;

  while ($row = $sh->fetch_array())
  {
    $song_info[$row['song_id']] = $row;
  }
  $sh->finish();

  $songs = explode(',', $pl['playlist_songs']);
  foreach ($songs as $song_id)
  {
    if ($song_id > 0)
    {
      $row = $song_info[$song_id];
      $tmp .= '#EXTINF:'.intval($row['length']).','.utf8_decode($row['artist_name']).' - '.utf8_decode($row['name'])."\n";
      $tmp .= stream_url().'stream?i='.$row['song_id']."\n";
    }
    else if ($song_id < 1)
    {
      $tmp .= getPlaylistM3u((-1 * $song_id), $quality, $depth+1);
    }
  }

  return $tmp;
}

function play($type, $id, $quality = 'high')
{
  global $db;
  $tmp = '';
  $query = '';

  if ('pl' == $type)
  {
    $tmp .= getPlaylistM3u($id, $quality);
  }
  else
  {
    $query = 'SELECT ms.song_id, artist_name, ms.name, (ms.length/1000) AS length '.
             'FROM music_songs AS ms '.
             'LEFT JOIN music_artists AS mt ON ms.artist_id=mt.artist_id '.
             'WHERE ';

    $sql_id = $db->escape($id);
    switch ($type)
    {
      case 'song':
        $query .= 'ms.song_id='.$sql_id;
        break;
      case 'album':
        $query .= 'ms.album_id='.$sql_id.' '.
          'ORDER BY ms.track';
        break;
      default:
        return '';
    }

    $sh = $db->query($query);
    if ($sh)
    {
      while ($row = $sh->fetch_array())
      {
        $tmp .= '#EXTINF:'.intval($row['length']).','.utf8_decode($row['artist_name']).' - '.utf8_decode($row['name'])."\n";
        $tmp .= stream_url().'stream?i='.$row['song_id']."\n";
      }
      $sh->finish();
    }
  }

  if($tmp == '')
    return '';

  session_cache_limiter('nocache');
  header('Content-Type: audio/mpegurl;');
  header('Content-Disposition: inline; filename="playlist.m3u"');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: nocache');

  return "#EXTM3U\n".$tmp;
}
