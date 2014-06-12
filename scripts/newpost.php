<?php
session_start();
$userkey = $_SESSION['userkey'];

print "POST: " . print_r($_POST, true) . "<br>"
	. "GET: " . print_r($_GET, true) . "<br>";

//	echo "Userkey: " . $userkey . "<br>";

include('dbconnect.php');
include('swears.php');
$domain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domport = $_SERVER['SERVER_PORT'];

//	echo "Before <br>";

$textkey = mysqli_query($con,"SELECT COALESCE(max(topickey)+1,1) AS max FROM topic;");


//print "POST: " . print_r($textkey, true) . "<br>";

while ($row = mysqli_fetch_array($textkey)) {
//echo "Row: " . $row['max'];
$maxkey = $row['max'];
}

$title = mysqli_real_escape_string($con, $_POST["title"]);
$body = mysqli_real_escape_string($con, $_POST["body"]);
$cancom = mysqli_real_escape_string($con, $_POST["cancom"]);

if ($cancom == "True") {
	$cancom = "Y";
} else {
	$cancom = "N";
}

	echo "Fetched <br>";

$textkey = mysqli_query($con,"SELECT COALESCE(max(comkey)+1,1) AS max FROM comment;");


print "POST: " . print_r($textkey, true) . "<br>";

while ($row = mysqli_fetch_array($textkey)) {
//echo "Row: " . $row['max'];
$comkey = $row['max'];
}

$modtitle = str_ireplace($swears, '****', $title);
$modbody = str_ireplace($swears, '****', $body);

$sql="INSERT INTO topic (topickey, title, id, date, tombstone, cancom) VALUES ('$maxkey', '$modtitle', '$userkey', curdate(), curdate(), '$cancom')";
$sqltwo="INSERT INTO comment (comkey, tkey, text, date, tombstone, userKey) VALUES ($comkey, '$maxkey', '$modbody', curdate(), curdate(), '$userkey')";

if (!mysqli_query($con,$sql)) {
 die('Error: ' . mysqli_error($con));
}

if (!mysqli_query($con,$sqltwo)) {
 die('Error: ' . mysqli_error($con));
}

include('dbdisconnect.php');

$_SESSION['tkey']=$tkey;

if(empty($domport)) {header("Location: http://" . $domain . "/post.php?topickey=" . $maxkey );} else {header("Location: http://" . $domain . ":" . $domport . "/post.php?topickey=" .  $maxkey);}

//header("Location: http://10.0.0.1/list.php");
?>