<?php
/***                                                                        ***\
    translate.php                            Last Updated: 2004.11.27 (xris)

    Basic routines that allow for language translation.  Please see
    languages/translations.txt for information about using the translation
    routines in this library, along with some guidelines of good practice.
\***                                                                        ***/

// Load the language file
    if ($_POST['language'])
        $_SESSION['language'] = $_POST['language'];
    if (!file_exists('languages/'.$_SESSION['language'].'.php'))
        $_SESSION['language'] = default_language;
    require_once 'languages/'.$_SESSION['language'].'.php';

// No language array defined?
    if (!is_array($L) || !count($L))
        trigger_error('No language strings defined.', FATAL);

/*
    t:
    returns $str, translated appropriately
*/
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
            $str = preg_replace('/(?<!\\\\)\\$'.($i+1).'/',
                                str_replace('$', '\\\\\\$', $arg),  // Replace $ with \$ so sub-args don't get reinterpreted
                                $str
                               );
        }
        $str = preg_replace('/\\\\\\$(?=\d\b)/', '$', $str);        // unescape any \$ sequences
        return $str;
    }

/*
    tn:
    return different translated strings based on the numerical value of int.
    an optional array of string arguments can be included and will be passed
    to t() for interpretation.
*/
    function tn(/* string1, string2, stringN, int [, array-of-args] */) {
        $a   = func_get_args();
    // Array of arguments?
        if (is_array($a[count($a)-1]))
            $args = array_pop($a);
        else
            $args = array();
    // Pull off the int
        $int = array_pop($a);
    // Return the appropriate translated string
        if ($a[$int-1])
            return t($a[$int-1], $args);
        return t($a[count($a)-1], $args);
    }
?>