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
    // 表示科目表名->科目中文的映射
    $name_table = [];
    try{
        $query = "select SUBJECTID from r_package_subject where PACKAGEID='$packageId'";
        $res = $db->query($query);
        $r = $res->fetchAll();

        //由体检科目id得到对应的体检结果数据表名
        foreach($r as $subject){
            //$subject[0]代表对应的subjectid
            $query = "select TABLENAME,SUBJECTNAME from t_check_subject where SUBJECTID='$subject[0]'";
            $res = $db->query($query);
            $r = $res->fetchAll();
            //向数组中添加映射
            $name_table[$r[0]['TABLENAME']] = $r[0]['SUBJECTNAME'];
        }

    }
    catch($PDOException $e){
        //echo "查询数据库出错,请稍后再试!";
        $getData = False;
    }
    //运行至此,如果$getData = False表示查询出错,没有获取到数据
    //否则,根据$name_table 数组去对应的结果表中查询对应的检查数据
    if(!$getData){
        // TODO 出错逻辑
        echo "查询数据库出错,请稍后再试!";
    }else{
        foreach($name_table as $table => $name){
            echo "<div class='panel panel-info'>";
            echo "<div class='panel-heading ajax-data'>";
            //此时通过ajax传输至后台接口的数据应该包括: 访问密钥=>$mkey, 报告id=>$reportid, 对应的检查结果表名=>$table
            echo "<input type='hidden' id='mkey' value='".$mkey."'>";
            echo "<input type='hidden' id='reportid' value='".$mkey."'>";
            echo "<input type='hidden' id='tablename' value='".$table."'>";
            echo "<h5 class='panel-title' style='text-align:center;'>".$name."</h5>";
            echo "</div>";
            echo "<div></div>";
            echo "</div>";
        }
    }
?>
<!--

<div class="panel panel-info">
	<div class="panel-heading ajax-data">
   	<h5 class="panel-title" style="text-align:center;">血常规</h5>
	</div>
	<div>
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
-->
</html>
