<?php
/**
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/modules/tv/tmpl/default/list.php $
 * @date        $Date: 2008-06-21 17:31:37 -0700 (Sat, 21 Jun 2008) $
 * @version     $Revision: 17555 $
 * @author      $Author: kormoc $
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Program Detail').":  $schedule->title";

    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/ListPanel.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<h3><?php echo t('Program Information'); ?></h3>

<ul class="ListPanel">
    <li class="text"><?php echo $schedule->title.(strlen($schedule->subtitle) > 0 ? ' - '.$schedule->subtitle: ''); ?>
    <li class="text small"><?php echo strftime('%a, %b %e', $schedule->starttime);
                        echo ', '
                            .t('$1 to $2', strftime($_SESSION['time_format'], $schedule->starttime),
                                           strftime($_SESSION['time_format'], $schedule->endtime));
                        if ($program)
                            echo ' ('.tn('$1 min', '$1 mins', intval($program->length/60)).')';
                        echo "<br>\n"; ?>
    <li class="text long"><?php echo $schedule->fancy_description; ?>
    <?php
        if ($program->hasAlternativeFormat('mp4'))
            echo '<li class="small"><a href="'.root.'/pl/stream/'.$program->chanid.'/'.$program->recstartts.'.mp4">'.t('Watch on iPod/iPhone').'</a>';
    ?>
</ul>

<h3><?php echo t('Cast Information'); ?></h3>

<ul class="ListPanel">
    <?php
        if ($program->get_credits('host', false))
            echo '<li class="text small">'.t('Hosted by').': '.$program->get_credits('host', false);
        if ($program->get_credits('presenter', false))
            echo '<li class="text small">'.t('Presented by').': '.$program->get_credits('presenter', false);
        if ($program->get_credits('actor', false))
            echo '<li class="text small">'.t('Cast').': '.$program->get_credits('actor', false);
        if ($program->get_credits('guest_star', false))
            echo '<li class="text small">'.t('Guest Starring').': '.$program->get_credits('guest_star', false);
        if ($program->get_credits('director', false))
            echo '<li class="text small">'.t('Directed by').': '.$program->get_credits('director', false);
        if ($program->get_credits('producer', false))
            echo '<li class="text small">'.t('Produced by').': '.$program->get_credits('producer', false);
        if ($program->get_credits('executive_producer', false))
            echo '<li class="text small">'.t('Executive Producer').': '.$program->get_credits('executive_producer', false);
        if ($program->get_credits('writer', false))
            echo '<li class="text small">'.t('Written by').': '.$program->get_credits('writer', false);
    ?>
</ul>

<h3><?php echo t('Program Flags'); ?></h3>

<ul class="ListPanel">
    <li class=""><a href="#" class="nochevron">Auto Expire<span class="right"><img src="<?php echo skin_url.'/img/'.($program->auto_expire ? 'on' : 'off').'.png'; ?>"></span></a>
        <?php
            if ($program->closecaptioned)
                echo '<li class="text small">Has Closed Captions';
            if ($program->stereo)
                echo '<li class="text small">Stereo Sound';
            if ($program->hdtv)
                echo '<li class="text small">HDTV';
            if ($program->has_commflag)
                echo '<li class="text small">Commercials are flagged';
            if ($program->has_cutlist)
                echo '<li class="text small">Cutlist is present';
            if ($program->bookmark)
                echo '<li class="text small">Bookmarked';
            if ($program->is_watched)
                echo '<li class="text small">Watched';
        ?>
</ul>

<h3><?php echo t('Extra Information'); ?></h3>

<ul class="ListPanel">
    <?php
        if (strlen($program->category) > 0)
            echo '<li class="text small">'.t('Category').': <span class="right">'.$program->category.'</span>';
        if (strlen($program->category_type) > 0)
            echo '<li class="text small">'.t('Type').': <span class="right">'.$program->category_type.'</span>';
        if (strlen($program->seriesid) > 0)
            echo '<li class="text small">'.t('Series ID').': <span class="right">'.$program->seriesid.'</span>';
        if (strlen($program->programid) > 0)
            echo '<li class="text small">'.t('Program ID').': <span class="right">'.$program->programid.'</span>';
        if (strlen($program->syndicatedepisodenumber) > 0)
            echo '<li class="text small">'.t('Episode Number').': <span class="right">'.$program->syndicatedepisodenumber.'</span>';
        if (strlen($program->airdate) > 0)
            echo '<li class="text small">'.t('Original Airdate').': <span class="right">'.$program->airdate.'</span>';
        if (strlen($program->starstring) > 0)
            echo '<li class="text small">'.t('Guide rating').': <span class="right">'.$program->starstring.'</span>';
        if (strlen($program->filesize) > 0)
            echo '<li class="text small">'.t('File Size').': <span class="right">'.nice_filesize($program->filesize).'</span>';
        if (strlen($program->recgroup))
            echo '<li class="text small">'.t('Recording Group').': <span class="right">'.$program->recgroup.'</span>';
        if (strlen($program->playgroup))
            echo '<li class="text small">'.t('Playback Group').': <span class="right">'.$program->playgroup.'</span>';
    ?>
</ul>

<?php
    if (count($program->jobs_possible)) {
        ?>
            <h3><?php echo t('Queue a job'); ?></h3>
            <ul class="ListPanel">
            <?php
                foreach ($program->jobs_possible as $id => $job)
                    echo '<li class="small"><a href="'.root.'tv/detail/'.$program->chanid.'/'.$program->recstartts.'?job='.$id.'">'.$job.'</a>';
            ?>
            </ul>
        <?php
    }
    if (count($program->jobs['queue'])) {
        ?>
            <h3><?php echo t('Queued jobs'); ?></h3>
            <ul class="ListPanel">
            <?php
                foreach ($program->jobs['queue'] as $job)
                    echo "<li class='small text'>{$Jobs[$job['type']]} ({$Job_Status[$job['status']]}:  ".strftime($_SESSION['date_listing_key'], $job['statustime']).') '.html_entities($job['comment']);
            ?>
            </ul>
        <?php
    }
    if (count($program->jobs['done'])) {
        ?>
            <h3><?php echo t('Recently completed jobs'); ?></h3>
            <ul class="ListPanel">
            <?php
                foreach ($program->jobs['done'] as $job)
                    echo "<li class='small text'>{$Jobs[$job['type']]} ({$Job_Status[$job['status']]}:  ".strftime($_SESSION['date_listing_key'], $job['statustime']).') '.html_entities($job['comment']);
            ?>
            </ul>
        <?php
    }
?>

<h3><?php echo t('Links'); ?></h3>

<ul class="ListPanel">
    <li class="small"><a href="http://www.imdb.com/Find?select=Titles&for=<?php echo urlencode($schedule->title) ?>"><?php echo t('Search $1', 'IMDB') ?></a>
    <li class="small"><a href="http://www.tv.com/search.php?type=11&stype=all&qs=<?php echo urlencode($schedule->title) ?>"><?php echo t('Search $1', 'TV.com') ?></a>
    <li class="small"><a href="http://www.google.com/search?q=<?php echo urlencode($schedule->title) ?>"><?php echo t('Search $1', 'Google') ?></a>
    <li class="small"><a href="<?php echo root ?>tv/search/<?php echo str_replace('%2F', '/', rawurlencode('^'.$schedule->title.'$')) ?>?field=title"><?php
                    if ($_GET['recordid'])
                        echo t('Find showings of this program');
                    else
                        echo t('Find other showings of this program');
                ?></a>
</ul>

<?php
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
?>
