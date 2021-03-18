<?php
session_start();
require_once '../config/setup.php';
require_once '../includes/constants.php';

$user = $_SESSION['user'];
$id = rand(0,10000);

?>

<!doctype html>
<html lang="en">
	<head>
		<title>Add Pic</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../includes/cam.png?">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" href="../includes/main.css">
		<link rel="stylesheet" href="../includes/webcam.css" type="text/css" media="all">
	</head>
	<body>
		<?php require_once '../includes/navbar.php';

		// FOR LOGGED IN USER'S ONLY
		if ($user) {
			echo "<p class='right-align'>Logged in as: ".$user."</p>";
			
			if (isset($_POST['cpt_1']) && $_POST['cpt_1'] != "") {
//				echo "<script type='text/javascript'>confirm('Save this picture?');</script>";
				//todo TOIMII
				//$thumbnails = true;
				$data = $_POST['cpt_1'];
					
				list($type, $data) = explode(';', $data);
				list(, $data) = explode(',', $data);
				
				$file = "images/".$user."_".$id.".txt";
				file_put_contents("../$file", $data);
				echo "FILEEN ".$file." MENI:<br>".$data."<br>";
				//	array_push($images, $file);
				//	echo "IMAGE COUNT: ".count($images)."<br>";
				
				
				try {
				$stmt = $conn->prepare("INSERT INTO pictures (user,`type`,`file`)
				VALUES('$user', '$type', '$file')");
				$stmt->execute();
				$msg = "Picture saved into database.";
				echo "<script type='text/javascript'>alert('$msg');</script>";
				} catch(PDOException $e) {
					die("ERROR: Could not add pic into database " . $e->getMessage());
				}
			}
		?>

		<div class="container">
			<form method="POST" action="" enctype="multipart/form-data">
				<input type="hidden" name="cpt_1" id="cpt_1">

				<script src="../includes/takepic.js"></script>

				<div class="row align-items-start">
					<div class="camera">
						<video id="video">Video stream not available.</video>
						<button id="startbutton">Take photo</button>
					</div>
					<canvas id="canvas">
					</canvas>
					<label>Preview:</label>
					<div class="output">
						<img id="photo" alt="The screen capture will appear in this box.">
						<button class="btn btn-dark" id="startbutton">Submit</button>
					</div>
				</div>
			</form>
			<div class="row">
				<div class="output">
					<!-- THUMBNAILS HERE -->
					<?php 
						$stmt = $conn->prepare("SELECT * FROM pictures WHERE user='$user'");
						$stmt->execute();
						$count = $stmt->rowCount();
						$picdata = $stmt->fetchAll();
						if ($count > 0)
							print("Total of $count images.<br><br>");

						foreach ($picdata as $row) {
							$location = ROOT.$row['file'];
							$rowtype = $row['type'];
							echo $location."<br>";
							$kuva = file_get_contents($location);
							echo '<img class="img-thumbnail-small" src="'.$rowtype.';base64,' . $kuva . '" />';
						}
					?>
					<!-- <?php if ($thumbnails) echo '<img class="rounded float-start img-thumbnail" src="'.$type.';base64,' . $data . '" />'; ?> -->
				</div>
			</div>
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
