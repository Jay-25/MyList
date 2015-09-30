<?php

namespace app\models;

use yii\rest\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class CMyController extends Controller {
    
    public function behaviors()
    {
        return [
                'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['logout'],
                        'rules' => [
                                [
                                        'actions' => ['logout'],
                                        'allow' => true,
                                        'roles' => ['@'],
                                        ],
                                ],
                        ],
                'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                                'logout' => ['post'],
                                ],
                        ],
                ];
    }
    
    public function actions()
    {
        return [
                'error' => [
                        'class' => 'yii\web\ErrorAction',
                        ],
                'captcha' => [
                        'class' => 'yii\captcha\CaptchaAction',
                        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                        ],
                ];
    }
    
    private function is_pjax(){
    	return array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX'];
    }
    
    private static $passUrl = array(
            'site/login',            // 登陆
            'site/logout',            // 登出
        );
    public function render( $view, $params = [] ){
        \Yii::$app->language = 'zh-CN';
        /*
        if( !isset( $_GET['r'] ) || (isset( $_GET['r'] ) && !in_array( $_GET['r'], CMyController::$passUrl )) ){
            if( \Yii::$app->user->isGuest ){
                return parent::redirect( \Yii::$app->urlManager->createUrl( [
                        'site/login' 
                ] ) );
            }
            
            // 后登陆优先
            if( COneLogin::getRestrict() == 2 ){
                if( isset( $_SESSION['__uuid'] ) && isset( $_SESSION['__id'] ) && (!COneLogin::has( $_SESSION['__id'] ) || $_SESSION['__uuid'] != COneLogin::get( $_SESSION['__id'] )) ){
                    \Yii::$app->user->logout();
                    return parent::redirect( \Yii::$app->urlManager->createUrl( [
                            'site/login','restrict' => 2 
                    ] ) );
                }
            }
            // 先登陆优先情况下，锁屏期间，有异处登陆
            else if( COneLogin::getRestrict() == 1 ){
                if( isset( $_SESSION['__uuid'] ) && isset( $_SESSION['__id'] ) && (!COneLogin::has( $_SESSION['__id'] ) || $_SESSION['__uuid'] != COneLogin::get( $_SESSION['__id'] )) ){
                    \Yii::$app->user->logout();
                    return parent::redirect( \Yii::$app->urlManager->createUrl( [
                            'site/login','restrict' => '-1' 
                    ] ) );
                }
            }
        }
        //
        if( !isset( $_GET['r'] ) ){
            if( !isset( $_SESSION['__refleshCount'] ) ){
                $_SESSION['__screenlock'] = time();
                COneLogin::update( $_SESSION['__id'], $_SESSION['__screenlock'] );
                $_SESSION['__refleshCount'] = 1;
            }
            $_SESSION['__refleshCount']++;
        }
        else if( !in_array( $_GET['r'], CMyController::$passUrl ) ){
            if( !isset( $_SESSION['__screenlock'] ) || is_null( $_SESSION['__screenlock'] ) || !is_numeric( $_SESSION['__screenlock'] ) || $_SESSION['__screenlock'] < time() - CScreenLock::getTimeout() ){
                return;
            }
            $_SESSION['__screenlock'] = time();
            COneLogin::update( $_SESSION['__id'], $_SESSION['__screenlock'] );
        }
        */
        //
        if( isset( $_SERVER["HTTP_X_REQUESTED_WITH"] ) && strtolower( $_SERVER["HTTP_X_REQUESTED_WITH"] ) == "xmlhttprequest" ){
            return parent::renderPartial( $view, $params );
        }
        else{
            return parent::render( $view, $params );
        }
    }
}

?>