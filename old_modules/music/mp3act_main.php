<?php
/*************************************************************************
*  mp3act Digital Music System - A streaming and jukebox solution for your digital music collection
*  http://www.mp3act.net
*  Copyright (C) 2005 Jon Buda (www.jonbuda.com)
*
*  This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

*  This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*************************************************************************/

    require_once("modules/music/mp3act_functions.php");
    require_once("modules/music/mp3act_sajax.php");

    GarbageCollector();

    $sajax_remote_uri   = 'music/';
    $sajax_request_type = 'POST';
    sajax_init();
    sajax_export("getplaylistnames","musicLookup","playlist_rem","playlist_add","playlistInfo","clearPlaylist","buildBreadcrumb","play","playlist_move","searchMusic","viewPlaylist","getDropDown","savePlaylist","getRandItems","randAdd","deletePlaylist");
    sajax_handle_client_request();

    $headers[] = '<link rel="Stylesheet" href="'.skin_url.'music.css" type="text/css">';

    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

    <script type="text/javascript">
            var page = 'search';
            var mode = '<?php echo $_SESSION['sess_playmode']; ?>';
            var bc_parenttype = '';
            var bc_parentitem = '';
            var bc_childtype = '';
            var bc_childitem = '';
            var prevpage = '';
            var currentpage = 'search';
            var nowplaying = 0;
            var isplaying = 0;
            var clearbc = 1;

  function getCookie( cookieName ) {
      var cookies = document.cookie;
      var substr1 = cookies.split( cookieName+'=' )
          if ( substr1 == cookies ) return -1;
      var substr2 = substr1[1].split( ';' );
      var len1 = substr1[0].length + cookieName.length + 1;
      var len2 = substr2[0].length
      return cookies.substring( len1, len1+len2 );
  }

  function checkPlaylistLoad( playlistId, unsavedPlaylistId ) {
    var pl_id = getCookie('mp3act_playlist_id');
    if (pl_id < 1) return true;
    if (playlistId == pl_id) {
        alert ('<?php echo t('This playlist is already loaded!'); ?>');
        return false;
    }
    if (unsavedPlaylistId == pl_id) {
        return confirm('<?php echo t('This will overwrite your current, unsaved playlist. Are you sure you want to continue?'); ?>');
    }
    return true;
  }
    <?php sajax_show_javascript(); ?></script>
    <script type="text/javascript" src="music/mp3act_js.js.php"></script>
    <script type="text/javascript" src="music/mp3act_fat.js"></script>

<div id="wrap">
    <div id="header">
        <div id="controls">

        </div>
        <h1 id="pagetitle"></h1>
        <ul class="music" id="nav">
            <li><a href="#" id="search_music" onclick="switchPage('search'); return false;" title="<?php echo t('Search the Music Database'); ?>"><?php echo t('Search'); ?></a></li>
            <li><a href="#" id="browse" onclick="switchPage('browse'); return false;"  title="<?php echo t('Browse the Music Database'); ?>" class="c"><?php echo t('Browse'); ?></a></li>
            <li><a href="#" id="random" onclick="switchPage('random'); return false;" title="Create Random Mixes"><?php echo t('Random'); ?></a></li>
            <li><a href="#" id="playlists" onclick="switchPage('playlists'); return false;" title="<?php echo t('Load Saved Playlists'); ?>"><?php echo t('Playlists'); ?></a></li>
            <li><a href="#" id="stats" onclick="switchPage('stats'); return false;" title="<?php echo t('View Server Statistics'); ?>"><?php echo t('Stats'); ?></a></li>
        </ul>

    </div>
    <div id="loading"><h1><?php echo t("LOADING"); ?>...</h1></div>
    <div id="left">
        <!--Disable breadcrumbs so info box and playlist align.-->
        <h2 id="breadcrumb" style="display:none"></h2>
        <div class="box" id="info">
        </div>
    </div>

    <div id="right">
            <div class="box">
                <div class="head">
                    <div class="right"><a href="#" onclick="play('pl',0); return false;" title="<?php echo t('Play This Playlist Now'); ?>"><?php echo t('Play'); ?></a> <a href="#" onclick="savePL('open',0); return false;" title="<?php echo t('Save or Rename the Current Playlist'); ?>"><?php echo t('Save/Rename'); ?></a> <a href="#" onclick="plclear(); return false;" class="red" title="<?php echo t('Create a New Playlist'); ?>"><?php echo t('New'); ?></a></div>
                    <h2 id="pl_title"></h2><span id="pl_info"></span>
                </div>
            <ul class="music" id="playlist">

            </ul>

            <div id="box_extra"> </div>
            </div>
    </div>
    <div class="clear"></div>
</div>
<iframe src="music/mp3act_hidden.php" frameborder="0" height="0" width="0" id="hidden" name="hidden"></iframe>
<?php
require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
