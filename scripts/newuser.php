<?php
session_start();

//Connect to mySQL
include('dbconnect.php');
include('swears.php');

$domain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domport = $_SERVER['SERVER_PORT'];

//Set Userkey
$userkey = mysqli_query($con,"SELECT COALESCE(max(userKey)+1,1) as max FROM user");

//Get Table Data
$username = mysqli_real_escape_string($con, $_POST["username"]);
$password = mysqli_real_escape_string($con, $_POST["password"]);
$confpassword = mysqli_real_escape_string($con, $_POST["confpassword"]);
$agree = mysqli_real_escape_string($con, $_POST["agreement"]);

//Check username for any swearing
foreach ($swears as $string) {
	if (stripos($username, $string) !== false) {
		if(empty($domport)) {header("Location: http://" . $domain . "/signup.php?error=2319");} else {header("Location: http://" . $domain . ":" . $domport . "/signup.php?error=2319");}
		return;
	}
}

//Check if password matches
if($password != $confpassword) {
	if(empty($domport)) {header("Location: http://" . $domain . "/signup.php?error=1133");} else {header("Location: http://" . $domain . ":" . $domport . "/signup.php?error=1133");}
	return;
}

//Check if username and password match
if($username == $password) {
	if(empty($domport)) {header("Location: http://" . $domain . "/signup.php?error=1976");} else {header("Location: http://" . $domain . ":" . $domport . "/signup.php?error=1976");}
	return;
}

//Check if not checked
if($agree != "Agree") {
	if(empty($domport)) {header("Location: http://" . $domain . "/signup.php?error=1155");} else {header("Location: http://" . $domain . ":" . $domport . "/signup.php?error=1155");}
	return;
}

//Converts to Md5 Encrpytion.
$mdpassword = md5($password);

//Get Max Number
while ($row = mysqli_fetch_array($userkey)) {
$maxkey = $row['max'];
}

//Insert into user database
$sql="INSERT INTO user (userKey, userName, password, tAgree, addDate) VALUES ('$maxkey', '$username', '$mdpassword', 'Y', curdate())";

//Get result of mySQL entry
$result = mysqli_query($con,$sql);
echo "Return " . mysqli_errno($con) . "<br>";
if (mysqli_errno($con) == 1062) {
	if(empty($domport)) {header("Location: http://" . $domain . "/signup.php?error=1062");} else {header("Location: http://" . $domain . ":" . $domport . "/signup.php?error=1062");}
	return;
}
elseif (!$result) {
 die('Error: ' . mysqli_error($con));
}

//Disconnect from mySQL database
include('dbdisconnect.php');

//Set userkey for session
$_SESSION['userkey']=$maxkey;

//Return to list page
if(empty($domport)) {header("Location: http://" . $domain . "/list.php");} else {header("Location: http://" . $domain . ":" . $domport . "/list.php");}
?>