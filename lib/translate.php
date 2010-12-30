<?php
/**
 * Basic routines that allow for language translation.  Please see
 * languages/translations.txt for information about using the translation
 * routines in this library, along with some guidelines of good practice.
 *
 * Language detection is also done here.  If no language preference is
 * present in the session, this library will attempt to detect the
 * preferred language based on the browser's specifications.
 *
 * This file was originally written by Chris Petersen for several different open
 * source projects.  It is distrubuted under the GNU General Public License.
 * I (Chris Petersen) have also granted a special LGPL license for this code to
 * several companies I do work for on the condition that these companies will
 * release any changes to this back to me and the open source community as GPL,
 * thus continuing to improve the open source version of the library.  If you
 * would like to inquire about the status of this arrangement, please contact
 * me personally.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

    function t($string) {
        $args = func_get_args();
        $args = array_slice($args, 1);
        return Translate::find()->string($string, $args);
    }

    function tn($string) {
        $args = func_get_args();
        $args = array_slice($args, 1);
        return Translate::find()->number($string, $args);
    }
