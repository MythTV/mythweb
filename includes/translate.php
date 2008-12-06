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
 * @global  array   $GLOBALS['Languages']
 * @name    $Languages
/**/
    global $Languages;
    $Languages = array();

// Define the languages that mythweb can translate into.  Each hash entry should
// point to an array containing first the user-visible name of the language, the
// php locale for printing and finally the matching language and charset codes.
    $Languages['Catalan']    = array('Catal&agrave;',   'ca_ES.UTF-8', 'ca_ES');
    $Languages['Dutch']      = array('Nederlands',      'nl_NL',       array('nl_NL', 'nl_BE'));
    $Languages['English']    = array('English',         'en_US.UTF-8', 'en_US.ISO-8859-1');
    $Languages['English_GB'] = array('English_GB',      'en_GB.UTF-8', 'en_GB.ISO-8859-1');
    $Languages['French']     = array('Fran&ccedil;ais', 'fr_FR.UTF-8', 'fr_FR');
    $Languages['Japanese']   = array('Japanese',        'ja_JP.UTF-8', 'ja_JP');
    $Languages['Spanish']    = array('Espa&ntilde;ol',  'es_ES.UTF-8', 'es_ES');
    $Languages['Swedish']    = array('Svenska',         'sv_SE.UTF-8', 'sv_SE');
    $Languages['Danish']     = array('Dansk',           'da_DK.UTF-8', 'da_DK');
    $Languages['German']     = array('Deutsch',         'de_DE',       'de_DE');
    $Languages['Slovenian']  = array('Slovensko',       'si_SI',       'sl_SI');
    $Languages['Finnish']    = array('Suomi',           'fi_FI.UTF-8', 'fi_FI');
    $Languages['Czech']      = array('Czech',           'cs_CZ.UTF-8', 'cs_CZ.UTF-8');
    $Languages['Polish']     = array('Polski',          'pl_PL.UTF-8', 'pl_PL');

// Need to detect the language?
    if (empty($_SESSION['language']))
        $_SESSION['language'] = get_browser_lang();
    if (empty($_SESSION['language']))
        $_SESSION['language'] = 'English';

/**
 * @global  array   $GLOBALS['L']
 * @name    $L
/**/
    global $L;
    $L = array();

// Load the primary language file, or English if the other doesn't exist.
    if (file_exists(modules_path.'/_shared/lang/'.$_SESSION['language'].'.lang'))
        load_translation(modules_path.'/_shared/lang/'.$_SESSION['language'].'.lang');
    else
        load_translation(modules_path.'/_shared/lang/English.lang');

// Load a module override translation if one exists.
    if (file_exists(modules_path.'/'.module.'/lang/'.$_SESSION['language'].'.lang'))
        load_translation(modules_path.'/'.module.'/lang/'.$_SESSION['language'].'.lang');
    elseif (file_exists(modules_path.'/'.module.'/lang/English.lang'))
        load_translation(modules_path.'/'.module.'/lang/English.lang');

// No language array defined?
    if (!is_array($L) || !count($L))
        trigger_error('No language strings defined.', FATAL);

// Set the locale
    setlocale(LC_ALL, $Languages[$_SESSION['language']][1]);

/**
 * Returns $str, translated appropriately
/**/
    function t($str /* [, arg1, arg2, argN] */ ) {
        global $L;
    // No string?
        if (!$str)
            return '';
    // No translation for this string?
        if (!isset($L[$str]) && !(int)($str) && $str != '0')
            return "!!NoTrans: $str!!";
    // Parse out anything passed in as an array (usually from tn())
        $args = array();
        if (func_num_args() > 1) {
            $a = func_get_args();
            array_shift($a);    // shift off $str, we don't need it here
            foreach ($a as $arg) {
                if (is_array($arg)) {
                    foreach ($arg as $arg2) {
                        $args[] = $arg2;
                    }
                }
                else
                    $args[] = $arg;
            }
        }
    // Pull in the translated string (or default to $str if the translated string is '')
        if ($L[$str])
            $str = $L[$str];
    // Nothing extra to print
        if (count($args) < 1)
            return $str;
    // Otherwise, parse in replacement strings as needed
        foreach ($args as $i => $arg) {
            $str = preg_replace('/\\$'.($i+1).'\b/',
                                str_replace('$', '~~$~~', $arg),    // Replace $ with ~~$~~ so sub-args don't get reinterpreted
                                $str
                               );
        }
        $str = str_replace('~~$~~', '$', $str);                     // re-convert any ~~$~~ sequences
        return $str;
    }

/**
 * return different translated strings based on the numerical value of int.
 * an optional array of string arguments can be included and will be passed
 * to t() for interpretation.  If no array is passed in, a default will be
 * created using the value of t(int).
/**/
    function tn(/* string1, string2, stringN, int [, array-of-args] */) {
        $a = func_get_args();
    // Array of arguments?
        if (is_array($a[count($a)-1]))
            $args = array_pop($a);
    // Pull off the int
        $int = intVal(array_pop($a));
    // Default parameters to $int
        if (!isset($args))
            $args = array(t($int));
    // Return the appropriate translated string
        if ($a[$int-1])
            return t($a[$int-1], $args);
        return t($a[count($a)-1], $args);
    }

