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
		// $msg = "Your password has been changed. New password has been sent to your email.";
		// echo "<script type='text/javascript'>alert('$msg');
		// window.location.href='http://localhost:8080/camagru/user/login.php';</script>";
		echo "<p class='msg'>Your password has been changed. New password has been sent to your email.</p>";
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

		<div style="margin-left:1vmin">
			<form name="registration" action="" method="post">
				<label>New password:</label>
				<div>
					<input type="password" name="password" autocomplete="on" placeholder="enter new password" maxlength="60" />
					<text class="info">*min 8 characters incl. one uppercase, lowercase & digit or special character</text>
				</div>
				<label>Confirm password:</label>
				<div>
					<input type="password" name="password2" autocomplete="on" placeholder="re-enter password" />
				</div>
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
		</div>

		<?php require_once '../includes/footer.php';?>
	</body>
</html>
