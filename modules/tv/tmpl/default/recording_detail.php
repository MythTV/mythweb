<?php
/**
 * Show recorded programs.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Recording Detail: $1',
                                 $program->subtitle
                                    ? $program->title.': '.$program->subtitle
                                    : $program->title);

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_detail.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Ease of access
    $channel = $program->channel;

/*
 * Print the page contents:
 * I really hate tables, but this layout just doesn't work right with pure-css.
 * In its defense, it *is* somewhat tabular.
/*/
?>
<table id="program_content" border="0" cellspacing="0" cellpadding="0">
<tr>

    <td>

    <div id="program_info" class="clearfix">
        <div id="program_header">
<?php
        if (file_exists(cache_dir.'/'.basename($program->filename).'.png')) {
            list($width, $height, $type, $attr) = getimagesize(cache_dir.'/'.basename($program->filename).'.png');
            echo "<a href=\"$program->url\" name=\"$row\" style=\"display: block; margin: 10px; text-align: center\">"
                .'<img id="'.$program->filename.'" src="'.$program->thumb_url.'.png" '.$attr.' border="0">'
                .'</a>';
        }

        if ($channel) {
?>
            <div id="channel_info" class="menu menu_border_t menu_border_b menu_border_l menu_border_r">
                <a href="<?php echo root ?>tv/channel/<?php echo $channel->chanid, '/', $program->starttime ?>"
                        onmouseover="return wstatus('<?php echo t('Details for') ?>: <?php echo $channel->channum.' '.$channel->callsign ?>')"
                        onmouseout="return wstatus('')"
                        title="<?php echo t('Details for') ?>: <?php echo $channel->name ?>">
<?php       if (show_channel_icons === true && !empty($channel->icon)) { ?>
                    <img src="<?php echo $channel->icon ?>" height="30" width="30" border="0">
<?php       } ?>
                    <span class="preferred"><?php echo _or(prefer_channum ? $channel->channum : $channel->callsign, '&nbsp') ?></span><br />
                    <?php echo (prefer_channum ? $channel->callsign : $channel->channum)."\n" ?>
                </a>
            </div>
<?php   } ?>
            <div id="program_title">
                <h1>
                    <a href="<?php echo root ?>tv/search/<?php echo str_replace('%2F', '/', rawurlencode($program->title)) ?>?search_title=1"><?php echo $program->title ?></a>
                </h1>
                <div id="program_time">
<?php
        if ($_GET['recordid'])
            echo '<span class="bold">';
        echo strftime('%a, %b %e', $program->starttime);
        if ($program && $program->previouslyshown)
            echo ' ('.t('Repeat').')';
        echo '<br />'
            .t('$1 to $2', strftime($_SESSION['time_format'], $program->starttime), strftime($_SESSION['time_format'], $program->endtime));
        if ($program)
            echo ' ('.tn('$1 min', '$1 mins', intval($program->length/60)).')';
        if ($_GET['recordid'])
            echo "</span>";
        echo "<br />\n";
?>
                </div>
                <div id="external_searches">
                    (<?php echo t('Search') ?>: &nbsp;
                    <a href="http://www.imdb.com/Find?select=Titles&for=<?php echo urlencode($program->title) ?>"><?php echo t('IMDB') ?></a>
                    &nbsp;-&nbsp;
                    <a href="http://www.tv.com/search.php?type=11&stype=all&qs=<?php echo urlencode($program->title) ?>"><?php echo t('TV.com') ?></a>
                    &nbsp;-&nbsp;
                    <a href="http://www.google.com/search?q=<?php echo urlencode($program->title) ?>"><?php echo t('Google') ?></a>
                    )
                </div>
            </div>
        </div>
<?php    if (strlen($program->subtitle) || strlen($program->fancy_description)) { ?>
        <div id="program_details">
            <dl>
<?php       if (strlen($program->subtitle)) { ?>
                <dt<?php if ($_GET['recordid']) echo ' class="bold"' ?>><?php echo t('Episode') ?>:&nbsp;</dt>
                <dd<?php if ($_GET['recordid']) echo ' class="bold"' ?>><?php
                echo $program->subtitle;
                    ?></dd>
<?php       }
            if (strlen($program->fancy_description)) {
?>
                <dt<?php if ($_GET['recordid']) echo ' class="bold"' ?>><?php echo t('Description') ?>:&nbsp;</dt>
                <dd<?php if ($_GET['recordid']) echo ' class="bold"' ?>><?php
                    echo nl2br($program->fancy_description);
                    ?></dd>
<?php       } ?>
            </dl>
        </div>
<?php    } ?>

        <div id="program_extra_details">
            <dl>
