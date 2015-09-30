<?php
namespace app\models;

class CDB {
    
    public static function getConnection(){
        return \Yii::$app->pgdb;
    }
}

?>