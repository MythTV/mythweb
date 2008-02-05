<?php
/**
 * Print the program list
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - ' . t('Program Listing') . ': '.strftime($_SESSION['date_statusbar'], $list_starttime);

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_list.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<script type="application/x-javascript">
    function list_update(timestamp) {
        ajax_add_request();
        new Ajax.Updater($('list_content'),
                         '<?php echo root ?>tv/list',
                         {
                            parameters: {
                                            ajax: true,
                                            time: timestamp
                                        },
                            onComplete: list_update_finished
                         }
                        );
    }

    function list_update_finished() {
        programs_to_load_popups = $$('a.program');
        programs_to_load_popups.reverse();
        ajax_remove_request();
    }

    var programs_to_load_popups;
    function load_popups_automagically() {
        console.profile();
        programs_to_load_popups = $$('a.program');
        programs_to_load_popups.reverse();
        console.profileEnd();
        new PeriodicalExecuter(load_popup_automagically, 1);
    }
    Event.observe(window, 'load', load_popups_automagically);

    function load_popup_automagically(pe) {
        if (pending_ajax_requests != 0)
            return;
        if (programs_to_load_popups.length == 0)
            return;
        var program = programs_to_load_popups.pop();
        var info = program.id.split('-');
        load_tool_tip(program.id, info[1], info[2]);
    }


    function load_tool_tip(element_id, channel_id, start_time) {
        var element = $(element_id);
        if (Tips.hasTip(element) == false) {
            ajax_add_request();
            new Ajax.Request('<?php echo root; ?>tv/get_show_details',
                             {
                                parameters: {
                                                chanid:     channel_id,
                                                starttime:  start_time,
                                                ajax:       true
                                            },
                                onSuccess: add_tool_tip,
                                method:    'get'
                             });
        }
    }

    function add_tool_tip(content) {
        var id = content.responseText.split("\n", 1);
        var details = content.responseText.substr((id[0].length+1));
        if (Tips.hasTip($(id[0])) == false)
            new Tip(id[0], details, { className: 'popup' });
        ajax_remove_request();
    }
</script>

<div id="list_content">
    <?php require_once tmpl_dir.'list_data.php'; ?>
</div>
<?php
// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
