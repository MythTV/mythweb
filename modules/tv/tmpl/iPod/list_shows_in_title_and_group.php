<?php
/**
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/modules/tv/tmpl/default/list.php $
 * @date        $Date: 2008-06-21 17:31:37 -0700 (Sat, 21 Jun 2008) $
 * @version     $Revision: 17555 $
 * @author      $Author: kormoc $
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
        if (is_array($SubTitles)) {
            foreach ($SubTitles as $subtitle) {
                echo '<li><a href="'.root.'/tv/detail/'.urlencode($subtitle[1]).'/'.urlencode($subtitle[2]).'">'.$subtitle[0]."\n";
            }
        }
    ?>
</ul>

<?php
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