/**
 * Load a translation file into the global translation array
 *
 * @param string $path The path to the translation file
/**/
    function load_translation($path) {
        $file = file_get_contents($path);
    // Error?
        if ($file === false)
            trigger_error("Failed to open translation file:  $path", FATAL);
    // Parse the file
        global $L;
        foreach (preg_split('/\n(?=\S)/', $file) as $group) {
            preg_match('/^([^\n]+?)\s*(?:$|\s*\n(\s+)(.+)$)/s', $group, $match);
            $indent = '';
            $trans  = '';
            if (count($match) == 2)
                list($match, $key) = $match;
            else
                list($match, $key, $indent, $trans) = $match;
        // Cleanup
            $trans = trim(str_replace("\n$indent", "\n", $trans));
            $key   = trim($key);
            if (preg_match('/^["\']/', $key))
                $key = preg_replace('/^(["\'])(.+)\\1$/', '$2', $key);
        // Store
            if ($trans || empty($L[$key]))
                $L[$key] = $trans;
        }
    }

/**
 * The get_browser_lang function is modified from Wouter Verhelst's source.
 * Relevant documentation from his code is included below.
 *
 * accept-to-gettext.inc -- convert information in 'Accept-*' headers to
 * gettext language identifiers.
 * Copyright (c) 2003, Wouter Verhelst <wouter@debian.org>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * Assumptions made:
 * * Charset encodings are written the same way as the Accept-Charset
 *   HTTP header specifies them (RFC2616), except that they're parsed
 *   case-insensitive.
 * * Country codes and language codes are the same in both gettext and
 *   the Accept-Language syntax (except for the case differences, which
 *   are dealt with easily). If not, some input may be ignored.
 * * The language is more important than the charset; i.e., if the
 *   following is given:
 *
 *   Accept-Language: nl-be, nl;q=0.8, en-us;q=0.5, en;q=0.3
 *   Accept-Charset: ISO-8859-15, utf-8;q=0.5
 *
 *   And the supplied parameter contains (amongst others) nl_BE.UTF-8
 *   and nl.ISO-8859-15, then nl_BE.UTF-8 will be picked.
 *
/**/
    function get_browser_lang() {
    // default to "everything is acceptable", as RFC2616 specifies
        $alparts = explode(',', $_SERVER["HTTP_ACCEPT_LANGUAGE"] ? $_SERVER["HTTP_ACCEPT_LANGUAGE"] : '*');
        $acparts = explode(',', $_SERVER["HTTP_ACCEPT_CHARSET"]  ? $_SERVER["HTTP_ACCEPT_CHARSET"]  : '*');
    // Parse the contents of the Accept-Language header.
        $alscores = array();
        foreach($alparts as $part) {
            $part = trim($part);
            if (strstr($part, ';')) {
                $lang  = explode(';', $part);
                $score = explode('=', $lang[1]);
                $alscores[$lang[0]] = $score[1];
            }
            else
                $alscores[$part] = 1;
        }
    // Do the same for the Accept-Charset header. */
        /* RFC2616: ``If no '*' is present in an Accept-Charset field, then
         * all character sets not explicitly mentioned get a quality value of
         * 0, except for ISO-8859-1, which gets a quality value of 1 if not
         * explicitly mentioned.''
         *
         * Making it 2 for the time being, so that we can distinguish between
         * "not specified" and "specified as 1" later on.
         */
        $acscores = array('ISO-8859-1' => 2);
        foreach($acparts as $part) {
            $part = trim($part);
            if (strstr($part, ';')) {
                $cs    = explode(';', $part);
                $score = explode('=', $cs[1]);
                $acscores[strtoupper($cs[0])]=$score[1];
            }
            else
                $acscores[strtoupper($part)]=1;
        }
        if ($acscores['ISO-8859-1'] == 2)
            $acscores['ISO-8859-1'] = $acscores['*'] ? $acscores['*'] : 1;
        /*
         * Loop through the available languages/encodings, and pick the one
         * with the highest score, excluding the ones with a charset the user
         * did not include.
         */
        $curlscore = 0;
        $curcscore = 0;
        $curlang   = null;
        foreach($GLOBALS['Languages'] as $lang => $details) {
            $encodings = is_array($details[2]) ? $details[2] : array($details[2]);
            if (empty($encodings))
                continue;
            foreach ($encodings as $encoding) {
                if (empty($encoding))
                    continue;
                $tmp      = @explode('.', str_replace('_', '-', $encoding));
                $allang   = strtolower($tmp[0]);
                $cs       = strtoupper($tmp[1]);
                $noct     = explode('-', $allang);
                $testvals = array(
                                  array($alscores[$allang],  $acscores[$cs]),
                                  array($alscores[$noct[0]], $acscores[$cs]),
                                  array($alscores[$allang],  $acscores['*']),
                                  array($alscores[$noct[0]], $acscores['*']),
                                  array($alscores['*'],      $acscores[$cs]),
                                  array($alscores['*'],      $acscores['*'])
                                 );
            // Scan through the possible test-match values until we find a valid set
                foreach($testvals as $tval) {
                    if(!isset($tval[0]) || !isset($tval[1]))
                        continue;
                    if($curlscore < $tval[0]) {
                        $curlscore = $tval[0];
                        $curcscore = $tval[1];
                        $curlang   = $lang;
                    }
                    elseif ($curlscore == $tval[0] && $curcscore < $tval[1]) {
                        $curcscore = $tval[1];
                        $curlang   = $lang;
                    }
                    break;
                }
            }
        }
    // Return the language we found
        return $curlang;
    }
