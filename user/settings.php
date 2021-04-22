<?php
session_start();
require_once '../config/setup.php';
require_once '../admin/validate_input.php';
require_once '../admin/mail.php';
require_once '../admin/db_variables.php';

if ($_POST['commentmail'] === "Save") {
	if (isset($_POST['mailia'])) {
		$stmt = $conn->prepare("UPDATE users SET emailNotification = 1 WHERE `user_id` = $db_userid");
		$stmt->execute();
		header('Location: '.$_SERVER['PHP_SELF']);
		die;
	} else {
		$stmt = $conn->prepare("UPDATE users SET emailNotification = 0 WHERE `user_id` = $db_userid");
		$stmt->execute();
		header('Location: '.$_SERVER['PHP_SELF']);
		die;
	}
}

if ($_POST['namechange'] === "Change") {
	$newname = preg_replace("/\s+/", "", $_POST['username']);
	if ($newname === $_SESSION['user'])
		array_push($errors,"it's your username, no changes have been made");
	else if ($valid_input == 1 && !$existing_user) {
		try {
			$stmt = $conn->prepare("UPDATE users SET username='$newname' WHERE token='$db_usertoken'");
			$stmt->execute();
			$_SESSION['user'] = $newname;
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
		<?php require_once '../includes/navbar.php';

		// FOR LOGGED IN USER'S ONLY
		if ($_SESSION['user']) { ?>

			<div style="margin-left: 10px">
			<label class="logged">Logged in as: <?php echo $_SESSION['user']?></label>
				<form name="namechange" action="" method="post">
					<label>Username:</label>
						<div>
							<input type="text" name="username" placeholder="enter username" maxlength="15" value="<?php if ($_POST['username']) echo $_POST['username']; else echo $db_username;?>" />
							<text class="info">*max 15 characters, whitespaces will be omitted</text>
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
							<input type="password" name="password" autocomplete="on" onfocus="this.value=''" placeholder="enter new password" maxlength="60" value="<?php if ($_POST['password']) echo $_POST['password']; else echo $db_userpass;?>" />
							<text class="info">*min 8 characters incl. one uppercase, lowercase & digit or special character</text>
						</div>
					<label>Confirm password:</label>
						<div>
							<input type="password" name="password2" autocomplete="on" onfocus="this.value=''" placeholder="re-enter password" maxlength="60" value="<?php if ($_POST['password']) echo $_POST['password']; else echo $db_userpass;?>" />
						</div>
					<input type="submit" name="submit" value="Change">
				</form>
				<form name="commentmail" action="" method="post">
					<div class="form-check form-switch" style="margin-top: 1vw">
						<input class="form-check-input" name="mailia" type="checkbox" id="flexSwitchCheckDefault" <?php if ($db_usernoti) echo "checked"?>>
						<label class="form-check-label" for="flexSwitchCheckDefault">Email me if someone comments my picture</label>
						<input type="submit" name="commentmail" value="Save">
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
		<?php }

		// UNAUTHORIZED ACCESS
		else {
			header('Location: http://localhost:8080/camagru/index.php');
			exit;
		}
		
		require_once '../includes/footer.php';?>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>
