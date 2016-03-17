<!DOCTYPE html>
<html>
<head>
<title>中南医院体检报告</title>
<meta name="viewport" id="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<link href="./bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
<script src="./js/jquery.min.js"></script>
<script src="./bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="./js/subjectResult.js"></script>
</head>

<?php
    require_once('./inc/funcs.inc.php');
    if(!isWeixin()){
	    echo "必须通过微信客户端访问!";
    	exit;	
    }

    if(!isset($_GET['mkey']) || !isset($_GET['reportId']) || !isset($_GET['packageId'])){
        //定义为非法请求
        echo "非法请求!";
        exit;
    }
    $mkey = $_GET["mkey"];
    require_once(dirname(__FILE__)."/inc/mysql.class.php");
    try{
        $db = new mysqlpdo($dbinfo);
        //对应的message必须已经通过验证
        $query = "select telephone,time from smsMessage where mid='$mkey' and used=1";
        $res = $db->query($query);
        $r = $res->fetchAll();
        if(count($r) == 0){
            //没有匹配到对应的手机号
            echo "非法请求";
            exit;
        }

        //单次验证有效期已过
        if(time() - $r[0]["time"] > LOGINPERTIME * 60){
            //echo "验证已过期!";
            echo "<script language=\"javascript\">document.location=\"/smsVerify.php\"</script>";
            exit;
        }
    }
    catch(PDOException $e){
        echo "数据库出错,请稍后再试!";
        exit;
    }

    //得到对应的报告id和套餐id
    $reportid = $_GET['reportId'];
    $packageId = $_GET['packageId'];
    
    $getDate = True;
    //由套餐id得到对应的检查科目id列表
    // TODO
    try{
        
    }
    catch($PDOException $e){
        //echo "查询数据库出错,请稍后再试!";
        $getData = False;
    }
?>


<div class="panel panel-info">
	<div class="panel-heading ajax-data">
   	<h5 class="panel-title" style="text-align:center;">血常规</h5>
	</div>
	<div>
	<!--
		<div class="table-responsive">
	 		<table class="table table-condensed table-bordered">
	 		
	 			<thead>
	 				<colgroup>
	 					<col width="50%"><col>
	 					<col><col>
	 				</colgroup>
	     			<tr>
	         		<th>项目名称</th>
	         		<th>检查结果</th>
	    			</tr>
	 			</thead>
	 
	 			<tbody>
	     			<tr>
	         		<td>白细胞</td>
	        			<td>8.17</td>
	     			</tr>
	     			<tr class="danger">
	         		<td>红细胞</td>
	         		<td>5.4 &uarr;</td>
	     			</tr>
	     			<tr>
	         		<td>血小板</td>
	         		<td>316</td>
	     			</tr>
	     			<tr class="danger">
	         		<td>血红蛋白</td>
	         		<td>164.8 &darr;</td>
	     			</tr>
	 			</tbody>
	 			
	 		</table>
	
		</div>
		-->
	</div>
</div>

<div class="panel panel-info">
	<div class="panel-heading ajax-data">
   	<h5 class="panel-title" style="text-align:center;">尿常规</h5>
	</div>
	<div></div>
</div>

<div class="panel panel-info">
	<div class="panel-heading ajax-data">
   	<h5 class="panel-title" style="text-align:center;">生化</h5>
	</div>
	<div></div>
</div>

<div class="panel panel-info">
	<div class="panel-heading ajax-data">
   	<h5 class="panel-title" style="text-align:center;">乙肝</h5>
	</div>
	<div></div>
</div>

<div class="panel panel-info">
	<div class="panel-heading ajax-data">
   	<h5 class="panel-title" style="text-align:center;">心电图</h5>
	</div>
	<div></div>
</div>

<div class="panel panel-info">
	<div class="panel-heading ajax-data">
   	<h5 class="panel-title" style="text-align:center;">幽门螺旋杆菌</h5>
	</div>
	<div></div>
</div>

<div class="panel panel-info">
	<div class="panel-heading ajax-data">
   	<h5 class="panel-title" style="text-align:center;">一般性检查</h5>
	</div>
	<div></div>
</div>

</html>
