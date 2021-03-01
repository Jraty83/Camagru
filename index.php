<?php
//require_once 'user/login.php';
session_start();
$user = $_SESSION['user'];

?>

<!doctype html>
<html lang="en">
	<head>
		<title>Home</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="includes/cam.png?">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" href="includes/main.css">
	</head>
	<body>
		<?php require_once 'includes/navbar.php';?>
		
		<?php

		if ($user) {
			echo "Logged in as: " . $user;
			echo '<h1 class="access">! ! ! WELCOME TO CAMAGRU ! ! !</h1>';
			echo '<form action="">
			<input type="submit" id="logout" name="logout" value="Test Button" >
			</form>';
		}
		else
			echo '<h1 class="denied">! ! ! VERIFIED ACCOUNTS ACCESS ONLY ! ! !</h1>';
		?>
		<?php require_once 'includes/footer.php';?>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>
