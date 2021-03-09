<?php
session_start();
$user = $_SESSION['user'];

if ($user) {
	$_SESSION['user'] = "";
	$msg = $user." succesfully logged out. Login again for privileged access";
	echo "<script type='text/javascript'>alert('$msg');
	window.location.href='../index.php';</script>";
}

// UNAUTHORIZED ACCESS
else {
	header('Location: http://localhost:8080/camagru/index.php');
	exit;
}

?>
