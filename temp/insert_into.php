<?php
include '../config/setup.php';

try {
  $usr = 'keke';
  $password = hash('whirlpool', $usr . 123456);
  //! USING password_hash() function
  //  $hash_encrypt = password_hash($usr . 123456, PASSWORD_DEFAULT);
  $stmt = $conn->prepare("INSERT INTO users (username,email,`password`)
    VALUES('$usr', '$usr.orava@gmail.com', '$password')");
    // VALUES('$usr', '$usr.orava@gmail.com', '$hash_encrypt')");
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
