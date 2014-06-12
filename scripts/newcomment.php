<?php
session_start();
$userkey = $_SESSION['userkey'];

include('dbconnect.php');
include('swears.php');
$domain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domport = $_SERVER['SERVER_PORT'];

$textkey = mysqli_query($con,"SELECT COALESCE(max(comkey)+1,1) AS max FROM comment;");


print "POST: " . print_r($textkey, true) . "<br>";

while ($row = mysqli_fetch_array($textkey)) {
$maxkey = $row['max'];
}

$body = mysqli_real_escape_string($con, $_POST["body"]);
$tkey = mysqli_real_escape_string($con, $_POST["tkey"]);

$modbody = str_ireplace($swears, '****', $body);

$sql="INSERT INTO comment (comkey, tKey, text, date, tombstone, userKey) VALUES ('$maxkey', '$tkey', '$modbody', curdate(), curdate(), '$userkey')";

if (!mysqli_query($con,$sql)) {
 die('Error: ' . mysqli_error($con));
}

include('dbdisconnect.php');

$_SESSION['tkey']=$tkey;

if(empty($domport)) {header("Location: http://" . $domain . "/post.php?topickey=$tkey");} else {header("Location: http://" . $domain . ":" . $domport . "/post.php?topickey=$tkey");}
?>