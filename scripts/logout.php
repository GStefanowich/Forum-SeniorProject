<?php
session_start();
if(isset($_SESSION['userkey'])){
	unset($_SESSION['userkey']);
}

session_destroy();

$domain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domport = $_SERVER['SERVER_PORT'];
if(empty($domport)) {
header("Location: http://" . $domain . "/list.php");
} else {
header("Location: http://" . $domain . ":" . $domport . "/list.php");
}

//header("Location: http://10.0.0.1/index.php");
?>