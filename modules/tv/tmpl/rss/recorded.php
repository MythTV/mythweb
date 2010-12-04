<?php
/**
 * Create a rss of the recorded programs.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

    $Feed = new FeedWriter(RSS2);
    $Feed->setTitle('MythWeb - '.t('Recorded Programs'));
    $Feed->setLink(root_url);
    $Feed->setDescription('MythWeb - '.t('Recorded Programs'));

    foreach ($All_Shows as $show) {
        $item = $Feed->createNewItem();

        $item->setTitle($show->title.(strlen($show->subtitle) > 0 ? ' - '.$show->subtitle : ''));
        $item->setLink(root_url.'tv/detail/'.$show->chanid.'/'.$show->recstartts);
        $item->setDate($show->starttime);
        $item->setDescription($show->description);

        $Feed->addItem($item);
    }

    $Feed->generateFeed();
