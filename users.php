<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['userkey'])) {
	$userkey = $_SESSION['userkey'];
}
include 'scripts/dbconnect.php';
?>
<html>
	<head>
	<title>Users</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<br><br><br>
		<div id ="navigation">
			<?php include('button.php'); ?>
		</div>
		<br><br>
		<div id="content">

		<?php
		echo "<table>";
		echo "<tr>";
		echo "<th id='Table-short'></th>";
		echo "<th id='Table-long'>Username</th>";
		echo "<th id='Table-short'>Join Date</th>";
		if (isset($userkey)) {
			echo "<th id='Table-short'>Modify</th>";
		}
		echo "</tr>";
if (isset($userkey)) {
$result = mysqli_query($con,"SELECT * FROM user WHERE active='N' AND userKey=$userkey");
	while($row = mysqli_fetch_array($result)) {
		echo "<tr>";
		echo "<td id='Table-short'></td>";
		echo "<td id='Table-long'><i>" . $row['userName'] . " <b>[Deactivated]</b></i> <br> <sup><i>(Other users cannot see your deactivated account on this list.)</i></sup> </td>";
		echo "<td id='Table-short'>" . $row['addDate'] . "</td>";
		echo "<td id=Table-short><a href='edituser.php?eUserKey=" . $row['userKey'] . "' id='tabletext'>&lt; Change &gt;</a></td>";
		echo "</tr>";
	}
}

$result = mysqli_query($con,"SELECT * FROM user WHERE active='Y'");
	while($row = mysqli_fetch_array($result)) {
//		print "POST: " . print_r($row, true) . "<br>";
		echo "<tr>";

		if (file_exists('images/users/' . $row['userKey'] . '.png')) {
			echo "<td id='Table-short'><img src='images/users/" . $row['userKey'] . ".png' width='32px' border='1px'></td>";
		} elseif (file_exists('images/users/' . $row['userKey'] . '.jpg')) {
			echo "<td id='Table-short'><img src='images/users/" . $row['userKey'] . ".jpg' width='32px' border='1px'></td>";
		} elseif (file_exists('images/users/' . $row['userKey'] . '.gif')) {
			echo "<td id='Table-short'><img src='images/users/" . $row['userKey'] . ".gif' width='32px' border='1px'></td>";
		} else {
			echo "<td id='Table-short'><img src='images/users/nouser.jpg' width='32px' border='1px'></td>";
		}

		if (isset($userkey)) {
			if ($row['userKey']===$userkey) {
				echo "<td id=Table-long><b>" . $row['userName'] . "</b></td>";
			} else {
				echo "<td id=Table-long>" . $row['userName'] . "</td>";
			}
		} else {
			echo "<td id=Table-long>" . $row['userName'] . "</td>";
		}
		echo "<td id=Table-short>" . $row['addDate'] . "</td>";
		if (isset($userkey)) {
			if ($row['userKey']===$userkey || $userkey == 1) {
				echo "<td id=Table-short><a href='edituser.php?eUserKey=" . $row['userKey'] . "' id='tabletext'>&lt; Change &gt;</a></td>";
			} else {
				echo "<td id=Table-short></td>";
			}
		}
		echo "</tr>";
	}
	echo"</table> <br> <br>";
	echo"<br><br>";
?>
		<br>
	</div> <br>
	</body>
</html>