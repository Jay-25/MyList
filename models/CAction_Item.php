<?php

namespace app\models;

class CAction_Item extends CAction {

    protected static function runx( $paras = null ){
    	
        if(empty($paras['oper']) || empty($paras['cuid'])) return -1;

        $uid = CMyUid::get($paras['cuid']);
        if($uid==-1) return  -1;
        
    	try{
    		if($paras['oper']=='#'){ //创建/更新清单项
    			if(empty($paras['id'])) return -1;
    			
    			$sql = "SELECT fun_mylist_update_item(:uid, :id, :name, :bell, :godate, :backdate) result";
    			$command = CDB::getConnection()->createCommand( $sql );
    			$command->bindParam( ':uid', $uid, \PDO::PARAM_INT );
    			$command->bindParam( ':id', $paras['id'], \PDO::PARAM_INT );
    			$command->bindParam( ':bell', $paras['bell'], \PDO::PARAM_STR );
    			$command->bindParam( ':godate', $paras['godate'], \PDO::PARAM_STR );
    			$command->bindParam( ':backdate', $paras['backdate'], \PDO::PARAM_STR );
    			$data = $command->queryAll();
    			
    			if(count($data)==1 && isset($data[0]['result'])){
    				return $data[0]['result'];
    			}
    		}
    	    else if($paras['oper']=='+'){ //创建/更新清单细则
    	        if(empty($paras['iid'])) return -1;
    	        
        		$sql = "SELECT fun_mylist_update_itemdetail(:uid, :iid, :ids, :cids, :names, :selecteds) result";
        		$command = CDB::getConnection()->createCommand( $sql );
        		$command->bindParam( ':uid', $uid, \PDO::PARAM_INT );
        		$command->bindParam( ':iid', $paras['iid'], \PDO::PARAM_INT );
        		$command->bindParam( ':ids', $paras['ids'], \PDO::PARAM_STR );
        		$command->bindParam( ':cids', $paras['cids'], \PDO::PARAM_STR );
        		$command->bindParam( ':names', $paras['names'], \PDO::PARAM_STR );
        		$command->bindParam( ':selecteds', $paras['selecteds'], \PDO::PARAM_STR );
        		$data = $command->queryAll();
        		
        	    if(count($data)==1 && isset($data[0]['result'])){
                    return $data[0]['result'];
                }
    	    }
    	    else if($paras['oper']=='-'){ //删除清单
    	        if(empty($paras['id'])) return -1;
    	        
    	        $sql = "SELECT fun_mylist_update_item(:uid, :id, NULL, NULL, NULL, NULL) result";
    	        $command = CDB::getConnection()->createCommand( $sql );
    	        $command->bindParam( ':uid', $uid, \PDO::PARAM_INT );
    	        $command->bindParam( ':id', $paras['id'], \PDO::PARAM_INT );
    	        $data = $command->queryAll();
    	        
    	        if(count($data)==1 && isset($data[0]['result'])){
                    return $data[0]['result'];
                }
    	    }
    	    else if($paras['oper']=='^'){ //上传数据
    	    	$jsondata = json_decode($paras['data'], true);
    	    }
    	}
    	catch (\Exception $e){}
    	
    	return -1;
    }
}
