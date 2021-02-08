<?php
include '/config/setup.php';

?>

<head>
  <title>User login</title>
</head>
<style>
	<?php include 'main.css'; ?>
</style>

<form method="post">
	<div>
		<label>Username:</label>
		<input type="text" name="username" placeholder="enter username" />
	</div>
	<div>
		<label>Password:</label>
		<input type="password" name="password" placeholder="enter password" />
	</div>
	<div>
		<input type="submit" name="submit" value="Login">
	</div>
	<br>
	<div>
		<p>Don't have an account? Register here</p><a href="register.php">Register Account</a>
	</div>
</form>
