<?php

$errors = [];
$valid_input = 0;
$existing = false;

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
		if ($_POST['submit'] === "Register") {
			$existing = true;
			array_push($errors,"username already used, choose another one");
		}
	}
	if ($row['email'] === $email) {
		$existing = true;
		if ($_POST['submit'] === "Register")
			array_push($errors,"email already used, choose another one");
	}
}

//REGEX FOR PASSWORD
$upper = preg_match('@[A-Z]@', $password);
$lower = preg_match('@[a-z]@', $password);
$digit = preg_match('@[0-9]@', $password);
$special = preg_match('@\W@', $password);
$minlen = strlen($password);

if ($_POST['submit'] === "Register" || $_POST['submit'] === "Save") {
	if ($user && (trim($user) != ""))
		$valid_input++;
	else
		array_push($errors,"enter a username");
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
	if ($email && !$existing)
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
