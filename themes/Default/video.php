<?php
/***                                                                        ***\
    video.php                               Last Updated: 2004.05.24 (bobc)

\***                                                                        ***/

class Theme_video extends Theme {

    function print_page() {
    // Print the main page header
        parent::print_header("MythWeb - Videos");
    // Print the page contents
        global $All_Shows;
        global $videodir;
?>

<SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT">
<!--Hide script from old browsers

function newWindow(newContent)
 {
  winContent = window.open(newContent, 'nextWin', 'right=0, top=20,width=350,height=410, toolbar=no,scrollbars=no, resizable=yes')         
 }

 //Stop hiding script from old browsers -->
 </SCRIPT>

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
<?php   if (show_recorded_pixmap) { ?>
    <td>cover</td>
<?php   } ?>
    <td><a href="video.php?sortby=title">title</a></td>
    <td><a href="video.php?sortby=director">director</a></td>
    <td>plot</td>
    <td>rating</a></td>
    <td>IMDB</a></td>
    <td><a href="video.php?sortby=length">length</a></td>
    <td><a href="video.php?sortby=userrating">imdb&nbsp;rating</a></td>
    <td><a href="video.php?sortby=year">year</a></td>
    <td>Edit</a></td>
</tr><?php
    $row = 0;
    foreach ($All_Shows as $show) {
    ?><tr class="recorded">
    <td><?php
        if (show_recorded_pixmaps) {
            if (file_exists(video_img_path.'/'.basename($show->coverfile)))
                echo '<a href="'.videos_url.'/'.rawurlencode(substr($show->filename,strlen($videodir)+1)).'">.<img id="'.$show->filename."\" src=\"".video_img_path.'/'.basename($show->coverfile).'" width="'.video_img_width.'" height="'.video_img_height.'">';
            else
                echo '&nbsp;';
        }
    ?></td>
    <td><?php echo '<a 
href="'.videos_url.'/'.rawurlencode(substr($show->filename,strlen($videodir)+1)).'">'."$show->title".'</a>'?></td>
    <td><?php echo $show->director?></td>
    <td><?php echo $show->plot?></td>
    <td><?php echo $show->rating?></td>
    <td><a href="http://www.imdb.com/Title?<?php echo $show->inetref?>"><?php echo $show->inetref?></a></td>
    <td nowrap><?php echo nice_length(($show->length*60))?></td>
    <td nowrap><?php echo $show->userrating?></td>
    <td nowrap><?php echo $show->year?></td>
    <td><a href="javascript:newWindow ('video_edit.php?intid=<?php echo $show->intid?>')" >Edit</a> 
<?php
        $row++;
    }
?>

</table>
<?php
    echo '<p align="right" style="padding-right: 75px">'.$row.' videos</p>';

    // Print the main page footer
        parent::print_footer();
    }

    function print_menu_content() {
        echo 'MythVideo';
    }
}

?>
