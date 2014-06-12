<?php
session_start();
$userkey = $_SESSION['userkey'];
$domain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domport = $_SERVER['SERVER_PORT'];

include('dbconnect.php');
include('swears.php');

$curpass = mysqli_real_escape_string($con, $_POST["curpass"]);
$verpassone = mysqli_real_escape_string($con, $_POST["curpass1"]);
$verpasstwo = mysqli_real_escape_string($con, $_POST["curpass2"]);
$eUserKey = mysqli_real_escape_string($con, $_GET["eUserKey"]);
	
$userresult = mysqli_query($con,"SELECT * FROM user t1 WHERE userKey=$eUserKey");
$userrow = mysqli_fetch_array($userresult);

if (md5($curpass)!==$userrow['password']) {
	if(empty($domport)) {header("Location: http://" . $domain . "/edituser.php?eUserKey=" . $eUserKey . "&error=2140");} else {header("Location: http://" . $domain . ":" . $domport . "/edituser.php?eUserKey=" . $eUserKey . "&error=2140");}
	return;
}

if ($verpassone!==$verpasstwo) {
	if(empty($domport)) {header("Location: http://" . $domain . "/edituser.php?eUserKey=" . $eUserKey . "&error=2140");} else {header("Location: http://" . $domain . ":" . $domport . "/edituser.php?eUserKey=" . $eUserKey . "&error=2140");}
	return;
}

$modpass = md5($verpassone);

if ($userrow['userKey']===$eUserKey || $userkey==1) {
	$sql="UPDATE user SET password='$modpass' WHERE userkey=$eUserKey";
} else {
	if(empty($domport)) {header("Location: http://" . $domain . "/edituser.php?eUserKey=" . $eUserKey . "&error=2140");} else {header("Location: http://" . $domain . ":" . $domport . "/edituser.php?eUserKey=" . $eUserKey . "&error=2140");}
	return;
}

$result = mysqli_query($con,$sql);
echo "Return " . mysqli_errno($con) . "<br>";
if (mysqli_errno($con) == 1062) {
	if(empty($domport)) {header("Location: http://" . $domain . "/edituser.php?eUserKey=" . $eUserKey . "&error=1062");} else {header("Location: http://" . $domain . ":" . $domport . "/edituser.php?eUserKey=" . $eUserKey . "&error=1062");}
	return;
}
elseif (!$result) {
	die('Error: ' . mysqli_error($con));
}

include('dbdisconnect.php');

if(empty($domport)) {header("Location: http://" . $domain . "/edituser.php?eUserKey=" . $eUserKey);} else {header("Location: http://" . $domain . ":" . $domport . "/edituser.php?eUserKey=" . $eUserKey);}

//header("Location: http://10.0.0.1/post.php?topickey=" . $tkey);
?>