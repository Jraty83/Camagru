<?php

?>

<head>
  <title>Register new user</title>
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
		<label>Email:</label>
		<input type="email" name="email" placeholder="enter email" />
	</div>
	<div>
		<input type="submit" name="submit" value="Register">
	</div>
	<br>
	<div>
		<p>Already have an account? Back to login</p><a href="login.php">Login</a>
	</div>
</form>
