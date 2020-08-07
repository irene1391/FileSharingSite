<?php
session_start();

$username = ($_SESSION['username'] ?? '');
$file_path_array = ($_SESSION['file_path_array'] ?? []);
$is_marked_removal = (int)($_GET['is_marked_removal'] ?? 0);

$_SESSION['file_path_array'] = [];

if(!$username){
    header('Location: login.php');
    exit;
}

$number_of_files = count($file_path_array);

if (!$number_of_files) {
    header("Location: index.php");
    exit;
}

if ($number_of_files > 1) {
    $_SESSION['file_path_array'] = $file_path_array;
    header('Location: compress.php?backref=download');
    exit;
}

// Assert $file_path_array has one and only one file path
$file_path = $file_path_array[0];

if(file_exists($file_path)) {            //Source: http://php.net/manual/en/function.readfile.php
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file_path));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_path));
    ob_clean();
    flush();
    readfile($file_path);
    if ($is_marked_removal) {
        unlink($file_path);
    }
} else {
    header('Location: error.php?error=' . urlencode('File does not exist.'));
    exit;
}
?>