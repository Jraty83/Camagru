<?php
include '../config/setup.php';

try {
  $usr = 'Tepon_Seppo58';
  $password = hash('whirlpool', $usr . 123456);
  $stmt = $conn->prepare("INSERT INTO users (username,email,`password`)
    VALUES('$usr', '$usr.orava@gmail.com', '$password')");
  //! test ADD CONFIRMED
  // $stmt = $conn->prepare("INSERT INTO users (username,email,`password`,confirmed)
  //   VALUES('$usr', '$usr.orava@gmail.com', '$password', 1)");
  $stmt->execute();
  echo "User '$usr' successfully added<br><br>";
} catch(PDOException $e) {
    die("ERROR: Could not add user " . $e->getMessage());
}

$conn = null;
?>
