<?php
/**
 * Display template for 18 Hour Forecast for the Weather module
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
        echo $screen->data["18hrlocation"]
    ?></p>

    <div class="forecast clearfix">
        <h2><?php echo $screen->container ?></h2>

        <?php
            for($i=0;$i<6;$i++) {
        ?>

        <div class="daily_forecast">
            <h3><?php echo $screen->data["time-$i"] ?></h3>
            <img src="<?php echo skin_url ?>img/weather/<?php echo $screen->data["18icon-$i"] ?>" class="alpha_png" alt="">

            <div class="temps">
                <div class="high">
                    <p><?php echo t('Temp') ?></p>
                    <p class="temp">
                        <?php echo $screen->data["temp-$i"] == 'NA' ? '' : $screen->data["temp-$i"] ?>&deg;<sup><?php echo $screen->units == 0 ? 'C' : 'F' ?></sup>
                    </p>
                </div>
            </div>
            <div class="temps">
                <div class="low">
                    <p><?php echo t('Precip') ?></p>
                    <p class="temp">
                        <?php echo $screen->data["pop-$i"] == 'NA' ? '' : $screen->data["pop-$i"] ?>
                    </p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
