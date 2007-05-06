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
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.root.'dcss/video.css.php" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT">
<!--Hide script from old browsers

    function newWindow(newContent) {
        winContent = window.open(newContent, 'nextWin', 'right=0, top=20,width=350,height=440, toolbar=no,scrollbars=no, resizable=yes');
    }

    function imdb_lookup(id, title) {
        if (pending_ajax_requests > 0) {
            alert('<?php echo t('Please wait for the pending ajax request'); ?>');
            return;
        }
        ajax_add_request();
    // Clean up the title string
        title = title.replace('&', '%26');
        var myAjax = new Ajax.Request('<?php echo root ?>video/imdb',
    	                                 {
    	                                 	method:     'get',
    	                                 	parameters: 'action=lookup&id='+id+'&title='+title,
    	                                 	onComplete: imdb_handler
    	                                 });
    }

    function imdb_handler(response) {
        ajax_remove_request();
        var results = response.responseText.split('\n');
        var result_index = 0;
        while (result_index < results.length) {
            var result = results[result_index];
            var result_split = result.split('~:~');
            var result_code =  result_split[0];
            var result_string = result_split[1];
        // There really should only be one error message at at time.
        // We really need to impliment a much better php/js error handler
            if (result_code == 'Error') {
                alert(result_string);
                return;
            }
            if (result_code == 'Warning') {
                alert(result_string);
            }
            if (result_code == 'Update') {
                update_video(result_string.replace(/^\s+/, ''));
            }
            if (result_code == 'Matches') {
                $('window_title').innerHTML = '<?php echo t('Video: IMDB: Window Title'); ?>';
                var content = $('window_content');
                content.innerHTML = '';
                var matches = result_string.split('|');
                var matches_index = 1;
                var line = matches[0].split(':');
                var id = line[1].replace(/^\s+/, '');
                while (matches_index < matches.length ) {
                    var line = matches[matches_index].split(':');
                    var num = line[0].replace(/^\s+/, '');
                    var title = '';
                    var title_index = 1;
                    while (title_index < line.length) {
                        if (title_index > 1)
                            title += ':';
                        title += line[title_index];
                        title_index += 1;
                    }
                    if (title.length > 0) {
                        content.innerHTML += '<br />';
                        content.innerHTML += '<a href="'+makeImdbWebUrl(num)+'" style="float: right; margin-left: 1em;" target="_blank">(IMDB)</a>';
                        content.innerHTML += '<a href="javascript:imdb_select(\''+id+'\',\''+num+'\')">'+title+'</a>';
                    }
                    matches_index += 1;
                }
                content.innerHTML += '<br /><a href="javascript: imdb_prompt(\''+id+'\');"><?php echo t('Custom Search'); ?><\/a>';
                remove_class('window', 'hidden');
            }
            if (result_code == 'No Matches') {
                var id = result_string.replace(/^\s+/, '');
                $('window_title').innerHTML = '<?php echo t('Video: IMDB: Window Title'); ?>';
                var content = $('window_content');
                content.innerHTML = '<?php echo t('Video: IMDB: No Matches'); ?>';
                content.innerHTML += '<br /><br /><br /><a href="javascript: imdb_prompt(\''+id+'\');"><?php echo t('Custom Search'); ?><\/a>';
                remove_class('window', 'hidden');
            }
            result_index += 1;
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
        add_class('window', 'hidden');
        var myAjax = new Ajax.Request('<?php echo root; ?>video/imdb',
    	                              {
    	                              	method:     'get',
    	                              	parameters: 'action=grab&id='+id+'&number='+number,
    	                              	onComplete: imdb_handler
    	                              });
    }

    function imdb_prompt(id) {
        var title = $(id+'-title').childNodes[0].innerHTML;
        var number = prompt('<?php echo t('Please enter an imdb number or a title to do another search'); ?>', title);
        if (typeof(number) != 'string')
            return;
        if (number.length == 0)
            return;
        add_class('window', 'hidden');
        if (number.match(/^(\d*)$/))
            imdb_select(id, number);
        else
            imdb_lookup(id, number);
    }

    function update_video(id) {
        ajax_add_request();
        var myAjax = new Ajax.Request('<?php echo root; ?>video/imdb',
    	                                 {
    	                                 	method:     'get',
    	                                 	parameters: 'action=metadata&id='+id,
    	                                 	onComplete: update_video_result
    	                                 });
    }

    function update_video_result(result) {
        var matches = result.responseText.split('\n');
        var matches_index = 0;
        while (matches_index < matches.length) {
            if (matches[matches_index].length > 0) {
                var line = matches[matches_index].split('|');
                var data = line[0];
                var value = line[1];
                if (data == 'intid')
                    var id = value;
                if (data.length > 0) {
                    var elementid = id+'_'+data;
                    var element = $(elementid);
                    if (element != null & typeof(element) != 'undefined')
                        element.innerHTML = value;
                }
            }
            matches_index += 1;
        }
        ajax_remove_request();
    }

// The filter timeout is done because it can take awhile to filter the page
// The timeout prevents the script from fireing while the user is setting options

    var filter_timeout = null;

    function filter() {
        if (filter_timeout != null)
            window.clearTimeout(filter_timeout);
        filter_timeout = window.setTimeout('filter_show()', 1000);
    }

    function filter_show() {
        ajax_add_request();
        window.setTimeout('filter_action()', 50);
    }

    function filter_action() {
        var title = $('filter_box').value.toLowerCase();
        var category = $('category').value;
        var genre = $('genre').value;
        var browse = $('browse').value;
        var container = $('videos');
        var id;
        for ( node in container.childNodes ) {
            id = container.childNodes[node].id;
        // We need to skip path, as it's a special box that doesn't get filtered.
            if (typeof(id) == 'undefined' || id.length == 0 || id == 'undefined' || id == 'path')
                continue;
            var hide = false;
            if (category != -1 & $(id+'_categoryid').innerHTML != category)
                hide = true;
            if (genre != -1 & !$(id+'_genre').innerHTML.match(' '+id+' '))
                hide = true;
            if (browse != -1 & $(id+'_browse').innerHTML != browse)
                hide = true;
            if ( title.length > 0 & $(id+'-title').childNodes[0].innerHTML.toLowerCase().match(title) == null )
                hide = true;
            if (hide)
                add_class(id, 'hidden');
            else
                remove_class(id, 'hidden');
        }
        ajax_remove_request();
    }

// We use a global var here to keep track of any pending requests so we don't keep repeat them.
    var popup_divs = new Array;

    function video_popup(id) {
        var popup_div = $(id+'_popup');
        if (popup_div == null & popup_divs[id] != true) {
            popup_divs[id] = true;
            var myAjax = new Ajax.Request('<?php echo root; ?>video/imdb',
    	                                 {
    	                                 	method:     'get',
    	                                 	parameters: 'action=metadata&id='+id,
    	                                 	onComplete: video_create_popup
    	                                 });
        }
        else {
            popup(id, '');
        }
    }

    function video_create_popup(result) {
        var lines       = result.responseText.split('\n');
        var line        = lines[0].split('|');
        var id          = line[1];
        var index       = 1;
        var popup_div   = document.createElement('div');
        popup_div.id    = id+'_popup';
        popup_div.className = 'popup';
        popup_div.innerHTML = '<dl class="details_list">';
        while (index < lines.length) {
            line = lines[index].split('|');
            if (   line[0] == 'img'
                || line[0] == 'title'
                || line[0] == 'playtime'
                || line[0] == 'category'
                || line[0] == 'imdb'
                || line[0] == 'inetref'
                || line[0] == 'userrating'
                || line[0] == 'length'
                || line[0] == 'showlevel'
               )
            {
                ;
            }
            else {
                if (typeof(line[0]) == 'string' && typeof(line[1]) == 'string' && line[1].length > 0 ) {
                    popup_div.innerHTML += '<dt>'+line[0].substring(0,1).toUpperCase()+line[0].substring(1)+'<\/dt><dd>'+line[1]+'<\/dd>';
                }
            }
            index += 1;
        }
        popup_div.innerHTML += '</dl>';
        document.body.appendChild(popup_div);
        popup(id, '');
    }

    function scan() {
        var myAjax = new Ajax.Request('<?php echo root; ?>video/scan',
    	                             {
    	                             	method:     'get',
    	                             	onComplete: reload
    	                             });
    }

    function reload() {
        location.reload(true);
    }

//Stop hiding script from old browsers -->
</SCRIPT>

<div id="window" class="hidden">
 <a style="position: absolute; right: 1px; top: 1px;" href="javascript:add_class('window','hidden')">[X]</a>
 <span id="window_video_title" class="hidden"></span>
 <span id="window_title"></span><br />
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
 <b>Directory Structure</b><hr />
 <a class="<?php if (!isset($_SESSION['video']['path']) || $_SESSION['video']['path'] == '/') echo 'active'; ?>" href="<?php echo root; ?>video?path=/">All Videos</a><br />
 <?php foreach ($PATH_TREE as $path) output_path_picker($path); ?>
</div>

<?php
    foreach ($All_Videos as $video) {
?>
    <div id="<?php echo $video->intid; ?>" class="video" onmouseover="video_popup(this.id)">
        <div id="<?php echo $video->intid; ?>_categoryid" class="hidden"><?php echo $video->category; ?></div>
        <div id="<?php echo $video->intid; ?>_genre" class="hidden"><?php if (count($video->genres)) foreach ($video->genres as $genre) echo ' '.$genre.' ';?></div>
        <div id="<?php echo $video->intid; ?>_browse" class="hidden"><?php echo $video->browse; ?></div>
        <div id="<?php echo $video->intid; ?>-title" class="title"><a href="<?php echo $video->url; ?>"><?php echo htmlentities($video->title); ?></a></div>
        <div id="<?php echo $video->intid; ?>_img">                <img <?php if (show_video_covers && file_exists($video->coverfile)) echo 'src="data/video_covers/'.basename($video->coverfile).'"'; echo ' width="'.video_img_width.'" height="'.video_img_height.'"'; ?> alt="<?php echo t('Missing Cover'); ?>"></div>
        <div id="<?php echo $video->intid; ?>-category">           <?php echo $Category_String[$video->category]; ?></div>
        <div id="<?php echo $video->intid; ?>_playtime">           <?php echo nice_length($video->length * 60); ?></div>
        <div id="<?php echo $video->intid; ?>_imdb">               <?php if ($video->inetref != '00000000') { ?><a href="<?php echo makeImdbWebUrl($video->inetref); ?>"><?php echo $video->inetref ?></a><?php } ?></div>
        <div class="command">
            <span class="commands"><a href="javascript:newWindow('<?php echo root ?>video/edit?intid=<?php echo $video->intid ?>')" ><?php echo t('Edit') ?></a></span>
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
