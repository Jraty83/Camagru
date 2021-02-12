<?php
include 'insert_into.php';

$user = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

echo "CHECKER VALUES:<br>";
echo "Username: " . '"' . $user . '"' . "<br>";
echo "Email: " . $email . "<br>";
echo "Password: " . $password . "<br>";
echo "Password2: " . $password2 . "<br><br>";
echo "ERRORS:<br>";

//TODO - 1. USER CHECK
if (!$user)
	echo "User: username is EMPTY<br>";
if (trim($user) == "")
echo "User: username is BLANK<br>";

//TODO - 2. EMAIL CHECK
if (!$email)
	echo "Email: email is EMPTY<br>";

//TODO - 3. PASSWORD CHECK
//REGEX FOR PASSWORD
$upper = preg_match('@[A-Z]@', $password);
$lower = preg_match('@[a-z]@', $password);
$digit = preg_match('@[0-9]@', $password);
$special = preg_match('@\W@', $password);
$minlen = strlen($password);

if(!$upper)
	echo "Password: Uppercase NOT found<br>";
if(!$lower)
	echo "Password: Lowercase NOT found<br>";
if(!$digit)
	echo "Password: Digit NOT found<br>";
if(!$special)
	echo "Password: Special character NOT found<br>";
if (!($minlen >= 8)) {
	echo "Password: Password too short<br>";
	echo "Password lenght is: " . $minlen . "<br>";
}

//TODO - 4. CONFIRM PASSWORD CHECK
if ($password !== $password2)
  echo "Password2: passwords don't match...<br>";

echo "<br>PASSES:<br>";
if ($user && (trim($user) != ""))
	echo "Username is VALID<br>";
if ($email)
	echo "Email: email is VALID<br>";
if($upper && $lower && $digit && $special && ($minlen >= 8))
	echo "Password: password is VALID<br>";
if ($password === $password2)
	echo "Password2: passwords MATCH<br>";
?>
