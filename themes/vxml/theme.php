<?php
/***                                                                        ***\
    theme.php                             Last Updated: 2003.08.19 (xris)

    This is the main theme class for the Default MythWeb theme.  It should
    not be instantiated directly, but will most likely contain methods
    called from its child classes via the parent:: construct.
\***                                                                        ***/

class Theme {

    function print_header($page_title = 'MythWeb') {
// Print the appropriate header information
    header("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">

    <Link Rel="stylesheet" HRef="<?php echo theme_dir ?>style.css" Type="text/css" Media="screen">
</head>

<body bgcolor="#003060" text="#DEDEDE" link="#3181B4" alink="#CC0000" vlink="#3181B4">

<center><img src="<?php echo theme_dir ?>img/mythtv-logo.gif" border="0" alt="MythTV" style="behavior: url('<?php echo theme_dir ?>pngbehavior.htc');"><br />
    <?php echo $this->print_menu_content() ?>
</center><br />
<form action="search.php" method="post">
        <center><input type="text" name="searchstr" value="<?php echo $_GET['searchstr'] ?>"><br />
        <input type="submit" class="submit" value="search"></center><br />
        <!--a href="search.php">[advanced]</a><br-->
    </form>
<?php
    }

    function print_menu_content() {
        ?>
                <a href="program_listing.php">Listings</a><br />
                <a href="scheduled_recordings.php">Scheduled</a><br />
                <a href="recorded_programs.php">Recorded</a><br />
<?php
    }

    function print_footer() {
/* ?>
<p align="center">
<font size="-1">MythWAP is part of the <a href="http://www.mythtv.org">MythTV</a> Project</font>
</p>

<?php */
// Display footnotes
    global $Footnotes;
    if (is_array($Footnotes)) {
        foreach ($Footnotes as $note) {
            echo $note;
        }
    }
?>


</body>
</html>
<?php
    }
}

