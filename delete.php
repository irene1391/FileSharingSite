<?php
session_start();
$username = (string)($_SESSION['username'] ?? '');
$file_path_array = ($_SESSION['file_path_array'] ?? []);

$_SESSION['file_path_array'] = [];

if (!$username) {
  header('Location: login.php');
  exit;
}

foreach ($file_path_array as $file_path) {
  unlink($file_path);
}

header("location: index.php");
?>