<?php
session_start();
if (isset($_SESSION['userkey'])) {
	$userkey = $_SESSION['userkey'];
}

include 'scripts/dbconnect.php';

$domain = $_SERVER['SERVER_NAME'];
$domport = $_SERVER['SERVER_PORT'];

if(!isset($_GET["topickey"])) {
	if(empty($domport)) {header("Location: http://" . $domain . "/list.php");} else {header("Location: http://" . $domain . ":" . $domport . "/list.php");}
	return;
}

$tkey = mysqli_real_escape_string($con, $_GET["topickey"]);

$result = mysqli_query($con,"SELECT * FROM topic WHERE topicKey=$tkey");
$row = mysqli_fetch_array($result);

if (isset($userkey)) {
	$userresult = mysqli_query($con,"SELECT * FROM user t1 WHERE userKey=$userkey");
	$userrow = mysqli_fetch_array($userresult);
}

$taggs = array(">", "<", "!", "@", "$", "%", "^", "*", "(", ")", "{", "}", "-", "+", "=");
$staggs = array("&gt;", "&lt;", "&#33;", "&#64;", "&#36;", "&#37;", "&#94;", "&#42;", "&#40;", "&#41;", "&#123;", "&#125;", "&#45;", "&#43;", "&#61;");

$featt = array("\n", "[B]", "[/b]", "[i]", "[/i]", "[ul]", "[/ul]", "[li]", "[/li]");
$sfeatt = array("<br>", "<b>", "</b>", "<i>", "</i>", "<ul>", "</ul>", "<li>", "</li>");

$end = ".jpg";

//echo "POST: " . print_r($row, true) . "<br>";
?>
<html>
	<head>
	<title>
	<?php
	echo $row['title'];
	?>
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

<?php
		echo"<table>"; //Open Table

		echo "<tr>";
		if (isset($userkey)) {
			echo "<th id='Table-short'></th>";
		}
		echo "<th id='Table-long'>" . $row['title'] . "</th>";
		echo "<th id='Table-short'></th>";
		if (isset($userkey)) {
			echo "<th id='Table-short'></th>";
		}
		echo "</tr>";

$tableresult = mysqli_query($con,"SELECT * FROM comment t1, user t2 WHERE tKey=$tkey AND t1.userKey=t2.userKey");
	while($trow = mysqli_fetch_array($tableresult)) {
		echo "<tr>";
		if (isset($userkey)) {
			if ($trow['userKey']===$userkey || $userkey == 1) {
				echo "<td id=Table-short><input type='checkbox' id=" . $trow['userKey'] . " disabled> </td>";
			} else {
				echo "<td id=Table-short></td>";
			}
		}
		
		if (file_exists('images/users/' . $trow['userKey'] . '.png')) {
			$image = $trow['userKey'] . ".png";
		} elseif (file_exists('images/users/' . $trow['userKey'] . '.jpg')) {
			$image = $trow['userKey'] . ".jpg";
		} elseif (file_exists('images/users/' . $trow['userKey'] . '.gif')) {
			$image = $trow['userKey'] . ".gif";
		} else {
			$image = "nouser.jpg";
		}
		
		echo "<td id=Table2-long>" . str_ireplace($featt,$sfeatt, str_ireplace($taggs, $staggs, $trow['text'])) . "</td>";
		echo "<td id=Table-short> <img src='images/users/" . $image . "' border='1px' width='125px'><br><br>" . $trow['userName'] . "<br><br><b>Posted At:</b><br>" . $trow['tombstone'] . "</td>";
//		echo "<td id=Table-short>" . $trow['tombstone'] . "</td>";
		
		if (isset($userkey)) {
			if ($trow['userKey']===$userkey || $userkey == 1) {
				if ($row['cancom'] === "Y" || $userkey == 1) {
					echo "<td id=Table-short> <a id='tabletext' href='editpost.php?comkey=" . $trow['comkey'] . "&tkey=" . $trow['tKey'] . "'>[ Edit ]</a>";
					echo "<br>";
					echo "<a id='tabletext' href=''>[ Delete ]</a></td>";
				} else {
					echo "<td id=Table-short></td>";
				}
			} else {
				echo "<td id=Table-short></td>";
			}
		}
		echo "</tr>";
	}
		echo"</table> <br> <br>";
	if (isset($userkey)) {
		if ($row['cancom']==="Y" and $userrow['active']==="Y") {
				echo "<center><form name='newComment' action='scripts/newcomment.php' method='POST'>";
				echo "<textarea name='body' rows='10' cols='90' placeholder='Respond to this post here.. Remember, Be Nice!' required></textarea><br>";
				echo "<input name='tkey' value='$tkey' readonly required hidden>";
				echo "<input type='submit' value='Submit Comment'>";
				echo "</form></center>";
			} else {
				if ($row['cancom']==="N") {
					echo "<center><button id='button' disabled>Commenting Disabled</button></center>";
				} else {
					echo "<center><button id='button' disabled>This Post Could<br>Not Be Found</button></center>";
				}
			}
	} else {
				echo "<center><a href='login.php'><button id='button'>Login to Comment</button></a></center>";
		}
?>
		<br><br><br>
	</div> <br>
	</body>
</html>