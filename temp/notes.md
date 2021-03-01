### REDIRECT SCRIPT WITH ALERT:
```sh
echo "<script type='text/javascript'>alert('$msg');
window.location.href='login.php';</script>";
```
### FETCH ALL DATA FROM DB:
```sh
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$data = $stmt->fetchAll();
```
> *$data now holds all data in an array
```sh
foreach ($data as $row) {
	echo "user_id is: ".$row['user_id']."<br>";
	echo "username is: ".$row['username']."<br>";
	echo "email is: ".$row['email']."<br>";
	echo "password is: ".$row['password']."<br>";
	echo "token is: ".$row['token']."<br>";
	echo "verified is: ".$row['verified']."<br><br>";
}
```
> You can now access values using $row['value'] syntax! 

### PRINT ALL VARIABLES:
```sh
session_start();
require_once '../admin/db_variables.php';

		<?php
		echo "SESSION USER IS: ".$_SESSION['user']."<br><br>";
		echo "DB_user_id is: ".$db_userid."<br>";
		echo "DB_username is: ".$db_username."<br>";
		echo "DB_email is: ".$db_usermail."<br>";
		echo "DB_password is: ".$db_userpass."<br>";
		echo "DB_token is: ".$db_usertoken."<br>";
		echo "DB_verified is: ".$db_userveri."<br><br>";
		?>
```
