<?php
/***                                                                        ***\
    video.php                               Last Updated: 2004.05.30 (xris)

\***                                                                        ***/

class Theme_video extends Theme {

    function print_page() {
    // Print the main page header
        parent::print_header("MythWeb - Videos");
    // Print the page contents
        global $All_Shows;
        global $Category_String;
        global $Total_Categories;
        global $Filter_Category;
        global $videodir;
        global $sortby;
        global $reverse;
?>

<SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT">
<!--Hide script from old browsers

function newWindow(newContent)
 {
  winContent = window.open(newContent, 'nextWin', 'right=0, top=20,width=350,height=440, toolbar=no,scrollbars=no, resizable=yes')
 }

 //Stop hiding script from old browsers -->
 </SCRIPT>
<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
<td>
<?php
    echo "<form action=\"video.php\" method=\"GET\">\n";
    echo "Display: ";
    echo "<select name=\"category\">\n";
    echo "<option value=-1 ";
    if( $Filter_Category == -1)
        echo "selected";
    echo ">All</option>\n";
    for($i=0;$i<=$Total_Categories;$i++) {
        echo "<option value=$i ";
        if( $i == $Filter_Category )
            echo "selected";
        echo ">"; 
        echo "$Category_String[$i]</option>\n";
    }
    echo "</select>\n";
    echo "<input TYPE=\"SUBMIT\" VALUE=\"Update\" >";
    echo "</form>\n";
?>
</td>
</tr>
</table>

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
<?php   if (show_recorded_pixmap) { ?>
    <td>cover</td>
<?php   } ?>
    <td><a href="video.php?sortby=title">title</a></td>
    <td><a href="video.php?sortby=director">director</a></td>
    <td>plot</td>
    <td><a href="video.php?sortby=category">category</a></td>
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
        if (show_recorded_pixmaps && file_exists(video_img_path.'/'.basename($show->coverfile)))
            echo '<a href="'.$show->url.'">.<img id="'.htmlentities($show->filename).'" src="'.video_img_path.'/'.basename($show->coverfile).'" width="'.video_img_width.'" height="'.video_img_height.'">';
        else
            echo '&nbsp;';
    ?></td>
    <td><?php echo '<a href="'.$show->url.'">'.htmlentities($show->title, ENT_COMPAT, 'UTF-8').'</a>'?></td>
    <td><?php echo $show->director?></td>
    <td><?php echo $show->plot?></td>
    <td><?php echo $Category_String[$show->category]?></td>
    <td><?php echo $show->rating?></td>
    <td><a href="http://www.imdb.com/Title?<?php echo $show->inetref?>"><?php echo $show->inetref?></a></td>
    <td nowrap><?php echo nice_length($show->length * 60) ?></td>
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
        if($_GET['sortby'])
            $new_sortby = $_GET['sortby'];
        if ( $_GET['reverse'] == 1 )  {
            $new_reverse = 0;
        } else  {
            $new_reverse = 1;
        }
        if ( $_GET['category'] ) 
            $new_cat = $_GET['category'];    
       
        echo 'MythVideo:';
        echo "&nbsp; &nbsp;";
        echo "<a href=\"video.php?reverse=$new_reverse";
        if($new_sortby)
            echo "&sortby=$new_sortby";
        if($new_cat)
            echo "&category=$new_cat";
        echo "\">";
        echo "Reverse Order";
        echo "</a>";
    }
}

?>
