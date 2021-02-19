<?php
require_once '../config/setup.php';
require_once '../admin/validate_reg.php';
require_once '../admin/mail.php';

if ($valid_input == 4 && !$duplicate) {
	try {
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		$token = bin2hex(random_bytes(50));
		$stmt = $conn->prepare("INSERT INTO users (username,email,`password`,token)
		  VALUES('$user', '$email', '$password_hash', '$token')");
		$stmt->execute();
		sendVerificationEmail($user,$email,$password,$token);
		$msg = "User ".$user." has been created, please verify your account by clicking the activation link that has been sent to your email.";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	  } catch(PDOException $e) {
		  die("ERROR: Could not add user " . $e->getMessage());
	  }
}
?>

<title>Register new user</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="../includes/cam.png?">
<link rel="stylesheet" href="../includes/main.css">

<form name="registration" action="" method="post">
	<!-- <div> -->
		<label>Username:</label>
		<div>
			<input type="text" name="username" placeholder="enter username" maxlength="25" value="<?php echo $_POST['username']?>" />
			<text class="info">*max 25 characters, whitespaces will be omitted</text>
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
			<input type="password" name="password" placeholder="enter password" maxlength="50" />
			<text class="info">*8-50 characters. one uppercase, lowercase & digit or special character</text>
		</div>
	<!-- </div> -->
	<!-- <div> -->
		<label>Confirm password:</label>
		<div>
			<input type="password" name="password2" placeholder="re-enter password" />
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
<?php require_once '../includes/footer.php';?>
