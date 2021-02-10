<?php
include '../config/setup.php';

try {
	$stmt = $conn->prepare("DROP DATABASE camagru");
	$stmt->execute();
	echo "Database 'camagru' succesfully deleted<br>";
}
catch(PDOException $e) {
    die("ERROR: Could not delete database " . $e->getMessage());
}

?>
