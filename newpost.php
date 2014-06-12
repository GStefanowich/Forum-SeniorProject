<!DOCTYPE html>
<?php
session_start();
$userkey = $_SESSION['userkey'];

include 'scripts/dbconnect.php';
?>

<html>
	<head>
	<title>
	New Post
	</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
	<br><br><br>
	<div id ="navigation">
	<?php include('button.php'); ?>
	</div>
	<br><br>
	<div id="content">
		<center>
		<form name="newPost" action="scripts/newpost.php" method="POST">
		<b><u>Title</u></b><br>
		<textarea name="title" rows="1" maxlength="40" placeholder="[Title] A Nice Title Goes Here" required></textarea><br>
		<b><u>Body</u></b><br>
		<textarea name="body" rows="20" placeholder="Write your post information here..." required></textarea><br>
		<br>
		<input id="cancom" type="checkbox" name="cancom" class="hidden-check" value="True" checked>
		<label for="cancom"><button id="button" type="button"><span>Allow Comments</span></button></label>
		<br><br>
		<input type="submit" value="Submit New Post">
		</form>
	<br>
	<u id="header">Text Tags</u><br>
	[b]<b>Bold Text</b>[/b]<br>
	[i]<i>Italics Text</i>[/i]
	<br><br>
	</div> <br><br><br><br><br><br>
	</body>
</html>