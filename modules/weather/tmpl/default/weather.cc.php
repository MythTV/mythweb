<?php
/**
 * Display template for Current Conditions for the Weather module
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
?>
    <p class="host"><?php
        echo t('Host') .": ".  $screen->host;
    ?></p>
    <p class="location"><?php
        echo $screen->data["cclocation"]
    ?></p>

    <div class="current_conditions clearfix">
        <h2><?php echo $screen->container ?></h2>

        <div class="overview">
            <img src="<?php echo skin_url ?>img/weather/<?php echo $screen->data["weather_icon"] ?>" class="alpha_png" alt="">
            <h3><?php echo $screen->data["weather"] ?></h3>
            <p class="temp">
                <?php echo $screen->data["temp"] ?>&deg;<sup><?php echo $screen->units == 0 ? 'C' : 'F' ?></sup>
            </p>
        </div>

        <table border="0" cellspacing="0" cellpadding="0">
        <tr>
            <th><?php echo t('Humidity') ?></th>
            <td><?php echo $screen->data["relative_humidity"] ?>%</td>
        </tr><tr>
            <th><?php echo t('Pressure') ?></th>
            <td><?php echo $screen->data["pressure"]; echo $screen->units == 0 ? ' mb' : ' in' ?></td>
        </tr><tr>
            <th><?php echo t('Wind') ?></th>
            <td><?php echo $screen->data["wind_dir"] . t(' at ') . $screen->data["wind_spdgst"]; echo $screen->units == 0 ? ' km/h' : ' mph' ?></td>
        </tr><tr>
            <th><?php echo t('Visibility') ?></th>
            <td><?php echo $screen->data["visibility"]; echo $screen->units == 0 ? ' km' : ' mi' ?></td>
        </tr><tr>
            <th><?php echo t('Wind Chill') ?></th>
            <td><?php echo $screen->data["appt"] . '&deg;<sup>'; echo $screen->units == 0 ? 'C' : 'F' ?></sup></td>
        </tr><tr>
            <td colspan="2"><?php echo $screen->data["observation_time"] ?></td>
        </tr>
        </table>
    </div>
