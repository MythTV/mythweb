<?php
/**
 * Show recommended results
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Recommended');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_search.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

?>

<table id="search_results" class="list small" width="100%" border="0" cellpadding="4" cellspacing="2">
<tr class="menu">
    <th class="x-title"><?php       echo t('Title');       ?></th>
    <th class="x-category"><?php    echo t('Category');    ?></th>
    <th class="x-description"><?php echo t('Description'); ?></th>
    <th class="x-channum"><?php     echo t('Channel');     ?></th>
    <th class="x-airdate"><?php     echo t('Airdate');     ?></th>
    <th class="x-length"><?php      echo t('Length');      ?></th>
</tr>
<?php
	if (count($shows) == 0) {
		?>
		<tr><td colspan=6"><?php echo t('No matches found'); ?></td></tr>
		<tr><td colspan=6"><?php echo t('Please rate more shows to get more results'); ?></td></tr>
		<?php
	}
	foreach ($shows as $show) { ?>
		<tr class="<?php echo $show->css_class ?>" valign="top">
			<td class="x-title <?php echo $show->css_class ?>"><?php
					if ($show->hdtv)
						echo '<span class="hdtv_icon">HD</span>';
					echo '<a href="', root_url, 'tv/detail/', $show->chanid, '/', $show->starttime, '">',
						 $show->title, '</a>';
					if ($show->subtitle)
						echo ': ', $show->subtitle;
				// Print some additional information for movies
					if ($show->category_type == 'movie') {
						$info = array();
						if ($show->airdate > 0)
							$info[] = sprintf('%4d', $show->airdate);
						if (strlen($show->rating) > 0)
							$info[] = "<i>$show->rating</i>";
						if (strlen($show->starstring) > 0)
							$info[] = $show->starstring;
						if (count($info) > 0)
							echo '<br>(', implode(', ', $info), ')';
					}
			
					?></td>
				<td class="x-category"><?php    echo $show->category ?></td>
				<td class="x-description"><?php echo $show->description ?></td>
				<td class="x-channum"><?php     echo $show->channel->channum.' - '.$show->channel->name ?></td>
				<td class="x-airdate"><?php
						echo '<a href="'.root_url.'tv/detail/'.$show->chanid.'/'.$show->starttime.'">'.
							strftime($_SESSION['date_search'], $show->starttime) . '</a>';
						if ($show->extra_showings)
							foreach ($show->extra_showings as $pair) {
								list($chanid, $showtime) = $pair;
								echo '<br><a href="', root_url, 'tv/detail/', $chanid, '/', $showtime, '" class="italic">',
									 strftime($_SESSION['date_search'] ,$showtime);
								if ($chanid != $show->chanid)
									echo ' (', Channel::find($chanid)->callsign, ')';
								echo '</a>';
							}
							?></td>
				<td class="x-length"><?php echo nice_length($show->length) ?></td>
				</tr>
	<?php } ?>
</table>

<?php
// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
