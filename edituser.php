<!DOCTYPE html>
<?php
session_start();
$userkey = $_SESSION['userkey'];

$domain = $_SERVER['SERVER_NAME'];
$domport = $_SERVER['SERVER_PORT'];

include 'scripts/dbconnect.php';

$eUserKey = mysqli_real_escape_string($con, $_GET["eUserKey"]);
if (isset($_GET['error'])) {
	$error = mysqli_real_escape_string($con, $_GET["error"]);
}

$result = mysqli_query($con,"SELECT * FROM user WHERE userKey=$eUserKey");
$row = mysqli_fetch_array($result);

if (file_exists('images/users/' . $eUserKey . '.png')) {
	$image = $eUserKey . ".png";
} elseif (file_exists('images/users/' . $eUserKey . '.jpg')) {
	$image = $eUserKey . ".jpg";
} elseif (file_exists('images/users/' . $eUserKey . '.gif')) {
	$image = $eUserKey . ".gif";
} else {
	$image = "nouser.jpg";
}
?>

<html>
	<head>
	<title>
<?php
	echo "Edit " . $row['userName'];
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
	if ($row['userKey']===$userkey || $userkey==1) {
		echo "<form name='newPost' action='scripts/editname.php?eUserKey=" . $eUserKey . "' method='POST'>";
		echo "<fieldset>";
		echo "<legend><h1><u>Modifying User " . $row['userName'] . "</u></h1></legend>";
		if ($row['active']==="N") {
			echo "<button id='button' disabled><b><i>This account is not active.<i></b></button>";
		}
		echo "<br>";
			echo "<h1><u>Information</u></h1>";
			echo "New Username:<input type='text' name='user' maxlength='20' value='" . $row['userName'] . "' placeholder='" . $row['userName'] . "' required></input><br>";
		if (isset($error)) {
			if ($error == 1062) {
				echo"<div class='error'>";
				echo "That username is taken.";
				echo "</div>";
			} elseif ($error == 1140) {
				echo"<div class='error'>";
				echo "Your do not have permission to do this.";
				echo "</div>";
			} elseif ($error == 1319) {
				echo"<div class='error'>";
				echo "The username contains innapropriate characters.";
				echo "</div>";
			} elseif ($error == 1902) {
				echo "<div class='success'>";
				echo "Your username has been changed.";
				echo "</div>";
			}
		}
		echo "<br>";
			echo "<input type='submit' value='Change Name'>";
			echo "</form>";
		echo "<br>";

		echo "<h1><u>Change Password</u></h1>";
		echo "<form name='modpassword' action='scripts/editpassword.php?eUserKey=" . $eUserKey . "' method='POST'>";
			echo "Current Password: <input type='password' name='curpass' maxlength='20' placeholder='********' maxlength='20'></input><br>";
			echo "New Password: <input type='password' name='curpass1' maxlength='20' placeholder='New-Password' maxlength='20'></input><br>";
			echo "Confirm Password: <input type='password' name='curpass2' maxlength='20' placeholder='New-Password' maxlength='20'></input><br>";
			echo "<br><br>";
			echo "<input type='submit' value='Change Password'>";
		echo "</form>";

		echo "<br><br><br>";
	echo "<fieldset style='border-color:#FF0000; color:#FF0000;'><legend style='color:#FF0000;'><h1><u>Work In Progress</u></h1></legend>";
		echo "<br>";
		echo "<h1><u>Change Picture</u></h1>";
		echo "<form name='modpicture' action='scripts/editpass.php' method='POST'>";
			echo "<img src='images/users/" . $image . "' width='200px' border='1px'><br>";
			echo "<input type='file' disabled><br><br>";
			echo "<input type='submit' value='Change Picture' disabled>";
		echo "</form>";
	echo "</fieldset>";


		echo "<br>";

		echo "<h1><u>Account Activity</u></h1>";
		echo "<form name='modactivation' action='scripts/accactivity.php?eUserKey=" . $eUserKey . "' method='POST'>";
		echo "<div class='notif'>Deactivating your account will: <br>";
			echo "<li>Hide all posts you have created.</li>";
			echo "<li>Hide your account from the users list.</li>";
			echo "<li>Add a <i>Deactivated</i> tag to all of your comments.</li>";
			echo "<li><i style='color:#FF0000'>Will NOT delete your account, posts, or comments.</i></li>";
		echo "</div>";
			if ($row['active']==="Y") {
				echo "<input type='submit' value='De-Activate Account'>";
			} else {
				echo "<input type='submit' value='Re-Activate Account'>";
			}
		echo "</form>";
		echo "</fieldset>";
	} else {
		if(empty($domport)) {header("Location: http://" . $domain . "/users.php");} else {header("Location: http://" . $domain . ":" . $domport . "/users.php");}
	}
		?>
	<br><br><br>
	</div> <br><br><br><br><br><br>
	</body>
</html>