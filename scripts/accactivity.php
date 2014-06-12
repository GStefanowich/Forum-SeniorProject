<?php
session_start();
$userkey = $_SESSION['userkey'];
$domain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domport = $_SERVER['SERVER_PORT'];

include('dbconnect.php');

$eUserKey = mysqli_real_escape_string($con, $_GET["eUserKey"]);

$result = mysqli_query($con,"SELECT * FROM user WHERE userKey=$eUserKey");
$row = mysqli_fetch_array($result);

if ($row['userKey']===$eUserKey || $userkey==1) {
	if ($row['active']==="N") {
		$sql="UPDATE user SET active='Y' WHERE userkey=$eUserKey";
	} else {
		$sql="UPDATE user SET active='N' WHERE userkey=$eUserKey";
	}
} else {
	if(empty($domport)) {header("Location: http://" . $domain . "/edituser.php?eUserKey=" . $eUserKey . "&error=2140");} else {header("Location: http://" . $domain . ":" . $domport . "/edituser.php?eUserKey=" . $eUserKey . "&error=2140");}
	return;
}

$result = mysqli_query($con,$sql);
echo "Return " . mysqli_errno($con) . "<br>";
if (mysqli_errno($con) == 1062) {
	if(empty($domport)) {header("Location: http://" . $domain . "/edituser.php?eUserKey=" . $eUserKey . "&error=2062");} else {header("Location: http://" . $domain . ":" . $domport . "/edituser.php?eUserKey=" . $eUserKey . "&error=2062");}
	return;
}
elseif (!$result) {
 die('Error: ' . mysqli_error($con));
}

include('dbdisconnect.php');

if(empty($domport)) {header("Location: http://" . $domain . "/edituser.php?eUserKey=" . $eUserKey);} else {header("Location: http://" . $domain . ":" . $domport . "/edituser.php?eUserKey=" . $eUserKey);}
?>