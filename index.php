<!DOCTYPE html>
<?php
session_start();
$domain = $_SERVER['SERVER_NAME'];
$domport = $_SERVER['SERVER_PORT'];
if (isset($_SESSION['userkey'])) {
	$userkey = $_SESSION['userkey'];
	if(empty($domport)) {header("Location: http://" . $domain . "/list.php");} else {header("Location: http://" . $domain . ":" . $domport . "/list.php");}
}
?>
<html>
	<head>
	<title>
	Welcome
	</title>
	<link rel='stylesheet' type='text/css' href='style.css'>
	<link rel='icon' type='/favicon.ico' href='images/favicon.ico'>
	</head>
	<body>
<?php
		echo "<div id='navigation-left'>";
		echo "<img src='/images/r_pi.png' width='60px'> <element id='header'> Powered by Raspbian </element>";
		echo "</div>";
	echo "<br><br>";
	echo "<div id='welcome'>";
	echo "<p>Welcome To The PHP Test Forum.</p>";
	echo "<p>&emsp; This forum was created for the purposes of completing the Senior Graduation Project required for graduating from high school. The posts within the website are not part of the projects representation, and have been strictly added by peers to confirm the functionality of the website.</p>";
	echo "<p>&emsp; The forum is coded in PHP/HTML.</p>";
	echo "<p>&emsp; A majority of the site was created within the 15 required project hours, and touched up on within my own time to make it look visually better. <i>Ten</i> scripts make up the visual representation of the website, <i>thirteen</i> background scripts give the site its functionality, and all information is inserted into <i>three<i/> mySQL tables within a database.</p>";
	echo "<p>&emsp; The first four hours of the Senior project was spent writing the basic HTML display of the website. <i>HTML (Hyper-Text Markup Language)</i> is a visual programming language, and can be created anywhere and each line of code is ran quickly upon opening it. <i>PHP (Hypertext Pre-Processor)</i>, is a server-side programming language that allows the server to process information entered by the user, and provide information requested by the pages visited.</p>";
	echo "<p></p>";
	echo "<p>Thanks for visiting,<br>&emsp; <b id='sign'>-Greg Stefanowich</b></p>";
	echo "<br> <br>";
	echo "<center><a href='list.php'><button id='button' style='font-size:25px'>Continue to Site</button></a></center>";
	echo "<br><br><br>";
	echo "</div> <br><br><br><br><br><br>";
	echo "</body>";
?>
</html>
