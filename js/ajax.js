/**
 * A small but growing library of generic AJAX routines.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 *
 * @package     MythWeb
 * @subpackage  javascript
 *
/**/

// Global shared variable
    var shared_httpobj;

// Initialize an http connection object
    function get_connection_object() {
        try {
            httpobj_temp = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch (e) {
            try {
                httpobj_temp = new ActiveXObject('Microsoft.XMLHTTP');
            } catch (oc) {
                httpobj_temp = null;
            }
        }
        if (!httpobj_temp && typeof XMLHttpRequest != 'undefined')
            httpobj_temp = new XMLHttpRequest();
        return httpobj_temp;
    }

// Submit a simple URL and execute optional success_handler if it succeeds (or
// optional failure_handler if it fails).
    function submit_url(/* url, [success_handler, ] [failure_handler] */) {
        var args            = submit_url.arguments;
        var url             = args[0]
        var success_handler = args[1];
        var failure_handler = args[2];
    // No shared http object defined yet -- load it
        if (typeof(shared_httpobj) == 'undefined') {
            shared_httpobj = get_connection_object();
        }
    // Get a link
        var httpobj = shared_httpobj;
    // Not ready to accept connections?
        if (httpobj.readyState != 4) httpobj.abort();
    // Set up the query
        httpobj.open('GET', url, true);
    // Set up a response handler
        httpobj.onreadystatechange = function() {
            if (httpobj.readyState != 4) return;
        // Success
            if (httpobj.status == '200') {
            // Custom success handler receives the returned content as a parameter.
            // There is no default success handler
                if (typeof(success_handler) != 'undefined') {
                    success_handler(httpobj.responseXML ? httpobj.responseXML : httpobj.responseText);
                }
            }
        // Failure
            else {
            // Default failure handler
                if (typeof(failure_handler) == 'undefined')
                    alert('HTTP Error:  ' + httpobj.statusText + ' (' + httpobj.status + ')');
            // Custom failure handler receives status and statusText as parameters.
                else
                    failure_handler(httpobj.status, httpobj.statusText);
            }
        }
    // Submit the query
        httpobj.send(null);
    }

