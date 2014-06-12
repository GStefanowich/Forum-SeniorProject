<!DOCTYPE html>
<?php
session_start();
$userkey = $_SESSION['userkey'];

include 'scripts/dbconnect.php';

$comkey = mysqli_real_escape_string($con, $_GET["comkey"]);
$tkey = mysqli_real_escape_string($con, $_GET["tkey"]);

$result = mysqli_query($con,"SELECT * FROM comment t1 WHERE comkey=$comkey");
$row = mysqli_fetch_array($result);
?>

<html>
	<head>
	<title>
	Edit Post
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
<?php
		echo "<form name='newPost' action='scripts/editpost.php?comkey=" . $row['comkey'] . "&tkey=" . $row['tKey'] . "' method='POST'>";

		echo "<b><u>Body</u></b><br>";
		echo "<textarea name='body' rows='20' cols='100' placeholder='Write your post information here.' required>" . $row['text'] . "</textarea><br>";
		echo "<br><br>";
		echo "<input type='submit' value='Modify Existing Post'>";
		echo "</form>";
		?>
	<br>
	<u id="header">Text Tags</u><br>
	[b]<b>Bold Text</b>[/b]<br>
	[i]<i>Italics Text</i>[/i]
	<br><br>
	</div> <br><br><br><br><br><br>
	</body>
</html>