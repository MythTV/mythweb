<?php
/***                                                                        ***\
    translate.php                            Last Updated: 2004.11.26 (xris)

    Basic routines that allow for language translation.
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
    function t($str) {
        global $L;
    // No translation for this string?
        if (!isset($L[$str]))
            return "!!NoTrans: $str!!";
    // Default to the string itself
        if (!$L[$str])
            $L[$str] = $str;
    // Nothing extra to print
        if (func_num_args() == 1)
            return $L[$str];
    // Otherwise, parse in replacement strings as needed
        $str = $L[$str];
        $a = func_get_args();
        array_shift($a);
        foreach ($a as $i => $arg) {
            $str = preg_replace('/(?<!\\\\)\\$'.($i+1).'/',
                                str_replace('$', '\\\\\\$', $arg),  // Replace $ with \$ so sub-args don't get reinterpreted
                                $str
                               );
        }
        $str = preg_replace('/\\\\\\$(?=\d\b)/', '$', $str);        // unescape any \$ sequences
        return $str;
    }

?>