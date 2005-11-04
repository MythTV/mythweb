<?php
/***                                                                        ***\
    program_detail.php                       Last Updated: 2003.08.22 (xris)

    This file defines a theme class for the program details section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_program_detail extends Theme {


    /*
        print_header:
        This function prints the header portion of the page specific to the program listing
    */
    function print_header($start_time, $end_time) {
?>
<vxml>
<?php
    }




    function print_page() {
        global $this_channel, $this_program;

    $this->print_header($list_starttime, $list_endtime);

    // Print the page contents
?>
<prompt>You have selected <?php echo $this_program->title ?> on channel <?php echo $this_channel->channum ?></prompt>
<prompt>at <?php echo date('g:i A', $this_program->starttime) ?> lasting <?php echo (int)($this_program->length/60) ?> minutes</prompt>
<prompt>This programme is <?php echo $this_program->will_record ? '' : 'not' ?> scheduled to record </prompt>

    <form>
      <field name="choice" type="digits?length=1" modal="true">
        <prompt>Press 1 for programme details</prompt>
        <prompt>Press 2 for the next programme</prompt>
        <prompt>Press 3 for the previous programme</prompt>
        <prompt>Press 4 to <?php echo $this_program->will_record ? 'cancel recording of' : 'record' ?> this programme</prompt>
        <prompt>Press Hash to hear these options again</prompt>
        <prompt>Press Star to choose another channel<break time="2s"/></prompt>
      </field>
      <noinput count="1">
        I didn't hear anything
        <reprompt/>
      </noinput>
      <noinput count="2">
        I still didn't hear anything. Last chance
        <reprompt/>
      </noinput>
      <filled>
        <if cond="choice == 1">
          <?php echo $this_program->description ?>
        <reprompt/>
        <elseif cond="choice == 2">
          <submit next="channel_detail.php?chanid=<?php echo $this_program->chanid ?>+time=<?php echo ($this_program->starttime) ?>+action=next" method="get" />
        <elseif cond="choice == 3">
          <submit next="channel_detail.php?chanid=<?php echo $this_program->chanid ?>+time=<?php echo ($this_program->starttime) ?>+action=previous" method="get" />
        <elseif cond="choice == 4">
          <submit next="program_detail.php?chanid=<?php echo $this_channel->chanid ?>+starttime=<?php echo $this_program->starttime ?>" namelist="record=<?php echo $this_program->will_record ? 'never' : 'once' ?>+save=Update" method="post" />
        <elseif cond="choice == #">
          <reprompt/>
        <elseif cond="choice == *">
          <submit next="program_listing.php" method="get" />
        <else>
          That is not a supported option
          <reprompt/>
        </if>
      </filled>
        </form>
</vxml>
<?php
    }

}

