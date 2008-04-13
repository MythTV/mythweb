<?php
/**
 * Rudimentary interface to MythVideo data
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Video
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Videos');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.root.'dcss/video.css.php">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<script type="text/javascript">

    function newWindow(id) {
        $('window_title').innerHTML   = '<?php echo t('Editing '); ?> ' + $(id+'-title').childNodes[0].innerHTML;
        $('window_content').innerHTML = '<iframe src="<?php echo root; ?>video/edit?intid='+id+'">';
        $('window').show();
        Tips.hideAll();
    }

    function imdb_lookup(id, title) {
        if (pending_ajax_requests > 0) {
            alert('<?php echo t('Please wait for the pending ajax request'); ?>');
            return;
        }
        ajax_add_request();
    // Clean up the title string
        title = title.replace('&', '%26');
        new Ajax.Request('<?php echo root ?>video/imdb',
    	                 {
                            method:     'get',
    	                    parameters: {
                                            action: 'lookup',
                                            id:     id,
                                            title:  title
                                        },
    	                    onSuccess:  imdb_handler
    	                 });
    }

    function imdb_handler(response) {
        ajax_remove_request();
        var result  = response.responseJSON;

        if (result['error'])
            for (var key in result['error'])
                console.error(result['error'][key]);
        if (result['warning'])
            for (var key in result['warning'])
                console.warn(result['warning'][key]);

        for (var key in result['update'])
            update_video(result['update'][key]);

        if (result['action'] == 'lookup') {
            if (result['matches']) {
                $('window_title').innerHTML   = '<?php echo t('Video: IMDB: Window Title'); ?> (<a href="javascript: imdb_prompt(\''+result['id']+'\');"><?php echo t('Custom Search'); ?><\/a>)';
                $('window_content').innerHTML = '';
                for (var key in result['matches'])
                    if (result['matches'][key]['title'])
                    $('window_content').innerHTML += '<br>'
                                                  +  '<a href="'+makeImdbWebUrl(result['matches'][key]['imdbid'])+'" style="float: right; margin-left: 1em;" target="_blank">(IMDB)</a>'
                                                  +  '<a href="javascript:imdb_select(\''+result['id']+'\',\''+result['matches'][key]['imdbid']+'\')">'+result['matches'][key]['title']+'</a>';

            }
            else {
                $('window_title').innerHTML   = '<?php echo t('Video: IMDB: Window Title'); ?> (<a href="javascript: imdb_prompt(\''+result['id']+'\');"><?php echo t('Custom Search'); ?><\/a>)';
                $('window_content').innerHTML = '<?php echo t('Video: IMDB: No Matches');   ?>';

            }
            $('window').show();
            Tips.hideAll();
        }
    }

    function makeImdbWebUrl(num) {
        var imdb = "<?php echo setting('web_video_imdb_type', hostname); ?>";
        if (imdb == 'ALLOCINE')
            return "http://www.allocine.fr/film/fichefilm_gen_cfilm="+num+".html";
        return "http://www.imdb.com/Title?"+num;
    }

    function imdb_select(id, number) {
        ajax_add_request();
        $('window').hide();
        new Ajax.Request('<?php echo root; ?>video/imdb',
    	                 {
    	                 	method:     'get',
    	                 	parameters: {
                                                action: 'grab',
                                                id:     id,
                                                number: number
                                            },
    	                 	onSuccess:  imdb_handler
    	                 });
    }

    function imdb_prompt(id) {
        var title  = $(id+'-title').childNodes[0].innerHTML;
        var number = prompt('<?php echo t('Please enter an imdb number or a title to do another search'); ?>', title);
        if (typeof(number) != 'string' || number.length == 0)
            return;
        $('window').hide();
        if (number.match(/^(\d*)$/))
            imdb_select(id, number);
        else
            imdb_lookup(id, number);
    }

    function update_video(id) {
        if (!id.match(/^(\d*)$/))
            return;
        ajax_add_request();
        new Ajax.Request('<?php echo root; ?>video/imdb',
    	                    {
    	                    	method:     'get',
    	                    	parameters: {
                                                action: 'metadata',
                                                id:     id
                                            },
    	                    	onSuccess:  update_video_result
    	                    });
    }

    function update_video_result(result) {
        var video    = result.responseJSON.metadata;
    // Update the video
        for (var key in video) {
            if (key == 'title')
                $(video['intid']+'-'+key).childNodes[0].innerHTML = video[key];
            var element = $(video['intid']+'_'+key);
                if (element != null & typeof(element) != 'undefined')
                    element.innerHTML = video[key];
        }
        Tips.remove(video['intid']);
        ajax_remove_request();
    }

// The filter timeout is done because it can take awhile to filter the page
// The timeout prevents the script from fireing while the user is setting options

    var filter_timeout = null;

    function filter() {
        if (filter_timeout != null)
            window.clearTimeout(filter_timeout);
        filter_timeout = window.setTimeout('filter_action()', 1050);
    }

    function filter_action() {
        ajax_add_request();
        var title    = $('filter_box').value.toLowerCase();
        var category = $('category').value;
        var genre    = $('genre').value;
        var browse   = $('browse').value;

        for (key in $$('#videos div.video') ) {
            var video = $$('#videos div.video')[key];
            if (!video.id)
                continue;
            var hide = false;
            if (category    != -1 &  $(video.id+'_categoryid').innerHTML != category)
                hide = true;
            if (genre       != -1 & !$(video.id+'_genre').innerHTML.match(' '+video.id+' '))
                hide = true;
            if (browse      != -1 &  $(video.id+'_browse').innerHTML != browse)
                hide = true;
            if (title.length  > 0 &  $(video.id+'-title').childNodes[0].innerHTML.toLowerCase().match(title) == null )
                hide = true;
            if (hide)
                $(video.id).hide();
            else
                $(video.id).show();
        }
        ajax_remove_request();
    }

    var hovering_video_id = null;
    var loading_popups    = new Array();

    function video_popup(id) {
        hovering_video_id = id;
        if (!Tips.hasTip(id) && loading_popups[id] != true ) {
            loading_popups[id] = true;
            new Ajax.Request('<?php echo root; ?>video/imdb',
    	                    {
    	                    	method:     'get',
    	                    	parameters: {
                                                action: 'metadata',
                                                id:     id
                                            },
    	                    	onSuccess:  video_create_popup
    	                    });
        }
    }

    function video_create_popup(result) {
        var video    = result.responseJSON['metadata'];
        var content  = '<dl class="details_list">'
                     + '<dt>Plot:</dt>     <dd>'+(video['plot'] ? video['plot'] : '&nbsp;')+'</dd>'
                     + '<dt>Rating:</dt>   <dd>'+(video['rating'] ? video['rating'] : '&nbsp;')+'</dd>'
                     + '<dt>Director:</dt> <dd>'+(video['director'] ? video['director'] : '&nbsp;')+'</dd>'
                     + '<dt>Year:</dt>     <dd>'+(video['year'] ? video['year'] : '&nbsp;')+'</dd>';
                     + '</dl>';
        new Tip(video['intid'], content, { className: 'popup' });
        loading_popups[video['intid']] = false;
        if (video['intid'] == hovering_video_id)
            Tips.showTip(video['intid']);
    }

// We currently do require a reload after a scan event
    function scan() {
        ajax_add_request();
        new Ajax.Request('<?php echo root; ?>video/scan',
    	                {
    	                	method:    'get',
    	                	onSuccess: reload
    	                });
    }

    function reload() {
        location.reload(true);
    }

</script>

<div id="window" style="display: none">
 <a style="position: absolute; right: 1px; top: 1px;" href="" onclick="('window').hide()">[X]</a>
 <span id="window_video_title" class="hidden"></span>
 <span id="window_title"></span><br>
 <div id="window_content"></div>
</div>

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
<td>
 <span style="float: right"><input type="button" value="<?php echo t('Scan Collection'); ?>" class="submit" onclick="scan()"></span>
 <form action="<?php echo root; ?>video" method="GET">
  <?php echo t('Display'); ?>:
  <select name="category" id="category" onchange="filter();">
   <option value="-1" <?php if($Filter_Category == -1) echo 'SELECTED'; ?>><?php echo t('All Categories'); ?></option>
   <?php
    foreach (array_keys($Category_String) as $i) {
        echo "<option value=\"$i\"";
        if( $i == $Filter_Category )
            echo ' SELECTED';
        echo '>'.html_entities($Category_String[$i])."</option>\n";
    }
   ?>
  </select>&nbsp;&nbsp;
  <select name="genre" id="genre" onchange="filter();">
   <option value="-1" <?php if ($Filter_Genre == -1) echo 'SELECTED'; ?>><?php echo t('All Genres'); ?></option>
   <?php
    foreach (array_keys($Genre_String) as $i) {
        echo "<option value=\"$i\"";
        if( $i == $Filter_Genre )
            echo ' SELECTED';
        echo '>'.html_entities($Genre_String[$i])."</option>\n";
    }
   ?>
  </select>&nbsp;&nbsp;
  <select name="browse" id="browse" onchange="filter();">
   <option value="-1" <?php if ($Filter_Browse == -1) echo 'SELECTED'; ?>><?php echo t('Browse all'); ?></option>
   <option value="1"  <?php if ($Filter_Browse ==  1) echo 'SELECTED'; ?>><?php echo t('Browse = yes'); ?></option>
   <option value="0"  <?php if ($Filter_Browse ==  0) echo 'SELECTED'; ?>><?php echo t('Browse = no'); ?></option>
  </select>&nbsp;&nbsp;
  <?php echo t('Title search'); ?>: <input id="filter_box" name="search" value="<?php echo $Filter_Search; ?>" onchange="filter();" onkeyup="filter();">
  <?php echo t('Admin Key'); ?>: <input type="password" name="VideoAdminPassword" value="<?php echo $_SESSION['video']['VideoAdminPassword']; ?>" size="5">
  <input type="submit" class="submit" value="<?php echo t('Update') ?>">
 </form>
</td>
<td style="text-align: right;">
 <?php echo count($All_Videos).' videos'; ?>
</td>
</tr>
</table>

<div id="videos">

<div id="path">
 <b>Directory Structure</b><hr>
 <a class="<?php if (!isset($_SESSION['video']['path']) || $_SESSION['video']['path'] == '/') echo 'active'; ?>" href="<?php echo root; ?>video?path=/">All Videos</a><br>
 <?php foreach ($PATH_TREE as $path) output_path_picker($path); ?>
</div>

<?php
    foreach ($All_Videos as $video) {
?>
    <div id="<?php echo $video->intid; ?>" class="video" onmouseover="video_popup(this.id)" onmouseout="hovering_video_id = null;">
        <div id="<?php echo $video->intid; ?>_categoryid" class="hidden"><?php echo $video->category; ?></div>
        <div id="<?php echo $video->intid; ?>_genre" class="hidden"><?php if (count($video->genres)) foreach ($video->genres as $genre) echo ' '.$genre.' ';?></div>
        <div id="<?php echo $video->intid; ?>_browse" class="hidden"><?php echo $video->browse; ?></div>
        <div id="<?php echo $video->intid; ?>-title" class="title"><a href="<?php echo $video->url; ?>"><?php echo html_entities($video->title); ?></a></div>
        <div id="<?php echo $video->intid; ?>_img">                <img <?php if ($_SESSION["show_video_covers"] && file_exists($video->cover_file)) echo 'src="'.$video->cover_url.'"'; echo ' width="'.$video->cover_scaled_width.'" height="'.$video->cover_scaled_height.'"'; ?> alt="<?php echo t('Missing Cover'); ?>"></div>
        <div id="<?php echo $video->intid; ?>-category">           <?php echo $Category_String[$video->category]; ?></div>
        <div id="<?php echo $video->intid; ?>_playtime">           <?php echo nice_length($video->length * 60); ?></div>
        <div id="<?php echo $video->intid; ?>_imdb">               <?php if ($video->inetref != '00000000') { ?><a href="<?php echo makeImdbWebUrl($video->inetref); ?>"><?php echo $video->inetref ?></a><?php } ?></div>
        <div class="command">
            <span class="commands"><a href="javascript:newWindow('<?php echo $video->intid ?>')" ><?php echo t('Edit') ?></a></span>
            <span class="commands"><a href="javascript:imdb_lookup('<?php echo $video->intid ?>','<?php echo addslashes($video->title); ?>')">IMDB</a></span>
        </div>
    </div>
<?php
    }
?>
</div>
<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
