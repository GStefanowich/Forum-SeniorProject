<?php
session_start();
$userkey = $_SESSION['userkey'];
$domain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domport = $_SERVER['SERVER_PORT'];

include('dbconnect.php');
include('swears.php');
	
$userresult = mysqli_query($con,"SELECT * FROM user t1 WHERE userKey=$userkey");
$userrow = mysqli_fetch_array($userresult);

$user = mysqli_real_escape_string($con, $_POST["user"]);
$eUserKey = mysqli_real_escape_string($con, $_GET["eUserKey"]);

	echo $eUserKey;

foreach ($swears as $string) {
	if (stripos($user, $string) !== false) {
		if(empty($domport)) {header("Location: http://" . $domain . "/edituser.php?eUserKey=" . $eUserKey . "&error=1319");} else {header("Location: http://" . $domain . ":" . $domport . "/edituser.php?eUserKey=" . $eUserKey . "&error=1319");}
		return;
	}
}

	echo "Text2<br>";

if ($userrow['userKey']===$eUserKey || $userkey==1) {
	$sql="UPDATE user SET userName='$user' WHERE userkey=$eUserKey";
} else {
	if(empty($domport)) {header("Location: http://" . $domain . "/edituser.php?eUserKey=" . $eUserKey . "&error=1140");} else {header("Location: http://" . $domain . ":" . $domport . "/edituser.php?eUserKey=" . $eUserKey . "&error=1140");}
	return;
}

	echo "Text3<br>";

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

if(empty($domport)) {header("Location: http://" . $domain . "/edituser.php?eUserKey=" . $eUserKey . "&error=1902");} else {header("Location: http://" . $domain . ":" . $domport . "/edituser.php?eUserKey=" . $eUserKey . "&error=1902");}

//header("Location: http://10.0.0.1/post.php?topickey=" . $tkey);
?>