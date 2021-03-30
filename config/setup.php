<?php
include 'database.php';

try {
    $conn = new PDO($DB_DSN_NO_DB, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("CREATE DATABASE IF NOT EXISTS camagru");
    $stmt->execute();
    // echo "Database created successfully<br>";
} catch(PDOException $e) {
    die("ERROR: No database created. " . $e->getMessage());
}

try {
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 	$stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS users (
	`user_id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(25) NOT NULL,
	email VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    token CHAR(100) NOT NULL,
	verified BIT DEFAULT 0 NOT NULL)");
	$stmt->execute();
	// echo "Table 'users' succesfully created<br>";
} catch(PDOException $e) {
    die("ERROR: users table not created. " . $e->getMessage());
}

try {
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 	$stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS pictures (
	`img_id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    user VARCHAR(25) NOT NULL,
    `user_id` INT(11) NOT NULL,
    `type` VARCHAR(25) NOT NULL,
    `file` VARCHAR(255) NOT NULL)");
	$stmt->execute();
	// echo "Table 'pictures' succesfully created<br>";
} catch(PDOException $e) {
    die("ERROR: pictures table not created. " . $e->getMessage());
}

?>
