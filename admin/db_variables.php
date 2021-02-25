<?php
require_once '../config/setup.php';

//USER VARIABLES
foreach ($data as $row) {
	if ($row['username'] === $_POST['username']) {
		$db_userid = $row['user_id'];
		$db_username = $row['username'];
		$db_usermail = $row['email'];
		$db_userpass = $row['password'];
		$db_usertoken = $row['token'];
		$db_userveri = $row['verified'];
	}
	else if ($row['email'] === $_POST['email']) {
		$db_userid = $row['user_id'];
		$db_username = $row['username'];
		$db_usermail = $row['email'];
		$db_userpass = $row['password'];
		$db_usertoken = $row['token'];
		$db_userveri = $row['verified'];
	}
}
