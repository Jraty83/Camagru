<?php
require_once '../config/setup.php';
require_once '../admin/verify_pass.php';
session_start();

if ($existing && $verified == 2) {
	$msg = "Welcome ".$user."! You can now start uploading, liking and commenting pictures";
	echo "<script type='text/javascript'>alert('$msg');
	window.location.href='../index.php';</script>";
	$_SESSION['user'] = $user;
}

?>

<title>User login</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="../includes/cam.png?">
<link rel="stylesheet" href="../includes/main.css">

<form name="login" action="" method="post">
	<div>
		<label>Username:</label>
		<div>
			<input type="text" name="username" placeholder="enter username" maxlength="25" value="<?php echo $_POST['username']?>" />
		</div>
	</div>
	<div>
		<label>Password:</label>
		<div>
			<input type="password" name="password" placeholder="enter password" maxlength="50" />
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

<?php require_once '../includes/footer.php';?>
