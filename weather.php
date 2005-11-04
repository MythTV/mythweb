<?php
/***                                                                        ***\
    weather.php                              Last Updated: 2005.01.23 (xris)

    MythWeather
\***                                                                        ***/


// Which section are we in?
    define('section', 'weather');

// Initialize the script, database, etc.
    require_once "includes/init.php";

    $WeatherSites = array();

    if(!$_SESSION['siunits']) {
    $result = mysql_query('SELECT * FROM settings WHERE value="SIUnits"')
    or trigger_error('SQL Error: '.mysql_error(), FATAL);

    $row = mysql_fetch_assoc($result);
    $use_metric = $row["data"];
        $_SESSION['siunits'] = $use_metric;

    mysql_free_result($result);
    }
    else
        $use_metric = $_SESSION['siunits'];

    $result = mysql_query('SELECT * FROM settings WHERE value="locale"')
    or trigger_error('SQL Error: '.mysql_error(), FATAL);
    while ($weather_site = mysql_fetch_assoc($result))    {
    if(isset($WeatherSites[$weather_site["data"]])) {
        $WeatherSites[$weather_site["data"]]->host .= ", " . $weather_site["hostname"];
        continue;
    }

    $weather_site["use_metric"] = $use_metric;
    $WeatherSites[$weather_site["data"]] = new WeatherSite($weather_site);
    }
    mysql_free_result($result);

// Load the class for this page
    require_once theme_dir.'weather.php';

// Create an instance of this page from its theme object
    $Page = new Theme_weather();

// Display the page
    $Page->print_page();

// Exit
    exit;

class WeatherSite {
    var $acid;
    var $host;

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

    function ChooseThemeImage($theme, $image) {
        $image = str_replace("\n", "", $image);
        $image_test=dirname($_SERVER['PATH_TRANSLATED'])."/images/weather/".$theme."/".$image;

        if (file_exists($image_test))
            $image = "images/weather/".$theme."/".$image;
        else
            $image = "images/weather/Default/".$image;
        return($image);
    }

    function WeatherSite($site) {
        $this->acid = $site['data'];
        $this->host = $site['hostname'];
    $this->use_metric = $site['use_metric'];

    $this->getData();
    $this->RadarImage = $this->getRadarURL();
    }

    function getData() {
    $data = file("http://www.msnbc.com/m/chnk/d/weather_d_src.asp?acid=" . $this->acid);

    foreach($data as $line) {
        if(strpos($line, "this.sw") === false)
        continue;
        if(strpos($line, "swTempCel") !== false)
        continue;

        $line = trim($line);
        list($name, $value) = explode(" = \"", $line);
        $name = substr($name, 7);
        $value = substr($value, 0, strlen($value) - 2);

        switch ($name) {
        case "City":
            $this->city = $value;
            break;

        case "SubDiv":
            $this->subdiv = $value;
            break;

        case "Country":
            $this->country = $value;
            break;

        case "Region":
            $this->region = $value;
            break;

        case "Temp":
            $this->Temperature = $value;
            break;

        case "CIcon":
            $this->CIcon = $value;
            break;

        case "WindS":
            $this->WindSpeed = $value;
            break;

        case "WindD":
            $this->WindDirection = $value;
            break;

        case "Baro":
            $this->BarometricPressure = $value;
            break;

        case "Humid":
            $this->Humidity = $value;
            break;

        case "Real":
            $this->Real = $value;
            break;

        case "UV":
            $this->UV = $value;
            break;

        case "Vis":
            $this->Visibility = $value;
            break;

        case "LastUp":
            $this->LastUpdated = $value;
            break;

        case "ConText":
            $this->ConText = $value;
            break;

        case "Fore":
            $this->Forecast = $this->readForecast($value);
            break;

        default:
           // Weird, unknown type
           break;
        }
    }

    //Are we using metric or imperial system
    if($this->use_metric == "YES") {
        $this->Temperature = round((5/9) * ($this->Temperature - 32));
        $this->Real = round((5/9) * ($this->Real - 32));
        $this->BarometricPressure = round($this->BarometricPressure * 2.54);
        $this->Visibility = round($this->Visibility * 1.609344);
        $this->WindSpeed = round($this->WindSpeed * 1.609344);
    }

    if(strlen($this->ConText) > 0) {
        $this->ConditionText = $this->ConText;
        $this->ConditionImage = getImageFromName($this->ConditionText);
        if(strlen($this->ConditionImage) == 0)
        list($this->ConditionImage, $blah) = getImageAndDescFromId($this->CIcon);
    } else {
        list($this->ConditionImage, $this->ConditionText) = getImageAndDescFromId($this->CIcon);
    }
    $this->ConditionImage = (strlen($this->ConditionImage) > 0) ? $this->ConditionImage : "unknown.png";
    }

    function getRadarURL() {
    $data = file("http://w3.weather.com/weather/map/" . $this->acid . "?from=LAPmaps&setcookie=1");
    foreach($data as $line) {
        if(substr(trim($line), 0, 29) != "if (isMinNS4) var mapNURL = \"") continue;

        $url1 = substr(trim($line), 30);
        $url1 = "http://w3.weather.com/" . substr($url1, 0, strlen($url1) - 2);

        break;
    }

    $data = file($url1);
    foreach($data as $line) {
        if(substr(trim($line), 0, 48) != "<IMG NAME=\"mapImg\" SRC=\"http://image.weather.com") continue;

        $url2 = substr(trim($line), 24);
        $url2 = substr($url2, 0, strpos($url2, '"'));
        break;
    }
    return $url2;
    }

    function readForecast($data) {
    $ret = array();

    $data = explode("|", $data);
    for($i = 0;$i<5;$i++) {
        $forecast = new Forecast($data[5 + $i],$data[$i]);
        $forecast->dayofweek = $data[$i];
        list($forecast->DescImage,$forecast->DescText) = getImageAndDescFromId($data[15 + $i]);
        $forecast->DescImage = (strlen($forecast->DescImage) > 0) ? $forecast->DescImage : "unknown.png";
        $forecast->DescText = (strlen($forecast->DescText) > 0) ? $forecast->DescText : t('Unknown') . " (" . $data[15+$i] . ")";
        if($this->use_metric == "YES") {
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

function getImageAndDescFromId($myid) {
    $data = file("config/weathertypes.dat");
    foreach($data as $line) {
    list($id, $name, $img) = explode(",", $line);
    if($id != $myid) continue;

    return array($img, $name);
    }
}

function getImageFromName($myname) {
    $data = file("config/weathertypes.dat");
    foreach($data as $line) {
    list($id, $name, $img) = explode(",", $line);
    if($name != $myname) continue;

    return $img;
    }
}

class Forecast {
    var $date;
    var $dayofweek;

    var $DescImage;
    var $DescText;

    var $HighTemperature;
    var $LowTemperature;

    function Forecast($date,$real_dayofweek) {

    $month = substr($date,0,2);
    $day = substr($date,3,2);
    $year = substr($date,6,4);

    $temp_date = mktime(0,0,0,$month,$day,$year);
    $date_time_array = getdate( $temp_date );
    $claimed_dayofweek = $date_time_array['wday'];

    if($real_dayofweek != $claimed_dayofweek)

        $this->date = date("m/d/Y", mktime(0, 0, 0, $month  , $day+1, $year));
    else
        $this->date = $date;
    }
}

