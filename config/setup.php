<?php
include 'database.php';

try {
    $conn = new PDO($DB_DSN_NO_DB, $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("CREATE DATABASE IF NOT EXISTS camagru");
    $stmt->execute();
    echo "Database created successfully<br>"; //! DIES IF NOT SUCCESFULL
}

catch(PDOException $e) {
    die("ERROR: No database created. " . $e->getMessage());
}

try {
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 	$stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS users (
	`user_id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    -- username VARCHAR(20) NOT NULL UNIQUE, //! WITH 'UNIQUE' ALLOWS NO DUPLICATES
    username VARCHAR(20) NOT NULL,
	email VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
	verified BIT DEFAULT 0 NOT NULL)");
	$stmt->execute();
	echo "Table 'users' succesfully created<br>";
}
catch(PDOException $e) {
    die("ERROR: Table not created. " . $e->getMessage());
}

//$conn = null; //! DO NOT CLOSE HERE!!
?>
