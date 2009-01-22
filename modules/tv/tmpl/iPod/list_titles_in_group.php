<?php
/**
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
/**/

// Set the desired page title
    $page_title = 'MythWeb - ' . t('Recording Titles');

    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/ListPanel.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<ul class="ListPanel">
    <?php
        if (is_array($Titles)) {
            foreach ($Titles as $title) {
                echo '<li><a href="'.root.'/tv/list_shows_in_title_and_group/?group='.urlencode($group).'&title='.urlencode($title[0]).'">'.$title[0].($title[1] > 1 ? " ({$title[1]})" : '')."\n";
            }
        }
    ?>
</ul>

<?php
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
?>
