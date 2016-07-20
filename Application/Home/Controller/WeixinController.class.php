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

    /**
     * 获取微信用户的基本信息
     */
    public function getUserInfo() {
        getWeixinAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?'.'access_token='.session(C('SESSION_WEIXIN_ACCESS_TOKEN')).'&openid='.'oVS2hjhbJQtO1WxbgBIzYwxIqesc'.'&lang=zh_CN';
        $http = new \HttpClient();
        $info = $http->get($url);
        echo $info;
    }

    /**
     * 给单个用户发送消息
     */
    public function sendToUserMsg() {
        getWeixinAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.session(C('SESSION_WEIXIN_ACCESS_TOKEN'));
        $http = new \HttpClient();

        $data = array(
            'touser' => 'oVS2hjhbJQtO1WxbgBIzYwxIqesc',
            'template_id' => 'EtgyrJrU9huyYytxpIto8P8XRhLLVDK6gMmOARY9Y1M',
            'url' => 'http://www.baidu.com',
            'data' => array(
                'first' => array(
                    'value' => '恭喜你购买成功',
                    'color' => '#173177',
                ),
                'keyword1' => array(
                    'value' => '一条内裤',
                    'color' => '#173177',
                ),
                'keyword2' => array(
                    'value' => '0000000',
                    'color' => '#173177',
                ),
                'keyword3' => array(
                    'value' => '￥120.00',
                    'color' => '#173177',
                ),
                'keyword4' => array(
                    'value' => '2016.7.20',
                    'color' => '#173177',
                ),
                'remark' => array(
                    'value' => '祝你使用愉快',
                    'color' => '#173177',
                ),
            ),
        );
        $json_template = json_encode($data);
        $msg = $http->request_post($url,urldecode($json_template));
        echo $msg;
    }
}