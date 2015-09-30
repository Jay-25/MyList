<?php

namespace app\models;

class CToken {
    public static function randKey( $length ){
        $str = '';
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen( $strPol ) - 1;
        
        for($i = 0; $i < $length; $i++){
            $str .= $strPol[rand( 0, $max )];
        }
        
        return $str;
    }
    public static function decrypt( $key, $str, $default = null ){
        try{
            $iv = $key;
            $token = mcrypt_decrypt( MCRYPT_RIJNDAEL_128, $key, base64_decode( $str ), MCRYPT_MODE_CBC, $iv );
            
            return rtrim( $token, "\0\3\4" );
        }
        catch( \Exception $e ){
        }
        return $default;
    }
}

?>