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
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/video.css" />';

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
        get_element('window_video_id').innerHTML = id;
        var myAjax = new Ajax.Request('<?php echo root ?>video/imdb',
    	                                 {
    	                                 	method:     'get',
    	                                 	parameters: 'action=lookup&id='+id+'&title='+title,
    	                                 	onComplete: imdb_handler
    	                                 });
    }

    function imdb_handler(response) {
        ajax_remove_request();
        var result = response.responseText;
        if (result == '-1') {
            alert ('<?php echo t('Video: Error: Artwork'); ?>');
            return;
        }
        if (result == '-2') {
            imdb_prompt();
            return;
        }
        if (result == '-3') {
            alert("<?php echo t('Video: Error: IMDB'); ?>");
            return;
        }
        if (result == '1') {
            update_video(get_element('window_video_id').innerHTML);
            return;
        }
        get_element('window_title').innerHTML = 'IMDB Matches';
        var content = get_element('window_content')
        content.innerHTML = '';

        var matches = result.split('\n');
        var line;
        var index = 0;
        while (index < matches.length ) {
            line = matches[index].split(':');
            if (typeof(line[1]) != 'undefined')
                content.innerHTML += '<br /><a href="http://www.imdb.com/Title?'+line[0]+'" style="float: right; margin-left: 1em;">(IMDB)<\/a> <a href="javascript:imdb_select(\''+line[0]+'\')">'+line[1]+'<\/a>';
            index += 1;
        }
        content.innerHTML += '<br /><a href="javascript: imdb_prompt();"><?php echo t('Custom Search'); ?><\/a>';
        remove_class('window', 'hidden');
    }

    function imdb_select(number) {
        ajax_add_request();
        add_class('window', 'hidden');
        var myAjax = new Ajax.Request('<?php echo root; ?>video/imdb',
    	                                 {
    	                                 	method:     'get',
    	                                 	parameters: 'action=grab&id='+get_element('window_video_id').innerHTML+'&number='+number,
    	                                 	onComplete: imdb_handler
    	                                 });
    }

    function imdb_prompt() {
        var number = prompt('<?php echo t('Please enter an imdb number or a title to do another search'); ?>');
        if (typeof(number) != 'string')
            return;
        if (number.length == 0)
            return;
        if (number.match(/^(\d*)$/))
            imdb_select(number);
        else
            imdb_lookup(get_element('window_video_id').innerHTML, number);
    }

    function update_video(id) {
        ajax_add_request();
        get_element('window_video_id').innerHTML = id;
        var myAjax = new Ajax.Request('<?php echo root; ?>video/imdb',
    	                                 {
    	                                 	method:     'get',
    	                                 	parameters: 'action=metadata&id='+id,
    	                                 	onComplete: update_video_result
    	                                 });
    }

    function update_video_result(result) {
        ajax_remove_request();
        var matches = result.responseText.split('\n');
        var line;
        var element;
        for ( index in matches) {
            if (typeof(matches[index]) == 'string') {
                line = matches[index].split('|');
                if (typeof(line[0]) == 'string') {
                    element = get_element('video_'+get_element('window_video_id').innerHTML+'_'+line[0]);
                    if (typeof(element) != 'undefined')
                        element.innerHTML = line[1];
                }
            }
        }
    }

    function filter(str) {
        var container = get_element('videos');
        var id;
        for ( node in container.childNodes ) {
            id = container.childNodes[node].id;
            if (typeof(id) == 'undefined')
                continue;
            if ( get_element(id+'_title').childNodes[0].innerHTML.toLowerCase().match(str.toLowerCase()) )
                remove_class(id, 'hidden');
            else
                add_class(id, 'hidden');
        }
    }
// We use a global var here to keep track of any pending requests so we don't keep repeat them.
    var popup_divs = new Array;

    function video_popup(id) {
        var popup_div = get_element('video_'+id+'_popup');
        if (popup_div == null & popup_divs[id] != true) {
            popup_divs[id] = true;
            var myAjax = new Ajax.Request('<?php echo root; ?>video/imdb',
    	                                 {
    	                                 	method:     'get',
    	                                 	parameters: 'action=extendedmetadata&id='+id,
    	                                 	onComplete: video_create_popup
    	                                 });
        }
        else {
            popup('video_'+id, '');
        }
    }

    function video_create_popup(result) {
        var lines       = result.responseText.split('\n');
        var line        = lines[0].split('|');
        var id          = line[1];
        var index       = 1;
        var popup_div   = document.createElement('div');
        popup_div.id    = 'video_'+id+'_popup';
        popup_div.class = 'popup';
        popup_div.innerHTML = '<dl class="details_list">';
        while (index < lines.length) {
            line = lines[index].split('|');
            if (typeof(line[0]) == 'string' & typeof(line[1]) == 'string') {
                popup_div.innerHTML += '<dt>'+line[0]+'<\/dt><dd>'+line[1]+'<\/dd>';
            }
            index += 1;
        }
        popup_div.innerHTML += '</dl>';
        document.body.appendChild(popup_div);
        popup('video_'+id, '');
    }

