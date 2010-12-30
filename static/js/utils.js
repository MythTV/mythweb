/**
 * A random assortment of javascript utility routines
 *
 * @license     LGPL
 *
/**/

// For some reason, calling "value" from within onclick doesn't work
// Seems to be a name conflict somewhere, but I can't find it.
    function set_field(id, val) {
        value(id, val);
    }

// Pass in value to change, otherwise it returns the value of the "e" element
    function value(e, new_value) {
        e = $(e);
        if (!e)
            return '';
    // A <select>
        if (e.options)
            return value(e.options[e.selectedIndex]);
    // Just an html element?  (or in IE, an option element with no value="" specified)
        else if (e.value == null || e.tagName.toLowerCase() == 'option' && e.value == '') {
            if (new_value != null)
                e.innerHTML = new_value;
            return e.innerHTML;
        }
    // Form field
        if (new_value != null)
            e.value = new_value;
        return e.value;
    }

// Overwrite the href attribute of all <a> tags with a js_href attribute
    Event.observe(window, 'load', add_js_attributes);
    function add_js_attributes() {
    // Get all links in this form
        var links = $$('a');
        for (var i=0; i<links.length; i++) {
        // js_href
            var js_href = links[i].getAttribute('js_href');
            if (js_href && js_href.length)
                links[i].href = js_href;
        }
    }

// Image Preloader
    var img_on  = new Array();
    var img_off = new Array();
    function preload_image(id, on, off) {
        img_on[id]      = new Image();
        img_on[id].src  = on;
        if (off) {
            img_off[id]     = new Image();
            img_off[id].src = off;
        }
    }

// Functions to swap on/off states of images
    function on(which) {
        var img = $(which);
        img.src=img_on[which].src;
    }
    function off(which) {
        var img = $(which);
        img.src=img_off[which].src;
    }

// Submit a form
    function submit_form(newvar, val, form, confirm_str) {
    // Confirm?
        if (confirm_str && !confirm(confirm_str))
            return;
    // Find the form we want to submit
        form = $(form ? form : 'form');
        if (!form)
            form = document.form ? document.form : document.forms[0];
    // Create a new variable?
        if (newvar) {
            var hidden = document.createElement('input');
            hidden.type  = 'hidden';
            hidden.name  = newvar;
            hidden.value = val != null ? val : 1;
            form.appendChild(hidden);
        }
    // Submit
        form.submit();
    }

// Check/uncheck a checkbox
    function toggle_checkbox(id, check) {
        var e = $(id);
        if (check)
            e.checked = true;
        else if (check != null)
            e.checked = false;
        else
            e.checked = e.checked ? false : true;
    }

// Change the help text
    function help_text(text) {
    // Set the text
        $('help_text').innerHTML = text;
    // Toggle the regions
        $('help_text_default').toggle();
        $('help_text').toggle();
    }


// Return a time in hours and minutes
    function nice_length(mylength, rx_hr, rx_hrs, rx_min, rx_mins) {
        var mins  = Math.round((mylength % 3600) / 60);
        var hours = Math.round(mylength / 3600);
        var ret;
        if (hours) {
            if (hours > 1)
                ret = rx_hrs.replace(/\$1/, hours);
            else
                ret = rx_hr.replace(/\$1/, hours);
        }
        else
            ret = '';
        if (mins > 0) {
            if (ret.length)
                ret = ret + ' ';
            if (mins > 1)
                ret = ret + rx_mins.replace(/\$1/, mins);
            else
                ret = ret + rx_min.replace(/\$1/, mins);
        }
        return ret;
    }

// Return a human-readable filesize
    function nice_filesize(size) {
        var kb = 1024;         // Kilobyte
        var mb = 1024 * kb;    // Megabyte
        var gb = 1024 * mb;    // Gigabyte
        var tb = 1024 * gb;    // Terabyte
    //  If it's less than a kb we just return the size
        if (size < kb)
            return size + ' B';
    // Otherwise we keep going until the size is in the appropriate measurement range.
        else if (size < mb)
            return Math.round(size/kb) + ' KB';
        else if (size < gb)
            return Math.round(size/mb) + ' MB';
        else if (size < tb)
            return Math.round(size/gb) + ' GB';
        else
            return Math.round(size/tb) + ' TB';
    }

// The routines to allow a small ajax request counter...
    var pending_ajax_requests = 0;

    function ajax_add_request() {
        pending_ajax_requests += 1;
        $('ajax_num_requests').innerHTML = pending_ajax_requests;
        $('ajax_working').removeClassName('hidden');
    }

    function ajax_remove_request() {
        pending_ajax_requests -= 1;
        $('ajax_num_requests').innerHTML = pending_ajax_requests;
        if (pending_ajax_requests == 0)
            $('ajax_working').addClassName('hidden');
    }
