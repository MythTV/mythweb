<?php
/***                                                                        ***\
	search.php                    Last Updated: 2004.04.12 (xris)

	This file defines a theme class for the search section.
	It must define one method.   documentation will be added someday.

\***                                                                        ***/

class Theme_search extends Theme {

	function print_page() {
	// Print the main page header
		parent::print_header('MythWeb - Search');
	// Print the advanced search header
?>
<p>
<form action="search.php" method="post">
<table class="command command_border_l command_border_t command_border_b command_border_r" align="center" width="90%" cellspacing="2" cellpadding="2">
<tr>
 	<td align="right"><?php echo _LANG_SEARCH?>:</td>
  	<td><input type="text" name="searchstr" size="15" value="<?php echo $_SESSION['search']['searchstr']?>"></td>
 	<td>&nbsp; <input type="submit" class="submit" value="<?php echo _LANG_SEARCH?>"></td>
  	<td align="right"><input type="checkbox" class="radio" id="search_title" name="search_title" value="1"<?php echo $_SESSION['search']['search_title'] ? ' CHECKED' : ''?>></td>
 	<td onclick="get_element('search_title').checked=get_element('search_title').checked ? false : true;"><a><?php echo _LANG_TITLE?></a></td>
  	<td align="right"><input type="checkbox" class="radio" id="search_subtitle" name="search_subtitle" value="1"<?php echo $_SESSION['search']['search_subtitle'] ? ' CHECKED' : ''?>></td>
 	<td onclick="get_element('search_subtitle').checked=get_element('search_subtitle').checked ? false : true;"><a><?php echo _LANG_SUBTITLE?></a></td>
  	<td align="right"><input type="checkbox" class="radio" id="search_description" name="search_description" value="1"<?php echo $_SESSION['search']['search_description'] ? ' CHECKED' : ''?>></td>
 	<td onclick="get_element('search_description').checked=get_element('search_description').checked ? false : true;"><a><?php echo _LANG_DESCRIPTION?></a></td>
  	<td align="right"><input type="checkbox" class="radio" id="search_category" name="search_category" value="1"<?php echo $_SESSION['search']['search_category'] ? ' CHECKED' : ''?>></td>
 	<td onclick="get_element('search_category').checked=get_element('search_category').checked ? false : true;"><a><?php echo _LANG_CATEGORY?></a></td>
  	<td align="right"><input type="checkbox" class="radio" id="search_category_type" name="search_category_type" value="1"<?php echo $_SESSION['search']['search_category_type'] ? ' CHECKED' : ''?>></td>
 	<td onclick="get_element('search_category_type').checked=get_element('search_category_type').checked ? false : true;"><a><?php echo _LANG_CATEGORY_TYPE?></a></td>
	<td align="right"><input type="checkbox" class="radio" id="search_exact" name="search_exact" value="1"<?php echo $_SESSION['search']['search_exact'] ? ' CHECKED' : ''?>></td>
	<td onclick="get_element('search_exact').checked=get_element('search_exact').checked ? false : true;"><a><?php echo _LANG_EXACT_MATCH ?></a></td>
</tr>
</table>
</form>
</p>
<?php
	// Print any search results
		$this->print_results();
	// Print the main page footer
		parent::print_footer();
	}

	function print_results() {
		global $Results;
	// No search was performed, just return
		if (!is_array($Results))
			return;
	// Search, but nothing found - notify the user
		if (!count($Results)) {
			echo '<p class="huge" align="center">'._LANG_NO_MATCHES_FOUND.'</p>';
			return;
		}

	// Setup for grouping by various sort orders
		$group_field = $_SESSION['search_sortby'];
		if ($group_field == "")
			$group_field = "airdate";
		elseif ( ! (($group_field == "title") || ($group_field == "channum") || ($group_field == "airdate")) )
			$group_field = "";

	// Display the results
?><table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
	<?php if ($group_field != "") { echo "<td>&nbsp;</td>"; } ?>
	<td><a href="search.php?sortby=title"><?php echo _LANG_TITLE?></a></td>
	<td><a href="search.php?sortby=subtitle"><?php echo _LANG_SUBTITLE?></a></td>
	<td><?php echo _LANG_DESCRIPTION?></td>
	<td><a href="search.php?sortby=channum"><?php echo _LANG_STATION?></a></td>
	<td><a href="search.php?sortby=airdate"><?php echo _LANG_AIRDATE?></a></td>
	<td><a href="search.php?sortby=length"><?php echo _LANG_LENGTH?></a></td>
</tr><?php
		$row = 0;

		$prev_group="";
		$cur_group="";

		foreach ($Results as $show) {

			// Print a dividing row if grouping changes
			if ($group_field == "airdate") {
			    $cur_group = date($_SESSION['date_listing_jump'], $show->starttime);
			} elseif ($group_field == "channum") {
				$cur_group = $show->channel->name;
			} elseif ($group_field == "title") {
				$cur_group = $show->title;
			}

			if ( ($cur_group <> $prev_group) && ($group_field <> "") ) { ?>
	<tr class="list_separator">
	<td colspan="9">
		<?=$cur_group?>
		</td>
	</tr><?
			}

	// Print some additional information for movies
	$additional = '';
	if ($show->category_type == 'movie'
	        || $show->category_type == 'Film') {
	    if ($show->airdate > 0)
	            $additional = sprintf('%4d', $show->airdate);
	    if (strlen($show->rating) > 0) {
	        if ($additional)
	            $additional .= ", ";
	        $additional .= "<i>$show->rating</i>";
	    }
	    if (strlen($show->starstring) > 0) {
	        if ($additional)
	            $additional .= ", ";
	        $additional .= $show->starstring;
	    }
	    if ($additional)
	    	$additional = ', (' . $additional . ')';
	}

	// Print the content
	?><tr class="<?php echo $show->class ?>">
	<?php if ($group_field != "") { echo "<td>&nbsp;</td>"; }?>
	<td class="<?php echo $show->class ?>"><?php
		echo '<a href="program_detail.php?chanid='.$show->chanid.'&starttime='.$show->starttime.'">'
			 .$show->title . $additional.'</a>';
		?></td>
	<td><?php echo $show->subtitle?></td>
	<td><?php echo $show->description?></td>
	<td><?php echo $show->channel->name?></td>
	<td nowrap><?php echo date($_SESSION['date_search'], $show->starttime)?></td>
	<td nowrap><?php echo nice_length($show->length)?></td>
</tr><?php
			$prev_group = $cur_group;
			$row++;
		}
?>

</table>
<?php
	}

}

?>
