<?php
session_start();
require_once 'config/setup.php';
$user = $_SESSION['user'];

?>

<!doctype html>
<html lang="en">
	<head>
		<title>Home</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="includes/cam.png?">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" href="includes/main.css">
		<link rel="stylesheet" href="includes/webcam.css" type="text/css" media="all">
	</head>
	<body>
		<?php require_once 'includes/navbar.php';

		// FOR LOGGED IN USER'S ONLY
		if ($user) {
			echo "<p class='right-align'>Logged in as: ".$user."</p>"?>
			<h1 class="access">! ! ! VIP ACCESS ! ! !<br><span style="font-size:20px">display all pictures with commenting & liking enabled</span></h1>
		<?php }

		// FOR EVERYBODY
		else { ?>
			<h1 class="denied">! ! ! GALLERY ONLY ! ! !</h1>
		<?php }

		$stmt = $conn->prepare("SELECT * FROM pictures ORDER BY img_id DESC");
		$stmt->execute();
		$picdata = $stmt->fetchAll();

		$count = $stmt->rowCount();
		if ($count > 0)
			print("Total of $count images.<br><br>");

		// SHOW ALL PICTURES
		foreach ($picdata as $row) {
			$location = $row['file'];
			$rowtype = $row['type'];
			echo $location."<br>";
			$kuva = file_get_contents($location);
			echo '<img class="img-thumbnail" src="'.$rowtype.';base64,' . $kuva . '" />'.'<br>';
		}

		require_once 'includes/footer.php';?>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>
