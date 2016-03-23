<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="/css/jquery.mobile-1.3.2.min.css">
	<script src="js/jquery-1.8.3.min.js"></script>
	<script src="js/jquery.mobile-1.3.2.min.js"></script>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
	<title>修改个人信息</title>
</head>
<body>
	<?php	
	$userName = $_POST["userName"];
	$telephone = $_POST["telephone"];
	$sex = $_POST["sex"];
	$city = $_POST["city"];
	$provience = $_POST["provience"];
	
	// SAE数据库连接
	// $hostname = SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT;
	// $dbuser = SAE_MYSQL_USER;
	// $dbpass = SAE_MYSQL_PASS;
	// $dbname = SAE_MYSQL_DB;
	
	// $con = mysql_connect($hostname, SAE_MYSQL_USER, SAE_MYSQL_PASS);
	// $link = mysql_select_db(SAE_MYSQL_DB, $con);
	// mysql_query("set name utf8");
	// $sql = "insert into booking (userId, name, idNum, sex, age, telephone, date, institution, group) values ('".$userId."', '".$name."', '".$idNum."', '".$sex."', '".$age."', '".$telephone."', '".$date."', '".$institution."', '".$group."' )";
	// mysql_query($sql);
	
	?>

	<div data-role="page">
		<div data-role="content">
			<h3 style="text-align:center;">修改成功</h3>
			</div>
		</div>
	</div>
</body>
</html>