<?
/***                                                                        ***\
	program_detail.php                       Last Updated: 2003.08.22 (xris)

	This file defines a theme class for the program details section.
	It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_program_detail extends Theme {

	function print_page() {
		global $this_channel, $this_program;
	// Print the main page header
		parent::print_header("MythWeb - Program Detail:  $this_program->title");
	// Print the page contents
?>
<a href="channel_detail.php?chanid=<?=$this_channel->chanid?>" >
<?=prefer_channum ? $this_channel->channum : $this_channel->callsign?> &nbsp;
<?=prefer_channum ? $this_channel->callsign : $this_channel->channum?></a><br>

<?=$this_program->title?><BR>
<?=date('D m/d/y', $$this_program->starttime)?><br>
<?=date('g:i A', $this_program->starttime)?> to <?=date('g:i A', $this_program->endtime)?> (<?=(int)($this_program->length/60)?> minutes)<BR>
				<?
				if ($this_program->previouslyshown)
					echo '(Rerun) ';
//				if ($this_program->category_type == 'movie')
//					echo " (<a href=\"http://www.imdb.com/Find?select=Titles&for=" . urlencode($this_program->title) . "\">Search IMDB</a>)";
//				else
//					echo " (<a href=\"http://www.google.com/search?q=" . urlencode($this_program->title) . "\">Search Google</a>)";
				?>
		<? if (strlen($this_program->subtitle)) { ?>
			Episode: <b><?=$this_program->subtitle?></b><br>
		<? }
           if (strlen($this_program->description)) {?>
				Description: <?=$this_program->description?><br>
		<? } ?>
		<? if (strlen($this_program->category)) {?>
				Category: <?=$this_program->category?><br>
		<? }
  		   if (strlen($this_program->airdate)) {?>
				Orig. Airdate: <?=$this_program->airdate?><br>
		<? }
		   if (strlen($this_program->rating)) {?>
				<?=strlen($this_program->rater) > 0 ? "$this_program->rater " : ''?>Rating: <?=$this_program->rating?><br>
		<?
		   if (strlen($this_program->starstring) > 0)
					echo ", $this_program->starstring";
				?><br>
		<? } ?>

		<form action="program_detail.php" method="get" name="record_settings">
		<input type="hidden" name="chanid" value="<?=$_GET['chanid']?>">
		<input type="hidden" name="starttime" value="<?=$_GET['starttime']?>">
<br>
		<center>Recording Options:</center>
					<input type="radio" class="radio" name="record" value="never" id="record_never"<?=
					$this_program->will_record ? '' : ' CHECKED'?>></input>
  <a>Don't record</a><br>
					<input type="radio" class="radio" name="record" value="once" id="record_once"<?=
					$this_program->record_once ? ' CHECKED' : ''?>></input>
  <a>Record showing</a><br>
					<input type="radio" class="radio" name="record" value="daily" id="record_daily"<?=
					$this_program->record_daily ? ' CHECKED' : ''?>></input>
  <a>Record every day</a> at this time<br>
					<input type="radio" class="radio" name="record" value="weekly" id="record_weekly"<?=
					$this_program->record_weekly ? ' CHECKED' : ''?>></input> 
  <a>Record every week</a> at this time<br>
					<input type="radio" class="radio" name="record" value="channel" id="record_channel"<?=
					$this_program->record_channel ? ' CHECKED' : ''?>></input> 
  <a>Always record on this channel</a><br>
					<input type="radio" class="radio" name="record" value="always" id="record_always"<?=
					$this_program->record_always ? ' CHECKED' : ''?>></input> 
  <a>Always record on any channel</a><br>
				<br>
  Recording Profile<br>
  <select name="profile">
					<?php
					
						global $Profiles;
						foreach($Profiles as $profile) {
							echo '<option value="'.htmlentities($profile['id']).'"';
							if ($this_program->profile == $profile['id'])
								echo ' SELECTED';
							echo '>'.htmlentities($profile['name']).'</option>';
						}
						?></select><br>
  Rank<br>
  <select name="rank">
					<?php
						for($rankcount=-10;$rankcount<=10;++$rankcount) {
							echo '<option value="'.htmlentities($rankcount).'"';
							if ($this_program->rank == $rankcount)
								echo ' SELECTED';
							echo '>'.htmlentities($rankcount).'</option>';
						}
						?></select><br>
  <input type="checkbox" class="radio" name="recorddups"<?php if ($this_program->recorddups) echo ' CHECKED' ?>>
  Record Dupes?&nbsp;<br>
  <input type="checkbox" class="radio" name="autoexpire" <?php if ($this_program->autoexpire) echo "CHECKED" ?>>
  Auto-expire?&nbsp;<br>
					No of recordings to keep?<br><input type="input" name="maxepisodes" size="1" value="<?php echo htmlentities($this_program->maxepisodes) ?>"><br>
  <input type="checkbox" class="radio" name="maxnewest" <?php if ($this_program->maxnewest) echo "CHECKED" ?>>
  Record new and expire old?&nbsp;<br>

					<center><input type="submit" class="submit" name="save" value="Update Settings"></center>
				<br>

		</form>

<?
	// Print the main page footer
		parent::print_footer();
	}

}

?>