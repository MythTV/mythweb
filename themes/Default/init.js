/***                                                                        ***\
    init.js                                  Last Updated: 2003.09.05 (xris)
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
		if (isW3C)
			return document.getElementById(id);
		return document.all[id];
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

// Start tracking mouse movements, so we can show dynamic content

	var mouse_x = 0;
	var mouse_y = 0;

	function grabEv(e) {
		e = e ? e : event;
		if (e.clientX || e.clientY) {
			mouse_x = e.clientX + window.scrollX;
			mouse_y = e.clientY + window.scrollY;
		}
		else if (e.pageX || e.pageY) {
			mouse_x = e.pageX;
			mouse_y = e.pageY;
		}
		else {
			mouse_x = e.x + document.documentElement.scrollLeft + document.body.scrollLeft;
			mouse_y = e.y + document.documentElement.scrollTop  + document.body.scrollTop;
		}
	}

// We don't currently need this stuff now that we have find_position()
//	if (isNN4)
//		document.captureEvents(Event.MOUSEDOWN | Event.MOUSEMOVE);
//	document.onmousemove = grabEv;

// Functions to show/hide sections of the page (for mouseovers)

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
	var gtimeout = null;    // global timeout id
	var gname = null;       // global name to "show"
	function show(name) {
	// store data in global var
		gname = name;
	// remove timed display if already active
		if (gtimeout)
			clearTimeout(gtimeout);
	// delay .1s to give position time to be better
		gtimeout = setTimeout('timed_show()', 75);
	}

	function timed_show() {
	// retrieve data from global var
		name = gname;
		gtimeout = null;
	// In case the last was stuck on, let's hide it
		if (last_shown)
			hide(last_shown);
	// Grab the current element to be shown
		last_shown = name;
		var field = get_element(name);
		if (field.style)
			field = field.style;
	// Get the location of the parent element
		var pos = find_position(get_element(name+'_anchor'));
	// Set the initial position of the hidden element
		var x = parseInt(pos[0]);
		var y = parseInt(pos[1]) + get_element(name+'_anchor').offsetHeight;
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
		// Does this now conflict with the mouse?
			if (y < parseInt(pos[1])) {
				if (x < parseInt(pos[0]))
					y = parseInt(pos[1]) - height - 10;
				else
					x += get_element(name+'_anchor').offsetWidth + 5;
			}
		}
	// Adjust the element
		field.left = x;
		field.top  = y + 5;
		if (isNN4) {
			field.xpos       = x;
			field.ypos       = y;
			field.visibility = 'show';
		}
		else
			field.visibility = 'visible';
	}

	function hide(name) {
		if (gtimeout) {
			clearTimeout(gtimeout);
			gtimeout=null;
		}
		last_shown = null;
		var field = get_element(name);
		if (field.style)
			field = field.style;
		field.visibility = isNN4 ? 'hide' : 'hidden';
	}

