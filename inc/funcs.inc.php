<?php
//每一页显示的文章数
define("PAGESIZE",20);

//短信验证码有效期, min
define("PERTIME", 10);

//短信验证登录的有效期,代表一次验证多长时间内登录有效, min
define("LOGINPERTIME", 30);

//固定的接口访问密钥
define("CKEY", "df45asdf45asdf21asdf=");

//服务器地址
define("SERVERADDR","172.16.22.108");

//返回状态信息
define("SUCCESS",0);
define("DBFAIL",1);
define("NOCONTENT",2);
define("IMAGE_ERROR",3);
define("FILE_ERROR",4);

function SendJSON($status,$message='',$message2=''){
    $result = array("status"=>$status,"content"=>$message, "content2"=>$message2);
    echo json_encode($result);
//    echo  preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", json_encode($result));
    exit();
}

//判断是否为微信访问
//$flag: 
function isWeixin($flag=False){
    if(!$flag)
        return true;

    $ua = $_SERVER['HTTP_USER_AGENT'];
    $weixinUA = "MicroMessenger";

    if(!strpos($ua, $weixinUA)){
        return false;
//        echo "您必须通过微信访问!";
//        exit;
    }
    return true;
}

?>
