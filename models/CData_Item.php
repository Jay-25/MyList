<?php

namespace app\models;

class CData_Item extends CData {
	protected static function getex( $paras = null ){ // uid
	    if(empty($paras['cuid'])) $paras['cuid'] = 0;
	    $uid = CMyUid::get($paras['cuid']);
	    
	    if(empty($paras['specialid']) || $paras['specialid']==0){
	        $sql = "SELECT i.id iid, i.name iname, to_char(i.timestamp,'yyyy-mm-dd') \"timestamp\", c.id cid, d.id, d.name, d.selected, CASE WHEN v.itemversion IS NULL THEN 0 ELSE v.itemversion END v
	                 FROM tab_mylist_item i
	        		      LEFT JOIN tab_mylist_itemdetail d ON i.id = d.iid
	                      LEFT JOIN tab_mylist_column c ON d.cid = c.id 
	                      LEFT JOIN tab_mylist_columndetail cd ON d.id = cd.id
	                      LEFT JOIN tab_mylist_userversion v ON i.uid = :uid
	                 WHERE i.valid=1 AND i.uid = :uid 
	                 ORDER BY i.timestamp DESC, c.sort, cd.sort";
	        $command = CDB::getConnection()->createCommand( $sql );
	        $command->bindParam( ':uid', $uid, \PDO::PARAM_INT );
	        $result = $command->queryAll();
	        
	        $data = ['data'=>[], 'v'=>-1]; //{user's list} = {id:{name, timestamp, detail:{id:{cid,name,selected},{}, }}, }
	        $index = -1;
	        $_iname = '';
	        $rownum = count( $result );
	        if($rownum > 0){
	            $data['v'] = $result[0]['v'];
	            
	            for($i=0; $i<$rownum; $i++){
	                if($_iname != $result[$i]['iname']){
	                	$_iname = $result[$i]['iname'];
	                	$index = $result[$i]['iid'];
	                    $data['data'][$index] = [
					                    		 'name' => $result[$i]['iname'],
					                    		 'timestamp' => $result[$i]['timestamp'],
					                    		 'detail' => [] ];
	                }
	                if($index>=0 && !empty($result[$i]['cid'])){
		                //$data['data'][$index]['detail'][] = [ 'cid'=>$result[$i]['cid'], 'id'=>$result[$i]['id'], 'name'=>$result[$i]['name'], 'selected'=>$result[$i]['selected'] ];
		                $data['data'][$index]['detail'][$result[$i]['id']] = ['cid'=>$result[$i]['cid'], 'name'=>$result[$i]['name'], 'selected'=>$result[$i]['selected']];
	                }
	            }
	        }
	        
	        return $data;
	    }
	    else{
	    	$sql = "SELECT i.id iid, i.name iname, to_char(i.timestamp,'yyyy-mm-dd') \"timestamp\", c.id cid, d.id, d.name, d.selected, CASE WHEN v.itemversion IS NULL THEN 0 ELSE v.itemversion END v
	                 FROM tab_mylist_item i
	        		      LEFT JOIN tab_mylist_itemdetail d ON i.id = d.iid
	                      LEFT JOIN tab_mylist_column c ON d.cid = c.id
	                      LEFT JOIN tab_mylist_columndetail cd ON d.id = cd.id
	                      LEFT JOIN tab_mylist_userversion v ON i.uid = :uid
	                 WHERE i.valid=1 AND i.uid = :uid AND i.id = :specialid
	                 ORDER BY i.timestamp DESC, c.sort, cd.sort";
	    	$command = CDB::getConnection()->createCommand( $sql );
	    	$command->bindParam( ':uid', $uid, \PDO::PARAM_INT );
	    	$command->bindParam( ':specialid', $paras['specialid'], \PDO::PARAM_INT );
	    	$result = $command->queryAll();
	    	 
	    	$data = []; //{user's list} = {name, timestamp, detail:{id:{cid,name,selected},{}, }}
	    	$index = -1;
	    	$_iname = '';
	    	$rownum = count( $result );
	    	if($rownum > 0){
	    		for($i=0; $i<$rownum; $i++){
	    			if($_iname != $result[$i]['iname']){
	    				$_iname = $result[$i]['iname'];
	    				$index = $result[$i]['iid'];
	    				$data = [
	    						'name' => $result[$i]['iname'],
	    						'timestamp' => $result[$i]['timestamp'],
	    						'detail' => [] ];
	    			}
	    			if(!empty($result[$i]['cid'])){
	    				$data['detail'][$result[$i]['id']] = ['cid'=>$result[$i]['cid'], 'name'=>$result[$i]['name'], 'selected'=>$result[$i]['selected']];
	    			}
	    		}
	    	}
	    	 
	    	return $data;
	    }
    }
}
