<?php
	$URL = $_SERVER['REQUEST_URI'];
	echo "<link rel='icon' type='/favicon.ico' href='images/favicon.ico'>";

	echo "<div id='navigation-one'>";
	if (strpos($URL,  'list.php') == false) {
		echo "<a id='header' href='list.php'>Homepage</a>";
	} else {
		echo "<element id='header' style='font-weight:bold; color:#4C8BFF;'>Homepage</element>";
	}
	if (strpos($URL,  'users.php') == false) {
		echo "<a id='header' href='users.php'>User List</a>";
	} else {
		echo "<element id='header' style='font-weight:bold; color:#4C8BFF;'>User List</element>";
	}
	echo "</div>";
		
	echo "<div id='navigation-two'>";
	if (isset($userkey)) {
		$menuresult = mysqli_query($con,"SELECT * FROM user WHERE userKey=$userkey");
		while ($menurow = mysqli_fetch_array($menuresult)) {
			echo "<element id='header'>[" . $menurow['userName'] . "]</element>";
		}
		echo "<a id='header' href='scripts/logout.php'>Logout</a>";
	} else {
		if (strpos($URL,  'signup.php') == false) {
			echo "<a id='header' href='signup.php'>Signup</a>";
		} else {
			echo "<element id='header' style='font-weight:bold; color:#4C8BFF;'>Signup</element>";
		}
		if (strpos($URL,  'login.php') == false) {
			echo "<a id='header' href='login.php'>Login</a>";
		} else {
			echo "<element id='header' style='font-weight:bold; color:#4C8BFF;'>Login</element>";
		}
	}
	echo "</div>";
?>