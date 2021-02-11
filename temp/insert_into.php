<?php
include '../config/setup.php';

$user = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

//TODO: CHECK IF THE USER ALREADY EXIST BEFORE INSERTING TO TABLE

if ($_POST['username'] && $_POST['email'] && $_POST['password'] && $_POST['submit'] == "Register") {
  try {
    //$password = hash('whirlpool', $user . 123456); //! NO WHIRLPOOL
    //! USING password_hash() function
    $hash_encrypt = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username,email,`password`)
      VALUES('$user', '$email', '$hash_encrypt')");
    //! test ADD VERIFIED
    // $stmt = $conn->prepare("INSERT INTO users (username,email,`password`,verified)
    //   VALUES('$user', '$email', '$hash_encrypt', 1)");
    $stmt->execute();
    echo "User '$user' successfully added<br><br>";
  } catch(PDOException $e) {
      echo "not working";
      die("ERROR: Could not add user " . $e->getMessage());
  }
}

// $conn = null;
?>
