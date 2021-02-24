<?php
session_start();
$user = $_SESSION['user'];
$_SESSION['user'] = "";
$msg = $user." succesfully logged out. Login again for privileged access";
echo "<script type='text/javascript'>alert('$msg');
window.location.href='../index.php';</script>";
?>
