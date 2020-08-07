<!DOCTYPE html>
<html lang="en">
<head>
	<title>Upload</title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>
<body class="uploadBody">
	<div class="uploadContainer">
		<div class="uploadContent">
			<form method="POST" enctype="multipart/form-data"> 
		    <input class="uploadInput" type="file" name="uploadedfile" id="file">
		    <input class="uploadSubmit" type="submit" name="submit" value="upload">
			</form>
			<a href="index.php">
				<div class="uploadButtonCancel">Cancel</div>
			</a>
		</div>
	</div>
<?php
// Auth check
session_start();
$username = (string) ($_SESSION['username'] ?? '');

if (!$username) {
	header('Location: login.php');
	exit;
}

if (isset($_POST['submit'])) {
	$filename = basename($_FILES['uploadedfile']['name']);

	// Security check
	if(!preg_match('/^[\w_\.\-]+$/', $filename)) {
		header('Location: error.php?error=' . urlencode('Invalid file name.'));
		exit;
	}

	$full_path = sprintf("../mod2/%s/%s", $username, $filename);

	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path)) {
		header("Location: index.php");
		exit;
	} else {
		header('Location: error.php?error=' . urlencode('Cannot move file, please try again'));
		exit;
	}
}
?>	
</body>
</html>
