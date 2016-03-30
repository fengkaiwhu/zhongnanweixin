<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/css/jquery.mobile-1.3.2.min.css">
    <script src="/js/jquery-1.8.3.min.js"></script>
    <script src="/js/jquery.mobile-1.3.2.min.js"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
    <title>我的预约</title>
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
	
	require "../inc/mysql.class.php";
	try {
		$db = new mysqlpdo($dbinfo);
		$sql = "select * from t_appointment_list where OPENID =".$openid."order by OPERATIONTIME desc limit 1";
		$r = $db->query($sql);
		$r = $r->fetchAll();
	} catch (Exception e) {
		
	}
	$name = $r[0]["NAME"];
	$s = $r[0]["SEX"];
	$age = $r[0]["AGE"];
	$telephone = $r[0]["CELLPHONE"];
    $date = $r[0]["DATE"];
    $date = date("Y-m-d", $date);
	$institution = $r[0]["ORGANIZATIONID"];
    $group = $r[0]["PACKAGEID"];
	if ($s == 1)
		$sex = "男";
	else
		$sex = "女";
    try{
        $sql = "select ORGANIZATIONNAME from t_check_organization where ORGANIZATIONID='$institution'";
        $r = $db->query($sql);
        $r = $r->fetchAll();
        $institution = $r[0]["ORGANIZATIONNAME"];
    }
    catch(PDOException $e){
        
		$institution = "未知体检机构";
    }
    try{
        $sql = "select PACKAGENAME from t_check_package where PACKAGEID='$group'";
        $r = $db->query($sql);
        $r = $r->fetchAll();
        $group = $r[0]["PACKAGENAME"];
    }
    catch(PDOException $e){
        
		$group = "未知体检套餐";
    }
	//$name = "张三";
	//$s = "1";
	//$age = "33";
	//$telephone = "13333333333";
	//$date = "2016-03-29";
	//$i = "1";
	//$g = "2";
	
	?>
   <div data-role="page">
    <div data-role="content">
      <h3 style="text-align:center;">我的预约</h3>
		<div data-role="fieldcontain" style="align:center">
			<table width="100%">   
				<tr>
					<td>
					  <label for="name">姓名：</label>
					</td>
					<td>
						<input name="userId" id="userId" value="<?=$name?>" readonly="readonly"/>
					</td>
				</tr>
				<tr>
					<td>
					  <label for="name">性别：</label>
					</td>
					<td>
						<input name="userId" id="userId" value="<?=$sex?>" readonly="readonly"/>
					</td>
				</tr>
				<tr>
					<td>
					  <label for="name">年龄：</label>
					</td>
					<td>
						<input name="userId" id="userId" value="<?=$age?>" readonly="readonly"/>
					</td>
				</tr>
				<tr>
					<td>
					  <label for="name">电话：</label>
					</td>
					<td>
						<input name="userId" id="userId" value="<?=$telephone?>" readonly="readonly"/>
					</td>
				</tr>
				<tr>
					<td>
					  <label for="name">预约时间：</label>
					</td>
					<td>
						<input name="userId" id="userId" value="<?=$date?>" readonly="readonly"/>
					</td>
				</tr>
				<tr>
					<td>
					  <label for="name">体检机构：</label>
					</td>
					<td>
						<input name="userId" id="userId" value="<?=$institution?>" readonly="readonly"/>
					</td>
				</tr>
				<tr>
					<td>
					  <label for="name">预约套餐：</label>
					</td>
					<td>
						<input name="userId" id="userId" value="<?=$group?>" readonly="readonly"/>
					</td>
				</tr>
			</table>
		</div>
		<p style="text-align:justify; font-size:16px; font-weight:bold">
		<p style="text-align:justify; font-size:16px; font-weight:bold">
			注意事项：</p>
		<p style="text-align:justify; font-size:14px; text-indent:2em">
			如需修改预约信息，请致电：02787778777。</p>
		<p style="text-align:justify; font-size:16px; font-weight:bold">
			体检预导航：</p>
		<img src="/img/buju.jpg" width="100%" />
		<p style="text-align:justify; font-size:16px font; font-weight:900">
			图示：</p>
		<p style="text-align:justify; font-size:14px">
			6、&nbsp;饮食营养中心<br />7、&nbsp;器械消毒中心<br />8、&nbsp;后勤服务供应中心<br />9、&nbsp;宁养院<br />10、留学生进修宿舍<br />11、综合药库<br />12、动物实验<br />13、科研培训楼</p>
		</div>
	</div>
</body>
</html>
