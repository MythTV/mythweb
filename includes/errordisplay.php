<?php
/**
 * This file contains a number of error-display related routines.
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

/**
 * Error messages should prevent saving.
 *
 * @global  mixed   $GLOBALS['Errors']
 * @name    $Errors
/**/
    global $Errors;
    $Errors = array();

/**
 * Warnings should warn, but not prevent saving.
 *
 * @global  mixed   $GLOBALS['Warnings']
 * @name    $Warnings
/**/
    global $Warnings;
    $Warnings = array();

/**
 * This is an associative array for keeping track of whether items have been
 * marked as "bad" in order that they can properly be displayed with
 * highlight_error().
 *
 * @global  mixed   $GLOBALS['BadItems']
 * @name    $BadItems
/**/
    global $BadItems;
    $BadItems = array();

/**
 * This function displays any errors or warnings, in a javascript alert if the
 * browser has scripting enabled.
/**/
    function display_errors($leading='<p align="center">', $trailing = '</p>') {
        global $Errors, $Warnings;
    // Errors or warnings from a previous page?
        if (is_array($_SESSION['WARNINGS']) && count($_SESSION['WARNINGS'])) {
            foreach ($_SESSION['WARNINGS'] as $warning) {
                $Warnings[] = $warning;
            }
            unset($_SESSION['WARNINGS']);
        }
    // Nothing to show?
        if (!errors() && !warnings())
            return;
    // Load the errors
        $js_errstr = '';
        if (is_array($Errors) && count($Errors) > 0)
            $js_errstr .= "Error:\n".implode("\n", $Errors);
        if (is_array($Warnings) && count($Warnings) > 0)
            $js_errstr .= "Warning:\n".implode("\n", $Warnings);
        $errstr = str_replace("\n", "<br />\n", htmlentities($js_errstr));
    // Clean up the javascript error string
        $js_errstr = str_replace ("\n"     , "\\n",
                     str_replace ('"'      , '\\"',
                     preg_replace('/<.*?>/', ''   , $js_errstr)));
    // Print
        echo <<<EOF
<script type="text/javascript">
<!--
Event.observe(window, 'load', display_errors);
function display_errors() { alert("$js_errstr"); };
// -->
</script>
<noscript>
$leading
<table border="1" cellspacing="0" cellpadding="8" class="error">
<tr>
    <td>$errstr</td>
</tr>
</table>
$trailing
</noscript>
EOF;
    }

/**
 * This function just draws a simple red line around something, to mark it as
 * containing erroneous data.  It really needs to be replaced with a style.
/**/
    function highlight_error($content, $field = '') {
        global $BadItems;
        if (!$field || $BadItems[$field])
            echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"1\" class=\"error\"><tr><td>$content</td></tr></table>";
        else
            echo $content;
    }

/**
 * Add an error to the list.
 *
 * @param string $warning The warning to add
 * @param mixed  $fields  String or array of strings to add to $BadItems.
/**/
    function add_error($error, $fields = NULL) {
        global $Errors, $BadItems;
        if (!preg_match('/\\w/', $error)) return;
        $Errors[] = trim($error);
    // Add any bad item fields
        if (is_array($fields)) {
            foreach ($fields as $field) {
                $BadItems[$field] = true;
            }
        }
        elseif ($fields)
            $BadItems[$fields] = true;
    }

/**
 * Add a warning to the list.
 *
 * @param string $warning The warning to add
 * @param mixed  $fields  String or array of strings to add to $BadItems.
/**/
    function add_warning($warning, $fields = NULL) {
        global $Warnings, $BadItems;
        if (!preg_match('/\\w/', $warning)) return;
        $Warnings[] = trim($warning);
    // Add any bad item fields
        if (is_array($fields)) {
            foreach ($fields as $field) {
                $BadItems[$field] = true;
            }
        }
        elseif ($fields)
            $BadItems[$fields] = true;
    }

/**
 * Test the existence of errors
/**/
    function errors() {
        return !empty($GLOBALS['Errors']);
    }

/**
 * Test the existence of warnings
/**/
    function warnings() {
        return !empty($GLOBALS['Warnings']);
    }

/**
 * Save errors and warnings into a session error/warning variable
/**/
    function save_session_errors() {
        global $Errors, $Warnings;
        $_SESSION['WARNINGS'] = array();
		if (is_array($Errors)) {
			foreach ($Errors as $error) {
				$_SESSION['WARNINGS'][] = $error;
			}
		}
		if (is_array($Warnings)) {
			foreach ($Warnings as $warning) {
				$_SESSION['WARNINGS'][] = $warning;
			}
		}
    }

/**
 * Show one of the tailored error pages.
 *
 * @param string $error The error template page to load
/**/
    function tailored_error($error) {
        require_once "modules/_shared/tmpl/_errors/$error.php";
        exit;
    }

/**
 * Show the generic error page with a custom message.
 *
 * @param string $title  Page title.
 * @param string $header String for the error header.
 * @param string $text   Error text.
/**/
    function custom_error($text, $header='Error', $title='Error') {
        require_once 'modules/_shared/tmpl/_errors/error.php';
        exit;
    }
