<?php
/**
 * Display tailored error messages about setup problems, etc.
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

/**
 * Show one of the tailored error pages.
 *
 * @param string $error The error template page to load
/**/
    function tailored_error($error) {
        require_once "modules/_errors/tmpl/$error.php";
        exit;
    }

/**
 * Show the generic error page with a custom message.
 *
 * @param string $title  Page title.
 * @param string $header String for the error header.
 * @param string $text   Error text.
/**/
    function custom_error($text, $header='Error', $title='Error') {
        require_once 'modules/_errors/tmpl/error.php';
        exit;
    }