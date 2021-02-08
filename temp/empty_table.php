<?php
include '../config/setup.php';

try {
	$stmt = $conn->prepare("TRUNCATE TABLE users");
	$stmt->execute();
	echo "All users succesfully deleted<br><br>";
}
catch(PDOException $e) {
    die("ERROR: Could not delete users " . $e->getMessage() . "<br><br>");
}

$conn = null;
?>
