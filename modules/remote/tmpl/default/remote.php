<?php
/**
 * The display code for the Remote module.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Remote
 *
/**/

// Set the desired page title
    $page_title = 'MythFrontend Remote Control';

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/remote.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Print the content itself
?>

<script type="text/javascript">
<!--

// List of enabled frontends
    var frontends = [<?php
        $hosts = array();
        foreach (array_keys($_SESSION['remote']['frontends']) as $host) {
            $hosts[] = "'$host'";
        }
        echo implode(',', $hosts);
        ?>];

// Process the currently-selected frontends to make sure they are still alive.
    Event.observe(window, 'load', verify_frontends);
    function verify_frontends() {
        for (var i=0;i<frontends.length;i++) {
            var host = frontends[i];
            var r = new Ajax.Request('remote/',
                                     {
                                        parameters: 'ping='+encodeURIComponent(host),
                                      asynchronous: false
                                     });
        // Handle the response
            if (r.transport.responseText == '0') {
                $('host_'+host).removeClassName('x-selected');
                frontends.splice(i, 1);
            }
        }
    }

// Handle a request to enable a specific frontend
    function handle_frontend(host) {
        var i = frontends.indexOf(host);
    // Turn a host on (assuming it is alive)
        if (i == -1) {
            var r = new Ajax.Request('remote/',
                                     {
                                        parameters: 'ping='+encodeURIComponent(host),
                                      asynchronous: false
                                     });
        // Handle the response
            if (r.transport.responseText == '0') {
                alert("<?php echo t('$1 is not responding.', '"+host+"') ?>");
                return;
            }
            $('host_'+host).addClassName('x-selected');
            frontends.push(host);
        }
    // Unset an active host?
        else {
            frontends.splice(i, 1);
            $('host_'+host).removeClassName('x-selected');
            new Ajax.Request('remote/',
                             {
                                parameters: 'unping='+encodeURIComponent(host),
                              asynchronous: true
                             });
        }
    }

// -->
</script>

<table id="remote" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td class="x-overview" rowspan="2" valign="top">
        <div class="x-title">
            <?php echo t('Frontends') ?>:
        </div>
<?php
        if (empty($Frontends)) {
            echo t('No Frontends allow remote control.');
        }
        else {
?>
        <div class="x-modules">
            <ul><?php
                foreach (array_keys($Frontends) as $host) {
                    echo '<li><a id="host_', $host, '"',
                         ' onclick="handle_frontend(\'', $host, '\')"';
                    if ($_SESSION['remote']['frontends'][$host])
                        echo ' class="x-selected"';
                    echo '>', html_entities($host), '</a></li>';
                }
                ?></ul>
        </div>
<?php
        }
?>
        </td>
    <td class="x-sections">
        <ul><?php
            foreach (Modules::getModuleProperty('remote', 'links') as $link => $name) {
                echo '<li><a href="', Modules::getModuleProperty('remote', 'path'), '/', $link, '"';
                if ($link == $_REQUEST['type'])
                    echo ' class="x-selected"';
                echo '>', html_entities($name), '</a></li>';
            }
        ?></ul>
        </td>
</tr><tr>
<td class="x-content" colspan="2" valign="top">
<?php
    require_once tmpl_dir.'/'.$_REQUEST['type'].'.php';
?>
</td>
</tr><tr>
    <td class="x-screenshots" colspan="2">
        <ul style="list-style-type: none"><?php
            foreach (array_keys($Frontends) as $host) {
                if (!$_SESSION['remote']['frontends'][$host])
                    next;
                echo '<li><img id="hostscreen_', $host, '" class="x-screenshot"',
                     ' src="', root, html_entities(Modules::getModuleProperty('remote', 'path').'/screenshot?format=jpg&width=960&host='.urlencode($host)),
                     '" /></li>';
            }
            ?></ul>
        </td>
</tr>
</table>
<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
