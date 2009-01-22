<?php
/**
 * Create a ical for the upcoming recordings
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

    $calendar = new vcalendar();
    $calendar->setConfig($_SERVER['SERVER_SIGNATURE'], $_SERVER['HTTP_HOST']);
    $calendar->setProperty( 'method', 'PUBLISH' );

    foreach ($all_shows as $show) {
        $event = new vevent();
        $event->setProperty('dtstart',      array( 'year'  => date('Y', $show->starttime),
                                                   'month' => date('m', $show->starttime),
                                                   'day'   => date('d', $show->starttime),
                                                   'hour'  => date('H', $show->starttime),
                                                   'min'   => date('i', $show->starttime),
                                                   'sec'   => date('s', $show->starttime) ));
        $event->setProperty('dtend',        array( 'year'  => date('Y', $show->endtime),
                                                   'month' => date('m', $show->endtime),
                                                   'day'   => date('d', $show->endtime),
                                                   'hour'  => date('H', $show->endtime),
                                                   'min'   => date('i', $show->endtime),
                                                   'sec'   => date('s', $show->endtime) ));
        $event->setProperty('summary',      $show->title.($show->subtitle ? ' - '.$show->subtitle : ''));
        $event->setProperty('description',  $show->description."\n\n".preg_replace('/([A-Z]+)/',' $1',$show->recstatus));
        $calendar->setComponent($event);
    }

    $calendar->returnCalendar();
