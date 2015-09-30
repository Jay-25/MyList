<?php

namespace app\controllers;

use Yii;

use app\models\CMyController;
use app\models\CExportData;

class MyController extends CMyController {

	private function _dynamicGetDataConsole($data, $pars) {
		try {
			return call_user_func ( 'app\\models\\' . $data . '::get', $pars );
		} catch ( \Exception $e ) {
			return $e;//print_r($e);
		}
	}
	
	private function _dynamicGetData() {
		if (isset ( $_GET ['data'] )) {
		    return $this->_dynamicGetDataConsole($_GET ['data'], isset($_GET ['paras'])?$_GET ['paras']:null );
		}
		return [];
	}

	private function _dynamicRunAction() {
		if (isset ( $_GET ['data'] )) {
			try {
				return call_user_func ( 'app\\models\\' . $_GET ['data'] . '::run', isset($_GET ['paras'])?$_GET ['paras']:null );
			} catch ( \Exception $e ) {
				return $e;//print_r($e);
			}
		}
		return [];
	}
	
	/* ------------------------------------------------------ */

	public function actionData() {
		$data = $this->_dynamicGetData ();
		header('Access-Control-Allow-Origin: *');
		return $data;
	}

	public function actionRunaction() {
		$data = $this->_dynamicRunAction ();
		header('Access-Control-Allow-Origin: *');
		return $data;
	}

	public function actionExportdata(){
		$paras = json_decode($_POST ['paras'], true);
		$exname = $_POST ['exname'];
		$filename = (isset($_POST ['filename']) && !is_null($_POST ['filename']) && count($_POST ['filename'])>0)?$_POST ['filename']:$paras ['data'];

		$filename = CExportData::getFilename($filename, $exname, $paras['paras']);

		if($exname=="csv"){
			$resultData = $this->_dynamicGetDataConsole($paras ['data'], $paras ['paras']);
			$context = CExportData::getData_CSV($resultData);

//			header('Content-type: application/octet-stream');
			header("Content-type:text/csv");
			header('Accept-Ranges: bytes');
			header('Accept-Length:'.count($context));
			header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
			header('Expires:0');
			header('Pragma:public');
			header("Content-Disposition: attachment; filename=".$filename);

			echo $context;
		}
	}

}



