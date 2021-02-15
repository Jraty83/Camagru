<?php
include './temp/insert_into.php';

$errors = [];
// array_push($errors,"keke<br>");
// array_push($errors,"orava");
?>

<head>
  <title>Register new user</title>
</head>
<style>
	<?php include 'main.css'; ?>
</style>

<form name='registration' action='./temp/insert_into.php' method='POST'>
	<!-- <div> -->
		<label>Username:</label>
		<div>
			<input type="text" name="username" placeholder="enter username" value="" />
		</div>
	<!-- </div> -->
	<!-- <div> -->
		<label>Email:</label>
		<div>
			<input type="email" name="email" placeholder="enter email" value="" />
		</div>
	<!-- </div> -->
	<!-- <div> -->
		<label>Password:</label>
		<div>
			<input type="password" name="password" placeholder="enter password" value="" />
		</div>
	<!-- </div> -->
	<!-- <div> -->
		<label>Confirm password:</label>
		<div>
			<input type="password" name="password2" placeholder="enter password" value="" />
		</div>
	<!-- </div> -->
	<div>
		<input type="submit" name="submit" value="Register">
	</div>
	<p class="err"><?php foreach ($errors as $err_msg)
	echo $err_msg; ?></p>
	<div>
		<p>Already have an account? Back to login<br>
		<a href="login.php">Login</a></p>
	</div>
</form>
