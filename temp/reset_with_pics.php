<?php
include '../config/setup.php';

// REMOVE DATABASE
$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $conn->prepare("DROP DATABASE camagru");
$stmt->execute();

// CREATE DATABASE
$stmt = $conn->prepare("CREATE DATABASE IF NOT EXISTS camagru");
$stmt->execute();

// CREATE USERS TABLE
$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS users (
`user_id` INT(11) AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(15) NOT NULL,
email VARCHAR(50) NOT NULL,
`password` VARCHAR(255) NOT NULL,
token CHAR(100) NOT NULL,
emailNotification BIT DEFAULT 1 NOT NULL,
verified BIT DEFAULT 0 NOT NULL)");
$stmt->execute();

// INSERT FIVE RANDOM USERS
$user1 = "matti";
$email1 = "$user1@gmail.com";
$hash_encrypt1 = password_hash($user1, PASSWORD_DEFAULT);
$token1 = bin2hex(random_bytes(50));

$user2 = "teppo";
$email2 = "$user2@hotmail.com";
$hash_encrypt2 = password_hash($user2, PASSWORD_DEFAULT);
$token2 = bin2hex(random_bytes(50));

$user3 = "seppo";
$email3 = "$user3@yahoo.com";
$hash_encrypt3 = password_hash($user3, PASSWORD_DEFAULT);
$token3 = bin2hex(random_bytes(50));

$user4 = "keke";
$email4 = "$user4@aol.com";
$hash_encrypt4 = password_hash($user4, PASSWORD_DEFAULT);
$token4 = bin2hex(random_bytes(50));

$user5 = "orava";
$email5 = "$user5@google.com";
$hash_encrypt5 = password_hash($user5, PASSWORD_DEFAULT);
$token5 = bin2hex(random_bytes(50));

$stmt = $conn->prepare("INSERT INTO users (username,email,`password`,token,emailNotification,verified)
VALUES('$user1', '$email1', '$hash_encrypt1', '$token1', 0, 0),
('$user2', '$email2', '$hash_encrypt2', '$token2', 1, 1),
('$user3', '$email3', '$hash_encrypt3', '$token3', 1, 0),
('$user4', '$email4', '$hash_encrypt4', '$token4', 1, 1),
('$user5', '$email5', '$hash_encrypt5', '$token5', 1, 1)");
$stmt->execute();

// CREATE PICTURES TABLE
$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS pictures (
`img_id` INT(11) AUTO_INCREMENT PRIMARY KEY,
user VARCHAR(25) NOT NULL,
`user_id` INT(11) NOT NULL,
`file` VARCHAR(255) NOT NULL,
likes INT(11) DEFAULT 0 NOT NULL)");
$stmt->execute();

// CREATE LIKES TABLE
$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS likes (
`id` INT(11) AUTO_INCREMENT PRIMARY KEY,
`user_id` INT(11) NOT NULL,
`img_id` INT(11) NOT NULL)");
$stmt->execute();

// CREATE COMMENTS TABLE
$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS comments (
`id` INT(11) AUTO_INCREMENT PRIMARY KEY,
`commentor_id` INT(11) NOT NULL,
`commentor` VARCHAR(25) NOT NULL,
`img_id` INT(11) NOT NULL,
`author_id` INT(11) NOT NULL,
`comment` VARCHAR(255) NOT NULL,
`time` VARCHAR(25) NOT NULL)");
$stmt->execute();

// INSERT TWENTY RANDOM PICTURES
$user = "matti";
$userid = 1;

$file1 = "x_DSC_0035.JPG";
$file2 = "x_FLAG_B24.bmp";
$file3 = "x_cat.gif";
$file4 = "x_code.jpeg";
$file5 = "x_d51891b3-afaa-4ba7-a23f-5b7f849b9c46.jpg";
$file6 = "x_girl.gif";
$file7 = "x_hampaat.png";
$file8 = "x_olut.jpeg";
$file9 = "x_pissa.png";
$file10 = "x_sample_640×426.bmp";
$file11 = "x_DSC_0035copy.JPG";
$file12 = "x_FLAG_B24copy.bmp";
$file13 = "x_catcopy.gif";
$file14 = "x_codecopy.jpeg";
$file15 = "x_d51891b3-afaa-4ba7-a23f-5b7f849b9c46copy.jpg";
$file16 = "x_girlcopy.gif";
$file17 = "x_hampaatcopy.png";
$file18 = "x_olutcopy.jpeg";
$file19 = "x_pissacopy.png";
$file20 = "x_sample_640×426copy.bmp";

// $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $conn->prepare("INSERT INTO pictures (`user`,`user_id`,`file`)
	VALUES('$user', '$userid', '$file1'),
	('$user', '$userid', '$file2'),
	('$user', '$userid', '$file3'),
	('$user', '$userid', '$file4'),
	('$user', '$userid', '$file5'),
	('$user', '$userid', '$file6'),
	('$user', '$userid', '$file7'),
	('$user', '$userid', '$file8'),
	('$user', '$userid', '$file9'),
	('$user', '$userid', '$file10'),
	('$user', '$userid', '$file11'),
	('$user', '$userid', '$file12'),
	('$user', '$userid', '$file13'),
	('$user', '$userid', '$file14'),
	('$user', '$userid', '$file15'),
	('$user', '$userid', '$file16'),
	('$user', '$userid', '$file17'),
	('$user', '$userid', '$file18'),
	('$user', '$userid', '$file19'),
	('$user', '$userid', '$file20')");
$stmt->execute();

echo "Reset all OK, twenty testpics added<br>";
?>
