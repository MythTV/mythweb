<?php
/**
 *  This is the base object to handle all the common features for all myth classes
 *
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/modules/tv/classes/Channel.php $
 * @date        $Date: 2010-06-06 10:07:45 -0700 (Sun, 06 Jun 2010) $
 * @version     $Revision: 25003 $
 * @author      $Author: kormoc $
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Classes
 *
/**/

class MythBase {
    public $cacheKey = null;
    public $cacheLifetime = 600;
    private static $instances = array();

    public static function &find() {
        $args = func_get_args();
        $class = get_called_class();
        $key = $class.'('.implode(',', $args).')';
        if (!isset(self::$instances[$key])) {
            self::$instances[$key] = &Cache::getObject($key);
            if (is_null(self::$instances[$key]) || !is_object(self::$instances[$key]) || get_class(self::$instances[$key]) !== $class) {
                $r = new ReflectionClass($class);
                self::$instances[$key] = $r->newInstanceArgs($args);
                self::$instances[$key]->cacheKey = $key;
            }
        }
        return self::$instances[$key];
    }

    public function __destruct() {
        if (!is_null($this->cacheKey))
            Cache::setObject($this->cacheKey, $this, $this->cacheLifetime);
    }

}
