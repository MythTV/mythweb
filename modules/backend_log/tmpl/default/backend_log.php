<?php
/**
 * The display code for the main welcome page that lists the available mythweb
 * sections.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Set the desired page title
    $page_title = 'MythTV - '.t('Backend Logs');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/backend_log.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>
<table id="backend_logs" sortable="true">
    <thead>
        <tr class="header">
            <th>row</th>
            <?php
                foreach (array_keys($Logs[0]) as $key)
                    echo "<th>$key</th>\n";
            ?>
        </tr>
    </thead>
    <?php
        foreach ($Logs as $i => $log) {
            echo '<tr class="',
                 ($i % 2 ? 'even' : 'odd'),
                 "\">\n  <td>$i</td>\n";
            foreach ($log as $col) {
                echo "  <td>$col</td>\n";
            }
            echo '</tr>';
        }
    ?>
</table>

<?php
// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
