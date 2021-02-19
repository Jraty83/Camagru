<?php

$errors = [];
$verified = 0;
$existing = false;

$user = preg_replace("/\s+/", "", $_POST['username']);
$password = $_POST['password'];

if ($_POST['submit'] === "Login") {
	if ($user) {
		// QUERY TO FETCH ALL DATA FROM USERS TABLE
		$stmt = $conn->prepare("SELECT * FROM users");
		$stmt->execute();
		$data = $stmt->fetchAll();

		// CHECK IF USER EXISTS, PASSWORD MATCHES AND ACCOUNT IS VERIFIED
		foreach ($data as $row) {
			if ($row['username'] === $user) {
				$existing = true;
				if (password_verify($_POST['password'], $row['password'])) {
					$verified++;
					if ($row['verified'] == 1)
						$verified++;
					else
						array_push($errors,"account not verified, check your mail/spam folder");
				}
				else if ($password)
					array_push($errors,"check password");
			}
		}
		if (!$existing)
			array_push($errors,"username not found");
	}
	else
		array_push($errors,"enter a username");
	if (!$password)
		array_push($errors,"enter a password");

}

?>
