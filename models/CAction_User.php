<?php

namespace app\models;

class CAction_User extends CAction {

    protected static function runx( $paras = null ){ // cuid, email, tel, weixin, qq, sina
    	
    	try{
    	    if(!empty($paras['cuid'])){
    	        $sql = "UPDATE tab_mylist_user
SET tel = DO_STR_NULL(:tel, tel),
 email = DO_STR_NULL(:email, email),
 weixin = DO_STR_NULL(:weixin, weixin),
 qq = DO_STR_NULL(:qq, qq),
 sina = DO_STR_NULL(:sina, sina)
WHERE cuid = :cuid";
    	        $command = CDB::getConnection()->createCommand( $sql );
    	        $command->bindParam( ':cuid', $paras['cuid'], \PDO::PARAM_STR );
    	        $command->bindParam( ':tel', $paras['tel'], \PDO::PARAM_STR );
    	        $command->bindParam( ':email', $paras['email'], \PDO::PARAM_STR );
    	        $command->bindParam( ':weixin', $paras['weixin'], \PDO::PARAM_STR );
    	        $command->bindParam( ':qq', $paras['qq'], \PDO::PARAM_STR );
    	        $command->bindParam( ':sina', $paras['sina'], \PDO::PARAM_STR );
    	        $command->execute();
    	    }
    	    else{
    	        if(!empty($paras['email'])){
    	            
    	            
    	        }
    	        else if(!empty($paras['tel'])){
    	             
    	        }
    	        else if(!empty($paras['weixin'])){
    	            $sql = "SELECT cuid FROM tab_mylist_user WHERE weixin = :weixin AND length(weixin) > 0";
    	            $command = CDB::getConnection()->createCommand( $sql );
    	            $command->bindParam( ':weixin', $paras['weixin'], \PDO::PARAM_STR );
    	            $result = $command->queryAll();
    	            if( count( $result ) == 1 && isset( $result[0]['cuid'] ) ){
    	                return $result[0]['cuid'];
    	            }
    	        }
    	        else if(!empty($paras['qq'])){
    	            $sql = "SELECT cuid FROM tab_mylist_user WHERE qq = :qq AND length(qq) > 0";
    	            $command = CDB::getConnection()->createCommand( $sql );
    	            $command->bindParam( ':qq', $paras['qq'], \PDO::PARAM_STR );
    	            $result = $command->queryAll();
    	            if( count( $result ) == 1 && isset( $result[0]['cuid'] ) ){
    	                return $result[0]['cuid'];
    	            }
    	        }
    	        else if(!empty($paras['sina'])){
    	            $sql = "SELECT cuid FROM tab_mylist_user WHERE sina = :sina AND length(sina) > 0";
    	            $command = CDB::getConnection()->createCommand( $sql );
    	            $command->bindParam( ':sina', $paras['sina'], \PDO::PARAM_STR );
    	            $result = $command->queryAll();
    	            if( count( $result ) == 1 && isset( $result[0]['cuid'] ) ){
    	                return $result[0]['cuid'];
    	            }
    	        }
    	    }
    	    
    	}
    	catch (\Exception $e){}
    	
    	return '';
    }
}
