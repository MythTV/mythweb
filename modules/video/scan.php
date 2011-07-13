<?php
/**
 * Video scanner
 *
 *
 * @package     MythWeb
 * @subpackage  Video
 *
/**/

    MythBackend::find()->sendCommand('SCAN_VIDEOS');
    sleep(2);