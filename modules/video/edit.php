<?php
/**
 * Edit MythVideo file information
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 *
 * @package     MythWeb
 * @subpackage  Video
 *
/**/

/** @todo FIXME: this file needs to be rewritten to split out content/display */

header("Content-Type: text/html; charset=utf-8");

//check to see if the form has been submitted
if (isset($_POST['submit'])) {

// Insert data into database
    $sh = $db->query('UPDATE videometadata
                         SET title      = ?,
                             director   = ?,
                             plot       = ?,
                             category   = ?,
                             rating     = ?,
                             inetref    = ?,
                             year       = ?,
                             userrating = ?,
                             length     = ?
                       WHERE intid=?',
                     $_POST['title'],
                     $_POST['director'],
                     $_POST['plot'],
                     $_POST['category'],
                     $_POST['rating'],
                     $_POST['inetref'],
                     $_POST['year'],
                     $_POST['userrating'],
                     $_POST['length'],
                     $_POST['intid']
                    );
// Close window and refresh parent
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
</head>
<body onLoad="refreshParent()"></body>
</html><?php
// We saved, the window is going to close, just exit.
    exit;
}

//get data to prefill form if we're editing an existing entry
    list($intid,$title,$director,$plot,$category,$rating,$inetref,$year,$userrating,$length)
            = $db->query_row('SELECT intid,title,director,plot,category,rating,inetref,year,userrating,length
                                FROM videometadata
                               WHERE intid=?',
                             $_REQUEST['intid']
                            );
//output html form
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Edit Video Info</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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

<form method="post" action="<?php echo root ?>video/edit">
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
        <option <?php if (!isset($category) || $category == 0) echo ' SELECTED' ?> value="0">Uncategorized</option>
        <?php
            $sh = $db->query('SELECT * FROM videocategory');
            while ($cat_data = $sh->fetch_assoc()) {
                echo '<option value="'.$cat_data['intid'].'"';
                if ($category == $cat_data['intid'])
                    echo ' SELECTED';
                echo '>'.html_entities($cat_data['category']).'</option>';
            }
            $sh->finish();
        ?></select></td>
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
