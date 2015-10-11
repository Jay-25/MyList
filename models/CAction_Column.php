<?php

namespace app\models;

class CAction_Column extends CAction {

    protected static function runx( $paras = null ){
    	
        if(empty($paras['oper']) || empty($paras['cuid'])) return -1;

        $uid = CMyUid::get($paras['cuid']);
        if($uid<=0) return  -1;
        
    	try{
    	    if($paras['oper']=='+'){ // 在清单库中创建/更新一个清单
    	        if(empty($paras['cid']) || empty($paras['name'])) return -1;
    	        
        		$sql = "SELECT fun_mylist_update_column(:id, :cid, :name, :custom_id) newid";
        		$command = CDB::getConnection()->createCommand( $sql );
        		$command->bindParam( ':id', $paras['id'], \PDO::PARAM_INT );
        		$command->bindParam( ':cid', $paras['cid'], \PDO::PARAM_INT );
        		$command->bindParam( ':name', $paras['name'], \PDO::PARAM_STR );
        		$command->bindParam( ':custom_id', $uid, \PDO::PARAM_INT );
        		$data = $command->queryAll();
        		
        	    if(count($data)==1 && isset($data[0]['newid'])){
                    return $data[0]['newid'];
                }
    	    }
    	    else if($paras['oper']=='-'){ //从清单库中删除自定义的清单
    	        if(empty($paras['id'])) return -1;
    	        
    	        $sql = "DELETE FROM tab_mylist_columndetail WHERE id = :id AND custom_id = :custom_id";
    	        $command = CDB::getConnection()->createCommand( $sql );
    	        $command->bindParam( ':id', $paras['id'], \PDO::PARAM_INT );
    	        $command->bindParam( ':custom_id', $uid, \PDO::PARAM_INT );
    	        $command->execute();
    	        
    	        return $paras['id'];
    	    }
    	    else if($paras['oper']=='^'){ //上传数据
    	    	foreach($paras['data']['data']['data'] as $cid=>$c){
    	    		$ids=[];
    	    		foreach($c['detail'] as $d){
    	    			if(!empty($d['id']) && $d['id']>0) $ids[]=$d['id'];
     	    		}
    	    		if(count($ids)>0){
    	    			$sql = "DELETE FROM tab_mylist_columndetail WHERE cid=:cid AND custom_id=:custom_id AND id NOT IN (".join(",",$ids).")";
    	    			$command = CDB::getConnection()->createCommand( $sql );
    	    			$command->bindParam( ':cid', $cid, \PDO::PARAM_INT );
    	    			$command->bindParam( ':custom_id', $uid, \PDO::PARAM_INT );
    	    			$command->execute();
    	    		}
    	    		else{
    	    			$sql = "DELETE FROM tab_mylist_columndetail WHERE cid=:cid AND custom_id=:custom_id";
    	    			$command = CDB::getConnection()->createCommand( $sql );
    	    			$command->bindParam( ':cid', $cid, \PDO::PARAM_INT );
    	    			$command->bindParam( ':custom_id', $uid, \PDO::PARAM_INT );
    	    			$command->execute();
    	    		}
    	    	}

    	    	$sql = "SELECT fun_mylist_update_column(:id, :cid, :name, :custom_id) newid";
    	    	$command = CDB::getConnection()->createCommand( $sql );
    	    	foreach($paras['data']['data']['data'] as $cid=>$c){
    	    		foreach($c['detail'] as $d){
    	    			if(!empty($d['id']) && $d['id']<0){
    	    				$command->bindParam( ':id', $d['id'], \PDO::PARAM_INT );
    	    				$command->bindParam( ':cid', $cid, \PDO::PARAM_INT );
    	    				$command->bindParam( ':name', $d['name'], \PDO::PARAM_STR );
    	    				$command->bindParam( ':custom_id', $uid, \PDO::PARAM_INT );
    	    				$command->queryAll();
    	    			}
    	    		}
    	    	}
    	    	
    	    	return 0;
    	    }
    	}
    	catch (\Exception $e){}
    	
    	return -1;
    }
}
