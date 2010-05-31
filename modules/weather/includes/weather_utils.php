<?php
/**
 * Collection of functions used by the various pages of the MythWeb Weather module
 *
 * @url         $URL: 
 * @date        $Date: 
 * @version     $Revision: 
 * @author      $Author: 
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Weather
 *
/**/

function getScreenTitle($containerName) {
    if ($containerName == "Current Conditions")
        return t("Current Conditions");
    if ($containerName == "Three Day Forecast")
        return t("Three Day Forecast");
    if ($containerName == "18 Hour Forecast")
        return t("18 Hour Forecast");
    if ($containerName == "Severe Weather Alerts")
        return t("Severe Weather Alerts");
    if ($containerName == "Six Day Forecast")
        return t("Six Day Forecast");
    if ($containerName == "Static Map")
        return t("Static Map");
    if ($containerName == "Animated Map")
        return t("Animated Map");

    return screenName;
}
