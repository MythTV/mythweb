<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

/*  So the order we do things is the following:
   If the user is attempting to reset the template, use that value
   Else the cookie is set, use it's value
   Else try to auto-detect mobile or non-js/image browser
   If that fails, use the stored session default
*/

// Figure out the template
    $tmpl = $_SESSION['tmpl'];

    if (isset($_REQUEST['RESET_TMPL']))
        $tmpl = _or($_REQUEST['RESET_TMPL'], 'default');
    elseif (isset($_REQUEST['RESET_TEMPLATE']))
        $tmpl = _or($_REQUEST['RESET_TEMPLATE'], 'default');
    elseif (isMobileUser())
        $tmpl = 'wap';
    elseif (preg_match('/^(Lynx|ELinks)/i', $_SERVER['HTTP_USER_AGENT']))
        $tmpl = 'lite';

    if (!file_exists(modules_path.'/_shared/tmpl/'.$tmpl.'/welcome.php'))
        $tmpl = 'default';

// Figure out the skin
    $skin = $_SESSION['skin'];

    if (isset($_REQUEST['RESET_SKIN']))
        $skin = _or($_REQUEST['RESET_SKIN'], 'default');
    elseif (isMobileUser())
        $skin = 'wap';

    if (!file_exists('skins/'.$skin.'/img/'))
        $skin = 'default';

// We do want to over-ride the template for some paths.
// We do this after setting because certain templates
// Should never be stored as the normal end-user view
    if ($Path[0] == 'rss' || $Path[0] == 'ical')
        $tmpl = $Path[0];

// And now we define the paths
    define('skin',          $skin );
    define('skin_url',      root_url.'skins/'.skin.'/' );
    define('skin_img_url',  skin_url.'img/' );

    define('tmpl',          $tmpl );
    define('tmpl_dir',      'modules/'.module.'/tmpl/'.tmpl.'/' );
