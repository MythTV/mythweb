<?php
/**
 * Configure MythTV Channel info
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/
?>
<form class="form" method="post" action="<?php echo form_action ?>">

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu" align="center">
    <td width="4%"><?php  echo t('delete')        ?></td>
    <td width="4%"><a href="<?php echo form_action ?>?sortby=sourceid"><?php  echo t('sourceid') ?></a></td>
    <td width="4%"><a href="<?php echo form_action ?>?sortby=xmltvid"><?php  echo t('xmltvid') ?></a></td>
    <td width="5%"><a href="<?php echo form_action ?>?sortby=channum"><?php  echo t('channum') ?></a></td>
    <td width="5%"><a href="<?php echo form_action ?>?sortby=callsign"><?php echo t('callsign') ?></a></td>
    <td width="5%"><a href="<?php echo form_action ?>?sortby=name"><?php     echo t('name') ?></a></td>
    <td width="5%"><a href="<?php echo form_action ?>?sortby=freqid"><?php   echo t('freqid') ?></a></td>
    <td width="5%"><?php  echo t('finetune')      ?></td>
    <td width="5%"><?php  echo t('videofilters')  ?></td>
    <td width="7%"><?php  echo t('brightness')    ?></td>
    <td width="7%"><?php  echo t('contrast')      ?></td>
    <td width="7%"><?php  echo t('color')         ?></td>
    <td width="7%"><?php  echo t('hue')           ?></td>
    <td width="5%"><?php  echo t('recpriority')   ?></td>
    <td width="5%"><?php  echo t('commfree')      ?></td>
    <td width="5%"><?php  echo t('visible')       ?></td>
    <td width="5%"><?php  echo t('useonairguide') ?></td>
</tr><?php
    foreach ($channels as $chanid) {
        $channel =& Channel::find($chanid);
?><tr class="settings" align="center">
    <td><input type="checkbox" name="channel[<?php echo $channel->chanid ?>][delete]" id="delete_<?php echo $channel->chanid ?>" value="true" /></td>
    <td><?php echo html_entities($channel->sourceid) ?></td>
    <td><input type="text" size="5"  name="channel[<?php echo $channel->chanid ?>][xmltvid]"       id="xmltvid_<?php      echo $channel->chanid ?>" value="<?php echo html_entities($channel->xmltvid)      ?>" style="text-align: center" /></td>
    <td><input type="text" size="3"  name="channel[<?php echo $channel->chanid ?>][channum]"       id="channum_<?php      echo $channel->chanid ?>" value="<?php echo html_entities($channel->channum)      ?>" style="text-align: center" /></td>
    <td><input type="text" size="10" name="channel[<?php echo $channel->chanid ?>][callsign]"      id="callsign_<?php     echo $channel->chanid ?>" value="<?php echo html_entities($channel->callsign)     ?>" /></td>
    <td><input type="text" size="27" name="channel[<?php echo $channel->chanid ?>][name]"          id="name_<?php         echo $channel->chanid ?>" value="<?php echo html_entities($channel->name) ?>" /></td>
    <td><input type="text" size="3"  name="channel[<?php echo $channel->chanid ?>][freqid]"        id="freqid_<?php       echo $channel->chanid ?>" value="<?php echo html_entities($channel->freqid)       ?>" style="text-align: center" /></td>
    <td><input type="text" size="3"  name="channel[<?php echo $channel->chanid ?>][finetune]"      id="finetune_<?php     echo $channel->chanid ?>" value="<?php echo html_entities($channel->finetune)     ?>" style="text-align: center" /></td>
    <td><input type="text" size="3"  name="channel[<?php echo $channel->chanid ?>][videofilters]"  id="videofilters_<?php echo $channel->chanid ?>" value="<?php echo html_entities($channel->videofilters) ?>" style="text-align: center" /></td>
    <td><input type="text" size="5"  name="channel[<?php echo $channel->chanid ?>][brightness]"    id="brightness_<?php   echo $channel->chanid ?>" value="<?php echo html_entities($channel->brightness)   ?>" style="text-align: center" /></td>
    <td><input type="text" size="5"  name="channel[<?php echo $channel->chanid ?>][contrast]"      id="contrast_<?php     echo $channel->chanid ?>" value="<?php echo html_entities($channel->contrast)     ?>" style="text-align: center" /></td>
    <td><input type="text" size="5"  name="channel[<?php echo $channel->chanid ?>][colour]"        id="colour_<?php       echo $channel->chanid ?>" value="<?php echo html_entities($channel->colour)       ?>" style="text-align: center" /></td>
    <td><input type="text" size="5"  name="channel[<?php echo $channel->chanid ?>][hue]"           id="hue_<?php          echo $channel->chanid ?>" value="<?php echo html_entities($channel->hue)          ?>" style="text-align: center" /></td>
    <td><input type="text" size="2"  name="channel[<?php echo $channel->chanid ?>][recpriority]"   id="recpriority_<?php  echo $channel->chanid ?>" value="<?php echo html_entities($channel->recpriority)  ?>" style="text-align: center" /></td>
    <td><input type="checkbox"       name="channel[<?php echo $channel->chanid ?>][commfree]"      value="1"<?php if (!empty($channel->commmethod) && $channel->commmethod == -2)      echo ' CHECKED' ?> /></td>
    <td><input type="checkbox"       name="channel[<?php echo $channel->chanid ?>][visible]"       value="1"<?php if (!empty($channel->visible))       echo ' CHECKED' ?> /></td>
    <td><input type="checkbox"       name="channel[<?php echo $channel->chanid ?>][useonairguide]" value="1"<?php if (!empty($channel->useonairguide)) echo ' CHECKED' ?> /></td>
</tr><?php
    }
?>
</table>

<p align="center">
<input type="submit" name="save" value="<?php echo t('Save') ?>">
</p>

</form>