<?php       if (strlen($program->category)) { ?>
                <dt><?php echo t('Category') ?>:&nbsp;</dt>
                <dd><?php echo $program->category ?></dd>
<?php       }
            if (strlen($program->category_type)) { ?>
                <dt><?php echo t('Type') ?>:&nbsp;</dt>
                <dd><?php echo $program->category_type;
                          if ($program->seriesid)
                              echo ' (', $program->seriesid, ')' ?></dd>
<?php       }
            if (strlen($program->syndicatedepisodenumber) > 0) {
?>
               <dt><?php echo t('Episode Number') ?>:&nbsp;</dt>
               <dd><?php echo $program->syndicatedepisodenumber ?></dd>
<?php       }
            if (strlen($program->airdate)) {
?>
                <dt><?php echo t('Original Airdate') ?>:&nbsp;</dt>
                <dd><?php echo $program->airdate ?></dd>
<?php       }
            if (strlen($program->programid) > 0) {
?>
               <dt><?php echo t('Program ID') ?>:&nbsp;</dt>
               <dd><?php echo $program->programid ?></dd>
<?php       }
            if ($program->get_credits('host')) {
?>
                    <dt><?php echo t('Hosted by') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('host') ?></dd>
<?php       }
            if ($program->get_credits('presenter')) {
?>
                    <dt><?php echo t('Presented by') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('presenter') ?></dd>
<?php       }
            if ($program->get_credits('actor')) {
?>
                    <dt><?php echo t('Cast') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('actor') ?></dd>
<?php       }
            if ($program->get_credits('guest_star')) {
?>
                    <dt><?php echo t('Guest Starring') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('guest_star') ?></dd>
<?php       }
            if ($program->get_credits('director')) {
?>
                    <dt><?php echo t('Directed by') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('director') ?></dd>
<?php       }
            if ($program->get_credits('producer')) {
?>
                    <dt><?php echo t('Produced by') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('producer') ?></dd>
<?php       }
            if ($program->get_credits('executive_producer')) {
?>
                    <dt><?php echo t('Exec. Producer') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('executive_producer') ?></dd>
<?php       }
            if ($program->get_credits('writer')) {
?>
                    <dt><?php echo t('Written by') ?>:&nbsp;</dt>
                    <dd><?php echo $program->get_credits('writer') ?></dd>
<?php       }
            if (strlen($program->starstring) > 0) {
?>
                    <dt><?php echo t('Guide rating') ?>:&nbsp;</dt>
                    <dd><?php echo $program->starstring ?></dd>
<?php       } ?>
                    <dt><?php echo t('has commflag') ?>:&nbsp;</dt>
                    <dd><?php echo $program->has_commflag ? t('Yes') : t('No') ?></dd>
                    <dt><?php echo t('has cutlist') ?>:&nbsp;</dt>
                    <dd><?php echo $program->has_cutlist ? t('Yes') : t('No') ?></dd>
                    <dt><?php echo t('is editing') ?>:&nbsp;</dt>
                    <dd><?php echo $program->is_editing ? t('Yes') : t('No') ?></dd>
                    <dt><?php echo t('auto-expire') ?>:&nbsp;</dt>
                    <dd><?php echo $program->auto_expire ? t('Yes') : t('No') ?></dd>
                    <dt><?php echo t('has bookmark') ?>:&nbsp;</dt>
                    <dd><?php echo $program->bookmark ? t('Yes') : t('No') ?></dd>
                    <dt><?php echo t('watched') ?>:&nbsp;</dt>
                    <dd><?php echo $program->is_watched ? t('Yes') : t('No') ?></dd>
                    <dt><?php echo t('Length') ?>:&nbsp;</dt>
                    <dd><?php echo nice_length($program->length) ?></dd>
                    <dt><?php echo t('file size') ?>:&nbsp;</dt>
                    <dd><?php echo nice_filesize($program->filesize) ?></dd>
            </dl>
        </div>

        <div id="local_links">
            <a href="<?php echo root ?>tv/recorded"><?php
                echo t('Back to the recorded programs')
            ?></a>
            <a href="<?php echo root ?>tv/search/<?php echo str_replace('%2F', '/', rawurlencode($program->title)) ?>?search_title=1"><?php
                echo t('Find showings of this program');
            ?></a>
        </div>

    </div>

    </td>
    <td>

    <div id="recording_info" class="command command_border_l command_border_t command_border_b command_border_r clearfix">

        <form name="program_detail" method="post" action="<?php echo root ?>tv/detail<?php
            if ($_GET['recordid'])
                echo '?recordid='.urlencode($_GET['recordid']);
            else
                echo '/'.urlencode($_GET['chanid']).'/'.urlencode($_GET['starttime'])
            ?>">

        <div id="recorded_options">
            <h3><?php echo t('Download Choices') ?>:</h3>

            <ul>
                <li><a href="<?php echo video_url($program, true) ?>"><?php echo t('ASX Stream') ?></a></li>
                <li><a href="<?php echo $program->url ?>"><?php echo t('Direct Download') ?></a></li>
            </ul>
        </div>

        </form>

    </div>

    </td>

</tr>
</table>

<?php
// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';

