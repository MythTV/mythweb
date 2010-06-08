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
        $class = get_called_class();
        $args = func_get_args();
        $key = self::getCacheKey($class, $args);
        if (is_null($key)) {
            $r = new ReflectionClass($class);
            $obj = $r->newInstanceArgs($args);
            return $obj;
        }
        elseif (!isset(self::$instances[$key])) {
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
            Cache::setObject($this->cacheKey, &$this, $this->cacheLifetime);
        $this->cacheKey = null;
    }

    public function __wakeup() {
        if (!is_null($this->cacheKey)) {
            if (isset(self::$instances[$this->cacheKey]))
                $this->cacheKey = null;
            else
                self::$instances[$this->cacheKey] = &$this;
        }
    }

    private static function getCacheKey($class, &$data) {
        switch ($class) {
            case 'Program':
                $ret = implode(',', array('chanid'=>$data[0]['chanid'], 'starttime'=>$data[0]['starttime']));
                break;
            case 'Channel':
                if (isset($data['chanid']))
                    $ret = $data['chanid'];
                elseif (isset($data[0]))
                    $ret = $data[0];
                else
                    $ret = null;
                break;
            default:
                $ret = implode(',', $data);
                break;
        }
        return "$class($ret)";
    }

}
