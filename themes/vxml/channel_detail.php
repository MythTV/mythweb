<?php
/***                                                                        ***\
    channel_detail.php                        Last Updated: 2003.07.23 (xris)

  For each show we print a block that looks like this; which reads the show
  title whilst checking for * or # hit during the reading of the title.

    <form>
      <field name="keyhit" type="digits?length=1" modal="true">
        <prompt>6-30 pm Starsky and Hutch<break time="400ms"/></prompt>
      </field>
      <filled>
        <if cond="keyhit == #">
          <submit next="channel_detail.php?...." method="get" />
        <if cond="keyhit == *">
          <submit next="program_detail.php?...." method="get" />
        </if>
      </filled>
    </form>

  If the calling parameter is set action=next or action=previous; then this just creates a
  jump to the programme details of the next programme after the indicated time; i.e.

    <submit next="program_detail.php?...." method="get" />

\***                                                                        ***/

class Theme_channel_detail extends Theme {


    /*
        print_header:
        This function prints the header portion of the page specific to the program listing
    */
    function print_header() {
        global $this_channel;
?>
<vxml>
  <prompt>Channel <?php echo $this_channel->channum ?></prompt>
  <prompt>Press star to select a program or hash to replay the list</prompt>
<?php
    }


    function print_page() {
        global $this_channel;
    $start_time = $_SESSION['list_time'];

    // No search was performed, just return
        if (!is_array($this_channel->programs))
            return;

  // Check for next/previous actions. These are returned from programme_detail to move back/forward.
    if ($_GET['action'] == "next") {
      foreach ($this_channel->programs as $show) {
        if ($show->starttime > $start_time) {
          ?><vxml><submit next="program_detail.php?chanid=<?php echo $show->chanid ?>+starttime=<?php echo $show->starttime ?>" method="get" /></vxml><?php
          return;
        }
      }
      // No shows later; redo current show
      ?><vxml><submit next="program_detail.php?chanid=<?php echo $show->chanid ?>+starttime=<?php echo $start_time ?>" method="get" /></vxml><?php
    }

  // Check for next/previous actions. These are returned from programme_detail to move back/forward.
    if ($_GET['action'] == "previous") {
      $prev_show = $this_channel->programs[0];
      foreach ($this_channel->programs as $show) {
        if ($show->starttime >= $start_time)
        {
          ?><vxml><submit next="program_detail.php?chanid=<?php echo $show->chanid ?>+starttime=<?php echo $prev_show->starttime ?>" method="get" /></vxml><?php
          return;
        }
        $prev_show = $show;
      }
      // No shows later; redo current show
      ?><vxml><submit next="program_detail.php?chanid=<?php echo $show->chanid ?>+starttime=<?php echo $start_time ?>" method="get" /></vxml><?php
    }

    // Print the main page header
    $this->print_header();

    // List the shows
        $this->print_shows_1($_SESSION['list_time']);

    // Print the main page footer
    $this->print_footer();
    }



    function print_footer() {
?>
  <form>
    <field name="keyhit" type="digits?length=1" modal="true">
      <prompt>Press Hash to play the list again or star to pick another channel<break time="3s"/></prompt>
    </field>
    <filled>
      <if cond="keyhit == #">
        <submit next="channel_detail.php?chanid=<?php echo $this_channel->chanid ?>+time=<?php echo $_SESSION['list_time'] ?>" method="get" />
      <elseif cond="keyhit == *">
        <submit next="program_listing.php" method="get" />
      </elseif>
      </if>
    </filled>
  </form>
  <prompt>Goodbye</prompt>
</vxml>
<?php
    }


    function print_shows_1($start_time) {
        global $this_channel;
        global $list_starttime;
    // Display the results
        $row = 0;
        foreach ($this_channel->programs as $show) {
    ?><?php
      $row++;
    if ($show->starttime + $show->length < $start_time)
        continue;
?>
    <form>
      <field name="keyhit" type="digits?length=1" modal="true">
        <prompt><?php echo date('g:i A', $show->starttime) ?> <?php echo $show->title ?><break time="400ms"/></prompt>
      </field>
      <filled>
        <if cond="keyhit == #">
          <submit next="channel_detail.php?chanid=<?php echo $show->chanid ?>+time=<?php echo $start_time ?>" method="get" />
        <elseif cond="keyhit == *">
          <submit next="program_detail.php?chanid=<?php echo $show->chanid ?>+starttime=<?php echo $show->starttime ?>" method="get" />
        </elseif>
        </if>
      </filled>
    </form><?php
        }
    }


}

