<?php

?>

<head>
  <title>User login</title>
</head>
<style>
	<?php include 'main.css'; ?>
</style>

<form name='login' action='./temp/verify_pass.php' method="post">
	<div>
		<label>Username:</label>
		<div>
			<input type="text" name="username" placeholder="enter username" />
		</div>
	</div>
	<div>
		<label>Password:</label>
		<div>
			<input type="password" name="password" placeholder="enter password" />
		</div>
	</div>
	<div>
		<input type="submit" name="submit" value="Login">
	</div>
	<div>
		<p>Don't have an account? Register here<br>
		<a href="register.php">Register Account</a></p>
	</div>
</form>
