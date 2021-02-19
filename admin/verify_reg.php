<?php
require_once '../config/setup.php';
require_once 'mail.php';

// echo "GET_MAIL: " . $_GET['email'] . "<br>";
// echo "GET_TOKEN: " . $_GET['token'] . "<br>";

if (isset($_GET['token'])) {
	
	$token = $_GET['token'];
	$email = $_GET['email'];

	try {
		$stmt = $conn->prepare("UPDATE users SET verified=1 WHERE token='$token'");
		$stmt->execute();
		sendActivatedEmail($email);
		$msg = "Your account has been activated";
		echo "<script type='text/javascript'>alert('$msg');</script>";
    } catch(PDOException $e) {
		die("ERROR: Could not activate account " . $e->getMessage());
	}
}

?>
