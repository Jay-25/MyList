<?php

namespace app\models;

class CData_Column extends CData {
	protected static function getex( $paras = null ){ // uid
	    if(empty($paras['cuid'])) $paras['cuid'] = 0;
	    $uid = CMyUid::get($paras['cuid']);
	    
        $key = __METHOD__ ;
        $data = CUserCache::get( $key );
        //if( !is_null( $data ) ) return $data;
        
        $sql = "SELECT c.id cid, d.id, c.name cname, d.name, d.custom_id, CASE WHEN v.columnversion IS NULL THEN 0 ELSE v.columnversion END v
                FROM tab_mylist_column c, tab_mylist_columndetail d LEFT JOIN tab_mylist_userversion v ON uid = :custom_id
                WHERE (d.custom_id = 0 OR d.custom_id = :custom_id) AND c.id = d.cid 
                ORDER BY c.sort, d.sort";
        $command = CDB::getConnection()->createCommand( $sql );
        $command->bindParam( ':custom_id', $uid, \PDO::PARAM_INT );
        $result = $command->queryAll();
        
        $data = []; //{column} = {id:{name, detail:[{id, name, custom},{},] },}
        
        $_cname = '';
        $_cid = 0;
        $rownum = count( $result );
        if($rownum > 0){
            $data['v'] = $result[0]['v'];
            
            for($i=0; $i<$rownum; $i++){
                if($_cname != $result[$i]['cname']){
                    $_cid = $result[$i]['cid'];
                    $_cname = $result[$i]['cname'];
                    $data[$_cid] = [ 'name'=>$_cname, 'detail'=>[] ];
                }
                $data[$_cid]['detail'][] = [ 'id'=>$result[$i]['id'], 'name'=>$result[$i]['name'], 'custom'=>$result[$i]['custom_id'] ];
            }
            
            CUserCache::set( $key, $data, 24 * 60 * 60 );
        }
        
        return $data;
    }
}
