<?php
include '../config/setup.php';



$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_POST['username']]);
$user = $stmt->fetch();

if ($user && password_verify($_POST['password'], $user['password']))
{
    echo "valid!";
} else {
    echo "invalid";
}
?>
