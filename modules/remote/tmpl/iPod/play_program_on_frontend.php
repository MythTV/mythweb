<?php
/**
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
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
