<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/css/jquery.mobile-1.3.2.min.css">
    <script src="/js/jquery-1.8.3.min.js"></script>
    <script src="/js/jquery.mobile-1.3.2.min.js"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
    <title>体检导航</title>
	<style>
	th {
		border-bottom: 1px solid #d6d6d6;
	}

	tr:nth-child(even) {
		background: #e9e9e9;
	}
	</style>
</head>

<body>
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
		
		//查询数据库操作
		$con = mysql_connect(DB_HOST. ":". DB_PORT, DB_USER, DB_PASS);
		$link = mysql_select_db(DB_NAME, $con);
		mysql_set_charset("utf8");
		$sql = "select * from t_appointment_list where OPENID = '". $openid. "'";

		$r = mysql_query($sql);
		while ($row = mysql_fetch_array ($r, MYSQL_NUM)) {
			//$g = $row[8];
		}

		$g = 3;
	
		if ($g == 1)
			$group = "套餐A";
		else if ($g == 2)
			$group = "套餐B";
		else if ($g == 3)
			$group = "套餐C";
		else if ($g == 4)
			$group = "套餐D";
		else 
			$group = "未知体检套餐";
	?>
	<div data-role="page">
		<div data-role="content">
			<?php
			echo "<h3 style='text-align:center'>体检导航(". $group. ")</h3>";
			//通过openid在数据库中查询该用户的套餐及排队序号
			//模拟数据（科室、科目、排队号、注意事项）
			$r1_1 = array("科目A", "22", "科目B", "9", "科目C", "6", "科目D", "19");
			$r1_2 = array("科目A", "13", "科目B", "11", "科目C", "14", "科目D", "22");
			$r1_3 = array("科目A", "12", "科目B", "22", "科目C", "32", "科目D", "9");
			$r1_4 = array("科目A", "17", "科目B", "2", "科目C", "6", "科目D", "27");
			$r2 = array("注意事项：空腹", "注意事项：10点之前", "注意事项：静坐", "注意事项：憋尿");
			
			$r1 = array("科室A"=>array("科目A科目A科目A科目A科目A科目A"=>22, "科目B"=>9, "科目C"=>6, "科目D"=>19), 
						"科室B"=>array("科目AA"=>13, "科目BB"=>11, "科目CC"=>14, "科目DD"=>22), 
						"科室C"=>array("科目AAA"=>12, "科目BBB"=>2, "科目CCC"=>32, "科目DDD"=>9));
									
			foreach ($r1 as $name=>$detail) {
				echo "<h2>". $name ."</h2>";
				//echo "<div data-role='main' class='ui-content'>";
				echo "<table width='90%' align='center'>";
				echo "<thead>";
				echo "<tr>";
				echo "<th width='*'>科目</th>";
				echo "<th width='60px' align='center'>排队号</th>";
				echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
				
				foreach ($detail as $key=>$num) {
					echo "<tr>";
					echo "<td>". $key. "</td>";
					echo "<td align='center'>". $num. "</td>";
					echo "</tr>";
				}
				echo "</tbody>";
				echo "</table>";
				echo "<p style='text-align:justify; font-size:16px; font-weight:bold'>注意事项：</p>";
				echo "<p style='text-align:justify; font-size:14px; text-indent:2em'>空腹,注意事项注意事项注意事项注意事项注意事项注意事项。</p>";
			}
			?>
		</div>
	</div>
</body>
</html>
