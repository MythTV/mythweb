<?php
/**
 * Edit MythVideo file information
 *
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
    <link rel="stylesheet" type="text/css" href="<?php echo root_url; ?>dcss/style.css" />
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
        $Video->subtitle    = $_REQUEST['subtitle'];
        $Video->season      = $_REQUEST['season'];
        $Video->episode     = $_REQUEST['episode'];
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

<form method="post" action="<?php echo root_url ?>video/edit" enctype="multipart/form-data">
<?php echo t('Title'); ?><br>
<input name="title" type="text" value="<?php echo htmlspecialchars($Video->title, ENT_QUOTES ); ?>"><br><br>
<?php echo t('Subtitle'); ?><br>
<input name="subtitle" type="text" value="<?php echo htmlspecialchars($Video->subtitle, ENT_QUOTES ); ?>"><br><br>
<?php echo t('Season'); ?><br>
<input name="season" type="text" size="3" value="<?php echo intval($Video->season); ?>"><br><br>
<?php echo t('Episode'); ?><br>
<input name="episode" type="text" size="3" value="<?php echo intval($Video->episode); ?>"><br><br>
<?php echo t('Director'); ?><br>
<input name="director" type="text" value="<?php echo htmlspecialchars($Video->director, ENT_QUOTES ); ?>"><br><br>
<?php echo t('Plot'); ?><br>
<textarea name="plot" rows="5" cols="30" wrap="VIRTUAL"><?php echo htmlspecialchars($Video->plot, ENT_QUOTES ); ?></textarea><br><br>
<?php echo t('Category'); ?><br>
<select name="category">
<option <?php if ($Video->category == 0) echo ' SELECTED'; ?> value="0"><?php echo t('Uncategorized'); ?></option>
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
<?php echo t('Rating'); ?><br>
<input name="rating" type="text" value="<?php echo htmlspecialchars($Video->rating, ENT_QUOTES); ?>"><br><br>
<?php echo t('IMDB'); ?><br>
<input name="inetref" type="text" value="<?php echo htmlspecialchars($Video->inetref, ENT_QUOTES); ?>"><br><br>
<?php echo t('Year'); ?><br>
<input name="year" type="text" size="4" value="<?php echo htmlspecialchars($Video->year, ENT_QUOTES); ?>"><br><br>
<?php echo t('User Rating'); ?><br>
<input name="userrating" type="text" size="3" value="<?php echo htmlspecialchars($Video->userrating, ENT_QUOTES); ?>"><br><br>
<?php echo t('Length in minutes'); ?><br>
<input name="length" type="text" size="3" value="<?php echo htmlspecialchars($Video->length, ENT_QUOTES); ?>"><br><br>
<?php echo t('Browsable'); ?><br>
<select name="browse">
 <option value="0" <?php if ($Video->browse == 0) echo ' SELECTED'; ?>><?php echo t('No'); ?></option>
 <option value="1" <?php if ($Video->browse == 1) echo ' SELECTED'; ?>><?php echo t('Yes'); ?></option>
</select><br><br>
<?php echo t('Parental Level'); ?><br>
<select name="showlevel">
 <option value="1" <?php if ($Video->showlevel == 1) echo ' SELECTED'; ?>><?php echo t('1 - Lowest'); ?></option>
 <option value="2" <?php if ($Video->showlevel == 2) echo ' SELECTED'; ?>>2</option>
 <option value="3" <?php if ($Video->showlevel == 3) echo ' SELECTED'; ?>>3</option>
 <option value="4" <?php if ($Video->showlevel == 4) echo ' SELECTED'; ?>><?php echo t('4 - Highest'); ?></option>
</select><br><br>
<?php echo t('Cover Image'); ?><br>
<input type="file" name="coverfile"><br><br>
<input type="hidden" name="intid" value="<?php echo $_REQUEST['intid']; ?>">
<input class="submit" type="submit" name="submit" value="<?php echo t('Submit'); ?>">

</form>

</body>
</html>
