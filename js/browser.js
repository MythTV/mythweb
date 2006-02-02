/**
 * Revised/updated javascript browser detection.
 *
 * Based loosely on the ideas found here:
 *
 *     http://webreference.com/tools/browser/javascript.html
 *     http://www.mozilla.org/docs/web-developer/sniffer/browser_type.html
 *
 * Rewritten from scratch to be LGPL and easier to maintain.  Also removed
 * support for some really old browsers that no one should be running anymore.
 *
 * I've left out detection of weird/nonstandard browsers and OS's because they
 * represent such a tiny portion of the market that I don't expect any of my
 * javascript code to work with them, anyway.  I've also decided to drop
 * support for anything earlier than version 4 browsers because of their lack
 * of the RegExp object.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @copyright   Silicon Mechanics
 * @license     LGPL
 *
 * @package     SiMech
 * @subpackage  Javascript
 *
/**/

// To avoid stepping on other variables, store everything in its own object
    var browser = new Object();

// Get lowercase versions of the browser agent and app version strings for
// easier testing.
    browser.ua    = navigator.userAgent.toLowerCase();
    browser.v_app = navigator.appVersion.toLowerCase();

// Default minor version (major is calculated below)
    browser.v_minor = parseFloat(browser.v_app);

/***************************** Operating Systems *****************************/

    browser.is_mac     = (browser.ua.indexOf('mac')     != -1);
    browser.is_bsd     = (browser.ua.indexOf('bsd')     != -1);
    browser.is_freebsd = (browser.ua.indexOf('freebsd') != -1);
    browser.is_linux   = (browser.ua.indexOf('linux')   != -1);
    browser.is_solaris = (browser.ua.indexOf('sunos')   != -1);
    browser.is_x11     = (browser.ua.indexOf('x11')     != -1);
    browser.is_win     = (!browser.is_mac      && !browser.is_bsd
                          && !browser.is_linux && !browser.is_solaris && !browser.is_x11
                          && (browser.ua.indexOf('windows')  != -1
                              || browser.ua.indexOf('16bit') != -1
                              || browser.ua.indexOf('32bit') != -1));

/***************************** User Environment *****************************/

// Screen dimensions
    browser.screen_w  = parseInt(screen.width);
    browser.screen_h  = parseInt(screen.height);

// Window dimensions
    if (document.documentElement && document.documentElement.clientWidth) {
        browser.window_w = parseInt(document.documentElement.clientWidth);
        browser.window_h = parseInt(document.documentElement.clientHeight);
    }
    else if (document.body && document.body.clientWidth) {
        browser.window_w = parseInt(document.body.clientWidth);
        browser.window_h = parseInt(document.body.clientHeight);
    }
    else {
        browser.window_w = parseInt(window.innerWidth);
        browser.window_h = parseInt(window.innerHeight);
    }

// Window position
    if (window.screenLeft || window.screenTop) {
        browser.window_l = parseInt(window.screenLeft);
        browser.window_t = parseInt(window.screenTop);
    } else {
        browser.window_l = parseInt(window.screenX);
        browser.window_t = parseInt(window.screenY);
    }

/********************************* Browsers *********************************/

// Spoofing browsers
    browser.is_spoofer    = (browser.ua.indexOf('spoofer')    != -1);
    browser.is_compatible = (browser.ua.indexOf('compatible') != -1);

// Opera
    browser.is_opera = (browser.ua.indexOf('opera') != -1);
    browser.v_opera = browser.is_opera
                        ? parseFloat(browser.ua.match(RegExp('opera[\\s/]+([0-9\.]+)'))[1])
                        : 0;
    if (browser.v_opera > 0)
        browser.v_minor = parseFloat(browser.v_opera);

// Apple's webkit is the whole package surrounding their version of KHTML.  If
// a browser uses the webkit, it should be considered identical to safari.
    browser.is_applewebkit = (!browser.is_opera && browser.is_mac && browser.ua.indexOf('applewebkit') != -1);
    browser.v_applewebkit  = browser.is_applewebkit
                               ? parseFloat(browser.ua.match(RegExp('applewebkit[\\s/]+([0-9\.]+)'))[1])
                               : 0;

