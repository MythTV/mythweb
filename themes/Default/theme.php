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

	<Link Rel="stylesheet" HRef="<?=theme_dir?>style.css" Type="text/css" Media="screen">

	<title><?=$page_title?></title>

	<script type="text/javascript" src="<?php echo theme_dir?>init.js"></script>
</head>

<body bgcolor="#003060" text="#DEDEDE" link="#3181B4" alink="#CC0000" vlink="#3181B4">

<p>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
<tr>
	<td rowspan="2" width="300" align="center" valign="top"><a href="http://www.mythtv.org"><img src="<?=theme_dir?>img/mythtv-logo.png" height="110" width="290" border="0" alt="MythTV" style="behavior: url('<?=theme_dir?>pngbehavior.htc');"></a></td>
	<td colspan="2" align="right"><table border="0" cellspacing="2" cellpadding="2" style="padding-right: 10px">
		<tr>
<?
//	Work in a random quote (anybody got more of these?)
	$quote = array();
	switch(rand(1,5)) {
		case 1:
			$quote['text']   = "Basically, I want the mythical convergence box that's been talked about for a few years now.";
			$quote['author'] = "Isaac Richards";
			break;
		case 2:
			$quote['text']   = "Anytime you skip a commercial ... you're actually stealing the programming.";
			$quote['author'] = "Jamie Kellner (CEO, Turner Broadcasting)";
			break;
		case 3:
			$quote['text']   = "I say to you that the VCR is to the ... American public as the Boston strangler is to the woman home alone.";
			$quote['author'] = "Jack Valenti";
			break;
		case 4:
			$quote['text']   = "I am becoming more and more convinced that intellectual property is on a collision course with personal liberty.";
			$quote['author'] = "Posted on Slashdot";
			break;
		case 5:
			$quote['text']   = "I think that consumers just won't buy devices that don't let them do what they want to do.";
			$quote['author'] = "Linus Torvalds";
			break;
	}
?>
			<td><i><?=$quote['text']?></i></td>
		</tr><tr>
			<td colspan="2" align="right"><small>- <?=$quote['author']?></small></td>
		</tr>
		</table></td>
</tr><tr>

	<td valign="bottom"><table width="100%" border="0" cellspacing="2" cellpadding="2">
		<tr align="center">
			<td valign="top"><?php echo _LANG_GO_TO?>: &nbsp; &nbsp;
				<a href="program_listing.php">MythTV</a>
				&nbsp; | &nbsp;
				<a href="mythmusic.php">MythMusic</a>
				&nbsp; | &nbsp;
				<a href="video.php">MythVideo</a>
				&nbsp; | &nbsp;
				<a href="settings.php"><?php echo _LANG_SETTINGS?></a>
				<!--&nbsp; | &nbsp;
				<a href="#">MythWeather</a>--></td>



			<td align="right">
				<form action="search.php" method="post">
				<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><input type="text" name="searchstr" size="15" value="<?php echo $_GET['searchstr']?>"></td>
					<td>&nbsp; <input type="submit" class="submit" value="<?php echo _LANG_SEARCH?>"></td>
				</tr>
				<tr>
					<td align="right" colspan=3>&nbsp; <a href="search.php">[<? echo _LANG_ADVANCED?>]</a></td>
				<tr>
				</table>
				</form></td>

		</tr>
		</table></td>
</tr><tr>

	<td colspan="2" class="menu menu_border_t menu_border_b"><table class="body" width="100%" border="0" cellspacing="2" cellpadding="2">
		<tr>
			<td><?php $this->print_menu_content() ?></td>
			<td align="right"><?php echo date($_SESSION['date_statusbar'], time())?></td>
		</tr>
		</table></td>

