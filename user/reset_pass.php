<?php
require_once '../config/setup.php';
require_once '../admin/modify_pass.php';

echo "email linking account: ".$email."<br>";
echo "oldpass given: ".$oldpass."<br>";
echo "newpass given: ".$newpass."<br>";
echo "newpass2 given: ".$newpass2."<br><br>";
echo "valid_input count: ".$valid_input."<br>";
echo "verified count: ".$verified."<br>";
echo "error count: ".count($errors);

if ($valid_input == 4 && $verified == 1) {
	try {
		// $password_hash = password_hash($password, PASSWORD_DEFAULT);
		// $token = bin2hex(random_bytes(50));
		// $stmt = $conn->prepare("INSERT INTO users (username,email,`password`,token)
		//   VALUES('$user', '$email', '$password_hash', '$token')");
		// $stmt->execute();
		// sendVerificationEmail($user,$email,$password,$token);
		$msg = "User ".$user." has been created, please verify your account by clicking the activation link that has been sent to your email.";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	  } catch(PDOException $e) {
		  die("ERROR: Could not add user " . $e->getMessage());
	  }
}
?>

<title>Reset password</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="../includes/cam.png?">
<link rel="stylesheet" href="../includes/main.css">

<form name="registration" action="" method="post">
	<!-- <div> -->
		<label>Old password:</label>
		<div>
			<input type="password" name="oldpass" placeholder="enter old password" maxlength="50" />
		</div>
	<!-- </div> -->
	<!-- <div> -->
		<label>New password:</label>
		<div>
			<input type="password" name="newpass" placeholder="enter new password" maxlength="50" />
			<text class="info">*8-50 characters. one uppercase, lowercase & digit or special character</text>
		</div>
	<!-- </div> -->
	<!-- <div> -->
		<label>Confirm password:</label>
		<div>
			<input type="password" name="newpass2" placeholder="re-enter password" />
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
<div>
	<p>Already have an account? Back to login<br>
	<a href="login.php">Login</a></p>
</div>
<?php require_once '../includes/footer.php';?>
