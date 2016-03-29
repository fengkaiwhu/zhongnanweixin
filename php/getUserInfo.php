<?php

require "../inc/mysql.class.php";

$openid = $_GET["openid"];
//$appid = "wx777c25c676b36289";
//$appsecret = "977d97c23c77a7af29f4889fab8ff9a3";

$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET;

$content = _getcurl($url);
$content = json_decode($content, true);
$token = $content['access_token'];

$userurl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$openid."&lang=zh_CN";
$userinfo = _getcurl($userurl);
print_r($userinfo);

function _getcurl($url) {
	
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);      
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22");
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	

?>