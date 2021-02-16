<?php
require_once 'config/setup.php';
include 'temp/validate_reg.php';

if ($valid_input == 4 && !$duplicate) {
	//TODO - NOW INSERT INTO DATABE and goto LOGIN.PHP
	echo "JEEEEEE";

}

?>

<title>Register new user</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="style/cam.png?">
<link rel="stylesheet" href="style/main.css">

<form name="registration" action="" method="post">
	<!-- <div> -->
		<label>Username:</label>
		<div>
			<input type="text" name="username" placeholder="enter username" value="<?php echo $_POST['username']?>" />
		</div>
	<!-- </div> -->
	<!-- <div> -->
		<label>Email:</label>
		<div>
			<input type="email" name="email" placeholder="enter email" value="<?php echo $_POST['email']?>" />
		</div>
	<!-- </div> -->
	<!-- <div> -->
		<label>Password:</label>
		<div>
			<input type="password" name="password" placeholder="enter password" />
			<text class="info">*min. 8 characters. at least one uppercase, lowercase & digit or special character</text>
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
<?php require_once 'footer.php';?>
