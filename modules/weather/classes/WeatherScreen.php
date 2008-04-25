<?php
/**
 * WeatherScreen class for MythWeb's Weather module
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

class WeatherScreen {

    var $screen_id;
    var $source_id;
    var $draworder;
    var $container;
    var $host;
    var $units;
    var $active;

    var $data = array();
    var $search = array();

    function WeatherScreen($screen_id) {
        global $db;

        $this->screen_id = $screen_id;
        $this->setActive();

        if ($this->active) {
            $sh = $db->query('SELECT weatherscreens.draworder,
                                     weatherscreens.container,
                                     weatherscreens.hostname,
                                     weatherscreens.units
                                FROM weatherscreens
                               WHERE weatherscreens.screen_id = ?',
                              $this->screen_id
                              );

            list($draworder, $container, $hostname, $units) = $sh->fetch_row();

            $this->draworder = $draworder;
            $this->container = $container;
            $this->host      = $hostname;
            $this->units     = $units;

            $this->source_id = $db->query_col('SELECT DISTINCT weatherdatalayout.weathersourcesettings_sourceid
                                                 FROM weatherdatalayout
                                                WHERE weatherdatalayout.weatherscreens_screen_id = ?',
                                              $this->screen_id
                                              );
        }
    }

    function setActive() {
        $this->active = ( $this->checkScreenID() ? 1 : 0 );
    }

    function getSource( $source_id = NULL) {
        global $db;

    // If we get no source_id to lookup, use ours
        if ($source_id == NULL)
            $source_id = $this->source_id;

        $source_name = $db->query_col('SELECT weathersourcesettings.source_name
                                         FROM weathersourcesettings
                                        WHERE weathersourcesettings.sourceid = ?',
                                      $source_id
                                      );
        return $source_name;
    }

    function deleteScreen() {
        global $db;

        if (! $this->checkScreenID())
            return;

        $db->query('DELETE FROM weatherscreens
                          WHERE weatherscreens.screen_id = ?
                            AND weatherscreens.hostname  = ?',
                    $this->screen_id,
                    $this->host
                    );

        $db->query('DELETE FROM weatherdatalayout
                          WHERE weatherdatalayout.weatherscreens_screen_id = ?',
                   $this->screen_id
                   );

        $this->active = 0;
        $this->renumDrawOrder();

        return;
    }

    function initNew($container, $hostname) {
        global $db;

    // Get next draworder
        $draworder = $db->query_col('SELECT MAX(weatherscreens.draworder)
                                       FROM weatherscreens
                                      WHERE weatherscreens.hostname = ?',
                                    $hostname
                                    );

        if (strlen($draworder) > 0 && $draworder >= 0)
            $draworder++;
        else
            $draworder = 0;

    // Insert screen
        $db->query('INSERT INTO weatherscreens
                            SET weatherscreens.screen_id = NULL,
                                weatherscreens.draworder = ?,
                                weatherscreens.container = ?,
                                weatherscreens.hostname  = ?,
                                weatherscreens.units     = 0',
                    $draworder,
                    $container,
                    $hostname
                    );

        $this->setActive();
        $this->renumDrawOrder();
    }

    function renumDrawOrder( ) {
        global $db;
        $i = 0;

        $sh = $db->query('SELECT weatherscreens.screen_id
                            FROM weatherscreens
                           WHERE weatherscreens.hostname = ?
                        ORDER BY weatherscreens.draworder',
                        $this->host
                        );

        while($id = $sh->fetch_col()) {
            $db->query('UPDATE weatherscreens
                           SET weatherscreens.draworder = ?
                         WHERE weatherscreens.hostname  = ?
                           AND weatherscreens.screen_id = ?',
                        $i,
                        $this->host,
                        $id
                        );
            $i++;
        }
    }

    function move( $direction ) {
        global $db;

        if ($direction == 'up')   $i = -1;
        if ($direction == 'down') $i =  1;

        $db->query('UPDATE weatherscreens
                       SET weatherscreens.draworder = ?
                     WHERE weatherscreens.draworder = ?
                       AND weatherscreens.hostname  = ?',
                    $this->draworder,
                    ($this->draworder+$i),
                    $this->host
                    );

        $db->query('UPDATE weatherscreens
                       SET weatherscreens.draworder = ?
                     WHERE weatherscreens.screen_id = ?
                       AND weatherscreens.hostname  = ?',
                    ($this->draworder+$i),
                    $this->screen_id,
                    $this->host
                    );

        $this->renumDrawOrder();
    }

    function checkScreenID( ) {
        global $db;

    // Sanity check on screen_id
        if ($this->screen_id >= 0) {
            $count = $db->query_col('SELECT COUNT(weatherscreens.screen_id)
                                       FROM weatherscreens
                                      WHERE weatherscreens.screen_id = ?',
                                    $this->screen_id
                                    );
            if ($count != 0)
                return TRUE;
        }
        return FALSE;
    }

    function runSearch( $needle ) {
        global $db;
        if (!$this->checkScreenID())
            return;

    // Build container name to types hash
    //
    // TODO This is not the way to do this.  All of this data is stored
    //      in the weather-ui.xml file.  Parsing it to get type descriptions
    //      seems overkill.

        $type_hash['Animated Map']          = 'amdesc';
        $type_hash['Static Map']            = 'smdesc';
        $type_hash['Current Conditions']    = 'cclocation';
        $type_hash['Six Day Forecast']      = '6dlocation';
        $type_hash['Three Day Forecast']    = '3dlocation';
        $type_hash['Severe Weather Alerts'] = 'swlocation';
        $type_hash['18 Hour Forecast']      = '18hrlocation';

        // Run scripts that supply $this->container and search for $needle
        $sh = $db->query('SELECT weathersourcesettings.sourceid,
                                 weathersourcesettings.path,
                                 weathersourcesettings.types
                            FROM weathersourcesettings
                           WHERE weathersourcesettings.hostname = ?',
                         $this->host
                         );

        while (list($source_id, $script, $types) = $sh->fetch_row()) {
            $types_arr = explode(',', $types);
            foreach ($types_arr as $type) {
                if ($type_hash[$this->container] == $type) {
                    $results = $this->runScript($script, "-l \"$needle\"");
                    if (count($results))
                        $this->search[$source_id] = $results;
                }
            }
        }

        $sh->finish();
    }

    function getData( ) {
        global $db;
        if (!$this->checkScreenID())
            return;

    // Find script file for this screen_id
        $sh = $db->query('SELECT DISTINCT weathersourcesettings.path
                            FROM weathersourcesettings,
                                 weatherdatalayout
                           WHERE weatherdatalayout.weatherscreens_screen_id = ?
                             AND weathersourcesettings_sourceid             = weathersourcesettings.sourceid',
                         $this->screen_id
                         );

        $script = $sh->fetch_col();
        if (!isset($script))
            return;

    // Find location
        $sh = $db->query('SELECT DISTINCT weatherdatalayout.location
                            FROM weatherdatalayout
                           WHERE weatherdatalayout.weatherscreens_screen_id = ?',
                        $this->screen_id
                        );
        $location = $sh->fetch_col();

    // Generate args and run the script
        $units = $this->units == 0 ? 'SI' : 'ENG';
        $output_array = $this->runScript($script, '-u '. $units .' -d '. getcwd() .'/'. cache_dir ." $location");

    // Query db data items
        $sh = $db->query('SELECT weatherdatalayout.dataitem
                            FROM weatherdatalayout,
                                 weathersourcesettings
                           WHERE weatherscreens_screen_id      = ?
                            AND weathersourcesettings_sourceid = weathersourcesettings.sourceid',
                        $this->screen_id
                        );

    // Populate data array
        while($dataitem = $sh->fetch_col())
            $this->data[$dataitem] = $output_array[$dataitem];
    }

    function runScript( $script, $args ) {
        $cwd          = getcwd();
        $output_array = array();

    // Make sure the script exists
        if (!file_exists($script)) {
            custom_error("Could not find '$script'.\nThis most likely means that MythWeather is not installed on this host.");
        }

    // Separate path and filename of script
        $scratch      = explode('/', $script);
        $script       = array_pop($scratch);
        $path         = implode('/', $scratch);

        if (chdir($path)) {
            $command  = "$script $args";
            $output   = `./$command`;
        }
        else
            custom_error("Could not change active directory to $path.\n");

        if (! chdir($cwd))
            custom_error("Could not change active directory to $cwd.\n");

    // Split script output into an array
        $scratch = preg_split('/\n/', $output);
        foreach ($scratch as $line) {
            list($key, $var) = preg_split('/::/', $line);
            if (strlen($key))
                $output_array[$key] = trim($var);
        }

        return $output_array;
    }

    function updateLocation ( $source_id, $loc ) {
        global $db;
        if (!$this->checkScreenID() || strlen($loc) <= 0)
            return;

    // Does this location have settings?
        $has_settings = $db->query_col('SELECT COUNT(weatherdatalayout.weathersourcesettings_sourceid)
                                          FROM weatherdatalayout
                                         WHERE weatherdatalayout.weatherscreens_screen_id = ?',
                                       $this->screen_id
                                       );

        if ($has_settings)
            $db->query('UPDATE weatherdatalayout
                           SET weatherdatalayout.location                       = ?,
                               weatherdatalayout.weathersourcesettings_sourceid = ?
                         WHERE weatherdatalayout.weatherscreens_screen_id       = ?',
                       $loc,
                       $source_id,
                       $this->screen_id
                       );
        else {
            $types = $db->query_col('SELECT weathersourcesettings.types
                                       FROM weathersourcesettings
                                      WHERE weathersourcesettings.sourceid = ?',
                                    $source_id
                                    );

            foreach(explode(',', $types) as $type) {
                $db->query('INSERT INTO weatherdatalayout ( location, dataitem, weatherscreens_screen_id, weathersourcesettings_sourceid )
                                 VALUES                   (        ?,        ?,                        ?,                              ? )',
                           $loc,
                           $type,
                           $this->screen_id,
                           $source_id
                           );
            }
        }
    }

    function updateUnits( $units ) {
        global $db;
        if ( !$this->checkScreenID() || $units < 0 || $units > 1 )
            return;

        $db->query('UPDATE weatherscreens
                       SET weatherscreens.units     = ?
                     WHERE weatherscreens.screen_id = ?
                       AND weatherscreens.hostname  = ?',
                   $units,
                   $this->screen_id,
                   $this->host
                   );
    }
}
