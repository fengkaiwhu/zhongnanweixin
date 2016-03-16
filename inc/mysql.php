<?php
$dbinfo=array(
    "dsn"=>"mysql:host=127.0.0.1;dbname=enNercms",
    "username"=>"nercms",
    "passwd"=>"123456"
);

class mysqlpdo extends PDO{
    function __construct($dbinfo){
        parent::__construct($dbinfo["dsn"],$dbinfo["username"],$dbinfo["passwd"]);
    }
}
?>
