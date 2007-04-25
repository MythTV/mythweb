<?php
/**
 * WeatherSite class for MythWeb's Weather module
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

class WeatherSite {

    var $acid;
    var $hosts = array();

    var $city;
    var $subdiv;
    var $country;
    var $region;

    var $use_metric;
    var $Temperature;
    var $CIcon;
    var $ConditionImage;
    var $ConditionText;
    var $WindSpeed;
    var $WindDirection;
    var $BarometricPressure;
    var $Humidity;
    var $Real;
    var $UV;
    var $Visibility;
    var $ConText;
    var $Forecast;

    var $RadarImage;

    var $LastUpdated;

    function WeatherSite($data, $hostname, $use_metric) {
        $this->acid       = $data;
        $this->hosts[]    = $hostname;
        $this->use_metric = $use_metric;

        $this->getData();
        $this->RadarImage = $this->getRadarURL();
    }

    function getData() {
        global $Weather_Types;
        $data = @file('http://www.msnbc.com/m/chnk/d/weather_d_src.asp?acid=' . $this->acid);
        if ($data === FALSE)
            return;

        foreach($data as $line) {
            if(strpos($line, 'this.sw') === false)
                continue;
            if(strpos($line, 'swTempCel') !== false)
                continue;

            $line = trim($line);
            list($name, $value) = explode(' = "', $line);
            $name  = substr($name, 7);
            $value = substr($value, 0, strlen($value) - 2);

            switch ($name) {
                case 'City':    $this->city               = $value;             break;
                case 'SubDiv':  $this->subdiv             = $value;             break;
                case 'Country': $this->country            = $value;             break;
                case 'Region':  $this->region             = $value;             break;
                case 'Temp':    $this->Temperature        = $value;             break;
                case 'CIcon':   $this->CIcon              = $value;             break;
                case 'WindS':   $this->WindSpeed          = $value;             break;
                case 'WindD':   $this->WindDirection      = $value;             break;
                case 'Baro':    $this->BarometricPressure = $value;             break;
                case 'Humid':   $this->Humidity           = $value;             break;
                case 'Real':    $this->Real               = $value;             break;
                case 'UV':      $this->UV                 = $value;             break;
                case 'Vis':     $this->Visibility         = $value;             break;
                case 'LastUp':  $this->LastUpdated        = $value;             break;
                case 'ConText': $this->ConText            = $value;             break;
                case 'Fore':    $this->Forecast = $this->readForecast($value);  break;
                default:        /* Weird, unknown type */                       break;
            }
        }

    //Are we using metric or imperial system
        if ($this->use_metric == 'YES') {
            $this->Temperature        = round((5/9) * ($this->Temperature - 32));
            $this->Real               = round((5/9) * ($this->Real - 32));
            $this->BarometricPressure = round($this->BarometricPressure * 2.54);
            $this->Visibility         = round($this->Visibility * 1.609344);
            $this->WindSpeed          = round($this->WindSpeed * 1.609344);
        }

        if (strlen($this->ConText) > 0) {
            $this->ConditionText = $this->ConText;
            foreach ($Weather_Types as $pair) {
                if ($pair[1] != $this->ConditionText)
                    continue;
                $this->ConditionImage = $pair[0];
                break;
            }
            if(strlen($this->ConditionImage) == 0)
                list($this->ConditionImage, $blah) = $Weather_Types[$this->CIcon];
        }
        else {
            list($this->ConditionImage, $this->ConditionText) = $Weather_Types[$this->CIcon];
        }
        $this->ConditionImage = (strlen($this->ConditionImage) > 0) ? $this->ConditionImage : 'unknown.png';
    }

    function getRadarURL() {
        $data = file('http://w3.weather.com/weather/map/' . $this->acid . '?from=LAPmaps&setcookie=1');
        foreach($data as $line) {
            if(substr(trim($line), 0, 29) != 'if (isMinNS4) var mapNURL = "') continue;

            $url1 = substr(trim($line), 30);
            $url1 = 'http://w3.weather.com/' . substr($url1, 0, strlen($url1) - 2);

            break;
        }

        $data = file($url1);
        foreach($data as $line) {
            if(substr(trim($line), 0, 48) != '<IMG NAME="mapImg" SRC="http://image.weather.com') continue;

            $url2 = substr(trim($line), 24);
            $url2 = substr($url2, 0, strpos($url2, '"'));
            break;
        }
        return $url2;
    }

    function readForecast($data) {
        global $Weather_Types;
        $ret = array();

        $data = explode('|', $data);
        for($i = 0;$i<5;$i++) {
        // mktime uses 0-6;  msnbc gives us 1-7;  adjust msnbc to match mktime
            $dayofweek = $data[$i] - 1;
            $forecast = new Forecast($data[5 + $i],$dayofweek);
            $forecast->dayofweek = $dayofweek;
            list($forecast->DescImage,$forecast->DescText) = $Weather_Types[$data[15 + $i]];
            $forecast->DescImage = (strlen($forecast->DescImage) > 0) ? $forecast->DescImage : 'unknown.png';
            $forecast->DescText  = (strlen($forecast->DescText)  > 0) ? $forecast->DescText  : t('Unknown') . ' (' . $data[15+$i] . ')';
            if($this->use_metric == 'YES') {
                $forecast->HighTemperature = round((5/9) * ($data[20 + $i] - 32));
                $forecast->LowTemperature = round((5/9) * ($data[40 + $i] -32 ));
            } else {
            $forecast->HighTemperature = $data[20 + $i];
            $forecast->LowTemperature = $data[40 + $i];
            }

            $ret[$i] = $forecast;
        }

        return $ret;
    }
}