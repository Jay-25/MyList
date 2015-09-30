<?php
namespace app\models;

abstract class CCache {
    
    abstract public static function set($key, $value, $duration = 0, $dependency = null);
    
    abstract public static function get($key, $default=null);
    
    abstract public static function delete($key);
    
    protected function uniqueKey($key) {
        return hash ( 'md5', $key, false ) . hash ( 'sha512', $key, false );
    }
}

?>