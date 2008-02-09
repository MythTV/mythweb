/**
 * The routines to allow a small ajax request counter
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     LGPL
 *
/**/

var pending_ajax_requests = 0;

function ajax_add_request() {
    pending_ajax_requests += 1;
    $('ajax_num_requests').innerHTML = pending_ajax_requests;
    $('ajax_working').removeClassName('hidden');
}

function ajax_remove_request() {
    pending_ajax_requests -= 1;
    $('ajax_num_requests').innerHTML = pending_ajax_requests;
    if (pending_ajax_requests == 0)
        $('ajax_working').addClassName('hidden');
}
