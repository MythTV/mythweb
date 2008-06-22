<?php
/**
 * Display template for Static Maps for the Weather module
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

<?php
    $image = array_pop(split('/', $screen->data['map']));
    $matches = array();
    preg_match('/(.*)-\d*x\d*/', $image, $matches);
?>



    <div class="radar">
        <h2><?php echo $screen->data["smdesc"] ?></h2>

        <div class="radar_image">
            <center>
                <img name="static_map" src="<?php echo cache_url . $matches[1] ?>" alt="Static Map">
            </center>
        </div>
    </div>
