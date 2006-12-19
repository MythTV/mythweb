<?php
/**
 * Display template for the Weather module
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Page title
    $page_title = 'MythWeb - '.t('Weather');

// Load this page's custom stylesheet
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_dir.'/weather.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Print Information for each of the known weather sites.
    foreach ($WeatherSites as $accid => $site) {
?>
<div class="weather_site">
    <p class="host"><?php
        echo tn('Host', 'Hosts', count($site->hosts)), ': ',
             implode(', ', $site->hosts);
    ?></p>
    <p class="location"><?php
            echo "$site->acid: $site->city, ",
                 ($site->subdiv ? "$site->subdiv, " : ''),
                 $site->country;
    ?></p>

    <div class="current_conditions clearfix">
        <h2><?php echo t('Current Conditions') ?>:</h2>

        <div class="overview">
            <img src="<?php echo skin_url ?>img/weather/<?php echo $site->ConditionImage ?>" class="alpha_png" />
            <h3><?php echo $site->ConditionText ?></h3>
            <p class="temp">
                <?php echo $site->Temperature ?>&deg;<sup><?php echo (strcasecmp($site->use_metric, 'YES') == 0) ? 'C' : 'F' ?></sup>
            </p>
        </div>

        <table border="0" cellspacing="0" cellpadding="0">
        <tr>
            <th><?php echo t('Humidity') ?></th>
            <td><?php echo $site->Humidity ?>%</td>
        </tr><tr>
            <th><?php echo t('Pressure') ?></th>
            <td><?php echo $site->BarometricPressure; if($site->use_metric == "YES") echo " cm"; else echo " in" ?> </td>
        </tr><tr>
            <th><?php echo t('Wind') ?></th>
            <td><?php echo $site->WindDirection . t(' at ') .  $site->WindSpeed; if($site->use_metric == "YES") echo " kph"; else echo " mph" ?></td>
        </tr><tr>
            <th><?php echo t('Visibility') ?></th>
            <td><?php echo $site->Visibility; if($site->use_metric == "YES") echo " km"; else echo " mi" ?></td>
        </tr><tr>
            <th><?php echo t('Wind Chill') ?></th>
            <td class="temp"><?php echo $site->Real.'&deg;<sup>';
                      echo (strcasecmp($site->use_metric, 'YES') == 0) ? 'C' : 'F';
                ?></sup></td>
        </tr><tr>
            <th><?php echo t('UV Index') ?></th>
            <td><?php
                    echo $site->UV . " (";
                    if     ($site->UV < 3)  echo t('UV Minimal');
                    elseif ($site->UV < 6)  echo t('UV Moderate');
                    elseif ($site->UV < 8)  echo t('UV High');
                    else                    echo t('UV Extreme');
                ?>)</td>
        </tr>
        </table>
    </div>

    <div class="forecast clearfix">
        <h2><?php echo t('Forecast') ?>:</h2>

<?php
            for ($i=0; $i<6; $i++) {
                $forecast = $site->Forecast[$i];
                if (!$forecast)
                    break;
?>
        <div class="daily_forecast">
            <h3><?php

                $today = date("m/d/Y");
                $tomorrow = date("m/d/Y", mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));

                switch($forecast->dayofweek) {
                    case 0:  $day = t('Sunday');        break;
                    case 1:  $day = t('Monday');        break;
                    case 2:  $day = t('Tuesday');       break;
                    case 3:  $day = t('Wednesday');     break;
                    case 4:  $day = t('Thursday');      break;
                    case 5:  $day = t('Friday');        break;
                    case 6:  $day = t('Saturday');      break;
                    default: $day = $forecast->date;    break;
                }

                if ($forecast->date == $today)
                    echo t('Today')." ($day)";
                elseif ($forecast->date == $tomorrow)
                    echo t('Tomorrow')." ($day)";
                else
                    echo $day;

                ?></h3>

            <img src="<?php echo skin_url ?>img/weather/<?php echo $forecast->DescImage ?>" class="alpha_png" />

            <h3><?php echo $forecast->DescText ?></h3>

            <div class="temps">
                <div class="low">
                    <p><?php echo t('Low') ?></p>
                    <p class="temp">
                        <?php echo $forecast->LowTemperature ?>&deg;<sup><?php echo (strcasecmp($site->use_metric, 'YES') == 0) ? 'C' : 'F' ?></sup>
                    </p>
                </div>
                <div class="high">
                    <p><?php echo t('High') ?></p>
                    <p class="temp">
                        <?php echo $forecast->HighTemperature ?>&deg;<sup><?php echo (strcasecmp($site->use_metric, 'YES') == 0) ? 'C' : 'F' ?></sup>
                    </p>
                </div>
            </div>
        </div>
<?php       } ?>

    </div>

    <div class="radar">

        <h2><?php echo t('Radar') ?>:</h2>

        <div class="radar_image">
            <img src="<?php echo $site->RadarImage ?>" />
        </div>

    </div>

    <p class="last_updated">
        <?php echo t('Last Updated') ?>: <?php echo $site->LastUpdated ?>
    </p>
</div>
<?php
    }

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';

