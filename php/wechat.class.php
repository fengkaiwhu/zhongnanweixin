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
                $contentStr='关键字回复“测试1”';
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

	public function _getAccessToken()
	{
		$file = './accesstoken';
		if (file_exists($file)) {
			$content = file_get_contents($file);
			$content = json_decode($content);
			if (time() - filemtime($file) < $content->expires_in) {
				return $content->access_token;
			}
		}
		$curl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->_appid.'&secret='.$this->_appsecret;
		$content = $this->_request($curl);
		file_put_contents($file, $content);
		$content = json_decode($content);
		return $content->access_token;
	}

	public function _getTicket($scene_id, $type = 'temp', $expire_seconds = 604800)
	{
		if ($type == 'temp') {
			$data = '{"expire_seconds": %s, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": %s}}}';
			$data = sprintf($data, $expire_seconds, $scene_id);
		} else {
			$data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": %s}}}';
			$data = sprintf($data, $scene_id);
		}
		$curl = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->_getAccessToken();
		$content = $this->_request($curl, true, 'POST', $data);
		$content = json_decode($content);
		return $content->ticket;
	}

	public function _getQRCode($scene_id, $type = 'temp', $expire_seconds = 604800)
	{
		$ticket = $this->_getTicket($scene_id, $type, $expire_seconds);
		$content = $this->_request('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ticket));
		return $content;
	}

}
//$wechat = new WeChat('wx80454f3f840c6190', 'ae6aa50379466503bae3563995d9ca84', 'weixin');
//$wechat = new WeChat('wx5907de41eed25602', 'd4624c36b6795d1d99dcf0547af5443d', 'weixin');
//echo $wechat->_request('https://www.baidu.com');
//echo $wechat->_getAccessToken();
//echo $wechat->_getTicket(30);
//header('Content-type:image/jpeg');
//echo $wechat->_getQRCode(30);
 ?>