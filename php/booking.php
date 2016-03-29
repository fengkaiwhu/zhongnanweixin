<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/css/jquery.mobile-1.3.2.min.css">
    <script src="/js/jquery-1.8.3.min.js"></script>
    <script src="/js/jquery.mobile-1.3.2.min.js"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
    <title>预约体检</title>
</head>

<body onload="getvalue()">
  <?php
  require "../inc/mysql.class.php";
  
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
	
	$code = $_GET["code"];
	$state = $_GET["state"];
	//$appid = "wx777c25c676b36289";
	//$appsecret = "977d97c23c77a7af29f4889fab8ff9a3";
	
	$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=". APPID. "&secret=". APPSECRET. "&code=". $code. "&grant_type=authorization_code";

	$content = _getcurl($url);
	$content = json_decode($content, true);
	$openid = $content['openid'];
  ?>
  <div data-role="page">
    <div data-role="content">
      <h3 style="text-align:center;">预约体检</h3>
      <form action="/php/booking_ensure.php" method="post">
                <div data-role="fieldcontain" style="align:center">
                    <table width="100%">
                        <tr>
                            <td>
                              <label for="name">姓名：</label>
                            </td>
                            <td>
                                <input type="text" name="name" id="name" placeholder="请输入姓名" />
                                <input type="hidden" name="userId" id="userId" value="<?=$openid?>" readonly="readonly" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                              <label for="idNum">身份证号：</label>
                            </td>
                            <td>
                                <input type="text" name="idNum" id="idNum" placeholder="请输入身份证号" />
                            </td>
                        </tr>
                        <tr>
                          <td>
                                <label for="sex">性别：</label>
                            </td>
                            <td>
                                <fieldset data-role="controlgroup" data-type="horizontal">
                                  <label for="male">男性</label>
                                  <input type="radio" name="sex" id="male" value="1" checked>
                                  <label for="female">女性</label>
                                  <input type="radio" name="sex" id="female" value="2">
                              </fieldset>
                          </td>
                        </tr>
                        <tr>
                          <td>
                             <label for="age">年龄：</label>
                          </td>
                           <td>
                            <input type="range" name="age" id="age" value="30" min="0" max="120">
                        </td>
                  </tr>
                  <tr>
                      <td>
                         <label for="telephone">电话：</label>
                     </td>
                     <td>
                      <input type="text" name="telephone" id="telephone" placeholder="请输入电话" />
                  </td>
              </tr>
              <tr>
                  <td>
                     <label for="date">预约时间：</label>
                 </td>
                 <td>
                  <input type="date" name="date" id="date" />
              </td>
          </tr>
          <tr>
              <td>
                 <label for="group">体检机构：</label>
             </td>
             <td>
              <fieldset data-role="controlgroup">
                  <select name="institution" id="institution" data-native-menu="false">
                     <option selected="selected" value="1">体检机构A</option>
                     <option value="2">体检机构B</option>
                     <option value="3">体检机构C</option>
                     <option value="4">体检机构D</option>
                 </select>
             </fieldset>
             </td>
         </tr>
          <tr>
              <td>
                 <label for="group">套餐选择：</label>
             </td>
             <td>
              <fieldset data-role="controlgroup">
                  <select name="group" id="group" data-native-menu="false">
                     <option selected="selected" value="1">体检套餐A</option>
                     <option value="2">体检套餐B</option>
                     <option value="3">体检套餐C</option>
                     <option value="4">体检套餐D</option>
                 </select>
             </fieldset>
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
