<?php
include '../config/setup.php';

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

try {
  $stmt = $conn->prepare("INSERT INTO users (username,email,`password`,token,verified)
      VALUES('$user1', '$email1', '$hash_encrypt1', '$token1', 0),
      ('$user2', '$email2', '$hash_encrypt2', '$token2', 1),
      ('$user3', '$email3', '$hash_encrypt3', '$token3', 0),
      ('$user4', '$email4', '$hash_encrypt4', '$token4', 0),
      ('$user5', '$email5', '$hash_encrypt5', '$token5', 1)");
    //! test ADD VERIFIED
    // $stmt = $conn->prepare("INSERT INTO users (username,email,`password`,verified)
    //   VALUES('$user', '$email', '$hash_encrypt', 1)");
    $stmt->execute();
    echo "Five random users successfully added<br>";
  } catch(PDOException $e) {
      echo "not working";
      die("ERROR: Could not add users " . $e->getMessage());
  }

?>
