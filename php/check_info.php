<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/css/jquery.mobile-1.3.2.min.css">
    <script src="/js/jquery-1.8.3.min.js"></script>
    <script src="/js/jquery.mobile-1.3.2.min.js"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
    <title>修改个人信息</title>
</head>

<body onload="getvalue()">
  <?php
	class stateInterface
    {
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
	}
	$code = $_GET["code"];
	$state = $_GET["state"];
	$stateInterface = new stateInterface();
	$content =  $stateInterface->_request('https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx5907de41eed25602&secret=d4624c36b6795d1d99dcf0547af5443d&code='. $code. '&grant_type=authorization_code');
	$content = json_decode($content);
	$openid = $content->openid;
	
	// SAE数据库连接
	// $hostname = SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT;
	// $dbuser = SAE_MYSQL_USER;
	// $dbpass = SAE_MYSQL_PASS;
	// $dbname = SAE_MYSQL_DB;
	
	// $con = mysql_connect($hostname, SAE_MYSQL_USER, SAE_MYSQL_PASS);
	// $link = mysql_select_db(SAE_MYSQL_DB, $con);
	// mysql_query("set name utf8");
	// $sql = "select from userinfo where 'userId' = '".$openid."';
	// $info = mysql_query($sql);
	
	// $userName = $info->userName;
	// $sex = $info->sex;
	// $city = $info->city;
	// $provience = $info->provience;
	
	$userName = "张三";
	$telephone = "13131";
	$sex = "男";
	$city = "武汉";
	$provience = "湖北";
	
	?>
  <div data-role="page">
    <div data-role="content">
      <h3 style="text-align:center;">修改个人信息</h3>
      <form action="/php/update_info.php" method="post">
                <div data-role="fieldcontain" style="align:center">
                    <table width="100%">   
                        <tr>
                            <td>
                              <label for="name">姓名：</label>
                            </td>
                            <td>
                                <input type="hidden" name="userId" id="userId" value="<?=$userName?>" />
                            </td>
                        </tr>
						<tr>
                            <td>
                              <label for="name">电话：</label>
                            </td>
                            <td>
                                <input type="hidden" name="userId" id="userId" value="<?=$telephone?>" />
                            </td>
                        </tr>
						<tr>
                            <td>
                              <label for="name">性别：</label>
                            </td>
                            <td>
                                <input type="hidden" name="userId" id="userId" value="<?=$sex?>" />
                            </td>
                        </tr>
						<tr>
                            <td>
                              <label for="name">城市：</label>
                            </td>
                            <td>
                                <input type="hidden" name="userId" id="userId" value="<?=$city?>" />
                            </td>
                        </tr>
						<tr>
                            <td>
                              <label for="name">省份：</label>
                            </td>
                            <td>
                                <input type="hidden" name="userId" id="userId" value="<?=$provience?>" />
                            </td>
                        </tr>
                        
  <tr align="center">
      <td colspan=2>
         <input type="submit" value="--提交预约信息--">
     </td>
  </tr>
  </table>
  </div>
  </form>
  </div>
  </div>
</body>
</html>
