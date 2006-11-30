/**
 * Functions to show/hide sections of the page (for mouseovers).
 * Primarily used for interactive menus
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     LGPL
 *
 * @package     MythWeb
 * @subpackage  Javascript
 *
/**/

// Make a reasonable attempt to determine the css position of a particular field.
    function get_css_position(field) {
        var e = get_element(field);
    // Display assigned directly to the element
        if (e.style.position)
            return e.style.position;
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
                    if (!rule || !rule.style || !rule.style.position)
                        continue;
                // Grab the selectors and scan through them for id or rudimentary class name matches
                    var selectors = rule.selectorText.split(/\s*,\s*/);
                    for (var k=0;k<selectors.length;k++) {
                        var str = selectors[k];
                    // See if this is a matching id-based class
                        var match = new RegExp('^#'+field+'$');
                        if (str.match(match)) {
                            return e.style.position = rule.style.position;
                        }
                    // Nope -- scan through this field's classnames for a match
                        else {
                            for (var l=0;l<classes.length;l++) {
                                match = new RegExp('^\.'+classes[l]+'$');
                                if (str.match(match)) {
                                    return e.style.position = rule.style.position;
                                }
                            }
                        }
                    }
                }
            }
        }
    // Return the default
        return '';
    }

/**
 * find_position:
 *  returns the page position of any element on the screen
 *  thanks to webreference.com for info about tables, etc.
/**/
    function find_position(element, parse_absolute) {
    // Pull off the height/width early
        var w = element.offsetWidth  ? element.offsetWidth  : 0;
        var h = element.offsetHeight ? element.offsetHeight : 0;
    // No parent, just return the coordinates
        if (! element.offsetParent)
            return {x:element.x, y:element.y, w:w, h:h};
    // Scan backwards through the parents
        var x = 0, y = 0;
        do {
        // Ignore absolutely-positioned elements
            if (!parse_absolute && element.style && element.id && get_css_position(element.id) == 'absolute') {
                x -= parseInt(element.scrollLeft);
                y -= parseInt(element.scrollTop);
                continue;
            }
        /// I don't know why safari sets an offsetTop on the body element
            else if (element.tagName == 'BODY')
                continue;
        // If IE...
            if (browser.is_ie) {
                // If element is not a table or body tag, append the cell border info
                if (element.tagName != 'TABLE' && element.tagName != 'BODY') {
                    if (element.clientLeft)
                        x += parseInt(element.clientLeft);
                    if (element.clientTop)
                        y += parseInt(element.clientTop);
                }
            }
        // Gecko?
            else {
            // We need to take the table border into consideration
                if (element.tagName == 'TABLE') {
                    var border = parseInt(element.border);
                // No visible border, check for a frame attribute
                    if (isNaN(border)) {
                        var frame = element.getAttribute('frame');
                    // Found a frame attribute, but only add one pixel for it.
                        if (frame != null) {
                            x++;
                            y++;
                        }
                    }
                // Visible border, add it to the calculation, too
                    else if (border > 0) {
                        x += border;
                        y += border;
                    }
                }
            }
        // Don't forget the actual location of the element
            x += parseInt(element.offsetLeft) - parseInt(element.scrollLeft);
            y += parseInt(element.offsetTop)  - parseInt(element.scrollTop);
        } while (element = element.offsetParent);
        return {x:parseInt(x), y:parseInt(y), w:parseInt(w), h:parseInt(h)};
    }

// Keep track of things
    var popups        = new Array();
    var popup_timeout = null;

