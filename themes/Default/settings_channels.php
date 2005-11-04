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

class Theme_settings_channels extends Theme_settings {

    function print_page() {
        global $Channels;
        $this->print_header();
        echo "\n"
            .t('Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.');
?>

<form class="form" method="post" action="settings_channels.php">

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu" align="center">
    <td width="4%"><?php  echo t('delete')       ?></td>
    <td width="4%"><?php  echo t('sourceid')     ?></td>
    <td width="5%"><?php  echo t('channum')      ?></td>
    <td width="12%"><?php echo t('callsign')     ?></td>
    <td width="25%"><?php echo t('name')         ?></td>
    <td width="5%"><?php  echo t('freqid')       ?></td>
    <td width="5%"><?php  echo t('finetune')     ?></td>
    <td width="5%"><?php  echo t('videofilters') ?></td>
    <td width="7%"><?php  echo t('brightness')   ?></td>
    <td width="7%"><?php  echo t('contrast')     ?></td>
    <td width="7%"><?php  echo t('colour')       ?></td>
    <td width="7%"><?php  echo t('hue')          ?></td>
    <td width="5%"><?php  echo t('recpriority')  ?></td>
    <td width="5%"><?php  echo t('commfree')     ?></td>
    <td width="5%"><?php  echo t('visible')      ?></td>
    <td width="5%"><?php  echo t('useonairguide') ?></td>
</tr><?php
        foreach ($Channels as $channel) {
?><tr class="settings" align="center">
    <td><input type="checkbox" name="delete_<?php echo $channel['chanid']?>" id="delete_<?php echo $channel['chanid']?>" value="true"></td>
    <td><?php echo htmlentities($channel['sourceid'])?></td>
    <td><input type="text" size="3" name="channum_<?php echo $channel['chanid']?>" id="channum_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['channum'])?>"></td>
    <td><input type="text" size="15" name="callsign_<?php echo $channel['chanid']?>" id="callsign_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['callsign'])?>"></td>
    <td><input type="text" size="27" name="name_<?php echo $channel['chanid']?>" id="name_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['name'], ENT_COMPAT, 'UTF-8')?>"></td>
    <td><input type="text" size="3" name="freqid_<?php echo $channel['chanid']?>" id="freqid_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['freqid'])?>"></td>
    <td><input type="text" size="3" name="finetune_<?php echo $channel['chanid']?>" id="finetune_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['finetune'])?>"></td>
    <td><input type="text" size="3" name="videofilters_<?php echo $channel['chanid']?>" id="videofilters_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['videofilters'])?>"></td>
    <td><input type="text" size="6" name="brightness_<?php echo $channel['chanid']?>" id="brightness_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['brightness'])?>"></td>
    <td><input type="text" size="6" name="contrast_<?php echo $channel['chanid']?>" id="contrast_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['contrast'])?>"></td>
    <td><input type="text" size="6" name="colour_<?php echo $channel['chanid']?>" id="colour_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['colour'])?>"></td>
    <td><input type="text" size="6" name="hue_<?php echo $channel['chanid']?>" id="hue_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['hue'])?>"></td>
    <td><input type="text" size="2" name="recpriority_<?php echo $channel['chanid']?>" id="recpriority_<?php echo $channel['chanid']?>" value="<?php echo htmlentities($channel['recpriority'])?>"></td>
    <td><input type="checkbox" name="commfree_<?php echo $channel['chanid']?>" <?php if (htmlentities($channel['commfree'])) echo "CHECKED" ?> ></td>
    <td><input type="checkbox" name="visible_<?php echo $channel['chanid']?>" <?php if (htmlentities($channel['visible'])) echo "CHECKED" ?> ></td>
    <td><input type="checkbox" name="useonairguide_<?php echo $channel['chanid']?>" <?php if (htmlentities($channel['useonairguide'])) echo "CHECKED" ?> ></td>
</tr><?php
        }
?>
</table>

<p align="center">
<input type="submit" name="save" value="<?php echo t('Save')?>">
</p>

</form>
<?php
        $this->print_footer();
    }

    function print_header() {
        parent::print_header("MythWeb - " . t('Configure Channels'));
    }

    function print_footer() {
        parent::print_footer();
    }

}
?>
