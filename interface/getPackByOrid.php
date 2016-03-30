<?php
    require_once("../inc/funcs.inc.php");
    require_once("../inc/mysql.class.php");

    if(!isset($_POST['orid']) || !isWeixin()){
        //定义为非法请求
        SendJSON(-1, "非法请求");
    }

    $id = trim($_POST["orid"]);

    $time = time() - PERTIME*60;
    try{
        $db = new mysqlpdo($dbinfo);
        $query = "select PACKAGEID, PACKAGENAME from t_check_package where ORGANIZATIONID='$id'";
        $rows = $db->query($query);
        $rows = $rows->fetchAll();
    }
    catch(PDOException $e){
        SendJSON(-1, "数据库出错!!");
    }
    
    if(count($rows) == 0){
        SendJSON(-1, "暂无套餐信息!请选择其他医院!");
    }

    SendJSON(0, $rows);
?>
