<?php

namespace app\models;

class CExportData {
    public static function getFilename( $filename, $exname, $paras ){
        $accountName = \Yii::$app->user->identity->username;
        
        $accountCode = "---";
        if( isset( $paras['accountCode'] ) && !is_null( $paras['accountCode'] ) ){
            $accountCode = $paras['accountCode'];
            if( is_array( $accountCode ) ){
                $accountCode = "...";
            }
        }
        
        $y = date( "Y" );
        $M = date( "m" );
        $d = date( "d" );
        $H = date( "H" );
        $m = date( "i" );
        $s = date( "s" );
        
        $filename = str_replace( "%C", $accountName, $filename );
        $filename = str_replace( "%c", $accountCode, $filename );
        $filename = str_replace( "%y", $y, $filename );
        $filename = str_replace( "%M", $M, $filename );
        $filename = str_replace( "%d", $d, $filename );
        $filename = str_replace( "%h", $H, $filename );
        $filename = str_replace( "%m", $m, $filename );
        $filename = str_replace( "%s", $s, $filename );
        
        return iconv( "UTF-8", "GB2312", $filename . "." . $exname );
    }
    public static function getData_CSV( $resultData ){
        $resultData = json_decode( iconv( "UTF-8", "GB2312", $resultData ), true );
        
        $colnum = count( $resultData['header'] );
        $rownum = count( $resultData['rows'] );
        
        $context = "";
        for($c = 0; $c < $colnum; $c++){
            $context .= "\"" . str_replace( "\"", "\"\"", $resultData['header'][$c] ) . "\",";
        }
        $context .= "\n";
        
        for($r = 0; $r < $rownum; $r++){
            for($c = 0; $c < $colnum; $c++){
                $context .= "\"" . str_replace( "\"", "\"\"", $resultData['rows'][$r][$c] ) . "\",";
            }
            $context .= "\n";
        }
        
        return iconv( "UTF-8", "GB2312", $context );
    }
}

?>