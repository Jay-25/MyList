<?php

namespace app\models;

class CMyUid {
    public static function get( $cuid ){
        if($cuid==0) return -1;
        
        $key = __METHOD__ ;
        $data = CUserCache::get( $key );
        if( !is_null( $data ) ) return $data;
        
        try{
            $sql = "SELECT id FROM tab_mylist_user WHERE cuid = :cuid";
            $command = CDB::getConnection()->createCommand( $sql );
            $command->bindParam( ':cuid', $cuid, \PDO::PARAM_STR );
            $data = $command->queryAll();
            
            if( count( $data ) == 1 && isset( $data[0]['id'] ) ){
                $data = $data[0]['id'];
                CUserCache::set( $key, $data );
                return $data;
            }
        }
        catch( \Exception $e ){
        }
        
        return -1;
    }
}

?>