// Safari
    browser.is_safari = (browser.is_mac && browser.ua.indexOf('safari') != -1);
    browser.v_safari  = browser.is_safari
                          ? parseFloat(browser.ua.match(RegExp('safari[\\s/]+([0-9\.]+)'))[1])
                          : 0;
    if (browser.v_safari > 0)
       browser.v_minor = parseFloat(browser.v_safari);

// Shiira, another mac browser (it will also show up as safari)
    browser.is_shiira = (browser.is_mac && browser.ua.indexOf('shiira') != -1);
    browser.v_shiira  = browser.is_shiira
                          ? parseFloat(browser.ua.match(RegExp('shiira[\\s/]+([0-9\.]+)'))[1])
                          : 0;
    if (browser.v_shiira > 0)
       browser.v_minor = parseFloat(browser.v_shiira);

// Konqueror
    browser.is_konq = (browser.ua.indexOf('konqueror') != -1);
    browser.v_konq  = browser.is_konq
                        ? parseFloat(browser.ua.match(RegExp('konqueror[\\s/]+([0-9\.]+)'))[1])
                        : 0;
    if (browser.v_konq > 0)
       browser.v_minor = parseFloat(browser.v_konq);

// KHTML
    browser.is_khtml = (browser.is_applewebkit || browser.ua.indexOf('khtml') != -1);

// Internet Explorer
    browser.is_ie = (!browser.is_opera && !browser.is_khtml && browser.ua.indexOf('msie') != -1);
    if (browser.is_ie && browser.ua.indexOf('msie 5.5') != -1)
        browser.v_ie = 5.5;
    else
        browser.v_ie  = browser.is_ie
                            ? parseFloat(browser.ua.match(RegExp('msie[\\s/]+([0-9\.]+)'))[1])
                            : 0;
    if (browser.v_ie > 0)
       browser.v_minor = parseFloat(browser.v_ie);

// Gecko browsers
    browser.is_gecko = (!browser.is_opera && !browser.is_khtml && !browser.is_ie
                        && browser.ua.indexOf('gecko') != -1);
    browser.v_gecko  = browser.is_gecko
                         ? navigator.productSub
                         : 0;

    browser.is_firefox = false;
    browser.is_camino  = false;
    browser.is_mozilla = false;
    if (browser.is_gecko         && !browser.is_spoofer && !browser.is_compatible
            && !browser.is_opera && !browser.is_webtv   && !browser.is_hotjava) {
    // Mozilla browsers
        if (browser.ua.indexOf('mozilla/5') != -1) {
        // Camino
            browser.is_camino = (navigator.vendor=='Camino' || browser.ua.indexOf('camino') != -1);
            browser.v_camino  = browser.is_camino
                                  ? parseFloat(browser.ua.match(RegExp('camino[\\s/]+([0-9\.]+)'))[1])
                                  : 0;
            if (browser.v_camino)
                browser.v_minor = browser.v_camino;
        // Firefox (or firebird)
            browser.is_firefox = (navigator.vendor == 'Firefox'     || browser.ua.indexOf('firefox')  != -1
                                  || navigator.vendor == 'Firebird' || browser.ua.indexOf('firebird') != -1);
            browser.v_firefox  = browser.is_firefox
                                   ? parseFloat(browser.ua.match(RegExp('firefox[\\s/]+([0-9\.]+)'))[1])
                                   : 0;
            if (browser.v_firefox)
                browser.v_minor = browser.v_firefox;
        // Vanilla Mozilla
            browser.is_mozilla = (!browser.is_firefox && !browser.is_camino
                                  && (navigator.vendor == '' || navigator.vendor == 'Mozilla' || navigator.vendor == 'Debian'));
            if (browser.is_mozilla) {
                browser.v_mozilla = (navigator.vendorSub) ? navigator.vendorSub : 0;
                if (!browser.v_mozilla)
                    browser.v_mozilla = parseFloat(browser.ua.match(RegExp(';\\s*rv\:\\s*(.+?)\\)'))[1]);
                browser.v_minor   = parseFloat(browser.v_mozilla);
            }
        }
    // Netscape Navigator
        if (!browser.is_gecko && !browser.is_camino && !browser.is_mozilla
                && browser.ua.indexOf('mozilla') != -1) {
            browser.is_navigator = true;
        // Netscape 6
            if (navigator.vendor && navigator.vendor.match(RegExp('^Netscape6?$'))) {
                browser.v_navigator = parseFloat(navigator.vendorSub);
                browser.v_minor     = browser.v_navigator;
            }
        // Navigator-only
            browser.is_navigator_only = (browser.ua.match(RegExp('; ?nav')));
        }
    }

