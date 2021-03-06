<?php
session_start();
require_once '../config/setup.php';
require_once '../admin/validate_input.php';
require_once '../admin/mail.php';
require_once '../admin/db_variables.php';

if ($valid_input == 2) {
	try {
		$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$stmt = $conn->prepare("UPDATE users SET `password`='$password_hash' WHERE token='$db_usertoken'");
		$stmt->execute();
		sendPasswordChangedEmail($db_username,$db_usermail,$_POST['password']);
		$msg = "Your password has been changed. New password has been sent to your email.";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	  } catch(PDOException $e) {
		  die("ERROR: Could not change password " . $e->getMessage());
	  }
}
?>

<!doctype html>
<html lang="en">
	<head>
		<title>Reset password</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../includes/cam.png?">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" href="../includes/main.css">
	</head>
	<body>
		<?php require_once '../includes/navbar.php';?>

		<form name="registration" action="" method="post">
			<!-- <div> -->
				<label>New password:</label>
				<div>
					<input type="password" name="password" placeholder="enter new password" maxlength="60" />
					<text class="info">*min 8 characters incl. one uppercase, lowercase & digit or special character</text>
				</div>
			<!-- </div> -->
			<!-- <div> -->
				<label>Confirm password:</label>
				<div>
					<input type="password" name="password2" placeholder="re-enter password" />
				</div>
			<!-- </div> -->
			<div>
				<input type="submit" name="submit" value="Change">
			</div>
		</form>
		<div>
			<ul>
				<?php if (count($errors) > 0)
					foreach ($errors as $err_msg)
						echo '<li class="err">' . $err_msg . "</li>"?>
			</ul>
		</div>
		<!-- <div>
			<p>Already have an account? Back to login<br>
			<a href="login.php">Login</a></p>
		</div> -->
		<?php require_once '../includes/footer.php';?>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>
