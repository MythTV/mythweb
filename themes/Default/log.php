<?php
/***                                                                        ***\
    settings.php                            Last Updated: 2004.11.29 (xris)

    main configuration index

    Please be aware that there are many non-translated strings in this page.
    They have been left this way intentionally, because they refer to
    database fields.
\***                                                                        ***/

// Load the parent class for all settings pages
    require_once theme_dir.'settings.php';

class Theme_Logs extends Theme {

    function print_page() {
        global $Logs;
        $this->print_header();
        echo "\n"
            ;
?>

<form class="form" method="post" action="log.php">


<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr align="center">

<b><td>LogID</td>
<td>Module</td>
<td>Log Date</td>
<td>Host</td>
<td>Message</td>
<td>Details</td></b>
</tr>
<?php
        foreach ($Logs as $Log) {
?><tr class="settings" align="center">

    <td><?php echo htmlentities($Log['logid'])?></td>
    <td><?php echo htmlentities($Log['module'])?></td>
    <td><?php echo htmlentities($Log['logdate'])?></td>
    <td><?php echo htmlentities($Log['host'])?></td>
    <td><?php echo htmlentities($Log['message'])?></td>
    <td><?php echo htmlentities($Log['details'])?></td>
    
    
    
   
</tr><?php
        }
?>
</table>


//</form>
<?php
        $this->print_footer();
    }

    function print_header() {
        parent::print_header("MythWeb - BackEnd Logs");
    }

    function print_footer() {
        parent::print_footer();
    }

}
?>
