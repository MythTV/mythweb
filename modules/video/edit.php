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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo root; ?>dcss/style.css" />
    <style type="text/css">
    <!--
        body {
           font-family:         Arial, Helvetica, sans-serif;
           font-size:           12px;
           background-color:    green;
           color:               white;
        }

        input, select, textarea {
            width:              90%;
            margin-left:        1em;
        }

    -->
    </style>
<?php
//get data to prefill form if we're editing an existing entry
    $Video = new Video($_REQUEST['intid']);

//check to see if the form has been submitted
    if (isset($_REQUEST['submit'])) {
        $Video->title       = $_REQUEST['title'];
        $Video->director    = $_REQUEST['director'];
        $Video->plot        = $_REQUEST['plot'];
        $Video->category    = $_REQUEST['category'];
        $Video->rating      = $_REQUEST['rating'];
        $Video->inetref     = $_REQUEST['inetref'];
        $Video->year        = $_REQUEST['year'];
        $Video->userrating  = $_REQUEST['userrating'];
        $Video->length      = $_REQUEST['length'];
        $Video->save();
        ?>
        <SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT">
        <!--Hide script from old browsers
            parent.update_video('<?php echo $_REQUEST['intid']; ?>');
        //Stop hiding script from old browsers -->
        </SCRIPT>
        <?php
    }

?>

</head>
<body>

<form method="post" action="<?php echo root ?>video/edit">
Title<br />
<input name="title" type="text" value="<?php echo $Video->title; ?>"><br /><br />
Director<br />
<input name="director" type="text" value="<?php echo $Video->director; ?>"><br /><br />
Plot<br />
<textarea name="plot" rows="5" cols="30" wrap="VIRTUAL"><?php echo $Video->plot; ?></textarea><br /><br />
Category<br />
<select name="category">
<option <?php if ($Video->category == 0) echo ' SELECTED' ?> value="0">Uncategorized</option>
<?php
    $sh = $db->query('SELECT * FROM videocategory');
    while ($cat_data = $sh->fetch_assoc()) {
        echo '<option value="'.$cat_data['intid'].'"';
        if ($Video->category == $cat_data['intid'])
            echo ' SELECTED';
        echo '>'.html_entities($cat_data['category']).'</option>';
    }
    $sh->finish();
?></select><br /><br />
Rating<br />
<input name="rating" type="text" value="<?php echo $Video->rating; ?>"><br /><br />
IMDB<br />
<input name="inetref" type="text" value="<?php echo $Video->inetref; ?>"><br /><br />
Year<br />
<input name="year" type="text" size=4 value="<?php echo $Video->year; ?>"><br /><br />
Userrating<br />
<input name="userrating" type="text" size=3 value="<?php echo $Video->userrating; ?>"><br /><br />
Length in minutes<br />
<input name="length" type="text" size=3 value="<?php echo $Video->length; ?>"><br />
<input type="hidden" name="intid" value="<?php echo $_REQUEST['intid']; ?>"><br />
<input class="submit" type="submit" name="submit" value="submit">

</form>

</body>
</html>
