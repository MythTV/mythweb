<?php
/***                                                                        ***\
    settings_keys.php
    keybindings config
\***                                                                        ***/

// Load the parent class for all settings pages
    require_once theme_dir.'settings.php';

class Theme_settings_keys extends Theme_settings {

    function print_page() {
        global $Hosts;
        global $usehost;
        global $Jumps;
        global $Keys;
        $this->print_header();
?>
<table align="center" width="40%" cellspacing="2" cellpadding="2">
<tr>
    <td width="50%" class="command command_border_l command_border_t command_border_b command_border_r" align="center">
    <form class="form" action="settings_keys.php" method="get">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
        <td nowrap align="center"><?php echo t('Edit keybindings on') ?>:&nbsp;&nbsp;</td>
            <td><select name="host" style="text-align: right">
<?php
        foreach ($Hosts as $availhost) {
            echo '<option value='.$availhost['hostname'];
            if ($availhost['hostname'] == $usehost)
                echo ' SELECTED';
            echo '>'.$availhost['hostname'].'</option>';
        }
?>
        </select></td>
        <td align="center"><input type="submit" class="submit" value="Set Host"></td>
    </tr>
    </table>
    </form>
    </td>
</tr>
</table>
<p><p>
<p class="large">
Note:  This settings page has absolutely no error checking yet.  You can easily screw things up if you're not careful.
</p>
<p class="large">
Note:  JumpPoints are globally active.  If you set a keybinding for a JumpPoint that is that same as one defined in the Keybindings section, the JumpPoint will override the keybinding.
</p>
<p class="large">
Note:  You probably want to use function keys or keys combined with a modifier (alt, control) for JumpPoints, otherwise you may run into some problems.
</p>
<p class = "large">
Note:  Changes to keybindings/jumppoints requires a restart of the affected mythfrontend for now.  This will change in a future release.
</p>
<form class="form" method="post" action="settings_keys.php">
<table border="0" cellpadding="4" cellspacing="2" class="list small" align="center">
<tr class="menu large" align="center">
    <td colspan="3">JumpPoints Editor</td>
</tr>
<tr class="menu" align="center">
    <td width="33%">Destination</td>
    <td width="33%">Description</td>
    <td width="33%">Key bindings</td>
</tr><?php
        foreach ($Jumps as $jumppoint) {
?><tr class="settings" align="center">
    <td><?php echo htmlentities($jumppoint['destination'])?></td>
    <td><?php echo htmlentities($jumppoint['description'])?></td>
    <td><input type="text" size="35" name="jump:<?php echo $jumppoint['destination'].':'.$usehost?>" value="<?php echo str_replace("\\\\", "\\", htmlentities($jumppoint['keylist']))?>"></td>
</tr>
<?php
        }
?>
</table>
<p></p>
<table border="0" cellpadding="4" cellspacing="2" class="list small" align="center">
<tr class="menu large" align="center">
        <td colspan="4">Keybindings Editor</td>
</tr>
<tr class="menu" align="center">
        <td width="15%">Context</td>
        <td width="25%">Action</td>
        <td width="40%">Description</td>
        <td width="20%">Key bindings</td>
</tr><?php
                foreach ($Keys as $keyb) {
?><tr class="settings" align="center">
        <td><?php echo htmlentities($keyb['context'])?></td>
        <td><?php echo htmlentities($keyb['action'])?></td>
        <td><?php echo htmlentities($keyb['description'])?></td>
        <td><input type="text" size="25" name="key:<?php echo $keyb['context'].':'.$keyb['action'].':'.$usehost?>" value="<?php echo str_replace("\\\\", "\\", htmlentities($keyb['keylist']))?>
"></td>
</tr>
<?php
                }
?>
</table>

<p align="center">
<input type="submit" name="save" value="Save">
</p>

</form>
<?php
        $this->print_footer();
        }

    function print_header() {
        parent::print_header("MythWeb - Configure Keybindings");
    }

    function print_footer() {
        parent::print_footer();
    }

}
?>
