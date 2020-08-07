<!DOCTYPE html>
<html lang="en">
<head>
   <title>Display</title>
   <link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>
<body class="displayBody">
   <div class="displayContainer">
      <a href="index.php">
         <div class="displayContainerBackButton">Back To Directory</div>
      </a>
<?php
session_start();

$username = (string) ($_SESSION['username'] ?? '');
$file_path_array = ($_SESSION['file_path_array'] ?? []);
$file_path = NULL;

$_SESSION['file_path_array'] = [];

if (!$username) {
   header('Location: login.php');
   exit;
}

if (!count($file_path_array)) {
   header('Location: index.php');
   exit;
}

$_SESSION['view_file_path_array'] = $file_path_array;

foreach ($file_path_array as $index => $file_path) {
   $finfo = new finfo(FILEINFO_MIME_TYPE);
   $mime = $finfo->file($file_path);

   switch ($mime) {
      case "text/plain":
      case "image/png":
      case "image/jpeg":
      case "image/gif":
      case "image/png":
      case "text/html":
      case "application/pdf":
         echo '<iframe class="displayContent" src="displayfile.php?index=' . (string)($index + 1) . '"></iframe>';
         break;
      default:
         break;
   }
}
?>
   </div>
</body>
</html>