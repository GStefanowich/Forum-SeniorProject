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
	Sign Up
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
		<form name="Form" action="scripts/newuser.php" method="POST">
		<fieldset>
		<legend><h1><u>Sign up Form</u></h1></legend>
		<br>
		<b><u>Login Info</u></b><br>
		<sup>*</sup>Username: <input type="text" name="username" maxlength="20" placeholder="Username" required><br>
		<sup>*</sup>Password: <input type="password" name="password" maxlength="20" placeholder="Password" required><br>
		<sup>*</sup>Password <abbr title="Authenticate">Auth</abbr>: <input type="password" name="confpassword" maxlength="20" placeholder="Password" autocomplete="off" required><br>
		<sup><sup>(*Max Length 20)</sup></sup>
		<br>
		<input type="checkbox" value="Agree" name="agreement" required>I agree to the <a href="terms.php" id="norm">Terms Of Use</a>.<br>
		<?php
		if (isset($error)) {
			if ($error == 1062) {
				echo"<div class='error'>";
				echo "This username is already being used.";
				echo "</div>";
			} elseif ($error == 1133) {
				echo"<div class='error'>";
				echo "Your passwords did not match.";
				echo "</div>";
			} elseif ($error == 2319) {
				echo"<div class='error'>";
				echo "The username contains innapropriate characters.";
				echo "</div>";
			} elseif ($error == 1976) {
				echo"<div class='error'>";
				echo "Your username and password cannot match.";
				echo "</div>";
			} elseif ($error == 1155) {
			echo"<div class='error'>";
			echo "Please accept the terms of use.";
			echo "</div>";
			}
		}
		?>
		<div class="warning">Warning: Please use a new password for this website. Do not reuse old passwords to private accounts.</div>
		<input type="submit" value="Sign Up">
		</fieldset>
		</form>
		<br><br><br>
	</div> <br><br><br><br><br><br>
	</body>
</html>