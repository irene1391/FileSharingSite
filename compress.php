<?php
session_start();
date_default_timezone_set('America/Chicago');

$username = ($_SESSION['username'] ?? '');
$file_path_array = $_SESSION['file_path_array'] ?? [];
$backref = (string)($_GET['backref'] ?? '');

$_SESSION['file_path_array'] = [];

if (!$username) {
	header('Location: login.php');
	exit;
}

if (!count($file_path_array)) {
	header('Location: index.php');
	exit;
}


// Source: https://davidwalsh.name/create-zip-php
/* creates a compressed zip file */
function create_zip($files = array(),$destination = '',$overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	} else {
		return false;
	}
}

$output_dir= '../mod2/' . $username;
$output_path = $output_dir . '/compressed_' . date('mdYHis') . '.zip';

if (create_zip($file_path_array, $output_path, false)) {
	if ($backref) {
		$_SESSION['file_path_array'] = [$output_path];
		header('Location: ' . $backref . '.php?is_marked_removal=1'); // Remove temp zip afterwards
		exit;
	}

	header('Location: index.php');
	exit;
} else {
	header('Location: error.php?error=' . urlencode('Something went wrong during compress, please try again.'));
	exit;
}
?>