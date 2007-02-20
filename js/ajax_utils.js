/**
 * The routines to allow a small ajax request counter
 *
 * @url         $URL: http://svn.mythtv.org/svn/trunk/mythplugins/mythweb/js/utils.js $
 * @date        $Date: 2006-07-07 23:05:05 -0700 (Fri, 07 Jul 2006) $
 * @version     $Revision: 10427 $
 * @author      $Author: xris $
 * @license     LGPL
 *
/**/

var pending_ajax_requests = 0;

function ajax_add_request() {
    pending_ajax_requests +=1;
    get_element('ajax_num_requests').innerHTML = pending_ajax_requests;
    remove_class('ajax_working', 'hidden');
}

function ajax_remove_request() {
    pending_ajax_requests -=1;
    get_element('ajax_num_requests').innerHTML = pending_ajax_requests;
    if (pending_ajax_requests == 0)
        add_class('ajax_working', 'hidden');
}