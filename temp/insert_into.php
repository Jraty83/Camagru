<?php
include '../config/setup.php';

try {
  $usr = 'lolo';
  $stmt = $conn->prepare("INSERT INTO users (username,email)
    VALUES('$usr','$usr.orava@gmail.com')");
  //! test ADD CONFIRMED
  // $stmt = $conn->prepare("INSERT INTO users (username,email,confirmed)
  // VALUES('$usr','keke.orava@gmail.com',1)");
  $stmt->execute();
  echo "User '$usr' successfully added<br><br>";
} catch(PDOException $e) {
    die("ERROR: Could not add user " . $e->getMessage());
}

$conn = null;
?>
