<?php
/***                                                                        ***\
    errors.php                               Last Updated: 2003.08.23 (xris)

    alternate constants for user-invoked errors
    changes error_reporting
    user-defined error handler
\***                                                                        ***/

// Define some easier-to-read error values
    define('FATAL',   E_USER_ERROR);
    define('ERROR',   E_USER_WARNING);
    define('WARNING', E_USER_NOTICE);

// set the error reporting level for this script
    error_reporting(FATAL | ERROR | WARNING | E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR);

// Reconfigure the error handler to use our own routine
    set_error_handler('Error_Handler');

/*
    This user-defined error handler supports the built-in error_reporting()
    function, and is basically just an expansion of the built-in error-
    handling routine.  If it receives a fatal error (E_USER_ERROR or E_ERROR),
    it prints a more reassuring message to the viewer of the page and sends an
    XML-formatted email message to the address stored in Error_Email, which
    is defined in conf.php.
*/
    function Error_Handler ($errno, $errstr, $errfile, $errline, $vars) {
    // Leave early if we haven't requested reports from this kind of error
        if (!($errno & error_reporting())) return;
    // Create a hash of error types, so we can report something meaningful
        $errortype = array (1   =>  'Error',            2    =>  'Warning',
                            4   =>  'Parsing Error',    8    =>  'Notice',
                            16  =>  'Core Error',       64   =>  'Compile Error',
                            128 =>  'Compile Warning',  256  =>  'User Error',
                            512 =>  'User Warning',     1024 =>  'User Notice');
    // Fatal errors should report considerably more detail
        if ($errno == E_USER_ERROR || $errno == E_ERROR) {
        // Generate an xml-based error message that can be emailed to the administrator
            $err  =  '    datetime:  '.date("Y-m-d H:i:s (T)")."\n"
                    ."    errornum:  $errno\n"
                    .'  error type:  '.$errortype[$errno]."\n"
                    ."error string:  $errstr\n"
                    ."    filename:  $filename\n"
                    ."  error line:  $errline\n\n"
                    ."VARIABLES:\n\n";
        // We need to use an output buffer to capture the value of the variables
            if (in_array($errno, array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE))) {
                ob_start();
                print_r($vars);
                $err .= ob_get_contents();
                ob_end_clean();
            }
            $err .= "\n\n";
        // Email the error to the website's error mailbox
            if (strstr(Error_Email, '@')) {
                mail(Error_Email, "FATAL Error in $errfile, line $errline" , $err,
                     'From:  PHP Error <php_errors@'.server_domain.">\n");
            }
        // Print out a nice error page for the user
            echo "<hr><b>Fatal Error</b> at $errfile, line $errline:<BR>$errstr<p>";
            echo "The system administrator has been notified and the problem will be remedied shortly.<hr>";
        // Exit
            exit;
        }
    //otherwise, just report the error
        echo "<hr><b>" . $errortype[$errno] . "</b> at $errfile, line $errline:<BR>$errstr <hr>\n";
    // Email errors, but not warnings
        if (strstr(Error_Email, '@') && ($errno == E_USER_WARNING || $errno == E_WARNING)) {
            mail(Error_Email, "Error in $errfile, line $errline" ,
                 $errortype[$errno] . " at $errfile, line $errline:\n\n$errstr",
                 'From:  PHP Error <php_errors@'.server_domain.">\n");
        }
    }

?>
