<?php
/***                                                                        ***\
    video_edit.php                  Last Updated: 2005.01.23 (xris)

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
      mysql_query("UPDATE videometadata SET title='{$_POST['title']}',director='{$_POST['director']}',plot='{$_POST['plot']}',rating='{$_POST['rating']}',inetref='{$_POST['inetref']}',year='{$_POST['year']}',userrating='{$_POST['userrating']}',length='{$_POST['length']}' WHERE intid='{$_POST['intid']}'");
      //close window and refresh parent
      ?><body onLoad="refreshParent()"</body><?php
}

//get data to prefill form if we're editing an existing entry
   $edit_result = mysql_query("SELECT intid,title,director,plot,rating,inetref,year,userrating,length FROM videometadata WHERE intid=' {$_REQUEST['intid']}'")
          or trigger_error('SQL Error: '.mysql_error(), FATAL);
     list($intid,$title,$director,$plot,$rating,$inetref,$year,$userrating,$length)=mysql_fetch_array($edit_result);
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

<br>

<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="302" border="0" cellspacing="0" cellpadding="3">
<tr>
    <td width="99">Title:</td>
    <td width="301"><input name="title" type="text" value="<?if (isset($title)) print $title; ?>"></td>
</tr><tr>
    <td>Director:</td>
    <td><input name="director" type="text" value="<?if (isset($director)) print $director; ?>"></td>
</tr><tr>
    <td>Plot:</td>
    <td><textarea name="plot" rows="5" cols="30" wrap="VIRTUAL"><?if (isset($plot)) print $plot; ?></textarea></td>
</tr><tr>
    <td>Rating:</td>
    <td><input name="rating" type="text" value="<?if (isset($rating)) print $rating; ?>"></td>
</tr><tr>
    <td>IMDB:</td>
    <td><input name="inetref" type="text" value="<?if (isset($inetref)) print $inetref; ?>"></td>
</tr><tr>
    <td>Year:</td>
    <td><input name="year" type="text" size=4 value="<?if (isset($year)) print $year; ?>"></td>
</tr><tr>
    <td>Userrating:</td>
    <td><input name="userrating" type="text" size=3 value="<?if (isset($userrating)) print $userrating; ?>"></td>
</tr><tr>
    <td>Length:</td>
    <td><input name="length" type="text" size=3 value="<?if (isset($length)) print $length; ?>"> in minutes</td>
</tr><tr>
    <td></td>
    <td><input type="hidden" name="intid" value="<?if (isset($_REQUEST['intid'])) print $_REQUEST['intid']?>">
       <input type="submit" name="submit" value="submit"></td>
</tr>
</table>

</form>

</body>
</html>
