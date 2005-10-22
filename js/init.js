/**
 * javascript initialization routine, and the content necessary to load the
 * other javascript files.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     LGPL
 *
/**/

    window.onload = init;

// Include some other modules
    document.write('<script type="text/javascript" src="js/utils.js"></script>');
    document.write('<script type="text/javascript" src="js/mouseovers.js"></script>');
    document.write('<script type="text/javascript" src="js/visibility.js"></script>');
    document.write('<script type="text/javascript" src="js/ajax.js"></script>');

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

