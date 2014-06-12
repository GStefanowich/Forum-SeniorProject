<?php
$domain = $_SERVER['SERVER_NAME'];
$domport = $_SERVER['SERVER_PORT'];
if(empty($domport)) {header("Location: http://" . $domain . "/list.php");} else {header("Location: http://" . $domain . ":" . $domport . "/list.php");}
?>