// Popup boxes that disappear when the mouse leaves the parent area
    function popup(id, popup_id, x, y, click, menu) {
    // Need a popup id?
        if (!popup_id || popup_id.length < 1)
            popup_id = id + '_popup';
    // Add the obligatory _popup suffix
        else if (!get_element(popup_id))
            popup_id += '_popup';
    // No popup id element defined; just return (page probably isn't done loading)
        if (!get_element(popup_id))
            return;
    // Popup already showing with this content
        if (popups.length && popups[0].id == id) {
            if (click) {
            // Already a clicked-type, just hide it
                if (popups[0].click) {
                    hide_popup();
                    return;
                }
            // Make the current instance of this ignore mouseout events
            // (it will get hidden shortly, to visibly notify the user of the
            // change, and this will keep the "click" version from hiding
            // itself unnecessarily)
                else {
                    get_element(popups[0].id).onmouseout       = null;
                    get_element(popups[0].popup_id).onmouseout = null;
                }
            }
            else if (popups[0].click) {
                return;
            }
        // This popup is already visible -- cancel any "hide" commands and return
            else {
                clear_popup_timeout();
                return;
            }
        }
    // Hide all other popups, in case one was stuck on
        hide_popup();
    // Create the object and add it to the list
        popups.unshift(new popup_obj(id, popup_id, x, y, click, menu));
    // delaying show_popup() seems to make it more accurate at positioning things
        setTimeout(show_popup, 50);
    }

// An object for all popup types
    function popup_obj(id, popup_id, x, y, click, menu) {
    // menu and click tend to conflict, so let menu override
        if (menu)
            this.menu = true;
        else {
            this.menu = false;
            this.click = click ? true : false;
        }
    // Make sure that x and y are numbers
        this.x = isNaN(x) ? 0 : x;
        this.y = isNaN(y) ? 5 : y;
    // Get the name and popup name
        this.id = id;
        if (popup_id && popup_id.length > 0)
            this.popup_id = popup_id;
        else
            this.popup_id = id;
    // Set the mouseout behavior
        var field = get_element(this.id)
        if (!click)
            field.onmouseout = timed_hide_popup;
    // Set the mouseover behavior for the child
        field = get_element(this.popup_id)
        if (menu)
            field.onmouseover = show_popup;
        if (!click)
            field.onmouseout  = timed_hide_popup;
    // Adjust the z-index of the popup so that it shows on top of the parent menu
        field.style.zIndex = 99 + popups.length + 10;
    }

    function show_popup() {
        if (popup_timeout) {
            clear_popup_timeout();
            return;
        }
    // No need to do this?
        if (!popups[0])
            return;
    // Grab the current element to be shown
        var popup = popups[0];
        var field = get_element(popup.popup_id);
        if (field.style)
            field = field.style;
    // Allow the browser to render the popup in context
        field.display = 'inline';
    // Get the location of the parent element
        var pos = find_position(get_element(popup.id), true);
    // Grab another copy, since "field" is most likely a "style" now
        var orig_field = get_element(popup.popup_id);
        var width      = parseInt(orig_field.offsetWidth);
        var height     = parseInt(orig_field.offsetHeight);
    // Set the initial position of the hidden element
        var x = pos.x;
        var y = pos.y + parseInt(get_element(popup.id).offsetHeight);
    // Get some window information so we can make sure the box doesn't extend off the edge of the screen
        var window_width = 0, window_height = 0, scroll_left = 0, scroll_top = 0;
        if (document.documentElement.clientWidth && document.documentElement.clientHeight < document.body.clientHeight) {
            window_width  = document.documentElement.clientWidth;
            window_height = document.documentElement.clientHeight;
            scroll_left   = document.documentElement.scrollLeft;
            scroll_top    = document.documentElement.scrollTop;
        }
        else if (document.body.clientWidth || document.body.clientHeight) {
            window_width  = document.body.clientWidth;
            window_height = document.body.clientHeight;
            scroll_left   = document.body.scrollLeft;
            scroll_top    = document.body.scrollTop;
        }
        else {
            window_width  = window.innerWidth;
            window_height = window.innerHeight;
            scroll_left   = document.body.scrollLeft;
            scroll_top    = document.body.scrollTop;
        }
    // Do our best to try to keep the popup onscreen and away from the parent
    // element (plus a screen-edge padding of 3 pixels)
        if (window_width > 0 && window_height > 0) {
        // Adjust the element location?
            if (x > window_width + scroll_left - width - 6)
                x = window_width + scroll_left - width - 6;
            if (window_height > 200 && y > window_height + scroll_top - height - 6)
                y -= height + get_element(popup.id).offsetHeight + 6;
        }
    // Don't hide off the left side of the screen
        if (x < 0) x = 0;
        if (y < 0) y = 0;
    // Adjust the element
        field.left    = (x + 3) + 'px';
        field.top     = (y + 3) + 'px';
    // Finally, make it visible
        field.visibility = 'visible';
    }

