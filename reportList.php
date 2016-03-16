<!DOCTYPE html>
<html>
<head>
<title>中南医院体检报告</title>
<meta name="viewport" id="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<link href="./bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
<script src="./js/jquery.min.js"></script>
<script src="./bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="./js/reportList.js"></script>
<script src="./js/iscroll.js"></script>
</head>
<body>
<?php
    require_once('./inc/funcs.inc.php');
    if(!isWeixin()){
	    echo "必须通过微信客户端访问!";
    	exit;	
    }

    if(!isset($_GET['mkey']) || !isset($_GET['ckey'])){
        //定义为非法请求
        echo "非法请求!";
        exit;
    }
    $ckey = $_GET["ckey"];
    if($ckey != CKEY){
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

        //得到已经验证过的手机号
        $telephone = $r[0]["telephone"];
    }
    catch(PDOException $e){
        echo "数据库出错,请稍后再试!";
        exit;
    }

    // TODO:从数据库中得到电话对应的报告列表
    $getData = false;
    try{
        $db = new mysqlpdo($dbinfo);
        $query = "select * from t_check_report where CELLPHONE='$telephone' order by CHECKDATE";
        $res = $db->query($query);
        //得到电话对应的体检数组 $checks , 
        $checks = $res->fetchAll();
        $getData = True;
    }
    catch(PDOException $e){
        $getData = false;
    } 
?>


<div class="panel panel-info">
	<div class="panel-heading">
    <h5 class="panel-title" style="text-align:center;">病例列表(<?php echo $telephone; ?>)</h5>
	</div>
		<div class="table-responsive">
                        <table class="table table-condensed table-bordered" style="text-align:center;">
	 		
                                <thead>
	 				<colgroup>
	 					<col width="25%"><col>
	 					<col width="25%"><col>
	 					<col width="30%"><col>
	 					<col width="20%"><col>
	 				</colgroup>
	     			<tr>
	         		<th>机构</th>
	         		<th>姓名</th>
	         		<th>时间</th>
	         		<th>查看</th>
	    			</tr>
	 			</thead>
	 
	 			<div id="wrapper"><div id="scroller">
                <tbody id="reportList">
                    <?php
                        if(!$getData){
                            echo "访问数据库出错!请稍后再试!";
                        }else{
                            foreach($checks as $check){

                                $id = $check["ORGANIZATIONID"];
                                $sql = "select * from t_check_organization where ORGANIZATIONID='$id'";
                                $organizationname = $db->getNameById($sql, "ORGANIZATIONNAME");

                                echo "<tr>";
                                echo "<td>".$organizationname."</td>";    
                                echo "<td>".$check["NAME"]."</td>";    
                                echo "<td>".$check["CHECKDATE"]."</td>";    
                                echo "<td><a href=\"/checkReport.php?reportId=".$check["REPORTID"]."&packageId=".$check["PACKAGEID"]."&mkey=".$mkey."\">查看</td>";    
                                echo "<tr>";
                            }
                        }
                    ?>
	     			<tr>
	         		    <td>中南医院</td>
               			<td>张三</td>
               			<td>2015-09-09</td>
               			<td><a href="checkReport.php">查看</a></td>
	     			</tr>
                                <?php for($i=1;$i<20;$i++){?>
	     			<tr>
	         		<td>口腔医院</td>
	         		<td>张三</td>
	         		<td>2016-03-01</td>
	         		<td><a href="checkReport.php">查看</a></td>
	     			</tr>
                                <?php } ?>
	 			</tbody>
				</div></div>
	 			
	 		</table>
	
		</div>
</div>

</body>

</html>
