<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
 *
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/includes/init.php $
 * @date        $Date: 2007-07-28 21:46:51 -0700 (Sat, 28 Jul 2007) $
 * @version     $Revision: 14075 $
 * @author      $Author: xris $
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Detect different types of browsers and set the theme accordingly.
    if (isMobileUser()) {
    // Browser is mobile but does it accept HTML? If not, use the WML theme.
        $_SESSION['tmpl'] = browserAcceptsMediaType(array('text/html', '\*/\*'))
                            ? 'wap'
                            : 'wml';
    // Make sure the skin is set to the appropriate phone-template type
        $_SESSION['skin'] = $_SESSION['tmpl'];
        define('skin', $_SESSION['skin']);
    }
// Reset the template?
    elseif ($_REQUEST['RESET_TMPL'] || $_REQUEST['RESET_TEMPLATE'])
        $_SESSION['tmpl'] = 'default';
// Deal with people who use the same login for mobile and non-mobile, and might
// have a mobile template cached.
    elseif (in_array($_SESSION['tmpl'], array('wap', 'wml'))) {
        $_SESSION['tmpl'] = 'default';
    }
// If the requested template is missing the welcome file, use the default template
    elseif (!file_exists(modules_path.'/_shared/tmpl/'.$_SESSION['tmpl'].'/welcome.php')) {
        $_SESSION['tmpl'] = 'default';
    }

// Deal with people who use the same login for mobile and non-mobile, and might
// have a mobile skin cached.
    if (in_array($_SESSION['skin'], array('wap', 'wml'))) {
        $_SESSION['skin'] = 'default';
    }
// Is there a preferred skin?
    elseif (file_exists('skins/'.$_SESSION['skin'].'/img/') && !$_REQUEST['RESET_SKIN']) {
        define('skin', $_SESSION['skin']);
    }
    else {
        define('skin', 'default');
    }
    $_SESSION['skin'] = skin;

// Set up some handy constants
    define('skin_dir', 'skins/'.skin);
    define('skin_url', root.skin_dir.'/');
    define('tmpl',     $_SESSION['tmpl']);
    define('tmpl_dir', 'modules/'.module.'/tmpl/'.tmpl.'/');
