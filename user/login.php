<?php
session_start();
require_once '../config/setup.php';
require_once '../admin/verify_pass.php';

if ($existing_user && $verified == 2) {
	$msg = "Welcome ".$user."! You can now start uploading, liking and commenting pictures";
	echo "<script type='text/javascript'>alert('$msg');
	window.location.href='../index.php';</script>";
	$_SESSION['user'] = $user;
}

?>

<!doctype html>
<html lang="en">
	<head>
		<title>User login</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../includes/cam.png?">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" href="../includes/main.css">
	</head>
	<body>
		<?php require_once '../includes/navbar.php';?>

		<div style="margin-left:10px">
			<form name="login" action="" method="post">
				<div>
					<label>Username:</label>
					<div>
						<input type="text" name="username" placeholder="enter username" maxlength="15" value="<?php echo $_POST['username']?>" />
					</div>
				</div>
				<div>
					<label>Password:</label>
					<div>
						<input type="password" name="password" autocomplete="on" placeholder="enter password" maxlength="60" />
					</div>
				</div>
				<div>
					<input type="submit" name="submit" value="Login">
					<a class="info" href="forgot_pass.php">forgot password?</a></p>
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
				<p>Don't have an account? Register here<br>
				<a href="register.php">Sign up</a></p>
			</div>
		</div>

		<?php require_once '../includes/footer.php';?>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>
