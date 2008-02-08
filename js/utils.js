/**
 * A random assortment of javascript utility routines
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     LGPL
 *
/**/

// Wrapper for various "get element id" functions
    function get_element(id) {
        if (typeof id != 'string') return id;
        if (document.getElementById)
            return document.getElementById(id);
        if (document.all)
            return document.all[id];
        return null;
    }

// For some reason, calling "value" from within onclick doesn't work
// Seems to be a name conflict somewhere, but I can't find it.
    function set_field(id, val) {
        value(id, val);
    }

// Pass in value to change, otherwise it returns the value of the "e" element
    function value(e, new_value) {
        if (typeof e == 'string')
            var e = get_element(e);
        if (!e) return '';
    // A <select>
        if (e.options) {
            if (new_value != null) {
            // This would scan the options and choose the one that matches
            // new_value.  Not used anywhere yet, so no need to hook it up.
            }
            return value(e.options[e.selectedIndex]);
        }
    // Just an html element?  (or in IE, an option element with no value="" specified)
        else if (e.value == null || e.tagName.toLowerCase() == 'option' && e.value == '') {
            if (new_value != null)
                e.innerHTML = new_value;
            return e.innerHTML;
        }
    // Form field
        if (new_value != null) {
            e.value = new_value;
        }
        return e.value;
    }

// Overwrite the href attribute of all <a> tags with a js_href attribute
    Event.observe(window, 'load', add_js_attributes);
    function add_js_attributes(w) {
        if (!w.document)
            w = window;
    // Get all links in this form
        var links = w.document.getElementsByTagName('a');
        for (var i=0; i<links.length; i++) {
        // js_href
            var js_href = links[i].getAttribute('js_href');
            if (js_href && js_href.length)
                links[i].href = js_href;
        // show the link title in the status bar
            if (!links[i].onmouseover && !links[i].onmouseout) {
                var title = links[i].getAttribute('title');
                if (title && title.length) {
                    links[i].onmouseover = function () {
                                               window.status = this.getAttribute('title');
                                               return true;
                                           }
                    links[i].onmouseout = function () {
                                              window.status = '';
                                              return true;
                                          }
                }
            }
        }
    // Process textareas, too
        var text = w.document.getElementsByTagName('textarea');
        for (var i=0; i<text.length; i++) {
            var auto = text[i].getAttribute('autorows');
            if (auto && auto.length) {
                if (parseInt(auto) < 1)
                    auto = null;
            // First, run textarea_autorows on the field as it stands now
                textarea_autorows(text[i], auto);
            // Then, populate the event code
                text[i].onkeyup = function () {
                                      textarea_autorows(this, this.getAttribute('autorows'));
                                  }
            }
        }
    // Handle any subframes
        if (w && w.frames) {
            for(var i=0; i<w.frames.length; i++){
                add_js_attributes(w.frames[i]);
            }
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
            hidden.value = val != null ? val : 1;
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

// Check/uncheck a checkbox
    function toggle_checkbox(id, check) {
        var e = get_element(id);
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
        get_element('help_text').innerHTML = text;
        wstatus(text);
    // Toggle the regions
        toggle_vis('help_text_default');
        toggle_vis('help_text');
    // Return true so wstatus works
        return true;
    }

// Resize a the specified <textarea>
    function resize_textarea(id, rows, cols) {
        var text = get_element(id);
        text.rows = rows != null ? rows : value(id + '_rows');
        text.cols = cols != null ? cols : value(id + '_cols');
    }

// Adjust the number of rows in textarea id to match the number of lines it has
    function textarea_autorows(element, max) {
        if (typeof element != 'object')
            element = get_element(element);
        var text = element.value;
    // First, scan for newlines
        var list = text.match(/\n/g);
        var rows = parseInt((list && list.length) ? list.length + 1 : 0);
    // Next, scan for extra-long lines that may have wrapped (not perfect, but close enough)
        var re = new RegExp('(\\S [^\n]{'+(parseInt(element.cols)-2)+',})(?!\n)', 'g');
        list   = text.match(re);
        if (list && list.length) {
            for (line in list) {
                rows += parseInt(list[line].length / element.cols) + 1;
            }
        }
    // Apply
        if (rows < 1)
            rows = 1;
        if (max != null && max < rows)
            rows = max;
        if (element.rows != rows)
            element.rows = rows;
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
