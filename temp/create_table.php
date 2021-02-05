<?php
include '../config/setup.php';

try {
	$stmt = $conn->prepare("CREATE TABLE users (
	id INT(6) AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(20) NOT NULL,
	email VARCHAR(50) NOT NULL,
	confirmed BIT DEFAULT 0 NOT NULL)");
	$stmt->execute();
	echo "Table 'users' succesfully created<br><br>";
}
catch(PDOException $e) {
    die("ERROR: Table not created " . $e->getMessage() . "<br><br>");
}

$conn = null;
?>
