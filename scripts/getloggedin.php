<?php
session_start();

//echo "load \n";
include('dbconnect.php');
$domain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domport = $_SERVER['SERVER_PORT'];

$username = mysqli_real_escape_string($con, $_POST["username"]);
$password = mysqli_real_escape_string($con, $_POST["password"]);
//echo "Fetched \n";

$mdpassword = md5($password);

$result = mysqli_query($con,"SELECT * FROM user WHERE username='$username'");

if(mysqli_num_rows($result)>0) {
	while($row = mysqli_fetch_array($result)) {
		if ($row['password'] != $mdpassword) {
			if(empty($domport)) {header("Location: http://" . $domain . "/login.php?error=1024");} else {header("Location: http://" . $domain . ":" . $domport . "/login.php?error=1024");}
			return;
		} else {
			$userkey = $row['userKey'];
			}
	}
} else {
	if(empty($domport)) {header("Location: http://" . $domain . "/login.php?error=1024");} else {header("Location: http://" . $domain . ":" . $domport . "/login.php?error=1024");}
	return;
}

include('dbdisconnect.php');

$_SESSION['userkey']=$userkey;

if(empty($domport)) {header("Location: http://" . $domain . "/list.php");} else {header("Location: http://" . $domain . ":" . $domport . "/list.php");}
?>