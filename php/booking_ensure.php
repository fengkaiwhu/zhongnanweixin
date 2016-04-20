<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="/css/jquery.mobile-1.3.2.min.css">
	<script src="js/jquery-1.8.3.min.js"></script>
	<script src="js/jquery.mobile-1.3.2.min.js"></script>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
	<title>预约确认</title>
</head>
<body>
	<?php
	require "../inc/mysql.class.php";
	$userId = $_POST["userId"];
	$name = $_POST["name"];
	$idNum = $_POST["idNum"];
	$sex = $_POST["sex"];
	$age = $_POST["age"];
	$telephone = $_POST["telephone"];
    $date1 = $_POST["date"];
    $date = strtotime($date1);
	$institution = $_POST["institution"];
	$group = $_POST["group"];
	$status = "1";

			
	
	$con = mysql_connect(DB_HOST. ":". DB_PORT, DB_USER, DB_PASS);
	$link = mysql_select_db(DB_NAME, $con);
	mysql_set_charset("utf8");
    $time = time();
    $sql = "insert into t_appointment_list (OPENID, NAME, IDCARD, SEX, AGE, CELLPHONE, DATE, ORGANIZATIONID, PACKAGEID, OPERATIONTIME, STATUS) values ('".$userId."', '".$name."', '".$idNum."', '".$sex."', '".$age."', '".$telephone."', '".$date."', '".$institution."', '".$group."', '".$time."','".$status."' )";
	mysql_query($sql);
	
	?>

	<div data-role="page">
		<div data-role="content">
			<h3 style="text-align:center;">预约确认</h3>
			<div data-role="fieldcontain" style="align:center">
				<p style="text-align:justify; font-size:14px; text-indent:2em"><?=$name?>，您好！您已预约成功我院体检中心体检套餐，体检时间：<?=$date1?>，请您合理安排时间，提前做好体检前的准备。</p>
				<p style="text-align:justify; font-size:14px; text-indent:2em">通过微信公众号底部菜单“预约服务-套餐介绍”，可以查看体检套餐详细信息，了解挂号流程；通过“预约服务-我的预约”，可以查看预约信息。祝您身体健康，工作顺利！</p>
			</div>
		</div>
	</div>
</body>
</html>
