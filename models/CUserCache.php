<?php

namespace app\models;

class CUserCache extends CCache{
    
    public static function set($key, $var, $expire = 0, $dependency = null) {
        $timestamp = ($expire > 0) ? (time () + $expire) : 0;
        $_SESSION [$key] = array (
                'var' => $var,
                'timestamp' => $timestamp
        );
        return $var;
    }
    
	public static function get($key, $defaultVar = null) {
		if (!isset($_SESSION[$key])) {
			return null;
		}
		$result = $_SESSION [$key];
		if ($result ['timestamp'] > 0 && $result ['timestamp'] < time ()) {
			unset ( $_SESSION [$key] );
			return null;
		}
		return empty ( $result ) ? $defaultVar : $result ['var'];
	}
	
	public static function delete($key) {
		unset ( $_SESSION [$key] );
		return null;
	}
}

?>