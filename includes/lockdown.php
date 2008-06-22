<?php
/**
 * To attempt to curve the massive amounts of (unintentionally) open mythweb installs, we are attempting to
 * protect the users by having a automatic lockdown if we detect a 'bot' or if it's specifically requested by a user
 *
 * You can disable this feature with the apache env var of MYTHWEB_LOCKDOWN_DISABLE being set to true
 *
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/includes/lockdown.php $
 * @date        $Date: 2008-03-07 16:21:55 -0800 (Fri, 07 Mar 2008) $
 * @version     $Revision: 16436 $
 * @author      $Author: kormoc $
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

    if ($_SERVER['MYTHWEB_LOCKDOWN_DISABLE'] != true) {
        if (   stristr('bot',     $_SERVER['HTTP_USER_AGENT']) !== false
            || stristr('spider',  $_SERVER['HTTP_USER_AGENT']) !== false
            || stristr('crawler', $_SERVER['HTTP_USER_AGENT']) !== false
            || stristr('search',  $_SERVER['HTTP_USER_AGENT']) !== false
            || stristr('yahoo',   $_SERVER['HTTP_USER_AGENT']) !== false
            || isset($_GET['TRIGGER_MYTHWEB_LOCKDOWN'])
           )
            touch('lockdown');
    }

    if (   $_SERVER['MYTHWEB_LOCKDOWN_DISABLE'] != true && file_exists('lockdown'))
        tailored_error('lockdown');
