<?php
include '../config/setup.php';

//TODO - MESSAGE IF AN ACCOUT IS NOT VERIFIED YET... (USE TOKEN INSTED OF USERNAME?)
//! ONLY VERIFIED ACCOUNTS ARE ACCEPTED
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND verified=1");
//$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_POST['username']]);
$user = $stmt->fetch();

if ($user && password_verify($_POST['password'], $user['password']))
{
	//! PHP REDIRECT
	header("Location: http://localhost:8080/camagru/index.php");
	exit();
} else {
	//TODO - NOW REDIRECT INSTANTLY, NEED TO REMOVE HEADER REDIRECT AND USE WINDOW ?
	//! This is in the PHP file and sends a Javascript alert to the client
	// $message = "Enter a valid Username and Password";
	// echo "<script type='text/javascript'>alert('$message');</script>";
	header("Location: http://localhost:8080/camagru/user/login.php");
	exit();
}
?>
