<?php

function getHtmlSong($id, $artistName, $albumName, $trackNum, $trackName, $trackLength, $numPlays, $genre, $rating)
{
  static $alt = true;
  $alt = !$alt;
  $output = '<li'.($alt ? ' class="alt"' : '').
    ' ondblclick="pladd(\'song\','.$id.'); return false;">
    <a class="music" href="#"
      onclick="pladd(\'song\','.$id.'); return false;"
      title="'.t('Add Song to Current Playlist').'">
    <img src="'.pic_dir().'add.gif" /></a>
    <a class="music" href="#"
      onclick="play(\'song\','.$id.'); return false;"
      title="'.t('Play this Song Now').'">
    <img src="'.pic_dir().'play.gif" /></a> ';

  if (!empty($artistName))
    $output .= (!empty($trackNum) ? $trackNum.'. ' : '').'<em>'.$artistName.'</em> - ';

  $output .= $trackName;

  $sub_output = '';

  if (!empty($albumName))
    $sub_output .= sprintf(t('Track #%s from the album \'%s\''), $trackNum, $albumName).'<br>';

  if (!empty($numPlays))
  {
    if (1 == $numPlays)
      $sub_output .= t('Played once').'<br>';
    else
      $sub_output .= sprintf(t('Played %s times'), $numPlays).'<br>';
  }

  if (!empty($trackLength))
    $sub_output .= $trackLength.'<br>';

  if(!empty($genre))
    $sub_output .= t('Genre').': '.$genre.'<br>';

  if(!empty($rating))
    $sub_output .= t('Rating').': '.$rating.'<br>';

  if (!empty($sub_output))
  {
    $output .= '<p>'.$sub_output.'</p>';
  }

  $output .= '</li>';
  return $output;
}


function getHtmlAlbum($id, $albumName, $artistName='', $year='', $numTracks='', $length='', $extra='')
{
  static $alt = true;
  $alt = !$alt;
  $output = '<li'.($alt ? ' class="alt"' : '').'>';

  if (!empty($extra))
    $output .= '<small>'.$extra.'</small>';

  $output .= '<a class="music" href="#"
      onclick="pladd(\'album\','.$id.'); return false;"
      title="'.t('Add Album to Current Playlist').'">
    <img src="'.pic_dir().'add.gif" /></a>
    <a class="music" href="#"
      onclick="play(\'album\','.$id.'); return false;"
      title="'.t('Play this Album Now').'">
    <img src="'.pic_dir().'play.gif" /></a>
    <a class="music" href="#"
      onclick="updateBox(\'album\','.$id.'); return false;"
      title="'.sprintf(t('View Details of %s'), $albumName).'">'.
    $albumName;

  if (!empty($artistName))
    $output .= ' &mdash; <em>'.$artistName.'</em>';

  $output .= '</a>';

  $sub_output = '';

  if (!empty($year))
    $sub_output .= t('Year').': '.$year.'<br>';

  if (!empty($numTracks))
    $sub_output .= t('# Tracks').': '.$numTracks.'<br>';

  if (!empty($length))
    $sub_output .= t('Total Length').': '.$length.'<br>';

  if (!empty($sub_output))
    $output .= '<p>'.$sub_output.'</p>';

  $output .= '</li>';
  return $output;
}

function getHtmlArtist($id, $artistName='', $year='', $numTracks='', $length='', $extra='')
{
  static $alt = true;
  $alt = !$alt;
  $output = '<li'.($alt ? ' class="alt"' : '').'>';

  if (!empty($extra))
    $output .= '<small>'.$extra.'</small>';

  $output .= '<a class="music" href="#"
      onclick="pladd(\'artist\','.$id.'); return false;"
      title="'.t('Add Artist to Current Playlist').'">
    <img src="'.pic_dir().'add.gif" /></a>
    <a class="music" href="#"
      onclick="play(\'artist\','.$id.'); return false;"
      title="'.t('Play this Artist Now').'">
    <img src="'.pic_dir().'play.gif" /></a>
    <a class="music" href="#"
      onclick="updateBox(\'artist\','.$id.'); return false;"
      title="'.sprintf(t('View Details of %s'), $artistName).'">'.
    $artistName;

  $output .= '</a>';

  $sub_output = '';

  if (!empty($year))
    $sub_output .= t('Year').': '.$year.'<br>';

  if (!empty($numTracks))
    $sub_output .= t('# Tracks').': '.$numTracks.'<br>';

  if (!empty($length))
    $sub_output .= t('Total Length').': '.$length.'<br>';

  if (!empty($sub_output))
    $output .= '<p>'.$sub_output.'</p>';

  $output .= '</li>';
  return $output;
}

