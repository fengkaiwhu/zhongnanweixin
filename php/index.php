<?php 
//define('APPID', 'wx5907de41eed25602');
//define('APPSECRET', 'd4624c36b6795d1d99dcf0547af5443d');
//define('APPID', 'wx777c25c676b36289');
//define('APPSECRET', '977d97c23c77a7af29f4889fab8ff9a3');
define('TOKEN', 'weixin');
require 'wechat.class.php';
require "../inc/mysql.class.php";
$wechat = new WeChat(APPID, APPSECRET, TOKEN);
//$wechat->valid();                              //验证token
$wechat->responseMsg();                          //消息响应
 ?>
