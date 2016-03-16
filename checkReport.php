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
