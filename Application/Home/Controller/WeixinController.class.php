<?php
namespace Home\Controller;
use Think\Controller;
use Home\Common;

class WeixinController extends Controller {

    public function index(){
        echo 'error';
    }

    /**
     * 微信服务器认证
     * @return bool
     */
    public function valid() {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    /**
     * 验证微信返回的签名
     * @return bool
     * @throws Exception
     */
    private function checkSignature() {
        // you must define TOKEN by yourself
        if (!C('TOKEN')) {
            exit;
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = C('TOKEN');
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

}