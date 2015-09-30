<?php

namespace app\models;

class CTimestamp {
    public static function timestamp(){ // from 1970-1-1 ms
        list( $usec, $sec ) = explode( " ", microtime() );
        return round( ((float)$usec + (float)$sec) * 1000 );
    }
}

?>