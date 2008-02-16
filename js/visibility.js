/**
 * Functions to show/hide html elements
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     LGPL
 *
/**/

// Toggle the visibility of an element
    var toggle_vis_cache = new Array();
    function toggle_vis(field, vis) {
        var e = get_element(field);
        if (!e) return;
    // Get the display type
        var display = get_display(field);
    // Show
        if (display == 'none') {
            e.style.display = toggle_vis_cache[field] ? toggle_vis_cache[field] : (vis ? vis : default_display(field));
            e.style.visibility  = 'visible';
        }
    // Hide
        else {
            toggle_vis_cache[field] = vis ? vis : display;
            e.style.display         = 'none';
            e.style.visibility      = 'hidden';
        }
    }

// Make a reasonable attempt to determine whether or not a particular field is visible
// Returns the field's "display" parameter
    function get_display(field) {
        var e = get_element(field);
    // Display assigned directly to the element
        if (e.style.display)
            return e.style.display;
    // Unknown display type -- Make a reasonable effort to look it up in the stylesheet rules
        var classes = e.className.split(/\s+/);
        var found   = false;
        for (var i=0;i<document.styleSheets.length;i++) {
            var sheet = document.styleSheets[i];
            var rules = (typeof sheet.cssRules != 'undefined') ? sheet.cssRules
                            : ((typeof sheet.rules != 'undefined') ? sheet.rules : null);
            if (rules) {
                for (var j=0;j<rules.length;j++) {
                    var rule = rules[j];
                // No display rule given -- skip ahead early
                    if (!rule.style.display)
                        continue;
                // Grab the selectors and scan through them for id or rudimentary class name matches
                    var selectors = rule.selectorText.split(/\s*,\s*/);
                    for (var k=0;k<selectors.length;k++) {
                        var str = selectors[k];
                    // See if this is a matching id-based class
                        var match = new RegExp('^#'+field+'$');
                        if (str.match(match)) {
                            return rule.style.display;
                        }
                    // Nope -- scan through this field's classnames for a match
                        else {
                            for (var l=0;l<classes.length;l++) {
                                match = new RegExp('^\.'+classes[l]+'$');
                                if (str.match(match)) {
                                    return rule.style.display;
                                }
                            }
                        }
                    }
                }
            }
        }
    // Return the default
        return default_display(field);
    }

// Return the default display type of a particular field (as we assume things should be displayed)
    function default_display(field) {
        var e = get_element(field)
    // Return special display types for certain tags
        var tag = e.tagName.toLowerCase();
        switch (tag) {
            case 'tr':
                if (is_gecko || is_safari || is_khtml || is_opera)
                    return 'table-row';
                return 'block';
            case 'a', 'span':
                return 'inline';
            default:
                return 'block';
        }
    }

