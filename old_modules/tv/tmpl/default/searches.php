<?php
/**
 * Handy predefined searches
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Handy Predefined Searches');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_upcoming.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<div class="normal" style="width: 50em; margin: 0px auto">
    <p>
    <?php echo t('handy: overview') ?>
    </p>

    <ul style="list-style-type: circle">
<?php
    foreach(array_keys($Canned_Searches) as $name ) {
    // We have to clean the link like this or it results in 404 errors from mod_rewrite
        echo '        <li><a href="'.root_url.'tv/search/'.str_replace('%2F', '/', rawurlencode('canned:'.$name)).'">'
            .$name."</a></li>\n";
    }
?>
    </ul>

</div>

<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
