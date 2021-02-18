<?php
require_once '../config/setup.php';

if (isset($_GET['token'])) {
	
	$token = $_GET['token'];

	try {
		$stmt = $conn->prepare("UPDATE users SET verified=1 WHERE token='$token'");
		$stmt->execute();
		$msg = "Your account has been activated";
		echo "<script type='text/javascript'>alert('$msg');
		window.location.href='../user/login.php';</script>";
    } catch(PDOException $e) {
		die("ERROR: Could not activate account " . $e->getMessage());
	}
}

?>
