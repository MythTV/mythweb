/***                                                                        ***\
    init.js                                  Last Updated: 2003.02.10 (xris)
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
		if (e.pageX || e.pageY) {
			mouse_x = e.pageX;
			mouse_y = e.pageY;
		}
		else {
			mouse_x = e.x + document.body.scrollLeft;
			mouse_y = e.y + document.body.scrollTop;
		}
	}

	if (isNN4)
		document.captureEvents(Event.MOUSEDOWN | Event.MOUSEMOVE);
	document.onmousemove = grabEv;

// Functions to show/hide sections of the page (for mouseovers)

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
		gtimeout = setTimeout("timed_show()",100);
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
	// Add some padding
		var x = parseInt(mouse_x + 10);
		var y = parseInt(mouse_y + 10);
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

