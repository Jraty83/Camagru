<?php

function validate_reg($user,$email,$password) {
	$password2 = $_POST['password2'];
	//REGEX FOR PASSWORD
	$upper = preg_match('@[A-Z]@', $password);
	$lower = preg_match('@[a-z]@', $password);
	$digit = preg_match('@[0-9]@', $password);
	$special = preg_match('@\W@', $password);
	$minlen = strlen($password);

	if ($_POST['submit'] == "Register") {
		if ($user && (trim($user) != "")) {
			if ($email) {
				if ($password === $password2) {
					if($upper && $lower && $digit && $special && ($minlen >= 8))
						return true;
					else
						echo "your password must contain at least:<br><li>8 characters<br><li>one Uppercase<br><li>one Lowercase<br><li>one digit &<br><li>one special character<br>";
				}
				else
					echo "passwords don't match";
			}
			else
				echo "enter an email address";
		}
		else
			echo "enter a username";
	}
}
?>
