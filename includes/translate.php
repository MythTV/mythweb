<?php
/***                                                                        ***\
    translate.php                            Last Updated: 2004.11.25 (xris)

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
    // Otherwise, call sprintf with the passed-in parameters
        $a = func_get_args();
        return call_user_func_array('sprintf', $a);
    }

?>