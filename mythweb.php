<?php
/**
 * The main brain script for all of MythWeb.
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

// Add a custom include path?
    if (!empty($_SERVER['include_path']) && $_SERVER['include_path'] != '.')
        ini_set('include_path', $_SERVER['include_path'].PATH_SEPARATOR.ini_get('include_path'));

// Init
    require_once 'includes/init.php';

// Standard module?  Pass along the
    if ($Modules[$Path[0]]) {
        require_once 'modules/'.$Path[0].'/handler.php';
    }
    elseif (!empty($Path[0]) && preg_match('/\w/', $Path[0])) {
        tailored_error('unknown_module');
    }
    else {
        require_once 'modules/welcome.php';
    }

// Exit gracefully
    exit;

