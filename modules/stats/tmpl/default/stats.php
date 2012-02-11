<?php
/**
 * The display code for the main welcome page that lists the available mythweb
 * sections.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Stats
 *
/**/

// Set the desired page title
    $page_title = 'Recording Statistics';

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/stats.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Print the content itself
?>

<div id="content_wrapper">

    <form id="stats_form" name="stats_form" action="stats">

        <div id="query_time_div">
            <?php echo t('Time Span'); ?>&nbsp;
            <select name="query_time" onchange="submit_form(null, null, 'stats_form');">
                <option <?php if($_GET['query_time']=='All_time') echo 'selected' ?> value="All_time"><?php echo t('All') ?></option>
                <option <?php if($_GET['query_time']=='year')     echo 'selected' ?> value="year"><?php  echo t('Past Year') ?></option>
                <option <?php if($_GET['query_time']=='month')    echo 'selected' ?> value="month"><?php echo t('Past Month') ?></option>
                <option <?php if($_GET['query_time']=='week')     echo 'selected' ?> value="week"><?php  echo t('Past Week') ?></option>
                <option <?php if($_GET['query_time']=='day')      echo 'selected' ?> value="day"><?php   echo t('Yesterday') ?></option>
            </select>
        </div>

        <div id="count_div">
            <?php echo t('Show'); ?>&nbsp;
            <select name="count_dropdown" onchange="submit_form(null, null, 'stats_form');">
                <option <?php if($_GET['count_dropdown']=='10')  echo 'selected' ?> value="10"><?php  echo t('Top $1', 10) ?></option>
                <option <?php if($_GET['count_dropdown']=='25')  echo 'selected' ?> value="25"><?php  echo t('Top $1', 25) ?></option>
                <option <?php if($_GET['count_dropdown']=='50')  echo 'selected' ?> value="50"><?php  echo t('Top $1', 50) ?></option>
                <option <?php if($_GET['count_dropdown']=='100') echo 'selected' ?> value="100"><?php echo t('Top $1', 100) ?></option>
                <option <?php if($_GET['count_dropdown']=='all') echo 'selected' ?> value="all"><?php echo t('All') ?></option>
            </select>
        </div>

    </form>

    <h2><?php echo t('Recording Statistics') ?></h2>

    <div id="general_stats" class="clearfix">
        <dl>
            <dt><?php echo t('Number of shows'); ?>:
            <dd><?php echo $title_count; ?></dd>
            <dt><?php echo t('Number of episodes'); ?>:</dt>
            <dd><?php echo $show_count; ?></dd>
            <dt><?php echo t('First recording'); ?>:</dt>
            <dd><?php echo date('l F jS, Y', $first); ?></dd>
            <dt><?php echo t('Last recording'); ?>:</dt>
            <dd><?php echo date('l F jS, Y', $last); ?></dd>
            <dt><?php echo t('Total Running Time'); ?>:</dt>
            <dd><?php if(($last - $first)!=0) echo nice_length($last - $first); else echo "0"; ?></dd>
            <dt><?php echo t('Total Recorded'); ?>:</dt>
            <dd><?php if(!is_null($time)) echo nice_length($time); else echo "0"; ?></dd>
            <dt><?php echo t('Percent of time spent recording'); ?>:</dt>
            <dd><?php if(($last - $first)!=0) echo intval(($time / ($last - $first)) * 100); else echo "0"; ?>%</dd>
        </dl>
    </div>

    <table id="stats" style="text-align: left;">
    <tr class="caption">
     <td colspan="3"><?php echo t('Shows'); ?></td>
     <td></td>
     <td colspan="3"><?php echo t('Channels'); ?></td>
    </tr>
    <tr>
     <th><?php echo t('Title'); ?></th>
     <th><?php echo t('Recorded'); ?></th>
     <th><?php echo t('Last Recorded'); ?></th>
     <th class="center">#</th>
     <th><?php echo t('Title'); ?></th>
     <th><?php echo t('Recorded'); ?></th>
     <th><?php echo t('Last Recorded'); ?></th>
    </tr>
    <?php
     $maxcount = count($shows);
     if (count($channels) > $maxcount)
         $maxcount = count($channels);
     $padded = false;
     for ($i=0; $i<$maxcount; $i++) {
     ?>
     <tr>
     <?php
      if (isset($shows[$i])) {
      ?>
       <td><?php echo html_entities($shows[$i]['title']); ?></td>
       <td class="center"><?php echo $shows[$i]['recorded']; ?></td>
       <td><?php echo date('F j Y', $shows[$i]['last_recorded']); ?></td>
      <?php
      }
      elseif ($padded == false) {
       $padded = true;
      ?>
       <td colspan="5" rowspan="<?php echo count($shows)-$i; ?>"></td>
      <?php
      }
      ?>
       <td class="center" style="font-weight: bold;"><?php echo $i+1; ?></td>
      <?php
      if (isset($channels[$i])) {
      ?>
       <td><?php echo html_entities($channels[$i]['name']); ?></td>
       <td class="center"><?php echo $channels[$i]['recorded']; ?></td>
       <td><?php echo date('F j Y', $channels[$i]['last_recorded']); ?></td>
      <?php
      }
      elseif ($padded == false) {
       $padded = true;
      ?>
       <td colspan="5" rowspan="<?php echo count($channels)-$i; ?>"></td>
      <?php
      }
      ?>
     </tr>
     <?php
     }
    ?>
    </table>
</div>
<?php
// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
