<?php
require_once(dirname(__FILE__)."/../inc/mysql.class.php");
$rows = 1000000;
try{
    while($rows){
        $db = new mysqlpdo($dbinfo);
        $telephone = rand(10000000000, 99999999999);
        $time = rand(1000000000, 9999999999);
        $num = rand(100000, 999999);
        $mid = rand(100000000, 999999999);
        $sql = "insert into smsMessage(telephone, mid, time, verifynum) values('$telephone', '$mid', '$time', '$num')";
        $db->exec($sql);
        $rows = $rows - 1;
    }
}
catch(PDOException $e){
    echo "error";
}
?>
