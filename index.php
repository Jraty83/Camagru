<?php
//require_once 'user/login.php';
session_start();
$user = $_SESSION['user'];

?>

<title>Index</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="includes/cam.png?">
<link rel="stylesheet" href="includes/main.css">

<?php

if ($user) {
	echo "Logged in as: " . $user;
	echo '<h1 class="access">! ! ! WELCOME TO CAMAGRU ! ! !</h1>';
	echo '<form action="user/logout.php">
	<input type="submit" id="logout" value="Logout" name="logout">
	</form>';
}
else
	echo '<h1 class="denied">! ! ! VERIFIED ACCOUNTS ACCESS ONLY ! ! !</h1>';
?>
<?php require_once 'includes/footer.php';?>
