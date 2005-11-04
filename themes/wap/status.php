<?php
/***                                                                        ***\
    status.php                               Last Updated: 2005.02.06 (xris)

    This file defines a theme class for the backend status section.
    It must define one method.   documentation will be added someday.
\***                                                                        ***/

class Theme_status extends Theme {

    function print_page(&$content, $title) {
    // Load this page's custom stylesheet
        $this->headers[] = '<link rel="stylesheet" type="text/css" href="'.theme_dir.'status.css" />';
    // Print the main page header
        parent::print_header($title);
    // Print the page contents
        echo "<div id=\"content_wrapper\">\n"
            .$content
            ."\n</div>";
    // Print the main page footer
        parent::print_footer();
    }

}

