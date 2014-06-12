<!DOCTYPE html>
<?php
include 'scripts/dbconnect.php';
if (isset($_GET['error'])) {
	$error = mysqli_real_escape_string($con, $_GET["error"]);
}
?>

<html>
	<head>
	<title>
	Log In
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
		<form name="login" action="scripts/getloggedin.php" method="POST">
		<fieldset>
		<legend><h1><u>Log In</u></h1></legend>
		<br>
		<b><u>Information</u></b><br>
		Username: <input type="text" name="username" placeholder="Username" required><br>
		Password: <input type="password" name="password" placeholder="Password" required><br>
		<br>
		<input type="submit" value="Log in">
		</form>
		<?php
		if (isset($error)) {
			if ($error == 1024) {
			echo"<div class='error'>";
			echo "Invalid Username or Password.";
			echo "</div>";
			}
		}
		?>
		</fieldset>
		<br><br><br>
	</div> <br><br><br><br><br><br>
	</body>
</html>