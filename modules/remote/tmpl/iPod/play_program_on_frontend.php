<?php
/**
 *
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/modules/_shared/tmpl/default/welcome.php $
 * @date        $Date: 2008-02-09 18:36:08 -0800 (Sat, 09 Feb 2008) $
 * @version     $Revision: 15879 $
 * @author      $Author: kormoc $
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - ' . t('Play Recording on Frontend');

    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/ListPanel.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<ul class="ListPanel">
    <?php
        foreach (MythFrontend::findFrontends() as $frontend)
            echo '<li><a href="'.root.'/remote/play_program_on_frontend?host='.urlencode($frontend->getHost()).'&chanid='.urlencode($chanid).'&starttime='.urlencode($starttime).'">'.$frontend->getHost().'</a>';
    ?>
</ul>


<?php
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
