/**
 * A small but growing library of generic AJAX routines.
 *  - Sync and async ajax use.
 *  - Plaintext responses [non-XML]
 *  - Browser Support: Safari, Opera, Firefox
 *
 * @url         $URL: svn+ssh://xris@svn.siliconmechanics.com/var/svn/web/trunk/shared_code/js/ajax.js $
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     LGPL
 *
 * @package     SiMech
 * @subpackage  Javascript
 *
/**/

// Global shared variable
    var shared_httpobj         = new Array();
    var shared_success_handler = new Array();
    var shared_failure_handler = new Array();
    var shared_handler_args    = new Array();

// Initialize an http connection object
    function get_connection_object() {
        var httpobj_temp;
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
// optional failure_handler if it fails).  handler_args are any additional
// arguments passed in, and they are passed as an array to the success/failure
// handler functions.
    function submit_url( url, success_handler , failure_handler /* [handler_args, ...] */ ) {
    // Optional Parameters won't be introduced until Javascript 2.0
        success_handler = (success_handler ? success_handler : null);
        failure_handler = (failure_handler ? failure_handler : null);
    // Create a new connection object
        var httpobj = get_connection_object();
    // Add it to the array, and get the length
        var index = shared_httpobj.push(httpobj);
    // figure out the actual item index, which is one less then the length (arrays start at 0)
        index--;
        shared_handler_args[index] = new Array();
        for (var i=3; i<arguments.length; i++) {
            shared_handler_args[index].push(arguments[i]);
        }
        shared_success_handler[index] = success_handler;
        shared_failure_handler[index] = failure_handler;
    // If we have no success handler and no failure handler, we assume that we want to do a blocking call rather then async.
        if (success_handler == null && failure_handler == null ) {
        // Set up the query
            httpobj.open('GET', url, false);
        // Prevent the browser cache from being used [for documents post-1994]
        // Safari Bug: Safari will mark the satus as 'undefined' instead of 200 if a page is cached [bad]
            httpobj.setRequestHeader('If-Modified-Since','Wed, 15 Nov 1995 00:00:00 GMT');
        // Submit the query
            httpobj.send(null);
        // Return the data
            return (httpobj.responseText);
        }
        else {
        // Set up the query
            httpobj.open('GET', url, true);
        // Set up a response handler
            httpobj.onreadystatechange = ajax_check;
        // Submit the query
            httpobj.send(null);
        }
    }

    function ajax_check() {
        for (var i=0; i<shared_httpobj.length; i++) {
            httpobj = shared_httpobj[i];
            if (httpobj.readyState == 4) {
                handler_args    = shared_handler_args[i];
                success_handler = shared_success_handler[i];
                failure_handler = shared_failure_handler[i];
            // Remove the used up object from the array;
                shared_httpobj.splice(i,1);
                shared_success_handler.splice(i,1);
                shared_failure_handler.splice(i,1);
                shared_handler_args.splice(i,1);
            // Success
                if (httpobj.status == '200') {
                // Custom success handler receives the returned content as a parameter.
                // There is no default success handler
                    if (success_handler != null) {
                        success_handler(httpobj.responseText, handler_args);
                    }
                }
            // Failure
                else {
                // Default failure handler
                    if (failure_handler == null)
                        alert('HTTP Error:  ' + httpobj.statusText + ' (' + httpobj.status + ')');
                // Custom failure handler receives status and statusText as parameters.
                    else
                        failure_handler(httpobj.status, httpobj.statusText, handler_args);
                }

            }
        }
    }
