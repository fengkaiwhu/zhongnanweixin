<?php
    require_once("../inc/funcs.inc.php");
    require_once("../inc/mysql.class.php");

    if(!isset($_POST['mkey']) || !isset($_POST['ckey']) || !isset($_POST['data']) || !isWeixin()){
        //定义为非法请求
        SendJSON(-1, "非法请求");
    }

    $data = trim($_POST["data"]);
    $ckey = $_POST["ckey"];
    $mkey = $_POST["mkey"];

    if(!preg_match("/^\d{6}$/", $data)){
        SendJSON(-1, "非法验证码!");
    }
    if($ckey != CKEY){
        SendJSON(-1, "非法访问!");
    }
    
    $time = time() - PERTIME*60;
    try{
        $db = new mysqlpdo($dbinfo);
        $query = "select count(*) from smsMessage where mid='$mkey' and verifynum='$data' and time>'$time' and used=0";
        $rows = $db->selectNumRows($query);
    }
    catch(PDOException $e){
        SendJSON(-1, "数据库出错!!");
    }
    
    if($rows == 0){
        SendJSON(-1, "验证码错误!!");
    }

    try{
        $query = "update smsMessage set used=1 where mid='$mkey' and verifynum='$data'";
        $db->exec($query);
    }
    catch(PDOException $e){
        SendJSON(-1, "数据库出错!!");
    }

    SendJSON(0, "验证成功!!");
?>