</tr>
</table>
</p>
<?
	}

	function print_menu_content() {
		?><a id="category_legend" onmouseover="show('category_legend');return true;" onmouseout="hide();return true;">MythTV:</a> &nbsp; &nbsp;
				<a href="program_listing.php"><?php echo _LANG_LISTINGS?></a>
				&nbsp; | &nbsp;
				<a href="search.php?searchstr=<?php echo movie_word?>&search_category_type=yes"><?php echo movie_word?>s</a>
				<?/*&nbsp; | &nbsp;
				<a href="index.php?mode=favourites"><?php echo _LANG_FAVOURITES?></a>*/?>
				&nbsp; | &nbsp;
				<a href="recording_schedules.php"><?php echo _LANG_RECORDING_SCHEDULES?></a>
				&nbsp; | &nbsp;
				<a href="scheduled_recordings.php"><?php echo _LANG_SCHEDULED_RECORDINGS?></a>
				&nbsp; | &nbsp;
				<a href="recorded_programs.php"><?php echo _LANG_RECORDED_PROGRAMS?></a>
				&nbsp; | &nbsp;
				<a href="status.php"><?php echo _LANG_BACKEND_STATUS?></a><?php
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

<div id="category_legend_popup" class="hidden">
<table width="400" bgcolor="#003060" border="1" cellpadding="0" cellspacing="0">
<tr>
	<td><table width="400" bgcolor="#003060" class="small" cellpadding="5" cellspacing="5">
		<tr>
			<td colspan="3"><?php echo _LANG_CATEGORY_LEGEND?>:</td><?php
	$categories = array('cat_Action'		=> _LANG_ACTION,
						'cat_Adult'			=> _LANG_ADULT,
						'cat_Animals'		=> _LANG_ANIMALS,
						'cat_Art_Music'		=> _LANG_ART_MUSIC,
						'cat_Business'		=> _LANG_BUSINESS,
						'cat_Children'		=> _LANG_CHILDREN,
						'cat_Comedy'		=> _LANG_COMEDY,
						'cat_Crime_Mystery'	=> _LANG_CRIME_MYSTERY,
						'cat_Documentary'	=> _LANG_DOCUMENTARY,
						'cat_Drama'			=> _LANG_DRAMA,
						'cat_Educational'	=> _LANG_EDUCATIONAL,
						'cat_Food'			=> _LANG_FOOD,
						'cat_Game'			=> _LANG_GAME,
						'cat_Health_Medical'=> _LANG_HEALTH_MEDICAL,
						'cat_History'		=> _LANG_HISTORY,
						'cat_HowTo'			=> _LANG_HOWTO,
						'cat_Horror'		=> _LANG_HORROR,
						'cat_Misc'			=> _LANG_MISC,
						'cat_News'			=> _LANG_NEWS,
						'cat_Reality'		=> _LANG_REALITY,
						'cat_Romance'		=> _LANG_ROMANCE,
						'cat_Science_Nature'=> _LANG_SCIENCE_NATURE,
						'cat_SciFi_Fantasy'	=> _LANG_SCIFI_FANTASY,
						'cat_Shopping'		=> _LANG_SHOPPING,
						'cat_Soaps'			=> _LANG_SOAPS,
						'cat_Spiritual'		=> _LANG_SPIRITUAL,
						'cat_Sports'		=> _LANG_SPORTS,
						'cat_Talk'			=> _LANG_TALK,
						'cat_Travel'		=> _LANG_TRAVEL,
						'cat_War'			=> _LANG_WAR,
						'cat_Western'		=> _LANG_WESTERN,
						'cat_Unknown'		=> _LANG_UNKNOWN,
						'type_movie'		=> _LANG_MOVIES);
	$count = 0;
	foreach ($categories as $cat => $cat_display) {
		// skip no display string
		if($cat_display == '')
			continue;
		if ($count++ % 3 == 0)
			echo "\n\t\t</tr><tr>\n";
		echo "\t\t\t<td class=\"$cat\" align=\"center\"><b>$cat_display</b></td>\n";
	}
		?>
		</tr>
		</table></td>
</tr>
</table>
</div>

</body>
</html>
<?
	}
}


?>
