<?php
include '../config/setup.php';

try {
	$stmt = $conn->prepare("DROP TABLE users");
	$stmt->execute();
	echo "Table 'users' succesfully deleted<br><br>";
}
catch(PDOException $e) {
    die("ERROR: Could not delete table " . $e->getMessage() . "<br><br>");
}

$conn = null;
?>
