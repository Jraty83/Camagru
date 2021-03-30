<?php
session_start();
require_once '../config/setup.php';
require_once '../includes/constants.php';
require_once '../admin/db_variables.php';

$user = $_SESSION['user'];
$user_id = $db_userid;
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
		<script src = 
			"https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"> 
        </script> 
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
				// echo "FILEEN ".$file." MENI:<br>".$data."<br>";
				//	array_push($images, $file);
				//	echo "IMAGE COUNT: ".count($images)."<br>";
				
				
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
			?>

			<div class="container">
				<form method="POST" action="" enctype="multipart/form-data">
					<input type="hidden" name="cpt_1" id="cpt_1">

					<script src="../includes/takepic.js"></script>

					<!-- <div class="row align-items-start"> -->
						<div class="camera">
							<video id="video">Video stream not available.</video>
							<button id="startbutton">Take photo</button>
						</div>
						<canvas id="canvas">
						</canvas>
						<label style="vertical-align: top">Preview:</label>
						<div class="output">
							<img id="photo" alt="The screen capture will appear in this box.">
							<button onclick="return confirm('Upload this photo?')" class="btn btn-dark" id="submitbutton">Submit</button>
						</div>
					<!-- </div> -->
				<!-- </form> -->
					<!-- <div class="row"> -->
						<div class="output">
							<!-- THUMBNAILS HERE -->
							<form method="POST" action="#" enctype="multipart/form-data" onsubmit="return false">
							<?php 
								$stmt = $conn->prepare("SELECT * FROM pictures WHERE user_id='$user_id' ORDER BY img_id DESC");
								$stmt->execute();
								$count = $stmt->rowCount();
								$picdata = $stmt->fetchAll();
								if ($count > 0)
									print("Total of $count images.<br><br>");

								foreach ($picdata as $row) {
									$location = ROOT.$row['file'];
									$rowtype = $row['type'];
									// echo $location."<br>";
									echo $row['file']."<br>";
									$kuva = file_get_contents($location);
									echo '<img class="img-thumbnail-small" src="'.$rowtype.';base64,' . $kuva . '" />';
									// echo '<button class="btn btn-dark" id="del'.$row['img_id'].'">Delete</button>';
									echo '<button class="btn btn-dark" id="del'.$row['img_id'].'">Delete</button>';

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
							</form>
							<!-- <?php if ($thumbnails) echo '<img class="rounded float-start img-thumbnail" src="'.$type.';base64,' . $data . '" />'; ?> -->
						</div>
					<!-- </div> -->
				</form>
			</div>

			<?php
		}

		// UNAUTHORIZED ACCESS
		else {
			header('Location: '.ROOT.'index.php');
			exit;
		}

		require_once '../includes/footer.php';?>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	</body>
</html>
