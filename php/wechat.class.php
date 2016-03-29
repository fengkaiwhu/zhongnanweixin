<?php 
/**
* 
*/

class WeChat
{
	private $_appid;
	private $_appsecret;
	private $_token;
	
	public function __construct($_appid, $_appsecret, $_token)
	{
		$this->_appid = $_appid;
		$this->_appsecret = $_appsecret;
		$this->_token = $_token;
	}

		public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        switch ($postObj->MsgType) {
        	case 'event':
        		$this->_doEvent($postObj);                     //事件响应
        		break;
        	case 'text':
        		$this->_doText($postObj);                      //文本响应
        		break;
        	case 'image':
        		$this->_doImage($postObj);                      //图片响应
        		break;
        	case 'voice':
        		$this->_doVoice($postObj);                      //语音响应
        		break;
        	default:
        		# code...
        		break;
        }
    }

    private function _doEvent($postObj)
    {
    	$fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $eventType = trim($postObj->Event);
        $eventKey = trim($postObj->EventKey);
        $time = time();
        $textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";
		if ($eventType == "subscribe") {                                     //订阅事件
			$openid = $fromUsername;
			$curl = 'http://design4wechat1.applinzi.com/php/getUserInfo.php?openid='.$openid;
			$content = $this->_request($curl, false, 'POST');
			$content = json_decode($content);          
			$nickname = strip_tags($content->nickname);
			$sex = strip_tags($content->sex);
			$city = strip_tags($content->city);
			$province = strip_tags($content->province);
			$country = strip_tags($content->country);
			
			//插入数据库操作
			$con = mysql_connect(DB_HOST. ":". DB_PORT, DB_USER, DB_PASS);
			$link = mysql_select_db(DB_NAME, $con);
			mysql_set_charset("utf-8");

			$sql = "insert into users (OPENID, SEX, NICKNAME, PROVINCE, CITY, COUNTRY) values ('".$openid."', '".$sex."', '".$nickname."', '".$city."', '".$province."', '".$country."')";
			mysql_query($sql);
			
			$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[news]]></MsgType>
						<ArticleCount>1</ArticleCount>
						<Articles>
						<item>
						<Title><![CDATA[点击进入]]></Title> 
						<Description><![CDATA[欢迎订阅]]></Description>
						<PicUrl><![CDATA[picurl]]></PicUrl>
						<Url><![CDATA[url]]></Url>
						</item>
						<item>
						<Title><![CDATA[title]]></Title>
						<Description><![CDATA[description]]></Description>
						<PicUrl><![CDATA[picurl]]></PicUrl>
						<Url><![CDATA[url]]></Url>
						</item>
						</Articles>
						</xml>";
		} else if ($eventType == "unsubscribe") {                                     //取消订阅事件
			$openid = $fromUsername;
			
			//删除数据库操作
			$co$con = mysql_connect(DB_HOST. ":". DB_PORT, DB_USER, DB_PASS);
			$link = mysql_select_db(DB_NAME, $con);
			mysql_set_charset("utf-8");

			$sql = "delete from users where OPENID = '". $openid. "'";
			mysql_query($sql);
	
		}
		switch ($eventKey) {                                //响应点击事件
            default:
                break;
        }
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        echo $resultStr;
    }

    private function _doText($postObj)
    {
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time();
        $textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";             
        $msgType = "text";
        switch ($keyword) {
            case '测试1':
			
				$curl = 'http://design4wechat1.applinzi.com/php/getUserInfo.php?openid='.$fromUsername;
                $content = $this->_request($curl, false, 'POST');
                $content = json_decode($content);
				$openid = strip_tags($content->openid);
            	$nickname = strip_tags($content->nickname);
				$sex = strip_tags($content->sex);
				$city = strip_tags($content->city);
				$province = strip_tags($content->province);
				$country = strip_tags($content->country);
				$contentStr="openid：".$openid."\n姓名：".$nickname."\n性别：".$sex."\n城市：".$city."\n省份：".$province."\n国家：".$country;
				//插入数据库操作
				$con = mysql_connect(SAE_MYSQL_HOST_M. ":". SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS);
				$link = mysql_select_db(SAE_MYSQL_DB, $con);
				mysql_set_charset("utf-8");

				$sql = "insert into user (`openid`, `sex`, `nickname`, `province`, `city`, `country`) values ('".$openid."', '".$sex."', '".$nickname."', '".$city."', '".$province."', '".$country."')";
				mysql_query($sql);
                break;
            case '测试2':
            	$contentStr='关键字回复“测试2”';
            	break;
            default:
                $curl = 'http://www.tuling123.com/openapi/api?key=075ce2c21c5706547d13a0aff05aa5f4&info='.$postObj->Content;
                $content = $this->_request($curl, false, 'POST');
                $content = json_decode($content);          
            	$contentStr = strip_tags($content->text);
                break;
        }
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        echo $resultStr;
    }

    private function _doImage($postObj)
    {
		$fromUsername = $postObj->FromUserName;
		$toUsername = $postObj->ToUserName;
		$keyword = trim($postObj->Content);
		$time = time();
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";             
		$msgType = "text";
		$contentStr='对不起，暂不支持此种类型的消息回复!';
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		echo $resultStr;    	
    }

    private function _doVoice($postObj)
    {
		$fromUsername = $postObj->FromUserName;
		$toUsername = $postObj->ToUserName;
		$keyword = trim($postObj->Content);
		$time = time();
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";             
		$msgType = "text";
		$contentStr='对不起，暂不支持此种类型的消息回复!';
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		echo $resultStr;    	
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	public function _request($curl, $https = true, $method = 'GET', $data = null)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $curl);      
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if ($https) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
		}
		if ($method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		$content = curl_exec($ch);
		curl_close($ch);
		return $content;
	}
	
	public function _getinfo($openid) {
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx777c25c676b36289&secret=977d97c23c77a7af29f4889fab8ff9a3";

		$content = _getcurl($url);
		$content = json_decode($content, true);
		$token = $content['access_token'];

		$userurl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$openid."&lang=zh_CN";
		$userinfo = _getcurl($userurl);
		$userinfo = json_decode($userinfo, true);
		return $userinfo;
	}
	
	public function _getcurl($url) {
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
}
 ?>