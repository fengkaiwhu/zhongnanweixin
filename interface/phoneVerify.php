<?php
    require_once("../inc/funcs.inc.php");
    require_once("../inc/mysql.class.php");
    require_once("../inc/sendSMS.php");

    if(!isset($_POST['telephone']) || !isset($_POST['ckey']) || !isWeixin()){
        //定义为非法请求
        SendJSON(-1, "非法请求");
    }

    $telephone = trim($_POST["telephone"]);
    $ckey = $_POST["ckey"];

    if(!preg_match("/^1\d{10}$/", $telephone)){
        SendJSON(-1, "非法电话号码!");
    }
    if($ckey != CKEY){
        SendJSON(-1, "非法访问!");
    }

    //验证该号码是否在系统中是否存在,不存在则
    //SendJSON(2, "该号码未曾有过预约")
    //TODO
    try{
        $db = new mysqlpdo($dbinfo);
        $query = "select count(*) from t_check_report where CELLPHONE='$telephone'";
        if($db->selectNumRows($query) == 0){
            //预约表中不存在该电话
            SendJSON(2, "该号码未有过体检预约!");
        }
        
    }
    catch(PDOException $e){
        SendJSON(-1, $e->getMessage());
    }


    //发送短信,并将相关信息存数据库以作之后的验证
    $data = rand(100000, 999999);
    $time = time();
    $id = "d8495618e5174c2eac1be30843036d25";
/*    $result = sendTemplateSMS($telephone, array($data, PERTIME));

    if($result == NULL){
        SendJSON(-1, "result error!");
    }*/
/*
    if($result->statusCode!=0){
        SendJSON(-1, $result->statusMsg[0]);
    }else{
        $smsmessage = $result->TemplateSMS;
 */  
        //存数据库的相关操作
        try{
            $db = new mysqlpdo($dbinfo);
            //$query = "insert into smsMessage(telephone, mid, time, verifynum) values('$telephone', '$smsmessage->smsMessageSid', '$time', '$data')";
            $query = "insert into smsMessage(telephone, mid, time, verifynum) values('$telephone', '$id', '$time', '$data')";
            $db->exec($query);
        }
        catch(PDOException $e){
            //SendJSON(-1, "数据库操作失败,请稍后再试!");
            SendJSON(-1, $e->getMessage());
        }

        //SendJSON(0, $smsmessage->smsMessageSid);
        SendJSON(0, $id, $data);
   // }
?>
