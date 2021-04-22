<?php
	session_start();
	require_once '../config/setup.php';
	require_once '../includes/constants.php';
	require_once '../admin/db_variables.php';

	$user = $_SESSION['user'];
	$user_id = $db_userid;
	$num = rand(0,10000);

	function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
		$cut = imagecreatetruecolor($src_w, $src_h);
		imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
		imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
		imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
	}

	// CREATE WEBCAM PICTURE
	if (isset($_POST['cpt_1']) && $_POST['cpt_1'] != "") {

		$data = $_POST['cpt_1'];
		$file = $user."_".$num.".png";

		list($type, $data) = explode(';', $data);
		list(, $data) = explode(',', $data);
		$data = base64_decode($data);

		// Store picture taken in a temp file
		file_put_contents("../images/tmp.png", $data);

		// Create image instances
		$dest = imagecreatefrompng("../images/tmp.png");
		$src = imagecreatefrompng("../images/addons/".$_POST['addon'].".png");

		// Copy and merge
		imagecopymerge_alpha($dest, $src, 0, 0, 0, 0, imagesx($src), imagesy($src), 100);

		// Output (into a file) and free memory
		imagepng($dest, "../images/$file");
		imagedestroy($dest);
		imagedestroy($src);
		unlink("../images/tmp.png");

		$stmt = $conn->prepare("INSERT INTO pictures (user,`user_id`,`file`)
		VALUES('$user', '$user_id', '$file')");
		$stmt->execute();
		header('Location: '.$_SERVER['PHP_SELF']);
		die;
	}

	// CREATE UPLOADED PICTURE
	if ($_FILES['fileToUpload']['size']) {
		if ($_FILES['fileToUpload']['size'] > 1000000) {
			$msg = "Sorry, your file is too large.";
			echo "<script type='text/javascript'>alert('$msg');
			window.location.href='$_SERVER[PHP_SELF]';</script>";
		}
		else {
			//! list(, $type) = explode('.', $_FILES['fileToUpload']['name']);
            //! $type = strtolower($type);
            $type = strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION));
			$file = $user."_".$num.".png";
			move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "../images/tmp.$type");
		
			// Create image instances
			if ($type == "png")
				$dest = imagecreatefrompng("../images/tmp.$type");
			if ($type == "bmp")
				$dest = imagecreatefrombmp("../images/tmp.$type");
			if ($type == "gif")
				$dest = imagecreatefromgif("../images/tmp.$type");
			if ($type == "jpg" || $type == "jpeg")
				$dest = imagecreatefromjpeg("../images/tmp.$type");
			$dest = imagescale($dest, 320, 240);
			$src = imagecreatefrompng("../images/addons/".$_POST['addon'].".png");

			// Copy and merge
			imagecopymerge_alpha($dest, $src, 0, 0, 0, 0, imagesx($src), imagesy($src), 100);

			// Output (into a file) and free memory
			imagepng($dest, "../images/$file");

			imagedestroy($dest);
			imagedestroy($src);
			unlink("../images/tmp.$type");

			$stmt = $conn->prepare("INSERT INTO pictures (user,`user_id`,`file`)
			VALUES('$user', '$user_id', '$file')");
			$stmt->execute();
			header('Location: '.$_SERVER['PHP_SELF']);
			die;
		}
	}

	// DELETE PICTURE
	if (isset($_POST['delete']) && $_POST['delete'] != "") {
		unlink('../images/'.$_POST['file']);
		$stmt = $conn->prepare("DELETE FROM pictures WHERE $_POST[delete] = img_id");
		$stmt->execute();
		header('Location: '.$_SERVER['PHP_SELF']);
		die;
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
	</head>
	<body>
		<?php require_once '../includes/navbar.php';

		// FOR LOGGED IN USER'S ONLY
		if ($user) { ?>

			<label class="logged">Logged in as: <?php echo $user?></label>
			<div class="container">
				<form method="POST" action="" enctype="multipart/form-data">
<!-- // WEBCAM AND PREVIEW -->
					<div class="col" style="margin-top: 1vw">
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
							<button onclick="return confirm('Upload this photo?')" class="hidden" id="nobutton" disabled>Submit</button>
						</div>
					</div>
<!-- FILE UPLOAD -->
					<div class="col" style="margin-top: 1vw">
						Select image to upload (limit 1Mb):
						<br>
						<input type="file" name="fileToUpload" id="fileToUpload" accept=".png, .bmp, .gif, .jpg, .jpeg">
					</div>
<!-- ADDONS: -->
					<div class="col" style="margin-top: 1vw">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="addon" id="radio1" value="fire" checked>
								<label class="form-check-label" for="radio1">
									<img class="addon" style="margin-left: -15px;" src="../images/addons/fire.png" />
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="addon" id="radio2" value="water">
								<label class="form-check-label" for="radio2">
									<img class="addon" style="margin-left: -15px;" src="../images/addons/water.png" />
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="addon" id="radio3" value="bikini">
								<label class="form-check-label" for="radio3">
									<img style="width: 100px; margin-left: -15px;" src="../images/addons/bikini.png" />
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="addon" id="radio4" value="rainbow">
								<label class="form-check-label" for="radio4">
									<img class="addon" style="margin-left: 0px;" src="../images/addons/rainbow.png" />
								</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="addon" id="radio5" value="frog">
								<label class="form-check-label" for="radio5">
									<img class="addon" style="margin-left: 0px;" src="../images/addons/frog.png" />
								</label>
							</div>
					</div>
<!-- SUBMIT -->
					<div class="col" style="margin-top: 1vw">
						<button onclick="return confirm('Upload this photo?')" class="btn btn-dark" id="submitbutton" disabled>Submit</button>
					</div>
				</form>
<!-- THUMBNAILS -->
					<div class="col" >
						<div class="output">
							<?php 
								$stmt = $conn->prepare("SELECT * FROM pictures WHERE user_id='$user_id' ORDER BY img_id DESC");
								$stmt->execute();
								$count = $stmt->rowCount();
								$pics = $stmt->fetchAll();
								if ($count > 0) { ?>
									<label style="margin-left: 10px;font-weight:bold">Total of <?php echo $count?> images.</label>
									<br>
									<br>
								<?php }

								foreach ($pics as $row) { ?>
									<label style="margin-left: 10px;"><?php echo $row['file']?></label>
									<br>
									<form method="POST" action="">
										<input type="hidden" name="delete" value="<?php echo $row['img_id']?>">
										<input type="hidden" name="file" value="<?php echo $row['file']?>">
										<img class="img-thumbnail-small enlarge" style="margin-left:10px;margin-bottom:10px" src="../images/<?php echo $row['file']?>" />	
										<button onclick="return confirm('Delete this pic?')" class="btn btn-dark" id="<?php echo 'del'.$row['img_id']?>">Delete</button>
									</form>
								<?php
								}
							?>
						</div>
					</div>
			</div>
		<?php
		}

		// UNAUTHORIZED ACCESS
		else {
			header('Location: '.ROOT.'/index.php');
			die;
		}

		require_once '../includes/footer.php';?>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>
