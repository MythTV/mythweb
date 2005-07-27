/*
 *  $Date$
 *  $Revision$
 *  $Author$
 *
 *  ajax.js
 *
 *    A small but growing library of generic AJAX routines.
/*/

// Global shared variable
    var shared_httpobj;

// Initialize an http connection object
    function get_connection_object() {
        try {
            httpobj_temp = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (e) {
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

// Submit a URL, and execute callback_function if it succeeds
    function submit_url(/* url, callback_function */) {
        // Arguments: [0]->{backend function name}, [1]->{argument1} , [2]->{JS callback function}
        var args = submit_url.arguments, url = '', httpobj, callback_function = '';
        url = args[0]
        callback_function = args[1];

        if (typeof(shared_httpobj) == 'undefined') {
            shared_httpobj = get_connection_object();
        }
        httpobj = shared_httpobj;

        if (httpobj.readyState != 4) httpobj.abort();
        httpobj.open("GET", url, true);
        httpobj.onreadystatechange = function() {
            if (httpobj.readyState != 4) return;
            callback_function();
        }
        httpobj.send(null);
    }

