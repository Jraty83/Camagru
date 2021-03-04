<?php
session_start();
require_once '../config/setup.php';
require_once '../admin/validate_input.php';
require_once '../admin/mail.php';
require_once '../admin/db_variables.php';

if ($_POST['namechange'] === "Change") {
	if ($_POST['username'] === $db_username)
		array_push($errors,"it's your username, no changes have been made");
	else if ($valid_input == 1 && !$existing_user) {
		try {
			$stmt = $conn->prepare("UPDATE users SET username='$_POST[username]' WHERE token='$db_usertoken'");
			$stmt->execute();
			$_SESSION['user'] = $_POST['username'];
			$msg = "Username succesfully changed.";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		} catch(PDOException $e) {
			die("ERROR: Could not change username " . $e->getMessage());
		}
	}
	else if ($existing_user)
		array_push($errors,"username already used, choose another one");
}

if ($_POST['mailchange'] === "Change") {
	if ($_POST['email'] === $db_usermail)
		array_push($errors,"it's your email address, no changes have been made");
	else if ($valid_input == 1 && !$existing_mail) {
		try {
			$stmt = $conn->prepare("UPDATE users SET email='$_POST[email]' WHERE token='$db_usertoken'");
			$stmt->execute();
			$msg = "Email address succesfully changed.";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		} catch(PDOException $e) {
			die("ERROR: Could not change email " . $e->getMessage());
		}
	}
	else if ($existing_mail)
		array_push($errors,"email already used, choose another one");
}

if ($_POST['submit'] === "Change") {
	if (password_verify($_POST['password'], $db_userpass) || $_POST['password'] === $db_userpass)
		array_unshift($errors,"it's your current password, no changes have been made");
	else if ($valid_input == 2 && $_POST['password'] !== $db_userpass) {
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
}

?>

<!doctype html>
<html lang="en">
	<head>
		<title>Account Settings</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../includes/cam.png?">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" href="../includes/main.css">
	</head>
	<body>
		<?php require_once '../includes/navbar.php';?>

		<form name="namechange" action="" method="post">
			<label>Username:</label>
				<div>
					<input type="text" name="username" placeholder="enter username" maxlength="25" value="<?php if ($_POST['username']) echo $_POST['username']; else echo $db_username;?>" />
					<text class="info">*max 25 characters, whitespaces will be omitted</text>
				</div>
			<input type="submit" name="namechange" value="Change">
		</form>
		<form name="mailchange" action="" method="post">
			<label>Email:</label>
				<div>
					<input type="email" name="email" placeholder="enter email" maxlength="50" value="<?php if ($_POST['email']) echo $_POST['email']; else echo $db_usermail;?>" />
				</div>
			<input type="submit" name="mailchange" value="Change">
		</form>			
		<form name="pwchange" action="" method="post">
			<label>New password:</label>
				<div>
					<input type="password" name="password" onfocus="this.value=''" placeholder="enter new password" maxlength="60" value="<?php if ($_POST['password']) echo $_POST['password']; else echo $db_userpass;?>" />
					<text class="info">*min 8 characters incl. one uppercase, lowercase & digit or special character</text>
				</div>
			<label>Confirm password:</label>
				<div>
					<input type="password" name="password2" onfocus="this.value=''" placeholder="re-enter password" maxlength="60" value="<?php if ($_POST['password']) echo $_POST['password']; else echo $db_userpass;?>" />
				</div>
			<input type="submit" name="submit" value="Change">
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
