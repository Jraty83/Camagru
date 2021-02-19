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
