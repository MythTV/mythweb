/***                                                                        ***\
    init.js                                  Last Updated: 2004.02.16 (xris)
    basic javascript routines
\***                                                                        ***/

	window.onload = init;

// Define some global variables
	var isCSS, isW3C, isIE4, isNN4, isIE6;
	var on_load = new Array();				// An array of functions to be executed in init()

	function init() {
		isCSS = (document.body && document.body.style) ? true : false;
		isW3C = (isCSS && document.getElementById)     ? true : false;
		isIE4 = (isCSS && document.all)                ? true : false;
		isNN4 = (document.layers)                      ? true : false;
		isIE6 = (document.compatMode && document.compatMode.indexOf("CSS1") >= 0) ? true : false;

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

/*
	find_position:
	returns the page position of any element on the screen
	thanks to webreference.com for info about tables, etc.
*/
	function find_position(element) {
	// No parent, just return the coordinates
		if (! element.offsetParent)
			return [element.x, element.y];
	// Scan backwards through the parents
		for( var x = 0, y = 0; element.offsetParent; element = element.offsetParent ) {
		// If IE...
			if (isIE4 || isIE6) {
				// If element is not a table or body tag, append the cell border info
				if (element.tagName != 'TABLE' && element.tagName != 'BODY') {
					x += element.clientLeft
					x += element.clientTop
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
			x += element.offsetLeft;
			y += element.offsetTop;
		}
		return [x, y];
	}

/*
	for some reason, this doesn't seem to work properly in IE when scrolled down the page a bit...
	I'm open to suggestions for fixing it.
*/
	var last_shown = null;
	var gtimeout   = null;	// global timeout id
	var gname      = null;	// global name to "show"
	var gparent    = null;	// global name to "show"
	var x_offset   = 0;
	var y_offset   = 5;
	function show(id, popup_id, x, y) {
	// store data in global var
		if (popup_id && popup_id.length > 0)
			gname = popup_id + '_popup';
		else
			gname = id + '_popup';
		gparent = id;
	// Adjust x and y offsets?
		x_offset = isNaN(x) ? 0 : x;
		y_offset = isNaN(y) ? 5 : y;
	// delay to give position time to be better
		clear_timeout();
		gtimeout = setTimeout('timed_show()', 50);
	}

	function timed_show() {
		clear_timeout();
	// retrieve data from global var
		name = gname;
	// In case the last was stuck on, let's hide it
		if (last_shown && last_shown != name)
			timed_hide();
	// Grab the current element to be shown
		last_shown = name;
		var field = get_element(name);
		if (field.style)
			field = field.style;
	// Get the location of the parent element
		var pos = find_position(get_element(gparent));
	// Set the initial position of the hidden element
		var x = parseInt(pos[0]);
		var y = parseInt(pos[1]) + get_element(gparent).offsetHeight;
	// Get some window information so we can make sure the box doesn't extend off the edge of the screen
		var window_width = 0, window_height = 0, scroll_left = 0, scroll_top = 0;
		if (document.documentElement.clientWidth) {
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
	// Do our best to try to keep the popup onscreen and away from the mouse
		if (window_width > 0 && window_height > 0) {
			var orig_field = get_element(name);
			width  = parseInt(orig_field.offsetWidth);
			height = parseInt(orig_field.offsetHeight);
		// Adjust the element location?
			if (x > window_width + scroll_left - width - 2)
				x = window_width + scroll_left - width - 2;		// subtract a couple of extra pixels to account for borders
			if (y > window_height + scroll_top - height - 7)
				y = window_height + scroll_top - height - 7;	// subtract a couple of extra pixels to account for borders
		// Does this now conflict with the parent element?
			if (y < parseInt(pos[1])) {
				if (x < parseInt(pos[0]))
					y = parseInt(pos[1]) - height - 10;
				else
					x += get_element(gparent).offsetWidth + 5 - x_offset;
			}
		}
	// Make some minor corrections
		x += x_offset;
		y += y_offset;
		if (x < 0) x = 0;
		if (y < 0) y = 0;
	// Adjust the element
		field.left = x;
		field.top  = y;
		if (isNN4) {
			field.xpos       = x;
			field.ypos       = y;
			field.visibility = 'show';
		}
		else
			field.visibility = 'visible';
	}

	function hide(delay) {
		delay = parseInt(delay);
		if (isNaN(delay) || delay < 1)
			delay = 0;
		clear_timeout();
		gtimeout = setTimeout('timed_hide()', delay);
	}

	function timed_hide() {
		clear_timeout();
		if (last_shown) {
			var field = get_element(last_shown);
			if (field.style)
				field = field.style;
			field.visibility = isNN4 ? 'hide' : 'hidden';
		}
		last_shown = null;
	}

	function clear_timeout() {
		if (gtimeout) {
			clearTimeout(gtimeout);
			gtimeout = null;
		}
	}
