<?php
namespace app\models;

class Geocoder {
	static public function getPosition($address){
	    $url = "http://api.map.baidu.com/geocoder?address=".urlencode($address)."&output=json&key=" . \Yii::$app->params['Map-Key'];
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		
		$output = json_decode($output);
		
		if(isset($output->result->location)){
			return [$output->result->location->lng, $output->result->location->lat];
		}
		return null;
	}
}
