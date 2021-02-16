<?php

$errors = [];
$valid_input = 0;
$duplicate = false;

$user = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

// QUERY FOR CHECKING EXISTING USERS / EMAILS
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$data = $stmt->fetchAll();

foreach ($data as $row) {
	if ($row['username'] === $user) {
		$duplicate = true;
		array_push($errors,"username already used, choose another one");
	}
	if ($row['email'] === $email) {
		$duplicate = true;
		array_push($errors,"email already used, choose another one");
	}
}

//REGEX FOR PASSWORD
$upper = preg_match('@[A-Z]@', $password);
$lower = preg_match('@[a-z]@', $password);
$digit = preg_match('@[0-9]@', $password);
$special = preg_match('@\W@', $password);
$minlen = strlen($password);

if ($_POST['submit'] === "Register") {
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

?>
