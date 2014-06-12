<?php
session_start();
$userkey = $_SESSION['userkey'];
$domain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domport = $_SERVER['SERVER_PORT'];

include('dbconnect.php');
include('swears.php');

$result = mysqli_query($con,"SELECT * FROM user t1 WHERE userKey=$userkey");
$row = mysqli_fetch_array($result);

if ($row['userKey']==$userkey || $userkey==1) {
$tkey = mysqli_real_escape_string($con, $_GET["tkey"]);
$comkey = mysqli_real_escape_string($con, $_GET["comkey"]);

//	echo "Userkey: " . $userkey . "<br>";

$body = mysqli_real_escape_string($con, $_POST["body"]);
$modbody = str_ireplace($swears, '****', $body);

$sql="UPDATE comment SET text='$modbody', tombstone=curdate() WHERE comkey=$comkey";

if (!mysqli_query($con,$sql)) {
 die('Error: ' . mysqli_error($con));
}
} else {
if(empty($domport)) {header("Location: http://" . $domain . "/list.php");} else {header("Location: http://" . $domain . ":" . $domport . "/list.php");}
return;
}

include('dbdisconnect.php');

if(empty($domport)) {header("Location: http://" . $domain . "/post.php?topickey=" . $tkey);} else {header("Location: http://" . $domain . ":" . $domport . "/post.php?topickey=" . $tkey);}

//header("Location: http://10.0.0.1/post.php?topickey=" . $tkey);
?>