// This sets up a timeout so the popup isn't hidden immediately
    function timed_hide_popup() {
        clear_popup_timeout();
    // Set the timeout
    	if (popups.length > 0)
            popup_timeout = setTimeout('hide_popup()', popups[0].menu ? 500 : 5);
    // Let events bubble down
        no_bodyclick = false;
    }
// Hides all popups (so only one can be visible at any given time)
    function hide_popup() {
    // Clear the timeout, and hide any visible popups
        clear_popup_timeout();
        while (popups.length > 0) {
            var popup = popups.shift();
            var field = get_element(popup.popup_id);
            if (field != null) {
                if (field.style)
                    field = field.style;
                field.visibility = 'hidden';
                field.display    = 'none';
            }
        }
    }
// Clear any popup-related timeouts
    function clear_popup_timeout() {
        if (!popup_timeout)
            return
        clearTimeout(popup_timeout);
        popup_timeout = null;
    }

/*
    Thanks to Phrogz for setting me straight about menus.
    http://phrogz.net/JS/ul2menu/index.html
*/

// Register a popup menu, to be processed upon window load
    var menus = new Array();
    function register_menu(id) {
        menus.push(id);
    }

    on_load.push(init_menus);
    function init_menus() {
        if(!menus.length)
            return 0;
        for (var i=0;i<menus.length;i++) {
            var menu = get_element(menus[i]);
            if (!menu)
                continue;
            var items = menu.getElementsByTagName('li');
            var l = items.length;
            for (var j=0; j<l; j++) {
                var li = items[j];
            // Needs an id?  Make a semi-random one
                if (!li.id)
                    li.id = menu.id + '.' + (j + Math.random());
            // Find the immediate parent menu item, if there is one
                li.parent = li;
                while (li.parent) {
                    li.parent = li.parent.parentNode;
                    if (li.parent && li.parent.tagName == 'LI')
                        break;
                }
                if (!li.parent || li.parent && li.parent.tagName != 'LI')
                    li.parent = null;
            // We should probably only interact with the first <ul> we find -- treat it as a submenu
                var children = li.getElementsByTagName('ul');
                if (!children || children.length == 0)
                    continue;
                li.child = children[0];
            // Child needs an id, too?
                if (!li.child.id)
                    li.child.id = li.id + '.' + (10 * Math.random());
            // Set the mouseover/mouseout events
                li.onmouseover = show_menu_delayed;
                li.onmouseout  = hide_menu_delayed;
            // Gather some other info about this menu
                li.top_menu = (li.parentNode == menu);
                if (menu.className)
                    li.vertical = (li.top_menu && menu.className && (new RegExp('\\bvertical\\b')).test(menu.className));
                else
                    menu.className = 'horizontal';
            // Nothing left to test?
                if (li.top_menu || li.has_arrow)
                    continue;
            // Do we need to add anything to indicate this as a submenu?
                var a = li.getElementsByTagName('a');
                if (a && a.length > 0 && a[0].parentNode == li)
                    a[0].innerHTML = '<span style="float: right">&nbsp;&rArr;</span>' + a[0].innerHTML;
                else {
                    var arrow = document.createElement('span');
                    arrow.innerHTML='&nbsp;&rArr;';
                    arrow.style.cssFloat = arrow.style.styleFloat = 'right';
                    li.insertBefore(arrow,li.childNodes[0]);
                }
                li.has_arrow=true;
            }
        }
    }

    var menu_to_show;
    var menu_to_hide;
    var menu_show_timeout;
    var menu_hide_timeout;
    function show_menu_delayed(e) {
    // Make sure only ONE event fires
        if (!e) var e = window.event;
        e.cancelBubble = true;
        if (e.stopPropagation)
            e.stopPropagation();
    // Show this menu
        menu_to_show = this;
    // A menu is set to hide?
        if (menu_to_hide) {
        // Hiding this menu?  Cancel the request.
            if (menu_to_hide == this || menu_to_hide == this.parent)
                menu_to_hide = null;
        // Hiding another menu, just do it now
            else {
                hide_menu();
            }
        }
    // Show the new menu
        menu_show_timeout = setTimeout(show_menu, this.top_menu ? 250 : 50);
    }

    function show_menu() {
    // Loop to make sure we also show any parent menus that got hidden
        var this_menu = menu_to_show;
        while (this_menu) {
        // Make the menu active
            add_class(this_menu, 'active');
            var pos = find_position(this_menu);
            if (this_menu.top_menu) {
                pos.x += (this_menu.vertical ? pos.w : -1);
                pos.y += (this_menu.vertical ? 2     : pos.h - 2);
            }
            else {
                pos.x = this_menu.offsetWidth;
                pos.y = this_menu.offsetTop + 2;
            }
        // Make some corrections
            if (isNaN(pos.x) || pos.x < 0) pos.x = 0;
            if (isNaN(pos.y) || pos.y < 0) pos.y = 0;
        // Get some window information so we can make sure the menu doesn't extend off the edge of the screen
            var window_width = 0, scroll_left = 0;
            if (document.documentElement.clientWidth) {
                window_width  = document.documentElement.clientWidth;
                scroll_left   = document.documentElement.scrollLeft;
            }
            else if (document.body.clientWidth || document.body.clientHeight) {
                window_width  = document.body.clientWidth;
                scroll_left   = document.body.scrollLeft;
            }
            else {
                window_width  = window.innerWidth;
                scroll_left   = document.body.scrollLeft;
            }
        // Get the child field
            var child = this_menu.child;
            if (child.style)
                child = child.style;
        // Allow the browser to render the menu in context
            child.display = 'inline';
        // Make sure it doesn't hide beneath other objects
            child.zIndex  = 99;
        // Do our best to try to keep the menu onscreen
            if (window_width > 0) {
                var width = parseInt(this_menu.child.offsetWidth);
            // Adjust the element location?  Since it's nested position:absolute,
            // we need to gets its true location.
                if (find_position(this_menu).x > window_width + scroll_left - this_menu.offsetWidth - width) {
                // First level of menus should align with the right edge of the parent object
                    if (!this_menu.parent)
                        pos.x -= width - this_menu.offsetWidth;
                // Because it's nested position:absolute, submenus should subtract
                // width from zero (plus a few extra pixels to make it look nice)
                    else
                        pos.x = 5 - this_menu.offsetWidth;
                }
            }
        // Move the menu into its new location
            child.left = pos.x + 'px';
            child.top  = pos.y + 'px';
        // Show the menu
            child.visibility = 'visible';
        // Up to the next layer
            this_menu = this_menu.parent;
        }
    }

    function hide_menu_delayed(e) {
    // Make sure only ONE event fires
        if (!e) var e = window.event;
        e.cancelBubble = true;
        if (e.stopPropagation)
            e.stopPropagation();
    // Did we just show this menu?  Don't avoid closing it.
        if (menu_to_show == this) {
            menu_to_show = null;
        }
    // If the user was moving the mouse quickly, reset the counter so the delay is accurate
        clearTimeout(menu_hide_timeout);
    // Hide this menu
        menu_to_hide = this;
        menu_hide_timeout = setTimeout(hide_menu, 350);
    }

    function hide_menu() {
    // Process each menu we have to hide
        var this_menu = menu_to_hide;
        while (this_menu) {
        // Look for a common parent, so we only hide as many submenus as needed
            var found   = false;
            var submenu = menu_to_show;
            while (submenu) {
                if (submenu == this_menu) {
                    found = true;
                    break;
                }
                submenu = submenu.parent;
            }
            if (found)
                break;
        // Hide the menu
            var child = this_menu.child;
            if (child.style)
                child = child.style
            child.display    = 'none';
            child.visibility = 'hidden';
            remove_class(this_menu, 'active');
        // On to the parent menu
            this_menu = this_menu.parent;
        }
    // Don't need to hide this anymore
        menu_to_hide = null;
    }

