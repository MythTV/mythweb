<?php
/**
 * Alternate constants for user-invoked errors.
 * Changes error_reporting().
 * User-defined error handler.
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

// Probably already loaded, but it *is* used by this library
    require_once 'includes/errordisplay.php';

// Define some easier-to-read error values
    define('FATAL',   E_USER_ERROR);
    define('ERROR',   E_USER_WARNING);
    define('WARNING', E_USER_NOTICE);

// set the error reporting level for this script
    error_reporting(FATAL | ERROR | WARNING | E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR);

// Reconfigure the error handler to use our own routine
    set_error_handler('Error_Handler');

/**
 * This user-defined error handler supports the built-in error_reporting()
 * function, and is basically just an expansion of the built-in error-
 * handling routine.  If it receives a fatal error (E_USER_ERROR or E_ERROR),
 * it prints a more reassuring message to the viewer of the page and sends an
 * XML-formatted email message to the address stored in error_email, which
 * is defined in conf.php.
/**/
    function Error_Handler ($errno, $errstr, $errfile, $errline, $vars) {
    // Don't die on so-called fatal regex errors
        if (preg_match("/Got error '(.+?)' from regexp/", $errstr, $match)) {
            add_error('Regular Expression Error:  '.$match[1]);
            return;
        }
    // Leave early if we haven't requested reports from this kind of error
        if (!($errno & error_reporting())) return;
    // Create a hash of error types, so we can report something meaningful
        $errortype = array (1   =>  'Error',            2    =>  'Warning',
                            4   =>  'Parsing Error',    8    =>  'Notice',
                            16  =>  'Core Error',       64   =>  'Compile Error',
                            128 =>  'Compile Warning',  256  =>  'User Error',
                            512 =>  'User Warning',     1024 =>  'User Notice');
    // Generate an error message that can be emailed to the administrator
        $err  =  '    datetime:  '.date("Y-m-d H:i:s (T)")."\n"
                .'    errornum:  '.$errno                 ."\n"
                .'  error type:  '.$errortype[$errno]     ."\n"
                .'error string:  '.$errstr                ."\n"
                .'    filename:  '.$errfile               ."\n"
                .'  error line:  '.$errline               ."\n";
    // Fatal errors should report considerably more detail
        if (in_array($errno, array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE))) {
        // We need to use an output buffer to capture the value of the variables
            ob_start();
        // Print a backtrace
            echo "\n==========================================================================\n\n";
            echo "Backtrace: \n\n";
            $backtrace = debug_backtrace();
            array_shift($backtrace);
            foreach ($backtrace as $layer) {
                foreach (array('file', 'line', 'class', 'function', 'type', 'args') as $key) {
                    $val = $layer[$key];
                    echo str_repeat(' ', max(8-strlen($key), 0)), "$key:  ";
                    if (is_array($val) || is_object($val))
                        print_r($val);
                    else
                        echo "$val\n";
                }
                echo "\n";
            }
        // print out some global stuff since we can't print out all of the variables
            if (!empty($_GET)) {
                echo "\n==========================================================================\n\n"
                    .'$_GET: ';
                print_r($_GET);
            }
            if (!empty($_POST)) {
                echo "\n==========================================================================\n\n"
                    .'$_POST: ';
                print_r($_POST);
            }
            if (!empty($_SESSION)) {
                echo "\n==========================================================================\n\n"
                    .'$_SESSION: ';
                print_r($_SESSION);
            }
            if (!empty($_SERVER)) {
                echo "\n==========================================================================\n\n"
                    .'$_SERVER: ';
                print_r($_SERVER);
            }
        ### stupid recursive objects break non-cutting-edge versions of php
            #echo "\n==========================================================================\n\n"
            #    ."vars:\n";
            #print_r($vars);
        // Gather the results into a string
            $err .= ob_get_contents();
            ob_end_clean();
        // Cleanup
            $err = preg_replace('/Array\s+\(\s+\)\n+/', "Array ( )\n", $err);
            $err .= "\n\n";
        // Email the error to the website's error mailbox
            if (strstr(error_email, '@')) {
                mail(error_email,
                     "FATAL Error in $errfile, line $errline",
                     $err,
                     'From:  MythWeb PHP Error <'.error_email.">\n");
            }
        // Print out a nice error page for the user
            echo "<hr><p><b>Fatal Error</b> at $errfile, line $errline:<br />$errstr</p>\n",
                 '<p>If you choose to ',
                 '<a href="https://svn.mythtv.org/trac/newticket" target="_blank">submit a bug report</a>, ',
                 'please make sure to include a<br />',
                 'brief description of what you were doing, along with the following<br />',
                 'backtrace as an attachment (please don\'t paste the whole thing into<br />',
                 "the ticket).\n",
                 "<hr>\n",
                 "<b>Details</b>:<br />\n<pre>", htmlentities($err), '</pre>';
        // Exit
            exit;
        }
    // Otherwise, just report the error
        echo "<hr><p><b>Error</b> at $errfile, line $errline:<br />$errstr</p>\n",
             "<hr>\n",
             "<b>Details</b>:<br />\n<pre>", htmlentities($err), '</pre>';
    }

