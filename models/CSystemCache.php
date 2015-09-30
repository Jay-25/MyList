<?php

namespace app\models;

class CSystemCache extends CCache{
    
    public static function set($key, $value, $duration = 0, $dependency = null){
        
        return \Yii::$app->cache->set($key, $value, $duration, $dependency);
    }
    
    public static function get($key, $default=null){
        $value = \Yii::$app->cache->get($key);
        
        return $value==false?$default:$value;
    }
    
    public static function delete($key){
        return \Yii::$app->cache->delete($key);
    }
}

?>