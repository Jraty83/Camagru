<?php
session_start();
require_once '../config/setup.php';
require_once '../admin/validate_input.php';
require_once '../admin/mail.php';
require_once '../admin/db_variables.php';

if ($valid_input == 1 && $existing) {
	try {
		sendPasswordResetEmail($email,$db_usertoken);
		$msg = "Password reset link sent to ".$email;
		echo "<script type='text/javascript'>alert('$msg');</script>";
	  } catch(PDOException $e) {
		  die("ERROR: Could not send email " . $e->getMessage());
	  }
}
?>

<!doctype html>
<html lang="en">
	<head>
		<title>Forgot password</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../includes/cam.png?">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" href="../includes/main.css">
	</head>
	<body>
		<?php require_once '../includes/navbar.php';?>

		<form name="reset" action="" method="post">
			<!-- <div> -->
				<label>Email:</label>
				<div>
					<input type="email" name="email" placeholder="enter email" maxlength="50" value="<?php echo $_POST['email']?>" />
					<text class="info">*email address to send password reset link</text>
				</div>
			<!-- </div> -->
			<div>
				<input type="submit" name="submit" value="Reset">
			</div>
		</form>
		<div>
			<ul>
				<?php if (count($errors) > 0)
					foreach ($errors as $err_msg)
						echo '<li class="err">' . $err_msg . "</li>"?>
			</ul>
		</div>
		<div>
			<p>Remember your password? Back to login<br>
			<a href="login.php">Login</a></p>
		</div>
		<?php require_once '../includes/footer.php';?>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>
