<?php
    require_once("../inc/funcs.inc.php");
    require_once("../inc/mysql.class.php");

    if(!isset($_POST['mkey']) || !isset($_POST['reportid']) || !isset($_POST['tablename']) || !isWeixin()){
        //定义为非法请求
        SendJSON(-1, "非法请求");
    }

    $mkey = $_POST["mkey"];
    $reportid = $_POST["reportid"];
    $tablename = $_POST["tablename"];
    
    //验证该次请求密钥 是否在有效期之内
    $time = time() - LOGINPERTIME * 60;
    try{
        $db = new mysqlpdo($dbinfo);
        $query = "select count(*) from smsMessage where mid='$mkey' and used=1 and time > '$time'";
        if($db->selectNumRows($query) == 0){
            echo "<script language=\"javascript\">document.location=\"/smsVerify.php\"</script>";
            exit;
        }
    }
    catch(PDOException $e){
        SendJSON(-1, $e->getMessage());
    }

    //获取检查结果
    try{
        $query = "select * from $tablename where REPORTID='$reportid'";
        $resultArray = $db->query($query);
        $resultArray = $resultArray->fetchAll();
        if(count($resultArray) == 0){
            SendJSON(-1, "检查结果尚未出来!");
        }
        $resultArray = $resultArray[0];
        $r_value = [];//用来存储处理过的结果
        $r_name = [];//用来存储处理过的中文名称
        $r_compare = [];//用来指示该指标是否正常,True表示正常,False表示不正常
    }
    catch(PDOException $e){
        SendJSON(-1, $e->getMessage());
    }

//    SendJSON(0, $resultArray);

        foreach($resultArray as $key=>$value){
            // FIXME: 这里需要注意数组中中文索引的问题,或者增加一个数组用来存放对应的中文名称,这里采用后一种方法

            //有些检查条目可能没有进行,故没结果
            if($value == ''){
                continue;
            }

            if($key == "SUMMARY"){
                $r_value[$key] = $value;
                $r_name[$key] = "小结";
                continue;
            }
            if($key == "DOCTORNAME"){
                $r_value[$key] = $value;
                $r_name[$key] = "检查者";
                continue;
            }
            if($key == "REPORTID" || $key == "ID"){
                continue;
            }

            //剩下的 $value 有两种状态,一是varchar类型,二是numeric类型
            if(!is_numeric($value)){
                $r_value[$key] = $value;
                $r_compare[$key] = True;
                //获取对应的中文名称
                try{
                    $query = "select CHINESENAME from t_data_dictionary where NAME='$key'";
                    $r_name[$key] = $db->getNameById($query, "CHINESENAME");
                }
                catch(PDOException $e){
                    $r_name[$key] = -1;
                }
                continue;
            }

            //numeric 类型
            try{
                $query = "select * from t_data_dictionary where NAME='$key'";
                $r = $db->query($query);
                $r = $r->fetchAll()[0];

                $r_name[$key] = $r["CHINESENAME"];

                if($value > $r["UPPERLIMIT"]){
                    $r_value[$key] = $value.'&uarr;';
                    $r_compare[$key] = False;
                }else if($value < $r["LOWERLIMIT"]){
                    $r_value[$key] = $value.'&darr;';
                    $r_compare[$key] = False;
                }else{
                    $r_value[$key] = $value;
                    $r_compare[$key] = True;
                }
            }
            catch(PDOException $e){
                //FIXME 异常处理
            }
        }
    SendJSON(0, $r_value, $r_name, $r_compare);
?>
