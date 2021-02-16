<?php

$errors = [];
// array_push($errors,"<li>keke");
// array_push($errors,"<li>orava");
?>

<title>User login</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="style/cam.png?">
<link rel="stylesheet" href="style/main.css">

<form name="login" action="temp/verify_pass.php" method="post">
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
	<ul class="err"><?php foreach ($errors as $err_msg)
	echo $err_msg; ?></ul>
	<div>
		<p>Don't have an account? Register here<br>
		<a href="register.php">Register Account</a></p>
	</div>
</form>
<?php require_once 'footer.php';?>