//Stop hiding script from old browsers -->
</SCRIPT>

<div id="window" class="hidden">
 <a style="position: absolute; right: 1px; top: 1px;" href="javascript:add_class('window','hidden')">[X]</a>
 <span id="window_video_id" class="hidden"></span>
 <span id="window_video_title" class="hidden"></span>
 <span id="window_title"></span><br />
 <div id="window_content"></div>
</div>

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
<td>
 <form action="<?php echo root; ?>video" method="GET">
  <?php echo t('Display'); ?>:
  <select name="category">
   <option value="-1" <?php if($Filter_Category == -1) echo 'SELECTED'; ?>>All Categories</option>
   <?php
    foreach (array_keys($Category_String) as $i) {
        echo "<option value=\"$i\"";
        if( $i == $Filter_Category )
            echo ' SELECTED';
        echo '>'.html_entities($Category_String[$i])."</option>\n";
    }
   ?>
  </select>&nbsp;&nbsp;
  <select name="genre">
   <option value="-1" <?php if ($Filter_Genre == -1) echo 'SELECTED'; ?>>All Genres</option>
   <?php
    foreach (array_keys($Genre_String) as $i) {
        echo "<option value=\"$i\"";
        if( $i == $Filter_Genre )
            echo ' SELECTED';
        echo '>'.html_entities($Genre_String[$i])."</option>\n";
    }
   ?>
  </select>&nbsp;&nbsp;
  <select name="browse">
   <option value="-1" <?php if ($Filter_Browse == -1) echo 'SELECTED'; ?>>Browse all</option>
   <option value="1"  <?php if ($Filter_Browse ==  1) echo 'SELECTED'; ?>>Browse = yes</option>
   <option value="0"  <?php if ($Filter_Browse ==  0) echo 'SELECTED'; ?>>Browse = no</option>
  </select>&nbsp;&nbsp;
  Title search: <input name="search" value="<?php echo $Filter_Search; ?>" onchange="filter(this.value);" onkeyup="filter(this.value);">
  <input type="submit" value="<?php echo t('Update') ?>">
 </form>
</td>
<td style="text-align: right;">
 <?php echo count($All_Shows).' videos'; ?>
</td>
</tr>
</table>

<div id="videos">

<?php
    foreach ($All_Shows as $show) {
?>
    <div id="video_<?php echo $show->intid; ?>" class="video">
        <div id="video_<?php echo $show->intid; ?>_title" class="title"><a href="<?php echo $show->url; ?>"><?php echo htmlentities($show->title); ?></a></div>
        <div id="video_<?php echo $show->intid; ?>_img">                <img <?php if (show_video_covers && file_exists($show->cover_url)) echo 'src="data/video_covers/'.basename($show->coverfile).'"'; echo ' width="'.video_img_width.'" height="'.video_img_height.'"'; ?> alt="Missing Cover"></div>
        <div id="video_<?php echo $show->intid; ?>_category">           <?php echo $Category_String[$show->category]; ?></div>
        <div id="video_<?php echo $show->intid; ?>_playtime">           <?php echo nice_length($show->length * 60); ?></div>
        <div id="video_<?php echo $show->intid; ?>_imdb">               <?php if ($show->inetref != '00000000') { ?><a href="http://www.imdb.com/Title?<?php echo $show->inetref; ?>"><?php echo $show->inetref ?></a><?php } ?></div>
        <div class="command">
            <span class="commands"><a href="javascript:newWindow('<?php echo root ?>video/edit?intid=<?php echo $show->intid ?>')" ><?php echo t('Edit') ?></a></span>
            <span class="commands"><a href="javascript:imdb_lookup('<?php echo $show->intid ?>','<?php echo urlencode($show->title); ?>')">IMDB</a></span>
        </div>
    </div>
<?php
    }
?>
</div>
<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
