<?php
session_start();

$username = ($_SESSION['username'] ?? '');
$view_file_path_array = ($_SESSION['view_file_path_array'] ?? []);
$index = (int)($_GET['index'] ?? 1);
$index -= 1;

if (!$username) {
	header('Location: login.php');
	exit;
}

if( !preg_match('/^[\w_\-]+$/', $username) ){
  header('Location: error.php?error=' . urlencode('Invalid Username.'));
  exit;
}

if ($index < 0) {
  exit;
}

$file_path = (@$view_file_path_array[$index] ?? '');

if (!$file_path) {
  exit;
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file_path);

header("Content-Type: " . $mime);
readfile($file_path);
?>