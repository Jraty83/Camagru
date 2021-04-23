<?php

$errors = [];
$valid_input = 0;
$existing_user = false;
$existing_mail = false;

$user = preg_replace("/\s+/", "", $_POST['username']);
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

// QUERY TO FETCH ALL DATA FROM USERS TABLE
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$data = $stmt->fetchAll();

// CHECK FOR EXISTING USERS AND EMAILS
foreach ($data as $row) {
	if ($row['username'] === $user) {
		$existing_user = true;
		if ($_POST['submit'] === "Register")
			array_push($errors,"username already used, choose another one");
	}
	if ($row['email'] === $email) {
		$existing_mail = true;
		if ($_POST['submit'] === "Register")
			array_push($errors,"email already used, choose another one");
	}
}

//REGEX FOR USERNAME
$specialusr = preg_match('@\W@', $user);

//REGEX FOR PASSWORD
$upper = preg_match('@[A-Z]@', $password);
$lower = preg_match('@[a-z]@', $password);
$digit = preg_match('@[0-9]@', $password);
$special = preg_match('@\W@', $password);
$minlen = strlen($password);

if ($_POST['submit'] === "Register" || $_POST['submit'] === "Save") {
	if ($user && (trim($user) != "") && !$specialusr)
		$valid_input++;
	else
		array_push($errors,"enter a valid username");
	if ($email)
		$valid_input++;
	else
		array_push($errors,"enter an email address");
	if ($upper && $lower && ($digit||$special) && ($minlen >= 8))
		$valid_input++;
	else
		array_push($errors,"enter a valid password");
	if (!$password2)
		array_push($errors,"re-enter password");
	if ($password && $password2) {
		if ($password === $password2)
			$valid_input++;
		else
			array_push($errors,"passwords don't match");
	}
}

if ($_POST['submit'] === "Reset") {
	if ($email)
		$valid_input++;
	else
		array_push($errors,"enter an email address");
	if ($email && !$existing_mail)
		array_push($errors,"email address not found");
}

if ($_POST['submit'] === "Change") {
	if ($upper && $lower && ($digit||$special) && ($minlen >= 8))
		$valid_input++;
	else
		array_push($errors,"enter a valid password");
	if (!$password2)
		array_push($errors,"re-enter password");
	if ($password && $password2) {
		if ($password === $password2)
			$valid_input++;
		else
			array_push($errors,"passwords don't match");
	}
}

if ($_POST['namechange'] === "Change") {
	if ($user && (trim($user) != "") && !$specialusr)
		$valid_input++;
	else
		array_push($errors,"enter a valid username");
}

if ($_POST['mailchange'] === "Change") {
	if ($email)
		$valid_input++;
	else
		array_push($errors,"enter an email address");
}
