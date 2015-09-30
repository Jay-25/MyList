<?php

namespace app\models;

class CData implements IData {
    
    protected static function getex( $paras = null ){
        return null;
    }
    
    public static function get( $paras = null ){
        if(is_array($paras)){
            if(isset($paras['type'])){
                if($paras['type']=='json'){
                    return json_encode(['v'=>\Yii::$app->params['dataVersion'], 'data'=>static::getex($paras)], JSON_UNESCAPED_UNICODE);
                }
                else if($paras['type']=='xml'){
                    $array2xml = new CArray2Xml();
                    $array2xml->transform(['v'=>\Yii::$app->params['dataVersion'], 'data'=>static::getex($paras)]);
                    $result = $array2xml->getXML();
                    unset($array2xml);
                    return $result;
                }
                else{
                    return [];
                }
            }
        }
        return json_encode(['v'=>\Yii::$app->params['dataVersion'], 'data'=>static::getex($paras)], JSON_UNESCAPED_UNICODE);
    }
}
