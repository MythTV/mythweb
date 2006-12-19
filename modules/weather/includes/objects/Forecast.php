<?php
/**
 * Forecast class for MythWeb's Weather module
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Weather
 *
/**/

class Forecast {

    var $date;
    var $dayofweek;

    var $DescImage;
    var $DescText;

    var $HighTemperature;
    var $LowTemperature;

    function Forecast($date, $real_dayofweek) {

        $month = substr($date,0,2);
        $day   = substr($date,3,2);
        $year  = substr($date,6,4);

        $temp_date         = mktime(0,0,0,$month,$day,$year);
        $date_time_array   = getdate( $temp_date );
        $claimed_dayofweek = $date_time_array['wday'];

        if ($real_dayofweek != $claimed_dayofweek)
            $this->date = date('m/d/Y', mktime(0, 0, 0, $month  , $day+1, $year));
        else
            $this->date = $date;
    }
}
