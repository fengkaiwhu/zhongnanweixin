<?php 
define('APPID', 'wx5907de41eed25602');
define('APPSECRET', 'd4624c36b6795d1d99dcf0547af5443d');
define('TOKEN', 'weixin');
require 'wechat.class.php';
$wechat = new WeChat(APPID, APPSECRET, TOKEN);
//$wechat->valid();                              //验证token
$wechat->responseMsg();                          //消息响应
 ?>