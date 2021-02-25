<?php
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

<title>Forgot password</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="../includes/cam.png?">
<link rel="stylesheet" href="../includes/main.css">

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
