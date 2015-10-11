<?php

namespace app\models;

class CData_Template extends CData {
	protected static function getex( $paras = null ){ // uid
	    if(empty($paras['cuid'])) $paras['cuid'] = 0;
	    $uid = CMyUid::get($paras['cuid']);
	    
        $sql = "SELECT i.id iid, i.astemplate, c.id cid, d.id, d.name, CASE WHEN v.itemversion IS NULL THEN 0 ELSE v.itemversion END v
                 FROM tab_mylist_item i, tab_mylist_itemdetail d
                      LEFT JOIN tab_mylist_column c ON d.cid = c.id 
                      LEFT JOIN tab_mylist_columndetail cd ON d.id = cd.id
                      LEFT JOIN tab_mylist_userversion v ON uid = :uid
                 WHERE i.id = d.iid AND valid=1 AND i.uid = :uid 
                 ORDER BY i.timestamp DESC, c.sort, cd.sort";
        $command = CDB::getConnection()->createCommand( $sql );
        $command->bindParam( ':uid', $uid, \PDO::PARAM_INT );
        $result = $command->queryAll();
        
        $data = ['data'=>[], 'v'=>-1]; //{user's list} = {id:{name, detail:{id:{cid,name},{}, }}, }
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
				                    		 'name' => $result[$i]['astemplate'],
				                    		 'detail' => [] ];
                }
                if($index>=0){
	                //$data['data'][$index]['detail'][] = [ 'cid'=>$result[$i]['cid'], 'id'=>$result[$i]['id'], 'name'=>$result[$i]['name'] ];
	                $data['data'][$index]['detail'][$result[$i]['id']] = ['cid'=>$result[$i]['cid'], 'name'=>$result[$i]['name']];
                }
            }
        }
        
        return $data;
    }
}
