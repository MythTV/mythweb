<?php
/***                                                                        ***\
    video_edit.php                  Last Updated: 2005.06.06 (xris)

    edit video info
\***                                                                        ***/

#### this file needs to be rewritten to live in a theme!!!


// Which section are we in?
    define('section', 'video');

// Initialize the script, database, etc.
    require_once "includes/init.php";

?>
<script language="JavaScript">
<!--
function refreshParent() {
  window.opener.location.href = window.opener.location.href;

  if (window.opener.progressWindow) {
    window.opener.progressWindow.close()
  }
  window.close();
}
//-->
</script>
<?php
//check to see if the form has been submitted
if (isset($_POST['submit'])) {

      //insert data into database
      mysql_query('UPDATE videometadata SET'
                 .' title='    .escape($_POST['title'])     .','
                 .'director='  .escape($_POST['director'])  .','
                 .'plot='      .escape($_POST['plot'])      .','
                 .'category='  .escape($_POST['category'])  .','
                 .'rating='    .escape($_POST['rating'])    .','
                 .'inetref='   .escape($_POST['inetref'])   .','
                 .'year='      .escape($_POST['year'])      .','
                 .'userrating='.escape($_POST['userrating']).','
                 .'length='    .escape($_POST['length'])
                 .' WHERE intid='.escape($_POST['intid']));
      //close window and refresh parent
      ?><body onLoad="refreshParent()"</body><?php
}

//get data to prefill form if we're editing an existing entry
   $edit_result = mysql_query("SELECT intid,title,director,plot,category,rating,inetref,year,userrating,length FROM videometadata WHERE intid=' {$_REQUEST['intid']}'")
          or trigger_error('SQL Error: '.mysql_error(), FATAL);
     list($intid,$title,$director,$plot,$category,$rating,$inetref,$year,$userrating,$length)=mysql_fetch_array($edit_result);
//output html form
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title text="#DEDEDE">Edit Video Info</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
td,body {
   font-family: Arial, Helvetica, sans-serif;
   font-size: 12px;
}
-->
</style>
</head>

<body bgcolor="#003060" text="#DEDEDE" link="#3181B4" alink="#CC0000" vlink="#3181B4" onclick="hide()">

<p align="center">
<font size="+1">Edit Video Info</font>
</p>

<br />

<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
<table width="302" border="0" cellspacing="0" cellpadding="3">
<tr>
    <td width="99">Title:</td>
    <td width="301"><input name="title" type="text" value="<?php if (isset($title)) print $title ?>"></td>
</tr><tr>
    <td>Director:</td>
    <td><input name="director" type="text" value="<?php if (isset($director)) print $director ?>"></td>
</tr><tr>
    <td>Plot:</td>
    <td><textarea name="plot" rows="5" cols="30" wrap="VIRTUAL"><?php if (isset($plot)) print $plot ?></textarea></td>
</tr><tr>
    <td>Category:</td>
    <td><select name="category">
       <option <?php if (!(isset($category)) || ($category == 0)) print "selected" ?> value="0">Uncategorized</option>
       <?php
       $result = mysql_query('SELECT * FROM videocategory')
            or trigger_error('SQL Error: '.mysql_error(), FATAL);
           while( $cat_data = mysql_fetch_assoc($result) )  {
      ?><option <?php if ($category == $cat_data["intid"]) print "selected" ?> value="<?php print $cat_data["intid"] ?>"><?php print $cat_data["category"] ?></option>
       <?php }
   ?></td>
</tr><tr>
    <td>Rating:</td>
    <td><input name="rating" type="text" value="<?php if (isset($rating)) print $rating ?>"></td>
</tr><tr>
    <td>IMDB:</td>
    <td><input name="inetref" type="text" value="<?php if (isset($inetref)) print $inetref ?>"></td>
</tr><tr>
    <td>Year:</td>
    <td><input name="year" type="text" size=4 value="<?php if (isset($year)) print $year ?>"></td>
</tr><tr>
    <td>Userrating:</td>
    <td><input name="userrating" type="text" size=3 value="<?php if (isset($userrating)) print $userrating ?>"></td>
</tr><tr>
    <td>Length:</td>
    <td><input name="length" type="text" size=3 value="<?php if (isset($length)) print $length ?>"> in minutes</td>
</tr><tr>
    <td></td>
    <td><input type="hidden" name="intid" value="<?php if (isset($_REQUEST['intid'])) print $_REQUEST['intid'] ?>">
       <input type="submit" name="submit" value="submit"></td>
</tr>
</table>

</form>

</body>
</html>
