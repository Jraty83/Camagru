<?php
session_start();
require_once '../config/setup.php';
require_once '../admin/validate_input.php';
require_once '../admin/mail.php';

if ($valid_input == 4 && !$existing_user && !$existing_mail) {
	try {
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		$token = bin2hex(random_bytes(50));
		$stmt = $conn->prepare("INSERT INTO users (username,email,`password`,token)
		  VALUES('$user', '$email', '$password_hash', '$token')");
		$stmt->execute();
		sendVerificationEmail($user,$email,$password,$token);
		// $msg = "User ".$user." has been created, please verify your account by clicking the activation link that has been sent to your email.";
		// echo "<script type='text/javascript'>alert('$msg');</script>";
		echo "<p class='msg'>User ".$user." has been created, please verify your account by clicking the activation link that has been sent to your email.</p>";
	} catch(PDOException $e) {
		  die("ERROR: Could not add user " . $e->getMessage());
	  }
}
?>

<!doctype html>
<html lang="en">
	<head>
		<title>Register new user</title>
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
				<!-- <div> -->
					<label>Username:</label>
					<div>
						<input type="text" name="username" placeholder="enter username" maxlength="15" value="<?php echo $_POST['username']?>" />
						<text class="info">*max 15 characters - no specials (whitespaces will be omitted)</text>
					</div>
				<!-- </div> -->
				<!-- <div> -->
					<label>Email:</label>
					<div>
						<input type="email" name="email" placeholder="enter email" maxlength="50" value="<?php echo $_POST['email']?>" />
					</div>
				<!-- </div> -->
				<!-- <div> -->
					<label>Password:</label>
					<div>
						<input type="password" name="password" autocomplete="on" placeholder="enter password" maxlength="60" />
						<text class="info">*min 8 characters incl. one uppercase, lowercase & digit or special character</text>
					</div>
				<!-- </div> -->
				<!-- <div> -->
					<label>Confirm password:</label>
					<div>
						<input type="password" name="password2" autocomplete="on" placeholder="re-enter password" />
					</div>
				<!-- </div> -->
				<div>
					<input type="submit" name="submit" value="Register">
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
				<p>Already have an account? Back to login<br>
				<a href="login.php">Login</a></p>
			</div>
		</div>

		<?php require_once '../includes/footer.php';?>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>
