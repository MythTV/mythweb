<?php
/***                                                                        ***\
    weather.php

\***                                                                        ***/

class Theme_weather extends Theme {

    function print_page() {
    // Print the main page header
        parent::print_header("MythWeb - Weather");
    // Print the page contents
        global $WeatherSites;

	foreach ($WeatherSites as $accid => $site) { ?>
		<div style="margin: 1em; border: 1px solid;">
			<p style="float:right; font-style: italic; font-weight: bold; padding-right: .5em;"><?php echo $site->host; ?></p>
			<p style="font-size: 130%; padding-left:.5em;padding-top: 0;"><?php echo $site->acid; ?>: <?php echo $site->city; ?>, <?php echo $site->subdiv; ?>, <?php echo $site->country; ?></p>

			<div style="margin: 1em 2em 1em 2em; border: 1px solid gray;">
				<h2 style="font-weight:normal;padding-left: 2.5em;"><?php echo _LANG_CURRENT_CONDITIONS; ?></h2>

				<div style="float: left; width: 220px; text-align: center;margin: 1em;padding: 5px;">
					<img src="themes/Default/img/weather/<?php echo $site->ConditionImage; ?>" style="behavior: url('<?=theme_dir?>pngbehavior.htc');" />
					<p style="font-size: 150%;margin: 0;padding: .3em 0"><?php echo $site->ConditionText; ?></p>
					<p style="font-size: 250%;margin: 0;"><?php echo $site->Temperature; ?><span style="vertical-align: text-top;font-size: 50%;"><span style="vertical-align: text-top;font-size:50%;">O</span>F</span></p>
				</div>

				<table border="0" style="width: 300px; margin-top: 1em; line-height: 1.7em;">
					<tr>	<td><?php echo _LANG_HUMIDITY; ?></td>
						<td style="text-align: right;"><?php echo $site->Humidity; ?>%</td></tr>
					<tr>	<td><?php echo _LANG_PRESSURE; ?></td>
						<td style="text-align: right;"><?php echo $site->BarometricPressure; ?> in</td></tr>
					<tr>	<td><?php echo _LANG_WIND; ?></td>
						<td style="text-align: right;"><?php echo $site->WindDirection . " " . _LANG_AT . " " . $site->WindSpeed; ?> mph</td></tr>
					<tr>	<td><?php echo _LANG_VISIBILITY; ?></td>
						<td style="text-align: right;"><?php echo $site->Visibility; ?> mi</td></tr>
					<tr>	<td><?php echo _LANG_WIND_CHILL; ?></td>
						<td style="text-align: right;"><?php echo $site->Real; ?> F</td></tr>
					<tr>	<td><?php echo _LANG_UV_INDEX; ?></td>
						<td style="text-align: right;"><?php echo $site->UV . " (";
						if($site->UV < 3) echo _LANG_UV_MINIMAL;
							else if($site->UV < 6) echo _LANG_UV_MODERATE;
							else if($site->UV < 8) echo _LANG_UV_HIGH;
							else echo _LANG_UV_EXTREME;
						 ?>)</td></tr>
				</table>
				<div style="clear:both">&nbsp;</div>
			</div>

			<div style="margin: 1em 2em 1em 2em; border: 1px solid gray;">
				<h2 style="font-weight: normal; padding-left: 2.5em;"><?php echo _LANG_FORECAST; ?></h2><?php
				for($i = 0;$i<5;$i++) { $forecast = $site->Forecast[$i]; ?>
				<div style="float: left; width: 220px; text-align: center;margin: 1em;padding: 5px; border: 1px solid;">
					<p style="margin:0;padding: .3em 0 .3em 0;font-size: 125%"><?php
			$today = date("m/d/Y");
			$tomorrow = date("m/d/Y", mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));
			if($forecast->date == $today)
				echo _LANG_TODAY;
			else if($forecast->date == $tomorrow)
				echo _LANG_TOMORROW;
			else
			    switch($forecast->dayofweek) {
				case 1:
				    echo _LANG_MONDAY; break;
				case 2:
				    echo _LANG_TUESDAY; break;
				case 3:
				    echo _LANG_WEDNESDAY; break;
				case 4:
				    echo _LANG_THURSDAY; break;
				case 5:
				    echo _LANG_FRIDAY; break;
				case 6:
				    echo _LANG_SATURDAY; break;
				case 7:
				    echo _LANG_SUNDAY; break;
				default:
				    echo $forecast->date; break;
			    }
					?></p>
					<img src="themes/Default/img/weather/<?php echo $forecast->DescImage; ?>" style="behavior: url('<?=theme_dir?>pngbehavior.htc');" />
					<p style="margin:0;padding: .3em 0 .3em 0;font-size: 125%"><?php echo $forecast->DescText; ?></p>
					<table style="width: 200px; text-align: center;" border="0">
						<tr><th><?php echo _LANG_LOW; ?></th><th><?php echo _LANG_HIGH; ?></th></tr>
						<tr><td><?php echo $forecast->LowTemperature; ?></td>
						<td><?php echo $forecast->HighTemperature; ?></td></tr>
					</table>
				</div>
			<?php	}
			?><div style="clear:both;">&nbsp;</div></div>

			<div style="margin: 1em 2em 1em 2em; border: 1px solid gray;">
				<h2 style="font-weight: normal; padding-left: 2.5em;"><?php echo _LANG_RADAR; ?></h2>

				<p style="padding: 0 2em .5em 2em;"><img src="<?php echo $site->RadarImage; ?>" /></p>
			</div>

			<p style="padding: 0 .5em 0 .5em; clear: both; text-align: right;"><?php echo _LANG_LAST_UPDATED; ?>: <?php echo $site->LastUpdated; ?></p>
		</div><?php
	}

    // Print the main page footer
        parent::print_footer();
    }

    function print_menu_content() {
        echo 'MythWeather';
    }
}

?>
