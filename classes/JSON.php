<?php
/**
 * Wrapper so we can support php less then 5.2 and/or installs without native json built in.
 * The native json is much faster, so prefer it if we can.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

class JSON {
    public static function encode($data) {
        if (function_exists('json_encode'))
            return json_encode($data);
        $JSON = new Services_JSON();
        return $JSON->encode($data);
    }

    public static function decode($data) {
        if (function_exists('json_decode'))
            return json_decode($data);
        $JSON = new Services_JSON();
        return $JSON->decode($data);
    }
}
