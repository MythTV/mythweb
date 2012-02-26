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
            <select name="query_time">
                <option <?php if($_GET['query_time']=='All_time') echo 'selected' ?> value="All_time"><?php echo t('All') ?></option>
                <option <?php if($_GET['query_time']=='year')     echo 'selected' ?> value="year"><?php  echo t('Past Year') ?></option>
                <option <?php if($_GET['query_time']=='month')    echo 'selected' ?> value="month"><?php echo t('Past Month') ?></option>
                <option <?php if($_GET['query_time']=='week')     echo 'selected' ?> value="week"><?php  echo t('Past Week') ?></option>
                <option <?php if($_GET['query_time']=='day')      echo 'selected' ?> value="day"><?php   echo t('Yesterday') ?></option>
            </select>
            &nbsp;
            <input type="submit" value="go">
        </div>

        <div id="count_div">
            <select name="count_dropdown">
                <option <?php if($_GET['count_dropdown']=='10')  echo 'selected' ?> value="10"><?php  echo t('Top $1', 10) ?></option>
                <option <?php if($_GET['count_dropdown']=='25')  echo 'selected' ?> value="25"><?php  echo t('Top $1', 25) ?></option>
                <option <?php if($_GET['count_dropdown']=='50')  echo 'selected' ?> value="50"><?php  echo t('Top $1', 50) ?></option>
                <option <?php if($_GET['count_dropdown']=='100') echo 'selected' ?> value="100"><?php echo t('Top $1', 100) ?></option>
                <option <?php if($_GET['count_dropdown']=='all') echo 'selected' ?> value="all"><?php echo t('All') ?></option>
            </select>
            &nbsp;
            <input type="submit" value="go">
        </div>

    </form>

    <h2><?php echo t('Recording Statistics') ?></h2>

    <div id="general_stats" class="clearfix">
        <dl>
            <dt><?php echo t('Number of shows') ?>:
            <dd><?php echo $title_count ?></dd>
            <dt><?php echo t('Number of episodes') ?>:</dt>
            <dd><?php echo $show_count ?></dd>
            <dt><?php echo t('First recording') ?>:</dt>
            <dd><?php echo date('l F jS, Y', $first) ?></dd>
            <dt><?php echo t('Last recording') ?>:</dt>
            <dd><?php echo date('l F jS, Y', $last) ?></dd>
            <dt><?php echo t('Total Time') ?>:</dt>
            <dd><?php echo t('$1 wasted', nice_length($time)) ?></dd>
        </dl>
    </div>

    <table id="top_ten_shows" style="text-align: left;">
    <caption>Top <?php echo $_REQUEST['count_dropdown'] ?> recorded shows</caption>
    <colgroup>
        <col class="num"></col>
        <col class="title"></col>
        <col class="count"></col>
        <col class="last_recorded"></col>
    </colgroup>
    <tr>
        <th>#</th>
        <th><?php echo t('Title') ?></th>
        <th><?php echo t('Count') ?></th>
        <th><?php echo t('Last Recorded') ?></th>
    </tr><?php
        foreach($top_ten_shows as $num => $row) {
            echo "<tr>\n",
                 "        <td>", ($num + 1), "</td>\n",
                 "        <td>", html_entities($row['title']), "</td>\n",
                 "        <td>", $row['count'], "</td>\n",
                 "        <td>".date('F j Y', $row['last_recorded'])."</td>\n",
                 "    </tr>\n";
        }
    ?>
    </table>

    <table id="top_ten_chan" style="text-align: left;">
    <caption>Top <?php echo $_REQUEST['count_dropdown'] ?> recorded channels</caption>
    <colgroup>
        <col class="num"></col>
        <col class="title"></col>
        <col class="count"></col>
        <col class="last_recorded"></col>
    </colgroup>
    <tr>
        <th>#</th>
        <th><?php echo t('Name') ?></th>
        <th><?php echo t('Count') ?></th>
        <th><?php echo t('Last Recorded') ?></th>
    </tr><?php
        foreach($top_ten_chans as $num => $row) {
            echo "<tr>\n",
                 "        <td>", ($num + 1), "</td>\n",
                 "        <td>", html_entities($row['name']), "</td>\n",
                 "        <td>", $row['count'], "</td>\n",
                 "        <td>".date('F j Y', $row['last_recorded'])."</td>\n",
                 "    </tr>\n";
        }
    ?>
    </table>

</div>
<?php
// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
