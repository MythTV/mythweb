<?php
/***                                                                        ***\
    canned_searches.php                      Last Updated: 2005.02.28 (xris)

    main configuration index
\***                                                                        ***/

class Theme_canned_searches extends Theme {

    function print_page($searches) {
        parent::print_header("MythWeb - Handy Predefined Searches");
?>

<div class="normal" style="width: 50em; margin: 0px auto">
    <p>
    <?php echo t('handy: overview') ?>
    </p>

    <ul style="list-style-type: circle">
<?php
    foreach(array_keys($searches) as $name ) {
        echo '        <li><a href="search.php?searchstr='.urlencode('canned:'.$name).'">'
            .$name."</a></li>\n";
    }
?>
    </ul>

</div>

<?php
        $this->print_footer();
    }


    function print_footer() {
        parent::print_footer();
    }

}

