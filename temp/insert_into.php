<?php
include '../config/setup.php';

$user = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

if ($_POST['username'] && $_POST['email'] && $_POST['password'] && $_POST['submit'] == "Register") {
  try {
    //$password = hash('whirlpool', $user . 123456);
    //! USING password_hash() function
  //  $hash_encrypt = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username,email,`password`)
      VALUES('$user', '$email', '$password')");
    //! test ADD CONFIRMED
    // $stmt = $conn->prepare("INSERT INTO users (username,email,`password`,confirmed)
    //   VALUES('$user', '$user.orava@gmail.com', '$password', 1)");
    $stmt->execute();
    echo "User '$user' successfully added<br><br>";
  } catch(PDOException $e) {
      echo "not working";
      die("ERROR: Could not add user " . $e->getMessage());
  }
}

$conn = null;
?>
