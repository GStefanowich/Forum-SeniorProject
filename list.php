<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['userkey'])) { $userkey = $_SESSION['userkey']; }
include 'scripts/dbconnect.php';

if (isset($userkey)) {
	$userresult = mysqli_query($con,"SELECT * FROM user t1 WHERE userKey=$userkey");
	$userrow = mysqli_fetch_array($userresult);
}

//print "POST: " . str_ireplace("\n",'<br>',print_r($userrow, true)) . "<br>";
?>
<html>
	<head>
	<title>
	Homepage
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

		<table>
		<tr>
		<th id="Table-long" style="text-align:center;">Title</th>
		<th id="Table-short"></th>
		<th id="Table-short"></th>
		</tr>
<?php
$result = mysqli_query($con,"SELECT * FROM topic t1, user t2 WHERE t1.id=t2.userKey AND t2.active='Y' ORDER BY t1.tombstone DESC, t1.sticky='Y' ASC");

	while($row = mysqli_fetch_array($result)) {
		$comresult = mysqli_query($con,"SELECT * FROM comment t1, user t2 WHERE tKey=$row[topickey] AND t1.userKey=t2.userKey ORDER BY comkey DESC LIMIT 1");
		$comrescount = mysqli_query($con, "SELECT COUNT(*) FROM comment WHERE tKey=$row[topickey]");
		$comcount = mysqli_fetch_array($comrescount);
		$comtest = mysqli_fetch_array($comresult);
//		print "<br>POST: " . print_r($comcount, true) . "<br>";

		echo "<tr>";
		echo "<td id=Table-long> <a id='tabletext' href='post.php?topickey=" . $row['topickey'] . "'>" . $row['title'] . "</a><sup><sup><br style='line-height:35px;'>Latest post from " . $comtest['userName'] . " at " . $comtest['tombstone'] . "</sup></sup></td>";
		echo "<td id=Table-short>Posted By " . $row['userName'] . "<br> <sup><sup>at " . $row['tombstone'] . "</sup></sup></td>";
		if ($comcount['COUNT(*)']>1) {
			echo "<td id=Table-short> " . $comcount['COUNT(*)'] . " Posts</td>";
		} else {
			echo "<td id=Table-short> " . $comcount['COUNT(*)'] . " Post</td>";
		}
		echo "</tr>";
	}
?>
		</table> <br> <br>
		<br><br>
<?php
if (isset($userkey)) {
	if ($userrow['active']==="Y" and $userkey>=1) {
		echo "<center><a href='newpost.php' method='GET'><button id='button'>Create New Post</button></a></center>";
	} else {
		echo "<center><a href='edituser.php?eUserKey=" . $userkey . "'><button id='button'>User Not Active</button></a></center>";
	}
} else {
	echo "<center><a href='login.php'><button id='button'>Login to Post</button></a></center>";
}
?>
		<br>
	</div> <br>
	</body>
</html>