<?php
//require_once('modules/music/mp3act_functions.php');

set_time_limit(0);
if (!empty($_GET['i']))
{
  $qual = 'high';
  if (!empty($_GET['q']))
    $qual = $_GET['q'];
  streamPlay($_GET['i'], $qual);
}


function updateNumPlays($num)
{
  $sql_song_id = mysql_real_escape_string($num);
  $query = 'UPDATE music_songs SET numplays=numplays+1 '.
    'WHERE song_id='.$sql_song_id;
   mysql_query($query);
}

function streamPlay($id)
{
  $query = 'SELECT mt.artist_name, ms.name, md.path, ms.filename '.
    'FROM music_songs AS ms '.
    'LEFT JOIN music_artists AS mt ON ms.artist_id=mt.artist_id '.
    'LEFT JOIN music_directories AS md ON ms.directory_id=md.directory_id '.
    'WHERE ms.song_id='.mysql_real_escape_string($id);

  $result = mysql_query($query);
  if (!$result)
    return;

  $row = mysql_fetch_array($result);
  updateNumPlays($id);
  clearstatcache(); // flush buffer

  if (false !== strpos($row['filename'], '://'))
  {
    header('Location: '.$row['filename']);
    exit;
  }

  $filename = 'data/music/'.$row['path'].'/'.$row['filename'];

  switch (substr($filename, -3))
  {
    case 'mp3':
      $mime = 'audio/mpeg'; break;
    case 'ogg':
      $mine = 'application/ogg'; break;
    default:
      $mime = 'application/octet-stream';
  }

  header('Content-Type: '.$mime);
  header('Content-Length: '.filesize($filename));
  header('Content-Disposition: filename='.$row['artist_name'].' - '.$row['name']);

  $fp = fopen($filename, 'rb');
  while (!feof($fp))
    echo fread($fp, 4096);
  fclose($fp);
  exit;
}


?>