function getHtmlPlaylist($playlistId, $playlistName, $songcount, $length, $unsavedId = 0, $blnShowDelete = true)
{
  return '<li>
    <a class="music" href="#"
        onclick="pladd(\'playlist\','.$playlistId.'); return false;"
        title="'.t('Add this Playlist as a Subplaylist').'">
        <img src="'.pic_dir().'add.gif" /></a>
    <a class="music" href="#"
        onclick="checkPlaylistLoad(\''.$playlistId.'\', '.$unsavedId.')'.
        ' && pladd(\'loadplaylist\','.$playlistId.'); return false;"
        title="'.t('Load this Saved Playlist').'">
        <img src="'.pic_dir().'add.gif" /></a>
    <a class="music" href="#"
        onclick="play(\'pl\','.$playlistId.'); return false;"
        title="'.t('Play this Playlist Now').'">
    <img src="'.pic_dir().'play.gif" /></a> '.
    ($blnShowDelete ? '<a class="music" href="#"
        onclick="deletePlaylist('.$playlistId.'); return false;"
        title="'.t('DELETE this Saved Playlist').'">
    <img src="'.pic_dir().'rem.gif" /></a> ' : '').
    '<a class="music" href="#"
        onclick="updateBox(\'saved_pl\','.$playlistId.'); return false;"
        title="'.t('Click to View Playlist').'"><em>'.
    $playlistName.
    '</em> - '.sprintf(t('%s Songs'), $songcount).' ('.$length.')'.
    '</a></li>';
}

function getHtmlPlaylistEntry($id, $contents)
{
  return '<li id="pl'.$id.'"
      onmouseover="setBgcolor(\'pl'.$id.'\',\'#FCF7A5\');"
      onmouseout="setBgcolor(\'pl'.$id.'\',\'#F3F3F3\');">
    <a class="music" href="#"
      onclick="movePLItem(\'up\',this.parentNode); return false;"
      title="'.t('Move Item Up in Playlist').'">
    <img src="'.pic_dir().'up.gif" /></a>
    <a class="music" href="#"
      onclick="movePLItem(\'down\',this.parentNode); return false;"
      title="'.t('Move Item Down in Playlist').'">
    <img src="'.pic_dir().'down.gif" /></a>
    <a class="music" href="#"
      onclick="plrem(this.parentNode); return false;"
      title="'.t('Remove Item from Playlist').'">
    <img src="'.pic_dir().'rem.gif" /></a> '.
    $contents.
    '</li>';
}

function getHtmlPlaylistEntrySong($id, $artistName, $albumName, $trackNum, $trackName, $trackLength)
{
  return getHtmlPlaylistEntry($id,
    '<em>'.$artistName.'</em> - '.$trackName.
    '<p>'.sprintf(t('Track #%s from the album \'%s\''), $trackNum, $albumName).
    '<br>'.$trackLength.'</p>');
}

function getHtmlPlaylistEntryPlaylist($id, $playlistName, $playlistSongCount, $playlistTotalTime)
{
  return getHtmlPlaylistEntry($id,
    sprintf(t('Playlist: %s'), '<em>'.$playlistName.'</em>').
    '<p>'.sprintf(t('%s Songs'), $playlistSongCount).
    '<br>'.sprintf(t('Total Time:  %s'), $playlistTotalTime).'</p>');
}

?>
