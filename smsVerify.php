<!DOCTYPE html>
<html>
<head>
<title>中南医院体检报告短信验证</title>
<meta name="viewport" id="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<link href="./bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
<script src="./js/jquery.min.js"></script>
<script src="./bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="./js/smsVerify.js"></script>
</head>

<?php
require_once('./inc/funcs.inc.php');
if(!isWeixin()){
	echo "必须通过微信客户端访问!";
	exit;	
}
?>


<body>
	<div class="panel panel-info">
		<div class="panel-heading">
			<h5 class="panel-title" style="text-align:center;">短信验证</h5>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<div class="col-sm-3 col-xs-3">
						<label for="firstname" class="control-label">手机号</label>
					</div>
					<div class="col-sm-9 col-xs-9">
						<input type="text" class="form-control" id="telephone" placeholder="请输入11位手机号">
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-3 col-xs-3">
						<label for="lastname" class="control-label">验证码</label>
					</div>
					<div class="col-sm-4 col-xs-4">
						<input type="text" class="form-control" id="verifynum" placeholder="6位验证码">
					</div>
					<div class="col-sm-5 col-xs-5">
						<button type="button" class="btn btn-default" id="getnum">获取验证码</button>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-1">
						<button type="button" class="btn btn-default" id="verify">确定</button>
					</div>
					<div id="information" class="col-sm-3" style="text-align:center;color:red;">
					
					</div>
				</div>
			</form>
		
		</div>
	</div>
	
	<input type="hidden" id="_constant_key" value="<?php echo CKEY; ?>">
	<input type="hidden" id="_sms_key" value="">	
	
</body>
</html>
