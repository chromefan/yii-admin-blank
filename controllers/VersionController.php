<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class VersionController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout','checkrule'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'checkrule' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionCheckrule(){
        if(Yii::$app->request->isAjax){
            $rule=Yii::$app->request->post('rule_text');
            $msg='匹配成功!';
            if(strstr($rule,'||')){
                $tmp=explode('||',$rule);
                $msg=implode('和',$tmp).'   符合升级条件';
            }
            if(empty($rule)){
                $msg='不能为空';
                self::error($msg);
            }
            self::success($msg);
        }
    }
    public function actionHashcode(){
        if(Yii::$app->request->isAjax){
            $scale=(int)Yii::$app->request->post('scale');
            $str=Yii::$app->request->post('deviceId');
            $str=trim($str);
            if(empty($str)){
                $msg='不能为空';
                self::error($msg);
            }
            $str=md5($str);
            $hash_value=$this->getStringHashCode($str);
            $num=$hash_value%100;
            $msg="HashCode:{$hash_value}<br>";
            $msg.="对比值:{$num}<br>";
            $msg.="限制比例:{$scale}%<br>";
            if($num>$scale){
                $result='<span class="red">不符合升级条件</span>';
            }else{
                $result='<span class="green">符合升级条件</span>';
            }
            $msg.="{$result}<br>";
            self::success($msg);
        }
    }
    public function getStringHashCode($string){
        $hash = 0;
        $stringLength = strlen($string);
        for($i = 0; $i < $stringLength; $i++){
            $hash  += $string[$i];
        }
        return $hash;
    }
    /**
    +----------------------------------------------------------
     * Ajax方式返回数据到客户端
    +----------------------------------------------------------
     * @access protected
    +----------------------------------------------------------
     * @param mixed $data 要返回的数据
     * @param String $info 提示信息
     * @param boolean $status 返回状态
     * @param String $status ajax返回类型 JSON XML
    +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     */
    public static function ajaxReturn($data='',$info='',$status=1,$type='JSON') {
        $result  =  array();
        $result['status']  =  $status;
        $result['info'] =  $info;
        $result['data'] = $data;

        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($result));
    }
    /**
    +----------------------------------------------------------
     * 操作错误跳转的快捷方法
    +----------------------------------------------------------
     * @access public
    +----------------------------------------------------------
     * @param string $message 错误信息
    +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     */
    public static function error($message='error',$data='') {
        self::ajaxReturn($data,$message,0);
    }

    /**
    +----------------------------------------------------------
     * 操作成功跳转的快捷方法
    +----------------------------------------------------------
     * @access public
    +----------------------------------------------------------
     * @param string $message 提示信息
    +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     */
    public static function success($message='ok',$data='') {

        self::ajaxReturn($data,$message,1);
    }
}
