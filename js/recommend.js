function update_feelings(json) {
    ajax_remove_request();
    jQuery('#feelings .active').removeClass('active');

    if (json.likes == 'true')
        jQuery('#feelings .like').addClass('active');
    if (json.mehs == 'true')
        jQuery('#feelings .meh').addClass('active');
    if (json.dislikes == 'true')
        jQuery('#feelings .dislike').addClass('active');
    if (json.stars == 'true')
        jQuery('#feelings .star').addClass('active');
}

function error_handler_feeling ( jqxhr, textStatus, error ) {
    if (console) {
        console.log(jqxhr);
        console.log(textStatus);
        console.log(error);
    }
}

function like() {
    ajax_add_request();
    var inetref = jQuery(this).attr('inetref');

    jQuery.getJSON(
              recommend_server+'/shows/'+inetref+'/like.json?callback=?&auth_token='+recommend_key,
              {} )
        .done(update_feelings)
        .fail(error_handler_feeling);
}

function meh() {
    ajax_add_request();
    var inetref = jQuery(this).attr('inetref');

    jQuery.getJSON(
              recommend_server+'/shows/'+inetref+'/meh.json?callback=?&auth_token='+recommend_key,
              {} )
        .done(update_feelings)
        .fail(error_handler_feeling);
}

function dislike() {
    ajax_add_request();
    var inetref = jQuery(this).attr('inetref');

    jQuery.getJSON(
              recommend_server+'/shows/'+inetref+'/dislike.json?callback=?&auth_token='+recommend_key,
              {} )
        .done(update_feelings)
        .fail(error_handler_feeling);
}

function star() {
    ajax_add_request();
    var inetref = jQuery(this).attr('inetref');

    jQuery.getJSON(
              recommend_server+'/shows/'+inetref+'/star.json?callback=?&auth_token='+recommend_key,
              {} )
            .done(update_feelings)
            .fail(error_handler_feeling);
}

jQuery(document).ready(function() {
    if (recommend_enabled) {
        var inetref = jQuery('#feelings').attr('inetref');
        if (inetref) {
            ajax_add_request();
            jQuery.getJSON(
                recommend_server+'/shows/'+inetref+'.json?callback=?&auth_token='+recommend_key,
                      {} )
            .done(update_feelings)
            .fail(function( jqxhr, textStatus, error ) {
                jQuery('#feelings').hide();
            });
        }
    }
    
    jQuery('div.like').bind( 'click', like);
    jQuery('div.meh').bind( 'click', meh);
    jQuery('div.dislike').bind( 'click', dislike);
    jQuery('div.star').bind( 'click', star);
});
