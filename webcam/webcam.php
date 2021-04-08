<?php
	session_start();
	require_once '../config/setup.php';
	require_once '../includes/constants.php';
	require_once '../admin/db_variables.php';

	$user = $_SESSION['user'];
	$user_id = $db_userid;
	$id = rand(0,10000);

	if (isset($_POST['cpt_1']) && $_POST['cpt_1'] != "") {

		$data = $_POST['cpt_1'];
			
		list($type, $data) = explode(';', $data);
		list(, $data) = explode(',', $data);
		$data = base64_decode($data);
		
		$file = "images/".$user."_".$id.".png";
		file_put_contents("../$file", $data);

		try {
		$stmt = $conn->prepare("INSERT INTO pictures (user,`user_id`,`type`,`file`)
		VALUES('$user', '$user_id', '$type', '$file')");
		$stmt->execute();
		$msg = "Picture saved into database.";
		echo "<script type='text/javascript'>alert('$msg');</script>";
		} catch(PDOException $e) {
			die("ERROR: Could not add pic into database " . $e->getMessage());
		}
	}

	// DELETE PICTURE
	if (isset($_POST['delete']) && $_POST['delete'] != "") {
		$img_id = $_POST['delete'];
		// echo "poista kuva nro: ".$_POST['delete']."!!!<br>";
		try {
			$stmt = $conn->prepare("DELETE FROM pictures WHERE $img_id = img_id");
			$stmt->execute();
			$msg = "Picture deleted";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		} catch(PDOException $e) {
			die("ERROR: Could not delete picture from database " . $e->getMessage());
		}
	}
?>

<!-- HTML -->
<!doctype html>
	<html lang="en">
	<head>
		<title>Add Pic</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../includes/cam.png?">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" href="../includes/main.css">
		<link rel="stylesheet" href="webcam.css" type="text/css" media="all">
		<script src = 
			"https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"> 
        </script> 
	</head>
	<body>
		<?php require_once '../includes/navbar.php';

		// FOR LOGGED IN USER'S ONLY
		if ($user) { ?>

			<p class="logged">Logged in as: <?php echo $user?></p>
			<div class="container">
				<form method="POST" action="" enctype="multipart/form-data">
<!-- // WEBCAM AND PREVIEW -->
					<div class="col">
						<input type="hidden" name="cpt_1" id="cpt_1">

						<script src="takepic.js"></script>

						<div class="camera">
							<video id="video">Video stream not available.</video>
							<button id="startbutton">Take photo</button>
						</div>
						<canvas id="canvas">
						</canvas>
						<label style="vertical-align: top">Preview:</label>
						<div class="output">
							<img id="photo" alt="The screen capture will appear in this box.">
							<!-- <button onclick="return confirm('Upload this photo?')" class="btn btn-dark" id="submitbutton">Submit</button> -->
						</div>
					</div>
<!-- FILE UPLOAD -->
					<div class="col" style="margin-top: 1vw">	
						Select image to upload (limit 1Mb):
						<br>
						<input type="file" name="fileToUpload" id="fileToUpload" accept="image/*">
					</div>
<!-- ADDONS: -->
					<div class="col" style="margin-top: 1vw">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="addon" id="radio1" value="option1" checked>
								<label class="form-check-label" for="radio1">
									<img class="addon" style="margin-left: -15px;" src="../images/addons/fire.png" />
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="addon" id="radio2" value="option2">
								<label class="form-check-label" for="radio2">
									<img class="addon" style="margin-left: -15px;" src="../images/addons/water.png" />
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="addon" id="radio3" value="option3">
								<label class="form-check-label" for="radio3">
									<img style="width: 100px; margin-left: -15px;" src="../images/addons/bikini.png" />
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="addon" id="radio4" value="option4">
								<label class="form-check-label" for="radio4">
									<img class="addon" style="margin-left: 0px;" src="../images/addons/rainbow.png" />
								</label>
							</div>
					</div>
<!-- SUBMIT -->
					<div class="col" style="margin-top: 1vw">
						<button onclick="return confirm('Upload this photo?')" class="btn btn-dark" id="submitbutton">Submit</button>
					</div>
				</form>
<!-- THUMBNAILS -->
				
					<div class="col" style="margin-top: 1vw">
						<div class="output">
							<?php 
								$stmt = $conn->prepare("SELECT * FROM pictures WHERE user_id='$user_id' ORDER BY img_id DESC");
								$stmt->execute();
								$count = $stmt->rowCount();
								$pics = $stmt->fetchAll();
								if ($count > 0)
									print("Total of $count images.<br><br>");

								foreach ($pics as $row) {
									echo $row['file']."<br>";?>
									<form method="POST" action="">
										<img class="img-thumbnail-small" src="<?php echo '../'.$row['file']?>" />
										<input type="hidden" name="delete" value="<?php echo $row['img_id']?>">
										<button onclick="return confirm('Delete this pic?')" class="btn btn-dark" id="<?php echo 'del'.$row['img_id']?>">Delete</button>
									</form>
									<?php
								}
							?>
							<script> 
								$("button").click(function() { 
									var t = $(this).attr('id'); 
									console.log(t);
									$t = t;
									delbutton = document.getElementById(t);
									// delbutton.addEventListener('click', function(ev) {
									// 	takepicture();
									// 	ev.preventDefault();
									// }, false);
								}); 
							</script>
						</div>
					</div>
				<!-- </form> -->
			</div>

		<?php
		}

		// UNAUTHORIZED ACCESS
		else {
			header('Location: http://localhost:8080/camagru/index.php');
			exit;
		}

		require_once '../includes/footer.php';?>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>