// KNOWN BUG: AOL 4 returns false if IE 3 is the embedded browser or if it is
// the first browser window opened.  Thus is_aol isn't completely reliable, as
// it may show up as version 3 due to the IE version.
    browser.is_aol = (browser.ua.indexOf('aol') != -1);
    if (browser.is_aol && is_ie && browser.v_ie <= 4)
        browser.v_aol = browser.v_ie;
    else
        browser.v_aol = browser.is_aol
                            ? parseFloat(browser.ua.match(RegExp('aol[\\s/]*([0-9\.]+)'))[1])
                            : 0;
    if (browser.v_aol)
        browser.v_minor = browser.v_aol;

// Lastly, calculate the major version from the minor version
    browser.v_major = parseInt(browser.v_minor);

/***************************** Browser Features *****************************/

// Couple of useful checks
    browser.is_css = (document.body  && document.body.style)
    browser.is_w3c = (browser.is_css && browser.getElementById)

// Cookie support
    var tmp = document.cookie;
	document.cookie = 'cookies=true';
	browser.cookies = (document.cookie) ? true : false;
    document.cookie = tmp;

// Java support
	browser.java = navigator.javaEnabled();

/****************************** Plugin Support ******************************/

// Various plugins
    browser_check_plugin('flash',     'application/x-shockwave-flash', 'ShockwaveFlash.ShockwaveFlash');
    browser_check_plugin('realaudio', 'audio/x-pn-realaudio-plugin',   'rmocx.RealPlayer G2 Control');
    browser_check_plugin('quicktime', 'video/quicktime',               'QuickTimeCheckObject.QuickTimeCheck');
    browser_check_plugin('wma',       'application/x-mplayer2',        'MediaPlayer.MediaPlayer');

// There are two different strings for acrobat detection in IE
    browser_check_plugin('pdf',       'application/pdf',               'AcroPDF.PDF');  // Acrobat 7
    if (!browser.pdf)
        browser_check_plugin('pdf',   'application/pdf',               'PDF.PdfCtrl');  // Acrobat <= 6
    if (browser.v_pdf == 1)
        browser.v_pdf = 4;

// Multiple checks for SVG support
    browser_check_plugin('svg',       'image/svg+xml',                 'Adobe.SVGCtl');
    if (!browser.svg)
        browser.svg = document.implementation.hasFeature('org.w3c.dom.svg', '');

// A function to simplify detecting plugins
    function browser_check_plugin(prop, mime_type, plugin_name) {
        browser[prop]        = false;
        browser['v_' + prop] = 0;
    // Smart browsers
        if (navigator.mimeTypes.length > 0) {
            var plugin = navigator.mimeTypes[mime_type]
                            ? navigator.mimeTypes[mime_type].enabledPlugin
                            : null;
            if (plugin && plugin.description) {
                browser[prop]        = true;
                browser['v_' + prop] = parseInt(plugin.description.substring(plugin.description.indexOf('.') - 1));
            }
        }
    // IE
        else if (browser.is_ie && !browser.is_mac) {
            document.write('<scr' + 'ipt language="VBScript">'          + '\n' +
                           'Dim has_plugin, plugin_version'             + '\n' +
                           'has_plugin     = false'                     + '\n' +
                           'plugin_version = 10'                        + '\n' +
                           'Do While plugin_version > 0'                + '\n' +
                           '   On Error Resume Next'                    + '\n' +
                           '   has_plugin = (IsObject(CreateObject("' + plugin_name + '." & plugin_version)))' + '\n' +
                           '   If has_plugin = true Then Exit Do'       + '\n' +
                           '   plugin_version = plugin_version - 1'     + '\n' +
                           'Loop'                                       + '\n' +
                           'browser.v_' + prop + ' = playerversion'     + '\n' +
                           'browser.'   + prop + ' = has_plugin'        + '\n' +
                           '<\/sc' + 'ript>'
                          );
        }
   }

