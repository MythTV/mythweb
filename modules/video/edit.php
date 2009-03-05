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
        $Video->showlevel   = $_REQUEST['showlevel'];
        $Video->browse      = $_REQUEST['browse'];
        if (is_uploaded_file($_FILES['coverfile']['tmp_name'])) {
            $filename = setting('VideoArtworkDir', hostname).'/id-'.$_REQUEST['intid'].'.jpg';
            move_uploaded_file($_FILES['coverfile']['tmp_name'], $filename);
            chmod($filename, 0644); // make cover file readable by other users
            $Video->cover_file = $filename;
        }
        $Video->save();
        ?>
        <script type="text/javascript">
        <!--Hide script from old browsers
            parent.update_video('<?php echo $_REQUEST['intid']; ?>');
            parent.$('window').hide();
        //Stop hiding script from old browsers -->
        </script>
        <?php
    }

?>

</head>
<body>

<form method="post" action="<?php echo root ?>video/edit" enctype="multipart/form-data">
Title<br>
<input name="title" type="text" value="<?php echo htmlspecialchars($Video->title, ENT_QUOTES ); ?>"><br><br>
Director<br>
<input name="director" type="text" value="<?php echo htmlspecialchars($Video->director, ENT_QUOTES ); ?>"><br><br>
Plot<br>
<textarea name="plot" rows="5" cols="30" wrap="VIRTUAL"><?php echo htmlspecialchars($Video->plot, ENT_QUOTES ); ?></textarea><br><br>
Category<br>
<select name="category">
<option <?php if ($Video->category == 0) echo ' SELECTED'; ?> value="0">Uncategorized</option>
<?php
    $sh = $db->query('SELECT * FROM videocategory');
    while ($cat_data = $sh->fetch_assoc()) {
        echo '<option value="'.$cat_data['intid'].'"';
        if ($Video->category == $cat_data['intid'])
            echo ' SELECTED';
        echo '>'.html_entities($cat_data['category']).'</option>';
    }
    $sh->finish();
?></select><br><br>
Rating<br>
<input name="rating" type="text" value="<?php echo htmlspecialchars($Video->rating, ENT_QUOTES); ?>"><br><br>
IMDB<br>
<input name="inetref" type="text" value="<?php echo htmlspecialchars($Video->inetref, ENT_QUOTES); ?>"><br><br>
Year<br>
<input name="year" type="text" size="4" value="<?php echo htmlspecialchars($Video->year, ENT_QUOTES); ?>"><br><br>
User Rating<br>
<input name="userrating" type="text" size="3" value="<?php echo htmlspecialchars($Video->userrating, ENT_QUOTES); ?>"><br><br>
Length in minutes<br>
<input name="length" type="text" size="3" value="<?php echo htmlspecialchars($Video->length, ENT_QUOTES); ?>"><br><br>
Browsable<br>
<select name="browse">
 <option value="0" <?php if ($Video->browse == 0) echo ' SELECTED'; ?>>No</option>
 <option value="1" <?php if ($Video->browse == 1) echo ' SELECTED'; ?>>Yes</option>
</select><br><br>
Parental Level<br>
<select name="showlevel">
 <option value="1" <?php if ($Video->showlevel == 1) echo ' SELECTED'; ?>>1 - Lowest</option>
 <option value="2" <?php if ($Video->showlevel == 2) echo ' SELECTED'; ?>>2</option>
 <option value="3" <?php if ($Video->showlevel == 3) echo ' SELECTED'; ?>>3</option>
 <option value="4" <?php if ($Video->showlevel == 4) echo ' SELECTED'; ?>>4 - Highest</option>
</select><br><br>
Cover Image<br>
<input type="file" name="coverfile"><br><br>
<input type="hidden" name="intid" value="<?php echo $_REQUEST['intid']; ?>">
<input class="submit" type="submit" name="submit" value="submit">

</form>

</body>
</html>
