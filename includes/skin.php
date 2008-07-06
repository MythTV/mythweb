<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
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

// Detect different types of browsers and set the theme accordingly.
    if (isMobileUser()) {
    // Browser is mobile but does it accept HTML?
    // @TODO Need to fail more gracefully...
        $_SESSION['tmpl'] = 'wap';
    // Make sure the skin is set to the appropriate phone-template type
        $_SESSION['skin'] = $_SESSION['tmpl'];
        define('skin', $_SESSION['skin']);
    }
// Force the "lite" template
    elseif ($_REQUEST['RESET_TMPL'] == 'lite' || preg_match('/^(Lynx|ELinks)/i', $_SERVER['HTTP_USER_AGENT']))
        $_SESSION['tmpl'] = 'lite';
// Reset the template?
    elseif ($_REQUEST['RESET_TMPL'] || $_REQUEST['RESET_TEMPLATE'])
        $_SESSION['tmpl'] = 'default';
// If the requested template is missing the welcome file, use the default template
    elseif (!file_exists(modules_path.'/_shared/tmpl/'.$_SESSION['tmpl'].'/welcome.php'))
        $_SESSION['tmpl'] = 'default';

// Deal with people who use the same login for mobile and non-mobile, and might
// have a mobile skin cached.
    if (in_array($_SESSION['skin'], array('wap')))
        $_SESSION['skin'] = 'default';
// Is there a preferred skin?
    elseif (file_exists('skins/'.$_SESSION['skin'].'/img/') && !$_REQUEST['RESET_SKIN'])
        define('skin', $_SESSION['skin']);
    else
        define('skin', 'default');
    $_SESSION['skin'] = skin;

// Set up some handy constants
    define('skin_dir', 'skins/'.skin);
    define('skin_url', root.skin_dir.'/');
    if ($Path[0] == 'rss')
        define('tmpl',     'rss');
    else
        define('tmpl',     $_SESSION['tmpl']);

    define('tmpl_dir', 'modules/'.module.'/tmpl/'.tmpl.'/');
