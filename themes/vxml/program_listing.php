<?
/***                                                                        ***\
    program_listing.php                      Last Updated: 2003.08.19 (xris)

    This file defines a theme class for the program listing section.
    It must define several methods, some of which have specific
    parameters.   documentation will be added someday.
\***                                                                        ***/


#class theme_program_listing extends Theme {
class Theme_program_listing extends Theme {

    /*
        print_header:
        This function prints the header portion of the page specific to the program listing
    */
    function print_header($start_time, $end_time) {
?>
<vxml>
  <form>
    <field name="channelchoice" type="digits?minlength=1;maxlength=2" modal="true">
      <prompt>Please pick a channel</prompt>
      <prompt>Hash twice will repeat the list</prompt>
<?
    }


    function print_page(&$Channels, &$Timeslots, $list_starttime, $list_endtime) {
    // Display the listing page header
        $this->print_header($list_starttime, $list_endtime);

        // Go through each channel and load/print its info - use references to avoid "copy" overhead
        $channel_count = 0;
        foreach (array_keys($Channels) as $key) {
        // Ignore channels with no number
            if (strlen($Channels[$key]->channum) < 1)
                continue;
        // Count this channel
            $channel_count++;
        // Grab the reference
            $channel = &$Channels[$key];
        // Print the data
            $this->print_channel_block_1(&$channel, $channel_count, $list_starttime, $list_endtime);
        // Cleanup is a good thing
            unset($channel);
        }

        $this->print_mid_block();

        // Go through each channel and load/print its info - use references to avoid "copy" overhead
        $channel_count = 0;
        foreach (array_keys($Channels) as $key) {
        // Ignore channels with no number
            if (strlen($Channels[$key]->channum) < 1)
                continue;
        // Count this channel
            $channel_count++;
        // Grab the reference
            $channel = &$Channels[$key];
        // Print the data
            $this->print_channel_block_2(&$channel, $channel_count, $list_starttime, $list_endtime);
        // Cleanup is a good thing
            unset($channel);
        }


    // Display the listing page footer
        $this->print_footer();
    }


    /*
        print_mid_block:
    */
    function print_mid_block() {
?>
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
<?
    }


    /*
        print_footer:
        This function prints the footer portion of the page specific to the program listing
    */
    function print_footer() {
?>
      <elseif cond="channelchoice == ##">
        <reprompt/>
      <elseif cond="channelchoice == **">
        <submit next="program_listing.php" method="get" />
      <else>
        That is not a supported option
        <reprompt/>
      </if>
    </filled>
  </form>
</vxml>
<?
    }


    /*
        print_channel_block_1:

    */
    function print_channel_block_1($channel, $count, $start_time, $end_time) {
        ?>
    <prompt>Press <?=$count ?> for <?=prefer_channum ? $channel->channum : $channel->callsign?></prompt>
        <?
    }


    /*
        print_channel_block_2:

    */
    function print_channel_block_2($channel, $count, $start_time, $end_time) {
    if ($count > 1)
        echo "      <else";
    else
        echo "      <";
    ?>if cond="channelchoice == <?=$count ?>">
         <submit next="channel_detail.php?chanid=<?=$channel->chanid?>+time=<?=$start_time?>" method="get" />
<?
    }

}

?>
