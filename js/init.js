/***                                                                        ***\
    init.js                                  Last Updated: 2005.01.23 (xris)
    basic javascript routines
\***                                                                        ***/

    window.onload = init;

// Include some other modules
    document.write('<script type="text/javascript" src="js/mouseovers.js"></script>');
    document.write('<script type="text/javascript" src="js/visibility.js"></script>');

// Define some global variables
    var isCSS, isW3C, isIE4, isNN4, isIE6, is_gecko, is_safari, is_khtml, is_opera;
    var on_load = new Array();                // An array of functions to be executed in init()

    function init() {
        var ua    = navigator.userAgent.toLowerCase();
        isCSS     = (document.body && document.body.style);
        isW3C     = (isCSS && document.getElementById);
        isIE4     = (isCSS && document.all);
        isNN4     = (document.layers) ? true : false;
        isIE6     = (document.compatMode && document.compatMode.indexOf("CSS1") >= 0);
        is_gecko  = ((ua.indexOf('gecko') != -1) && (ua.indexOf('spoofer') == -1) && (ua.indexOf('khtml') == -1) && (ua.indexOf('netscape/7.0') == -1));
        is_safari = ((ua.indexOf('AppleWebKit')!=-1) && (ua.indexOf('spoofer')==-1));
        is_khtml  = (navigator.vendor == 'KDE' || ( document.childNodes && !document.all && !navigator.taintEnabled ));
        is_opera  = (ua.indexOf('opera') != -1);

        for (var key in on_load) {
            on_load[key]();
        }
    }

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


