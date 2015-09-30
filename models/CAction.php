<?php

namespace app\models;

class CAction implements IAction {
    
    protected static function runx( $paras = null ){
        return null;
    }
    
    public static function run( $paras = null ){
        if(is_array($paras)){
            if(isset($paras['type'])){
                if($paras['type']=='json'){
                    return json_encode(static::runx($paras), JSON_UNESCAPED_UNICODE);
                }
                else if($paras['type']=='xml'){
                    $array2xml = new CArray2Xml();
                    $array2xml->transform(static::runx($paras));
                    $result = $array2xml->getXML();
                    unset($array2xml);
                    return $result;
                }
                else{
                    return [];
                }
            }
        }
        return json_encode(static::runx($paras), JSON_UNESCAPED_UNICODE);
    }
    
    protected static function replaceHtmlTag($str){
        $str=str_replace(">","&gt",$str);
        $str=str_replace("<","&lt",$str);
        return $str;
    }
}
