/***                                                                        ***\
    utils.js                                  Last Updated: 2005.02.08 (xris)
    a random assortment of javascript utility routines
\***                                                                        ***/

    function get_element(id) {
        if (typeof id != 'string') return id;
        if (document.getElementById)
            return document.getElementById(id);
        if (document.all)
            return document.all[id];
        return null;
    }

    function value(id, value) {
        var e = get_element(id);
        if (!e) return '';
    // Just an html element?
        if (isNaN(e.value)) {
            if (value != null)
                e.innerHTML = value;
            return e.innerHTML;
        }
    // Form field
        if (value != null)
            e.value = value;
        return e.value;
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
        var img = get_element(which);
        img.src=img_on[which].src;
    }
    function off(which) {
        var img = get_element(which);
        img.src=img_off[which].src;
    }

// Window status changer
    function wstatus(str) {
        window.status = str ? str : '';
        return true;
    }

// Submit a form
    function submit_form(newvar, val, form, confirm_str) {
    // Confirm?
        if (confirm_str && !confirm(confirm_str))
            return;
    // Find the form we want to submit
        form = get_element(form ? form : 'form');
        if (!form)
            form = document.form ? document.form : document.forms[0];
    // Create a new variable?
        if (newvar) {
            var hidden = document.createElement('input');
            hidden.type  = 'hidden';
            hidden.name  = newvar;
            hidden.value = val ? val : 1;
            form.appendChild(hidden);
        }
    // Submit
        form.submit();
    }

// Add a css class to a specified element
    function add_class(id, classname) {
        var field = get_element(id);
    // No field
        if (!field)
            return;
    // Field already has this class, don't bother to add it again
        if (field.className && (new RegExp('\\b'+classname+'\\b')).test(field.className))
            return;
    // Add the class
        if (field.className)
            field.className = field.className + ' ' + classname;
        else
            field.className = classname;
    }

// Remove a css class from a particular element
    function remove_class(id, classname) {
        var field = get_element(id);
        if (!field)
            return;
        field.className = field.className.replace(RegExp('\\b'+classname+'\\s*\\b|\\b\\s*'+classname+'\\b', 'g'), '') ;
    }

// Toggle a checkbox
    function toggle_checkbox(id) {
        var e = get_element(id)
        e.checked = e.checked ? false : true;
    }

// Change the help text
    function help_text(text) {
    // Set the text
        get_element('help_text').innerHTML = text;
        wstatus(text);
    // Toggle the regions
        toggle_vis('help_text_default');
        toggle_vis('help_text');
    // Return true so wstatus works
        return true;
    }
