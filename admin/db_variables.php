<?php
include '../config/setup.php';

//USER VARIABLES
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$data = $stmt->fetchAll();

foreach ($data as $row) {
	if ($row['username'] === $_SESSION['user']) {
		$db_userid = $row['user_id'];
		$db_username = $row['username'];
		$db_usermail = $row['email'];
		$db_userpass = $row['password'];
		$db_usertoken = $row['token'];
		$db_usernoti = $row['emailNotification'];
		$db_userveri = $row['verified'];
	}
	else if ($row['token'] === $_GET['token']) {
		$db_userid = $row['user_id'];
		$db_username = $row['username'];
		$db_usermail = $row['email'];
		$db_userpass = $row['password'];
		$db_usertoken = $row['token'];
		$db_usernoti = $row['emailNotification'];
		$db_userveri = $row['verified'];
	}
	else if ($row['username'] === $_POST['username']) {
		$db_userid = $row['user_id'];
		$db_username = $row['username'];
		$db_usermail = $row['email'];
		$db_userpass = $row['password'];
		$db_usertoken = $row['token'];
		$db_usernoti = $row['emailNotification'];
		$db_userveri = $row['verified'];
	}
	else if ($row['email'] === $_POST['email']) {
		$db_userid = $row['user_id'];
		$db_username = $row['username'];
		$db_usermail = $row['email'];
		$db_userpass = $row['password'];
		$db_usertoken = $row['token'];
		$db_usernoti = $row['emailNotification'];
		$db_userveri = $row['verified'];
	}
}
