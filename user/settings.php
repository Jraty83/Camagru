<?php
session_start();
require_once '../config/setup.php';
require_once '../admin/validate_input.php';
require_once '../admin/mail.php';
require_once '../admin/db_variables.php';

$changed = false;

if ($valid_input == 4) {
	if ($_POST['username'] !== $db_username) {
		try {
			$stmt = $conn->prepare("UPDATE users SET username='$_POST[username]' WHERE token='$db_usertoken'");
			$stmt->execute();
			$_SESSION['user'] = $_POST['username'];
			$changed = true;
			// sendPasswordChangedEmail($_POST['username'],$_POST['email'],$_POST['password']);
			// $msg = "Your password has been changed. New password has been sent to your email.";
			// echo "<script type='text/javascript'>alert('$msg');</script>";
		} catch(PDOException $e) {
			die("ERROR: Could not change username " . $e->getMessage());
		}
	}
	if ($_POST['email'] !== $db_usermail) {
		try {
			$stmt = $conn->prepare("UPDATE users SET email='$_POST[email]' WHERE token='$db_usertoken'");
			$stmt->execute();
			$changed = true;
			// sendPasswordChangedEmail($_POST['username'],$_POST['email'],$_POST['password']);
			// $msg = "Your password has been changed. New password has been sent to your email.";
			// echo "<script type='text/javascript'>alert('$msg');</script>";
		} catch(PDOException $e) {
			die("ERROR: Could not change email " . $e->getMessage());
		}
	}
	// try {
	// 	$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
	// 	$stmt = $conn->prepare("UPDATE users SET `password`='$password_hash' WHERE token='$db_usertoken'");
	// 	$stmt->execute();
	// 	sendPasswordChangedEmail($db_username,$db_usermail,$_POST['password']);
	// 	$msg = "Your password has been changed. New password has been sent to your email.";
	// 	echo "<script type='text/javascript'>alert('$msg');</script>";
	//   } catch(PDOException $e) {
	// 	  die("ERROR: Could not change password " . $e->getMessage());
	//   }
}

if ($changed)
	echo "jotain on muutettu!! laita new login info maili peraan";

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

		<?php
		echo "SESSION USER IS: ".$_SESSION['user']."<br>";
		echo "DB_token is: ".$db_usertoken."<br><br>";

		echo "DB_username is: ".$db_username."<br>";
		echo "POST_username is: ".$_POST['username']."<br>";
		echo "DB_email is: ".$db_usermail."<br>";
		echo "POST_email is: ".$_POST['email']."<br>";
		echo "DB_password is: ".$db_userpass."<br>";
		echo "POST_password is: ".$_POST['password']."<br><br>";

		echo "len DB_password is: ".strlen($db_userpass)."<br>";		
		echo "ERROR count is: ".count($errors)."<br>";
		echo "VALID INPUT count is: ".$valid_input."<br>";
		if ($existing)
			echo "username/email EXISTS!!!!";
		else
			echo "username and email OK";

		?>

		<form name="registration" action="" method="post">
			<label>Username:</label>
				<div>
					<input type="text" name="username" placeholder="enter username" maxlength="25" value="<?php if ($_POST['username']) echo $_POST['username']; else echo $db_username;?>" />
					<text class="info">*max 25 characters, whitespaces will be omitted</text>
				</div>
			<!-- </div> -->
			<!-- <div> -->
				<label>Email:</label>
				<div>
					<input type="email" name="email" placeholder="enter email" maxlength="50" value="<?php if ($_POST['email']) echo $_POST['email']; else echo $db_usermail;?>" />
				</div>
			
			<!-- <div> -->
				<label>New password:</label>
				<div>
					<input type="password" name="password" onfocus="this.value=''" placeholder="enter new password" maxlength="60" value="<?php echo $db_userpass;?>" />
					<text class="info">*min 8 characters incl. one uppercase, lowercase & digit or special character</text>
				</div>
			<!-- </div> -->
			<!-- <div> -->
				<label>Confirm password:</label>
				<div>
					<input type="password" name="password2" onfocus="this.value=''" placeholder="re-enter password" maxlength="60" value="<?php echo $db_userpass;?>" />
				</div>
			<!-- </div> -->
			<div>
				<input type="submit" name="submit" value="Save">
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
