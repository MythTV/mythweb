<?
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

	<Link Rel="stylesheet" HRef="<?=theme_dir?>style.css" Type="text/css" Media="screen">

	<title><?=$page_title?></title>

	<script type="text/javascript" src="<?php echo theme_dir?>init.js"></script>
</head>

<body bgcolor="#003060" text="#DEDEDE" link="#3181B4" alink="#CC0000" vlink="#3181B4">

<table width="100%" border="0" cellspacing="2" cellpadding="2">
	<tr>
		<td align="left"><a href="http://www.mythtv.org/"><img src="<?=theme_dir?>img/mythtv-logo.gif" height="110" width="290" border="0" alt="MythTV"></a></td>
		<td valign="bottom" align="center">
			Go To: &nbsp; &nbsp;
			<a href="program_listing.php">MythTV</a>
			&nbsp; | &nbsp;
			<a href="mythmusic.php">MythMusic</a>
			<!--&nbsp; | &nbsp;
			<a href="#">MythWeather</a>-->
		</td>
		<td valign="bottom" align="right">
			<form style="display: inline" action="search.php" method="post">
				<input type="text" name="searchstr" size="15" value="<?php echo $_GET['searchstr']?>">
				&nbsp; <input type="submit" class="submit" value="search">
				&nbsp; <a href="search.php">[advanced]</a>
			</form>
		</td>
	</tr>
	<tr>
		<td colspan="3" class="menu menu_border_t menu_border_b">
			<table class="body" width="100%" border="0" cellspacing="2" cellpadding="2">
				<tr>
					<td><?php $this->print_menu_content() ?></td>
					<td align="right"><?=date(longdate_format, time())?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?
	}

	function print_menu_content() {
		?>MythTV: &nbsp; &nbsp;
				<a href="program_listing.php">Listings</a>
				<?/*&nbsp; | &nbsp;
				<a href="search.php?category=movie">Movies</a>
				&nbsp; | &nbsp;
				<a href="index.php?mode=favourites">Favourites</a>*/?>
				&nbsp; | &nbsp;
				<a href="scheduled_recordings.php">Scheduled Recordings</a>
				&nbsp; | &nbsp;
				<a href="recorded_programs.php">Recorded Programs</a><?php
		# really should move the category_legend footnote to this section,
		# so it doesn't render in other sections
	}

	function print_footer() {
/*?>
<p align="center">
<font size="-1">MythWeb is part of the <a href="http://www.mythtv.org">MythTV</a> Project</font>
</p>

<?*/
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
<?
	}
}


?>
