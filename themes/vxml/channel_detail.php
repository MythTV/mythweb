<?php
/***                                                                        ***\
	channel_detail.php                        Last Updated: 2003.07.23 (xris)

	This file defines a theme class for the channel detail section.
	It must define one method.   documentation will be added someday.

\***                                                                        ***/

class Theme_channel_detail extends Theme {


	/*
		print_header:
		This function prints the header portion of the page specific to the program listing
	*/
	function print_header($start_time, $end_time) {
		global $this_channel;
?>
<vxml>
  <form>
    <field name="choice" type="digits?minlength=1;maxlength=2" modal="true">
      <prompt>Channel <?=$this_channel->channum?></prompt><?
	}


	function print_page() {
	// Print the main page header
		global $this_channel;
   	$this->print_header($list_starttime, $list_endtime);

	// No search was performed, just return
		if (!is_array($this_channel->programs))
			return;

	// List the shows
		$this->print_shows_1();

   	$this->print_mid_block();

		$this->print_shows_2();

	// Print the main page footer
   	$this->print_footer();
	}



	/*
		print_mid_block:
	*/
	function print_mid_block() {
?> 
      <prompt>Press hash twice to repeat the list or star twice to go back to the channel list</prompt> 
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


	function print_footer() {
?>
      <elseif cond="choice == ##">
        <reprompt/>
      <elseif cond="choice == **">
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


	function print_shows_1() {
		global $this_channel;
	// Display the results
		$row = 0;
		foreach ($this_channel->programs as $show) {
	?>
    
<?php
	  $row++;
		echo '      <prompt>Press '.$row.' for '.$show->title.'</prompt>';
		}
	}


	function print_shows_2() {
		global $this_channel;
	// Display the results
		$row = 0;
		foreach ($this_channel->programs as $show) {
	  $row++;
    if ($row > 1)
        echo "      <else";
    else
        echo "      <";
    ?>if cond="choice == <?=$row ?>">
         <submit next="program_detail.php?chanid=<?=$show->chanid?>+starttime=<?=$show->starttime?>" method="get" />
<?
	}
  }

}

?>
