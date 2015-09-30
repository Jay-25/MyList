<?php

namespace app\models;

class CData_Item extends CData {
	protected static function getex( $paras = null ){ // uid
	    if(empty($paras['cuid'])) $paras['cuid'] = 0;
	    $uid = CMyUid::get($paras['cuid']);
	    
        $key = __METHOD__ ;
        $data = CUserCache::get( $key );
        //if( !is_null( $data ) ) return $data;
        
        $sql = "SELECT i.id iid, i.name iname, i.bell, i.godate, i.backdate, c.id cid, d.id, d.name, d.selected, CASE WHEN v.itemversion IS NULL THEN 0 ELSE v.itemversion END v
                 FROM tab_mylist_item i, tab_mylist_itemdetail d
                      LEFT JOIN tab_mylist_column c ON d.cid = c.id 
                      LEFT JOIN tab_mylist_columndetail cd ON d.id = cd.id
                      LEFT JOIN tab_mylist_userversion v ON uid = :uid
                 WHERE i.id = d.iid AND valid=1 AND i.uid = :uid 
                 ORDER BY i.godate DESC, c.sort, cd.sort";
        $command = CDB::getConnection()->createCommand( $sql );
        $command->bindParam( ':uid', $uid, \PDO::PARAM_INT );
        $result = $command->queryAll();
        
        $data = []; //{user's list} = [{id, name, godate, backdate, bell, detail:[{cid,id,name,selected},{}, ]}]
        $index = -1;
        $_iname = '';
        $rownum = count( $result );
        if($rownum > 0){
            $data['v'] = $result[0]['v'];
            
            for($i=0; $i<$rownum; $i++){
                if($_iname != $result[$i]['iname']){
                	$_iname = $result[$i]['iname'];
                	$index++;
                    $data[$index] = ['id' => $result[$i]['iid'], 
                    		         'name' => $result[$i]['iname'], 
                    		         'godate' => $result[$i]['godate'], 
    		                		 'backdate' => $result[$i]['backdate'],
    		                		 'bell' => $result[$i]['bell'],
                    		         'detail'=> [] ];
                }
                $data[$index]['detail'][] = [ 'cid'=>$result[$i]['cid'], 'id'=>$result[$i]['id'], 'name'=>$result[$i]['name'], 'selected'=>$result[$i]['selected'] ];
            }
            
            CUserCache::set( $key, $data, 24 * 60 * 60 );
        }
        
        return $data;
    }
}
