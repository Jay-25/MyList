<?php

namespace app\models;

class CAction_Column extends CAction {

    protected static function runx( $paras = null ){
    	
        if(empty($paras['oper']) || empty($paras['cuid'])) return -1;

        $uid = CMyUid::get($paras['cuid']);
        if($uid==-1) return  -1;
        
    	try{
    	    if($paras['oper']=='+'){ // 在清单库中创建/更新一个清单
    	        if(empty($paras['cid']) || empty($paras['name'])) return;
    	        
        		$sql = "SELECT fun_mylist_update_column(:cid, :name, :custom_id) newid";
        		$command = CDB::getConnection()->createCommand( $sql );
        		$command->bindParam( ':cid', $paras['cid'], \PDO::PARAM_INT );
        		$command->bindParam( ':name', $paras['name'], \PDO::PARAM_STR );
        		$command->bindParam( ':custom_id', $uid, \PDO::PARAM_INT );
        		$data = $command->queryAll();
        		
        		CUserCache::delete('app\\models\\CData_Column::getex');
        		
        	    if(count($data)==1 && isset($data[0]['newid'])){
                    return $data[0]['newid'];
                }
    	    }
    	    else if($paras['oper']=='-'){ //从清单库中删除自定义的清单
    	        if(empty($paras['id'])) return;
    	        
    	        $sql = "DELETE FROM tab_mylist_columndetail WHERE id = :id AND custom_id = :custom_id";
    	        $command = CDB::getConnection()->createCommand( $sql );
    	        $command->bindParam( ':id', $paras['id'], \PDO::PARAM_INT );
    	        $command->bindParam( ':custom_id', $uid, \PDO::PARAM_INT );
    	        $command->execute();
    	        
    	        CUserCache::delete('app\\models\\CData_Column::getex');
    	        
    	        return $paras['id'];
    	    }
    	    else if($paras['oper']=='^'){ //上传数据
    	    	$jsondata = json_decode($paras['data'], true);
    	    	
    	    }
    	}
    	catch (\Exception $e){}
    	
    	return -1;
    }
}
