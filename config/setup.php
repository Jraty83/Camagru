<?php
$DB_DSN = "mysql:dbname=camagru;host=127.0.0.1";
$DB_USER = "root";
$DB_PASSWORD = "123456";
//$DB_DSN_NO_DB = "mysql:host=127.0.0.1";

try {
    $conn = new PDO("$DB_DSN", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Connected successfully<br><br>"; //! DIES IF NOT SUCCESFULL
}

catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage() . "<br><br>");
}

//$conn = null; //! DO NOT CLOSE HERE!!
?>
