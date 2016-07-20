<?php
/**
 * Created by PhpStorm.
 * User: oliwen-fly
 * Date: 2016/7/17
 * Time: 22:47
 */
require_once('HttpClient.class.php');
/**
 * 读取微信access_token
 * @return string
 */
function getWeixinAccessToken() {
    $url = C('WEIXIN_ACCESS_TOKEN_URL').'&appid='.C('WEIXIN_APP_ID').'&secret='.C('WEIXIN_APP_APPSECRET');

    $http = new HttpClient();
    $token = $http->curl_https($url);
    session(C('SESSION_WEIXIN_ACCESS_TOKEN'),$token);
}