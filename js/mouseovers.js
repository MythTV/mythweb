/***                                                                        ***\
    mouseovers.js                            Last Updated: 2005.03.21 (xris)

    Functions to show/hide sections of the page (for mouseovers)
\***                                                                        ***/

/*
    find_position:
    returns the page position of any element on the screen
    thanks to webreference.com for info about tables, etc.
*/
    function find_position(element) {
    // Pull off the height/width early
        var w = element.offsetWidth  ? element.offsetWidth  : 0;
        var h = element.offsetHeight ? element.offsetHeight : 0;
    // No parent, just return the coordinates
        if (! element.offsetParent)
            return {x:element.x, y:element.y, w:w, h:h};
    // Scan backwards through the parents
        var x = 0, y = 0;
        while (element.offsetParent) {
        // If IE...
            if (!is_gecko && !is_safari && !is_khtml && !is_opera  && (isIE4 || isIE6)) {
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
            x += parseInt(element.offsetLeft);
            y += parseInt(element.offsetTop);
        // On to the next parent
            element = element.offsetParent;
        }
        return {x:x, y:y, w:w, h:h};
    }

// Keep track of things
    var popups        = new Array();
    var popup_timeout = null;

// Popup boxes that disappear when the mouse leaves the parent area
    function popup(id, popup_id, x, y, click, menu) {
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
    // In case were trying to recycle popup id's, look for a _popup field
        if (get_element(this.popup_id + '_popup'))
            this.popup_id = this.popup_id + '_popup';
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
        field.style.zIndex = popups.length + 10;
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
    // Make sure it displays on top of everything else
        field.zIndex  = 20;
    // Get the location of the parent element
        var pos = find_position(get_element(popup.id));
    // Set the initial position of the hidden element
        var x = parseInt(pos.x);
        var y = parseInt(pos.y) + get_element(popup.id).offsetHeight;
    // Get some window information so we can make sure the box doesn't extend off the edge of the screen
        var window_width = 0, window_height = 0, scroll_left = 0, scroll_top = 0;
        if (document.body.clientWidth || document.body.clientHeight) {
            window_width  = document.body.clientWidth;
            window_height = document.body.clientHeight;
            scroll_left   = document.body.scrollLeft;
            scroll_top    = document.body.scrollTop;
        }
        else if (document.documentElement.clientWidth) {
            window_width  = document.documentElement.clientWidth;
            window_height = document.documentElement.clientHeight;
            scroll_left   = document.documentElement.scrollLeft;
            scroll_top    = document.documentElement.scrollTop;
        }
        else {
            window_width  = window.innerWidth;
            window_height = window.innerHeight;
            scroll_left   = document.body.scrollLeft;
            scroll_top    = document.body.scrollTop;
        }
    // Do our best to try to keep the popup onscreen and away from the mouse
        if (window_width > 0 && window_height > 0) {
            var orig_field = get_element(popup.popup_id);       // grab another copy, since "field" is most likely a "style" now
            width  = parseInt(orig_field.offsetWidth);
            height = parseInt(orig_field.offsetHeight);
        // Adjust the element location?
            if (x > window_width + scroll_left - width - 3)
                x = window_width + scroll_left - width - 3;      // subtract a few extra pixels to account for borders
            if (y > window_height + scroll_top - height - 12)
                y = window_height + scroll_top - height - 12;    // subtract a few extra pixels to account for borders
        // Does this now conflict with the parent element?
            if (y < parseInt(pos.y)) {
                if (x < parseInt(pos.x))
                    y = parseInt(pos.y) - height - 10;
                else
                    x += get_element(popup.id).offsetWidth + 5 - popup.x;
            }
        }
    // Make some minor corrections
        x += popup.x;
        y += popup.y;
        if (x < 0) x = 0;
        if (y < 0) y = 0;
    // Adjust the element
        field.left = x + 'px';
        field.top  = y + 'px';
        if (isNN4) {
            field.xpos       = x;
            field.ypos       = y;
            field.visibility = 'show';
        }
        else
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
                field.visibility = isNN4 ? 'hide' : 'hidden';
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
        for (var i=0;i<menus.length;i++) {
            var menu = get_element(menus[i]);
            if (!menu)
                continue;
            var items = menu.getElementsByTagName('li');
            var l = items.length;
            for (var j=0; j<l; j++) {
                var li = items[j];
            // Remove any text from inside of a separator
            //    if (li.className && (new RegExp('\\bsep(arator)?\\b')).test(li.className))
            //        li.innerHTML = '';
            // We should probably only interact with the first <ul> we find -- treat it as a submenu
                var children = li.getElementsByTagName('ul');
                if (!children || children.length == 0)
                    continue;
                li.child = children[0];
            // Set the mouseover/mouseout events
                li.onmouseover = show_menu;
                li.onmouseout  = hide_menu;
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

    function show_menu() {
        if (!this)
            return;
    // Make the menu active
        add_class(this, 'active');
        var pos = find_position(this);
        if (this.top_menu) {
            pos.x += (this.vertical ? pos.w : -1);
            pos.y += (this.vertical ? 2 : pos.h - 2);
        }
        else {
            pos.x = this.offsetWidth;
            pos.y = this.offsetTop + 2;
        }
    // Make some corrections
        if (isNaN(pos.x) || pos.x < 0) pos.x = 0;
        if (isNaN(pos.y) || pos.y < 0) pos.y = 0;
    // Get the child field
        var child = this.child;
        if (child.style)
            child = child.style;
    // Move the menu into its new location
        child.left = pos.x + 'px';
        child.top  = pos.y + 'px';
    // Show the menu
        if (isNN4) {
            child.xpos       = pos.x;
            child.ypos       = pos.y;
            child.visibility = 'show';
        }
        else
            child.visibility = 'visible';
    }

    function hide_menu() {
        var child = this.child;
        if (child.style)
            child = child.style
        if (isNN4)
        	child.visibility = 'hide';
        else
        	child.visibility = 'hidden';
    	remove_class(this, 'active');
    }

