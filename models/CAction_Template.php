<?php

namespace app\models;

class CAction_Template extends CAction {

    protected static function runx( $paras = null ){
    	
        if(empty($paras['oper']) || empty($paras['cuid'])) return -1;

        $uid = CMyUid::get($paras['cuid']);
        if($uid==-1) return  -1;
        
    	try{
    		if($paras['oper']=='+'){ //创建/更新 模板
    	        if(empty($paras['id'])) return -1;
    	        
        		$sql = "UPDATE tab_mylist_item SET astemplate = :template WHERE uid = :uid AND id = :iid";
        		$command = CDB::getConnection()->createCommand( $sql );
        		$command->bindParam( ':uid', $uid, \PDO::PARAM_INT );
        		$command->bindParam( ':iid', $paras['id'], \PDO::PARAM_INT );
        		$command->bindParam( ':template', $paras['template'], \PDO::PARAM_STR );
        		$data = $command->execute();
        		
        	    return 1;
    	    }
    	    else if($paras['oper']=='-'){ //删除 模板
    	        if(empty($paras['id'])) return -1;
    	        
    	        $sql = "UPDATE tab_mylist_item SET astemplate = NULL WHERE uid = :uid AND id = :iid";
    	        $command = CDB::getConnection()->createCommand( $sql );
    	        $command->bindParam( ':uid', $uid, \PDO::PARAM_INT );
    	        $command->bindParam( ':iid', $paras['id'], \PDO::PARAM_INT );
    	        $data = $command->execute();
    	        
    	        return 1;
    	    }
    	}
    	catch (\Exception $e){}
    	
    	return -1;
    }
}
