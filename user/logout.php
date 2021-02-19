<?php
session_start();
$_SESSION['user'] = "";
header("Location: http://localhost:8080/camagru/index.php");
?>
