<?php
/**
 * Welcome page that lists the available mythweb sections
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Default requested view
    if (empty($_REQUEST['view_module']) || !Modules::getModule($_REQUEST['view_module']))
        $_REQUEST['view_module'] = 'tv';

// Not really much to do here but print the list of modules
    require 'modules/_shared/tmpl/'.tmpl.'/welcome.php';
