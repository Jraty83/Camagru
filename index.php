<?php
session_start();
date_default_timezone_set("Europe/Helsinki");
require_once 'config/setup.php';
require_once 'admin/db_variables.php';
require_once 'admin/mail.php';

$user = $_SESSION['user'];

if(isset($_POST['like'])) {
	$img_id = $_POST['like'];
	$stmt = $conn->prepare("UPDATE pictures SET likes = likes + 1 WHERE $img_id = img_id");
	$stmt->execute();

	$stmt = $conn->prepare("INSERT INTO likes (`user_id`,`img_id`)
	VALUES('$db_userid', '$img_id')");
	$stmt->execute();
	header('Location: '.$_SERVER['PHP_SELF']);
	die;
}

if(isset($_POST['unlike'])) {
	$img_id = $_POST['unlike'];
	$stmt = $conn->prepare("UPDATE pictures SET likes = likes - 1 WHERE $img_id = img_id");
	$stmt->execute();

	$stmt = $conn->prepare("DELETE FROM likes WHERE $db_userid = `user_id` AND $img_id = img_id");
	$stmt->execute();
	header('Location: '.$_SERVER['PHP_SELF']);
	die;
}

if ($_POST['msg_submit'] === "Post" && $_POST['comment']) {
	$img_id = $_POST['img_id'];
	$commentor_name = $db_username;
	$commentor_id = $db_userid;
	$comment = $_POST['comment'];
	$time = date("d/m/Y h:i:s a");

	// EXTRA CHECK FOR CHROME SINCE IT CAN ACCEPT EXCESS NEWLINES
	if (strlen($comment) > 255) {
		$msg = "Sorry, your comment is too long (".strlen($comment)." characters). Maximum comment length is 255";
	 	echo "<script type='text/javascript'>alert('$msg');
		window.location.href='$_SERVER[PHP_SELF]';</script>";
		die;
	}

	$stmt = $conn->prepare("SELECT pictures.user, pictures.user_id, pictures.file, users.email, users.emailNotification
	FROM pictures INNER JOIN users ON pictures.user_id = users.user_id 
	WHERE img_id=$img_id");
	$stmt->execute();
	$img_data = $stmt->fetchAll();

	foreach ($img_data as $row) {
		$author = $row['user'];
		$author_id = $row['user_id'];
		$author_mail = $row['email'];
		$path = $row['file'];
		$mails = $row['emailNotification'];
	}

	$stmt = $conn->prepare("INSERT INTO comments (`commentor_id`,`commentor`,`img_id`,`author_id`,`comment`,`time`)
	VALUES('$commentor_id', '$commentor_name', '$img_id', '$author_id', '$comment', '$time')");
	$stmt->execute();

	if ($mails) {
		sendCommentedEmail($author_mail,$commentor_name,$path);
		$msg = "Your comment has been posted and ".$author." has been notified.";
		echo "<script type='text/javascript'>alert('$msg');
		window.location.href='$_SERVER[PHP_SELF]';</script>";
		// OR REMOVE POPUP + ELSE AND JUST REDIRECT
	}
	else {
		header('Location: '.$_SERVER['PHP_SELF']);
		die;
	}
}

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
		<link rel="stylesheet" href="webcam/webcam.css" type="text/css" media="all">
	</head>
	<body>
		<?php require_once 'includes/navbar.php';

		if ($user) { ?>
			<p class="logged">Logged in as: <?php echo $user?></p>
		<?php }

		$stmt = $conn->prepare("SELECT * FROM pictures ORDER BY img_id DESC");
		$stmt->execute();
		$pics = $stmt->fetchAll();

		$count = $stmt->rowCount();
		if ($count > 0)
			print("Total of $count images.<br><br>");

		// SHOW ALL PICTURES
		foreach ($pics as $row) {
			echo $row['file']."<br>";?>
			<form method="POST" action="">
				<img class="img-thumbnail" style="margin-left:10px" src="images/<?php echo $row['file']?>" />
				<br>
				<b style="margin-left: 10px;"><?php echo $row['likes']?> likes</b>
				<?php if ($user) {

					// CHECK IF USER ALREADY LIKED THIS PICTURE
					$stmt = $conn->prepare("SELECT * FROM likes WHERE $db_userid=`user_id` AND $row[img_id] = img_id");
					$stmt->execute();
					$count = $stmt->rowCount();

					if ($count == 0) {?>
						<button class="btn btn-light" name="like" id="likebutton" value="<?php echo $row['img_id']?>">Like</button>
						<?php } else { ?>
						<button class="btn btn-light" name="unlike" id="unlikebutton" value="<?php echo $row['img_id']?>">Unlike</button>
				<?php }?>
						<input type="hidden" name="img_id" value="<?php echo $row['img_id']?>">
						<table width="320" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<script>
									function myFunction(obj) {
									obj.outerHTML = '<td colspan="2" align="center"><br><textarea name="comment" id="comment" maxlength="255" placeholder="Add a comment here..."></textarea></td></tr><tr><td colspan="2" align="center"><br><input type="submit" class="btn btn-light" value="Post" name="msg_submit" id="msg_submit" /></td></tr>';
									}
								</script>
								<button class="btn btn-light" onclick="myFunction(this)">Comment</button>
						</table>
				<?php } ?>
			</form>

			<?php

				$stmt = $conn->prepare("SELECT * FROM comments WHERE $row[img_id] = img_id ORDER BY `id` DESC");
				$stmt->execute();
				$comments = $stmt->fetchAll();

				foreach ($comments as $row) { ?>
					<pre><p class="comment"><span class="timestamp"><?php echo $row['commentor']."\t".$row['time']?></span><br><?php echo $row['comment']?></pre>
				<?php }
		}
		
		require_once 'includes/footer.php';?>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>
