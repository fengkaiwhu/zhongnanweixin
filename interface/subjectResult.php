<?php
require_once("../inc/funcs.inc.php");

$seconds = 5;
sleep($seconds);
SendJSON(0, "请求成功!");
?>
